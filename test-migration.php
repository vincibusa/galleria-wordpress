<?php
/**
 * Test Migration Script
 * Test per verificare che OSSI sia migrato correttamente come project
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('../../../../../wp-config.php');
}

if (!current_user_can('manage_options')) {
    die('Access denied');
}

// Include migration functions
require_once(get_template_directory() . '/migration-script.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Migration - Galleria Catanzaro</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 1200px; margin: 0 auto; }
        h1 { color: #333; border-bottom: 3px solid #0073aa; padding-bottom: 10px; }
        h2 { color: #0073aa; margin-top: 40px; }
        .section { background: #f9f9f9; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .success { background: #d1edff; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .info { background: #e2e3e5; border: 1px solid #d3d6db; color: #383d41; padding: 15px; border-radius: 4px; margin: 10px 0; }
        pre { background: #f8f9fa; padding: 15px; border: 1px solid #e9ecef; border-radius: 4px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .test-button { background: #0073aa; color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; margin: 10px 5px; font-size: 16px; }
        .test-button:hover { background: #005a87; }
        .test-button.secondary { background: #6c757d; }
        .test-button.secondary:hover { background: #545b62; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test Migration Script</h1>
        <p><strong>Test Date:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        <p><strong>Site URL:</strong> <?php echo home_url(); ?></p>

        <h2>📋 Pre-Migration Checks</h2>
        <div class="section">
            <?php
            // Check if post types exist
            $post_types_check = array();
            $required_types = array('artist', 'exhibition', 'project');
            
            foreach ($required_types as $type) {
                $exists = post_type_exists($type);
                $post_types_check[$type] = $exists;
                
                if ($exists) {
                    echo '<div class="success">✅ Post type <strong>' . $type . '</strong> is registered</div>';
                } else {
                    echo '<div class="error">❌ Post type <strong>' . $type . '</strong> is NOT registered</div>';
                }
            }
            ?>
        </div>

        <h2>📊 Current Data Status</h2>
        <div class="section">
            <?php
            // Check existing posts
            $existing_data = array();
            foreach ($required_types as $type) {
                if (post_type_exists($type)) {
                    $count = wp_count_posts($type);
                    $existing_data[$type] = $count->publish ?? 0;
                    echo '<p><strong>' . ucfirst($type) . 's:</strong> ' . $existing_data[$type] . ' published</p>';
                }
            }
            
            // Check if OSSI already exists in exhibitions
            $ossi_exhibition = get_posts(array(
                'post_type' => 'exhibition',
                'title' => 'OSSI',
                'post_status' => 'publish',
                'numberposts' => 1
            ));
            
            // Check if OSSI already exists in projects
            $ossi_project = get_posts(array(
                'post_type' => 'project',
                'title' => 'OSSI',
                'post_status' => 'publish',
                'numberposts' => 1
            ));
            
            if (!empty($ossi_exhibition)) {
                echo '<div class="warning">⚠️ OSSI exists as Exhibition (ID: ' . $ossi_exhibition[0]->ID . ')</div>';
            }
            
            if (!empty($ossi_project)) {
                echo '<div class="info">ℹ️ OSSI exists as Project (ID: ' . $ossi_project[0]->ID . ')</div>';
            }
            
            if (empty($ossi_exhibition) && empty($ossi_project)) {
                echo '<div class="success">✅ OSSI not found - ready for fresh migration</div>';
            }
            ?>
        </div>

        <h2>🔍 Migration Script Analysis</h2>
        <div class="section">
            <?php
            // Test migration data functions
            echo '<h3>Available Migration Functions:</h3>';
            
            $functions_to_check = array(
                'get_nextjs_artists_data',
                'get_nextjs_exhibitions_data', 
                'get_nextjs_projects_data',
                'migrate_artists',
                'migrate_exhibitions',
                'migrate_projects'
            );
            
            foreach ($functions_to_check as $func) {
                if (function_exists($func)) {
                    echo '<div class="success">✅ Function <code>' . $func . '</code> exists</div>';
                    
                    // Special check for data functions
                    if (strpos($func, 'get_nextjs_') === 0) {
                        $data = call_user_func($func);
                        echo '<p>&nbsp;&nbsp;&nbsp;→ Returns ' . count($data) . ' items</p>';
                        
                        if ($func === 'get_nextjs_projects_data') {
                            echo '<p>&nbsp;&nbsp;&nbsp;→ Projects data:</p>';
                            echo '<pre>' . esc_html(print_r($data, true)) . '</pre>';
                        }
                    }
                } else {
                    echo '<div class="error">❌ Function <code>' . $func . '</code> NOT found</div>';
                }
            }
            ?>
        </div>

        <h2>🎯 OSSI Migration Test</h2>
        <div class="section">
            <?php
            // Check OSSI data in projects
            if (function_exists('get_nextjs_projects_data')) {
                $projects_data = get_nextjs_projects_data();
                $ossi_found = false;
                
                foreach ($projects_data as $project) {
                    if ($project['title'] === 'OSSI') {
                        $ossi_found = true;
                        echo '<div class="success">✅ OSSI found in projects data</div>';
                        echo '<table>';
                        echo '<tr><th>Field</th><th>Value</th></tr>';
                        foreach ($project as $key => $value) {
                            echo '<tr><td><strong>' . esc_html($key) . '</strong></td><td>' . esc_html($value) . '</td></tr>';
                        }
                        echo '</table>';
                        break;
                    }
                }
                
                if (!$ossi_found) {
                    echo '<div class="error">❌ OSSI NOT found in projects data</div>';
                }
            }
            
            // Check OSSI is NOT in exhibitions data
            if (function_exists('get_nextjs_exhibitions_data')) {
                $exhibitions_data = get_nextjs_exhibitions_data();
                $ossi_in_exhibitions = false;
                
                foreach ($exhibitions_data as $exhibition) {
                    if ($exhibition['title'] === 'OSSI') {
                        $ossi_in_exhibitions = true;
                        break;
                    }
                }
                
                if ($ossi_in_exhibitions) {
                    echo '<div class="error">❌ OSSI still found in exhibitions data (should be removed)</div>';
                } else {
                    echo '<div class="success">✅ OSSI correctly removed from exhibitions data</div>';
                }
            }
            ?>
        </div>

        <h2>🔗 Archive Template Check</h2>
        <div class="section">
            <?php
            $archive_project_file = get_template_directory() . '/archive-project.php';
            
            if (file_exists($archive_project_file)) {
                echo '<div class="success">✅ archive-project.php exists</div>';
                echo '<p><strong>File path:</strong> ' . $archive_project_file . '</p>';
                echo '<p><strong>File size:</strong> ' . size_format(filesize($archive_project_file)) . '</p>';
                
                // Check if it contains project-specific code
                $content = file_get_contents($archive_project_file);
                if (strpos($content, "post_type' => 'project'") !== false) {
                    echo '<div class="success">✅ Archive template queries for project post type</div>';
                } else {
                    echo '<div class="warning">⚠️ Archive template may not be querying project post type correctly</div>';
                }
                
                echo '<p><strong>Archive URL:</strong> <a href="' . home_url('/projects/') . '" target="_blank">' . home_url('/projects/') . '</a></p>';
            } else {
                echo '<div class="error">❌ archive-project.php does NOT exist</div>';
            }
            ?>
        </div>

        <h2>🚀 Action Buttons</h2>
        <div class="section">
            <div class="info">
                <strong>Available Actions:</strong>
                <ul>
                    <li><strong>Dry Run:</strong> Test migration without actually creating posts</li>
                    <li><strong>Run Migration:</strong> Execute the full migration script</li>
                    <li><strong>View Projects:</strong> See the projects archive page</li>
                    <li><strong>Cleanup:</strong> Remove any existing OSSI posts for fresh migration</li>
                </ul>
            </div>
            
            <p>
                <a href="<?php echo get_template_directory_uri(); ?>/migration-script.php?run_migration=true" class="test-button">
                    🔄 Run Full Migration
                </a>
                
                <a href="<?php echo home_url('/projects/'); ?>" target="_blank" class="test-button secondary">
                    👀 View Projects Archive
                </a>
                
                <?php if (!empty($ossi_exhibition) || !empty($ossi_project)): ?>
                <button onclick="if(confirm('Are you sure you want to delete existing OSSI posts?')) { window.location.href='?cleanup=true'; }" class="test-button secondary">
                    🗑️ Cleanup Existing OSSI
                </button>
                <?php endif; ?>
            </p>
        </div>

        <?php
        // Handle cleanup action
        if (isset($_GET['cleanup']) && $_GET['cleanup'] === 'true') {
            echo '<h2>🗑️ Cleanup Results</h2>';
            echo '<div class="section">';
            
            $deleted = array();
            
            if (!empty($ossi_exhibition)) {
                wp_delete_post($ossi_exhibition[0]->ID, true);
                $deleted[] = 'OSSI Exhibition (ID: ' . $ossi_exhibition[0]->ID . ')';
            }
            
            if (!empty($ossi_project)) {
                wp_delete_post($ossi_project[0]->ID, true);
                $deleted[] = 'OSSI Project (ID: ' . $ossi_project[0]->ID . ')';
            }
            
            if (!empty($deleted)) {
                echo '<div class="success">✅ Deleted: ' . implode(', ', $deleted) . '</div>';
                echo '<p><a href="' . $_SERVER['PHP_SELF'] . '">Refresh to see updated status</a></p>';
            } else {
                echo '<div class="info">ℹ️ No OSSI posts found to delete</div>';
            }
            
            echo '</div>';
        }
        ?>

        <h2>📝 Migration Status Summary</h2>
        <div class="section">
            <?php
            $all_checks_passed = true;
            $issues = array();
            
            // Check all requirements
            foreach ($required_types as $type) {
                if (!post_type_exists($type)) {
                    $all_checks_passed = false;
                    $issues[] = "Post type '$type' not registered";
                }
            }
            
            if (!function_exists('get_nextjs_projects_data')) {
                $all_checks_passed = false;
                $issues[] = "get_nextjs_projects_data() function not found";
            }
            
            if (!function_exists('migrate_projects')) {
                $all_checks_passed = false;
                $issues[] = "migrate_projects() function not found";
            }
            
            if (!file_exists($archive_project_file)) {
                $all_checks_passed = false;
                $issues[] = "archive-project.php template not found";
            }
            
            if ($all_checks_passed) {
                echo '<div class="success">';
                echo '<h3>🎉 All Systems Ready!</h3>';
                echo '<p>Migration script is ready to run. OSSI will be migrated as a Project and will appear in the projects archive.</p>';
                echo '</div>';
            } else {
                echo '<div class="error">';
                echo '<h3>❌ Issues Found:</h3>';
                echo '<ul>';
                foreach ($issues as $issue) {
                    echo '<li>' . esc_html($issue) . '</li>';
                }
                echo '</ul>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="info">
            <strong>🔗 Useful Links:</strong>
            <ul>
                <li><a href="<?php echo admin_url('edit.php?post_type=project'); ?>">WordPress Admin - Projects</a></li>
                <li><a href="<?php echo admin_url('edit.php?post_type=exhibition'); ?>">WordPress Admin - Exhibitions</a></li>
                <li><a href="<?php echo home_url('/projects/'); ?>" target="_blank">Projects Archive (Frontend)</a></li>
                <li><a href="<?php echo get_template_directory_uri(); ?>/migration-script.php?run_migration=true">Migration Script</a></li>
            </ul>
        </div>
    </div>
</body>
</html>