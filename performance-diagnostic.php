<?php
/**
 * Performance Diagnostic Script
 * Diagnosi problemi performance SiteGround vs Locale
 * Run: domain.com/wp-content/themes/galleria-catanzaro/performance-diagnostic.php?key=galleria_debug_2024
 */

// Security check
if (!isset($_GET['key']) || $_GET['key'] !== 'galleria_debug_2024') {
    die('Access denied - Invalid key');
}

// WordPress bootstrap
if (!defined('ABSPATH')) {
    require_once('../../../../../wp-config.php');
}

if (!current_user_can('manage_options')) {
    die('Access denied - Insufficient permissions');
}

function get_server_info() {
    return array(
        'PHP Version' => phpversion(),
        'WordPress Version' => get_bloginfo('version'),
        'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'Operating System' => PHP_OS,
        'Memory Limit' => ini_get('memory_limit'),
        'Post Max Size' => ini_get('post_max_size'),
        'Upload Max Filesize' => ini_get('upload_max_filesize'),
        'Max Execution Time' => ini_get('max_execution_time') . ' seconds',
        'Max Input Vars' => ini_get('max_input_vars'),
        'MySQL Version' => $GLOBALS['wpdb']->db_version(),
        'WP Memory Limit' => WP_MEMORY_LIMIT,
        'WP Max Memory Limit' => WP_MAX_MEMORY_LIMIT,
        'WP Debug' => WP_DEBUG ? 'Enabled' : 'Disabled',
        'PHP Error Reporting' => error_reporting(),
        'Current Memory Usage' => size_format(memory_get_usage(true)),
        'Peak Memory Usage' => size_format(memory_get_peak_usage(true))
    );
}

function get_database_performance() {
    global $wpdb;
    
    $results = array();
    
    // Test basic query performance
    $start_time = microtime(true);
    $posts = $wpdb->get_results("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_status = 'publish' LIMIT 10");
    $query_time = microtime(true) - $start_time;
    $results['Basic Query Time'] = number_format($query_time * 1000, 2) . ' ms';
    
    // Check database size
    $db_size = $wpdb->get_var("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'Database Size (MB)' FROM information_schema.tables WHERE table_schema='{$wpdb->dbname}'");
    $results['Database Size'] = $db_size . ' MB';
    
    // Count posts by type
    $post_counts = array();
    $post_types = get_post_types(array('public' => true));
    foreach ($post_types as $post_type) {
        $count = wp_count_posts($post_type);
        $post_counts[$post_type] = $count->publish ?? 0;
    }
    $results['Post Counts'] = $post_counts;
    
    // Check for slow queries (if possible)
    $slow_query_log = $wpdb->get_var("SHOW VARIABLES LIKE 'slow_query_log'");
    $results['Slow Query Log'] = $slow_query_log ? 'Enabled' : 'Disabled';
    
    return $results;
}

function check_plugin_performance() {
    $active_plugins = get_option('active_plugins');
    $plugin_data = array();
    
    foreach ($active_plugins as $plugin) {
        $plugin_file = WP_PLUGIN_DIR . '/' . $plugin;
        if (file_exists($plugin_file)) {
            $plugin_info = get_plugin_data($plugin_file);
            $plugin_data[] = array(
                'name' => $plugin_info['Name'],
                'version' => $plugin_info['Version'],
                'file_size' => size_format(filesize($plugin_file))
            );
        }
    }
    
    return $plugin_data;
}

function check_theme_performance() {
    $theme = wp_get_theme();
    $theme_dir = get_template_directory();
    
    // Calculate theme size
    $size = 0;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($theme_dir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $size += $file->getSize();
        }
    }
    
    return array(
        'Theme Name' => $theme->get('Name'),
        'Theme Version' => $theme->get('Version'),
        'Theme Size' => size_format($size),
        'Functions.php Size' => file_exists($theme_dir . '/functions.php') ? size_format(filesize($theme_dir . '/functions.php')) : 'N/A'
    );
}

function check_media_library() {
    $upload_dir = wp_upload_dir();
    $results = array();
    
    // Count attachments
    $attachment_count = wp_count_posts('attachment');
    $results['Total Attachments'] = $attachment_count->inherit ?? 0;
    
    // Calculate uploads directory size
    if (is_dir($upload_dir['basedir'])) {
        $size = 0;
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($upload_dir['basedir']));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }
        $results['Uploads Directory Size'] = size_format($size);
    }
    
    // Check for large images
    global $wpdb;
    $large_images = $wpdb->get_results("
        SELECT p.post_title, pm.meta_value 
        FROM {$wpdb->posts} p 
        JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id 
        WHERE p.post_type = 'attachment' 
        AND pm.meta_key = '_wp_attached_file' 
        AND p.post_mime_type LIKE 'image/%'
        ORDER BY p.ID DESC 
        LIMIT 10
    ");
    
    $results['Recent Images'] = array();
    foreach ($large_images as $image) {
        $file_path = $upload_dir['basedir'] . '/' . $image->meta_value;
        if (file_exists($file_path)) {
            $results['Recent Images'][] = array(
                'title' => $image->post_title,
                'size' => size_format(filesize($file_path)),
                'path' => $image->meta_value
            );
        }
    }
    
    return $results;
}

function check_caching() {
    $results = array();
    
    // Check for common caching plugins
    $caching_plugins = array(
        'wp-super-cache/wp-cache.php' => 'WP Super Cache',
        'w3-total-cache/w3-total-cache.php' => 'W3 Total Cache',
        'wp-rocket/wp-rocket.php' => 'WP Rocket',
        'litespeed-cache/litespeed-cache.php' => 'LiteSpeed Cache',
        'wp-fastest-cache/wpFastestCache.php' => 'WP Fastest Cache'
    );
    
    $active_plugins = get_option('active_plugins');
    $results['Active Caching Plugins'] = array();
    
    foreach ($caching_plugins as $plugin_path => $plugin_name) {
        if (in_array($plugin_path, $active_plugins)) {
            $results['Active Caching Plugins'][] = $plugin_name;
        }
    }
    
    if (empty($results['Active Caching Plugins'])) {
        $results['Active Caching Plugins'] = 'None detected';
    }
    
    // Check object cache
    $results['Object Cache'] = wp_using_ext_object_cache() ? 'Enabled' : 'Disabled';
    
    // Check opcache
    $results['OPcache'] = function_exists('opcache_get_status') && opcache_get_status() ? 'Enabled' : 'Disabled';
    
    return $results;
}

function test_external_requests() {
    $results = array();
    
    // Test Google Fonts loading
    $start_time = microtime(true);
    $response = wp_remote_get('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap', array('timeout' => 10));
    $load_time = microtime(true) - $start_time;
    
    if (is_wp_error($response)) {
        $results['Google Fonts'] = 'Error: ' . $response->get_error_message();
    } else {
        $results['Google Fonts'] = number_format($load_time * 1000, 2) . ' ms (Status: ' . wp_remote_retrieve_response_code($response) . ')';
    }
    
    return $results;
}

function check_file_permissions() {
    $results = array();
    
    $paths_to_check = array(
        'wp-content' => WP_CONTENT_DIR,
        'uploads' => wp_upload_dir()['basedir'],
        'themes' => get_theme_root(),
        'plugins' => WP_PLUGIN_DIR
    );
    
    foreach ($paths_to_check as $name => $path) {
        if (file_exists($path)) {
            $perms = fileperms($path);
            $results[$name] = substr(sprintf('%o', $perms), -4);
        } else {
            $results[$name] = 'Not found';
        }
    }
    
    return $results;
}

// Run diagnostics
?>
<!DOCTYPE html>
<html>
<head>
    <title>Galleria Catanzaro - Performance Diagnostic</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 1200px; margin: 0 auto; }
        h1 { color: #333; border-bottom: 3px solid #0073aa; padding-bottom: 10px; }
        h2 { color: #0073aa; margin-top: 40px; }
        .section { background: #f9f9f9; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .success { background: #d1edff; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 4px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .metric { display: inline-block; margin: 10px 20px 10px 0; }
        .metric strong { color: #0073aa; }
        ul { margin: 10px 0; }
        li { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Performance Diagnostic Report</h1>
        <p><strong>Generated:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        <p><strong>Site URL:</strong> <?php echo home_url(); ?></p>
        
        <div class="success">
            <strong>📊 Diagnostic completed successfully!</strong><br>
            Compare these results between your local environment and SiteGround hosting.
        </div>

        <h2>🖥️ Server Configuration</h2>
        <div class="section">
            <table>
                <?php 
                $server_info = get_server_info();
                foreach ($server_info as $key => $value): 
                ?>
                <tr>
                    <th><?php echo esc_html($key); ?></th>
                    <td><?php echo esc_html($value); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <h2>🗄️ Database Performance</h2>
        <div class="section">
            <?php 
            $db_performance = get_database_performance();
            foreach ($db_performance as $key => $value):
                if ($key === 'Post Counts'):
            ?>
                <h3><?php echo esc_html($key); ?></h3>
                <ul>
                    <?php foreach ($value as $post_type => $count): ?>
                    <li><strong><?php echo esc_html($post_type); ?>:</strong> <?php echo esc_html($count); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="metric">
                    <strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?>
                </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>

        <h2>🔌 Active Plugins</h2>
        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Plugin Name</th>
                        <th>Version</th>
                        <th>File Size</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $plugins = check_plugin_performance();
                    foreach ($plugins as $plugin): 
                    ?>
                    <tr>
                        <td><?php echo esc_html($plugin['name']); ?></td>
                        <td><?php echo esc_html($plugin['version']); ?></td>
                        <td><?php echo esc_html($plugin['file_size']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2>🎨 Theme Performance</h2>
        <div class="section">
            <?php 
            $theme_info = check_theme_performance();
            foreach ($theme_info as $key => $value): 
            ?>
                <div class="metric">
                    <strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>📁 Media Library</h2>
        <div class="section">
            <?php 
            $media_info = check_media_library();
            foreach ($media_info as $key => $value):
                if ($key === 'Recent Images'):
            ?>
                <h3><?php echo esc_html($key); ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Image Title</th>
                            <th>File Size</th>
                            <th>Path</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($value as $image): ?>
                        <tr>
                            <td><?php echo esc_html($image['title']); ?></td>
                            <td><?php echo esc_html($image['size']); ?></td>
                            <td><?php echo esc_html($image['path']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="metric">
                    <strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?>
                </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>

        <h2>⚡ Caching Status</h2>
        <div class="section">
            <?php 
            $cache_info = check_caching();
            foreach ($cache_info as $key => $value):
                if (is_array($value)):
            ?>
                <div class="metric">
                    <strong><?php echo esc_html($key); ?>:</strong>
                    <ul>
                        <?php foreach ($value as $item): ?>
                        <li><?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="metric">
                    <strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?>
                </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>

        <h2>🌐 External Requests</h2>
        <div class="section">
            <?php 
            $external_info = test_external_requests();
            foreach ($external_info as $key => $value): 
            ?>
                <div class="metric">
                    <strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>🔒 File Permissions</h2>
        <div class="section">
            <?php 
            $permissions = check_file_permissions();
            foreach ($permissions as $key => $value): 
            ?>
                <div class="metric">
                    <strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>💡 Recommendations for SiteGround</h2>
        <div class="section">
            <div class="warning">
                <h3>Common SiteGround Performance Issues:</h3>
                <ul>
                    <li><strong>Shared Hosting Limits:</strong> Memory limit too low, consider upgrading to GrowBig or higher</li>
                    <li><strong>Plugin Conflicts:</strong> Disable unnecessary plugins, especially heavy ones</li>
                    <li><strong>Image Optimization:</strong> Enable SiteGround's image optimization or use WebP format</li>
                    <li><strong>Caching:</strong> Enable SiteGround SuperCacher and CDN</li>
                    <li><strong>Database:</strong> Clean up old revisions and optimize database regularly</li>
                    <li><strong>PHP Version:</strong> Use latest PHP version supported (8.1 or higher)</li>
                </ul>
            </div>
            
            <div class="success">
                <h3>SiteGround Specific Optimizations:</h3>
                <ul>
                    <li>Enable SuperCacher in SiteTools → Speed → Caching</li>
                    <li>Enable Cloudflare CDN in SiteTools → Speed → Cloudflare CDN</li>
                    <li>Use SG Site Scanner for security and performance monitoring</li>
                    <li>Enable GZIP compression and browser caching</li>
                    <li>Monitor resource usage in SiteTools → Statistics</li>
                </ul>
            </div>
        </div>

        <h2>🔧 Immediate Actions</h2>
        <div class="section">
            <?php if (ini_get('memory_limit') < '256M'): ?>
            <div class="error">
                <strong>⚠️ Low Memory Limit:</strong> Current memory limit is <?php echo ini_get('memory_limit'); ?>. 
                Increase to at least 256M for better performance.
            </div>
            <?php endif; ?>

            <?php if (ini_get('max_execution_time') < 60): ?>
            <div class="warning">
                <strong>⚠️ Low Execution Time:</strong> Current max execution time is <?php echo ini_get('max_execution_time'); ?>s. 
                Consider increasing for large media uploads.
            </div>
            <?php endif; ?>

            <?php if (version_compare(phpversion(), '8.0', '<')): ?>
            <div class="error">
                <strong>⚠️ Outdated PHP:</strong> You're running PHP <?php echo phpversion(); ?>. 
                Upgrade to PHP 8.1+ for better performance and security.
            </div>
            <?php endif; ?>

            <?php 
            $cache_info = check_caching();
            if ($cache_info['Active Caching Plugins'] === 'None detected'): 
            ?>
            <div class="warning">
                <strong>⚠️ No Caching Plugin:</strong> Install a caching plugin like WP Super Cache or use SiteGround's SuperCacher.
            </div>
            <?php endif; ?>
        </div>

        <p><em>🔗 Access this diagnostic: <?php echo home_url(); ?>/wp-content/themes/galleria-catanzaro/performance-diagnostic.php?key=galleria_debug_2024</em></p>
    </div>
</body>
</html>