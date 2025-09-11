<?php
/**
 * Flush Rewrite Rules for News Archive
 * Run this file once after implementing the news functionality
 * Access via: yoursite.com/wp-content/themes/theme-name/flush-news-rules.php
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // Load WordPress
    require_once('../../../../../wp-load.php');
}

// Check if user is admin
if (!current_user_can('administrator')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}

// Flush rewrite rules
flush_rewrite_rules();

echo '<h1>Rewrite Rules Flushed Successfully!</h1>';
echo '<p>The news archive should now be accessible at: <a href="' . home_url('/news/') . '">' . home_url('/news/') . '</a></p>';
echo '<p><a href="' . admin_url() . '">← Back to WordPress Admin</a></p>';

// Test the news archive
echo '<h2>Testing News Archive URLs:</h2>';
echo '<ul>';
echo '<li><a href="' . home_url('/news/') . '" target="_blank">All News: ' . home_url('/news/') . '</a></li>';
echo '<li><a href="' . home_url('/news/page/2/') . '" target="_blank">Page 2: ' . home_url('/news/page/2/') . '</a></li>';
echo '<li><a href="' . home_url('/news/category/solo-exhibition/') . '" target="_blank">Solo Exhibitions: ' . home_url('/news/category/solo-exhibition/') . '</a></li>';
echo '<li><a href="' . home_url('/news/category/group-exhibition/') . '" target="_blank">Group Exhibitions: ' . home_url('/news/category/group-exhibition/') . '</a></li>';
echo '</ul>';

echo '<h2>Next Steps:</h2>';
echo '<ol>';
echo '<li>Test the URLs above to ensure they work correctly</li>';
echo '<li>Add some posts with the categories: solo-exhibition, group-exhibition, gallery-news, events</li>';
echo '<li>Optionally enable the automatic News menu link by uncommenting line 714 in functions.php</li>';
echo '<li>Delete this file (flush-news-rules.php) after testing</li>';
echo '</ol>';
?>