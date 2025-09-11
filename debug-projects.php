<?php
/**
 * Debug Projects - Simple test page
 */

// Include WordPress
if (!defined('ABSPATH')) {
    require_once('../../../../../wp-config.php');
}

if (!current_user_can('manage_options')) {
    die('Access denied');
}

// Simple query to get all projects
$all_projects = get_posts(array(
    'post_type' => 'project',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
));

?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Projects - Galleria Catanzaro</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 1200px; margin: 0 auto; }
        h1 { color: #333; border-bottom: 3px solid #0073aa; padding-bottom: 10px; }
        .project { background: #f9f9f9; padding: 15px; margin: 15px 0; border-radius: 4px; }
        .success { background: #d1edff; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin: 10px 0; }
        pre { background: #f8f9fa; padding: 10px; border: 1px solid #e9ecef; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Debug Projects</h1>
        <p><strong>Check Date:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        
        <h2>📊 Project Statistics</h2>
        <div class="success">
            <strong>Total Projects Found:</strong> <?php echo count($all_projects); ?>
        </div>
        
        <?php if (empty($all_projects)): ?>
            <div class="error">
                <strong>❌ No projects found!</strong><br>
                Possible reasons:
                <ul>
                    <li>Migration script didn't run successfully</li>
                    <li>Projects were created but not published</li>
                    <li>Post type 'project' not registered properly</li>
                </ul>
            </div>
        <?php else: ?>
            <h2>📋 All Projects</h2>
            <?php foreach ($all_projects as $project): ?>
                <div class="project">
                    <h3><?php echo esc_html($project->post_title); ?> (ID: <?php echo $project->ID; ?>)</h3>
                    <p><strong>Status:</strong> <?php echo $project->post_status; ?></p>
                    <p><strong>Date:</strong> <?php echo $project->post_date; ?></p>
                    
                    <?php
                    $meta = get_post_meta($project->ID);
                    if (!empty($meta)):
                    ?>
                        <strong>Meta Fields:</strong>
                        <pre><?php echo esc_html(print_r($meta, true)); ?></pre>
                    <?php endif; ?>
                    
                    <p><strong>View:</strong> <a href="<?php echo get_permalink($project->ID); ?>" target="_blank">Single Page</a></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <h2>🔗 Quick Actions</h2>
        <p>
            <a href="<?php echo home_url('/projects/'); ?>" target="_blank" style="background: #0073aa; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
                👀 View Projects Archive
            </a>
            
            <a href="<?php echo admin_url('edit.php?post_type=project'); ?>" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-left: 10px;">
                ⚙️ Manage Projects in Admin
            </a>
        </p>
        
        <h2>🧪 Test Different Queries</h2>
        
        <h3>Query 1: Simple query (no meta requirements)</h3>
        <?php
        $simple_query = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        ?>
        <div class="success">Found: <?php echo $simple_query->found_posts; ?> projects</div>
        
        <h3>Query 2: With meta_key start_date (original archive query)</h3>
        <?php
        $meta_query = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => -1,
            'meta_key' => 'start_date',
            'orderby' => array('meta_value' => 'DESC', 'date' => 'DESC')
        ));
        ?>
        <div class="<?php echo $meta_query->found_posts > 0 ? 'success' : 'error'; ?>">
            Found: <?php echo $meta_query->found_posts; ?> projects with start_date
        </div>
        
        <h3>Query 3: OSSI specific search</h3>
        <?php
        $ossi_query = get_posts(array(
            'post_type' => 'project',
            'title' => 'OSSI',
            'post_status' => 'publish',
            'numberposts' => 1
        ));
        ?>
        <div class="<?php echo !empty($ossi_query) ? 'success' : 'error'; ?>">
            OSSI found: <?php echo !empty($ossi_query) ? 'YES (ID: ' . $ossi_query[0]->ID . ')' : 'NO'; ?>
        </div>
        
        <?php if (!empty($ossi_query)): ?>
            <div class="project">
                <h3>OSSI Details</h3>
                <p><strong>Title:</strong> <?php echo esc_html($ossi_query[0]->post_title); ?></p>
                <p><strong>Status:</strong> <?php echo $ossi_query[0]->post_status; ?></p>
                <p><strong>Content:</strong> <?php echo esc_html(wp_trim_words($ossi_query[0]->post_content, 20)); ?></p>
                
                <?php
                $ossi_meta = get_post_meta($ossi_query[0]->ID);
                ?>
                <strong>Meta Fields:</strong>
                <pre><?php echo esc_html(print_r($ossi_meta, true)); ?></pre>
            </div>
        <?php endif; ?>
        
        <p><em>🔗 Access this page: <?php echo home_url(); ?>/wp-content/themes/galleria-catanzaro/debug-projects.php</em></p>
    </div>
</body>
</html>