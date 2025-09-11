<?php
/**
 * WWW Domain Redirect Fix
 * Script per risolvere problemi di redirect www → non-www o viceversa
 */

// Includi WordPress
if (!defined('ABSPATH')) {
    require_once('../../../../../wp-config.php');
}

if (!current_user_can('manage_options')) {
    die('Access denied');
}

/**
 * Genera regole .htaccess per redirect www
 */
function generate_htaccess_rules($redirect_type = 'www_to_non_www') {
    $site_url = parse_url(home_url());
    $domain = $site_url['host'];
    
    if ($redirect_type === 'www_to_non_www') {
        // Redirect da www.example.com a example.com
        $rules = "
# BEGIN WWW to Non-WWW Redirect
RewriteEngine On
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ https://%1/$1 [R=301,L]
# END WWW to Non-WWW Redirect
";
    } else {
        // Redirect da example.com a www.example.com
        $rules = "
# BEGIN Non-WWW to WWW Redirect
RewriteEngine On
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteCond %{HTTP_HOST} !^localhost [NC]
RewriteRule ^(.*)$ https://www.%{HTTP_HOST}/$1 [R=301,L]
# END Non-WWW to WWW Redirect
";
    }
    
    return $rules;
}

/**
 * Controlla lo status DNS del dominio
 */
function check_dns_status($domain) {
    $results = array();
    
    // Controlla record A per dominio principale
    $a_records = dns_get_record($domain, DNS_A);
    $results['A_records'] = $a_records;
    
    // Controlla record A per www
    $www_records = dns_get_record('www.' . $domain, DNS_A);
    $results['WWW_records'] = $www_records;
    
    // Controlla record CNAME per www
    $cname_records = dns_get_record('www.' . $domain, DNS_CNAME);
    $results['CNAME_records'] = $cname_records;
    
    return $results;
}

/**
 * Testa entrambe le versioni del dominio
 */
function test_domain_versions($domain) {
    $results = array();
    
    // Test versione senza www
    $non_www_url = 'https://' . $domain;
    $non_www_response = wp_remote_head($non_www_url, array('timeout' => 10, 'redirection' => 0));
    
    if (is_wp_error($non_www_response)) {
        $results['non_www'] = array(
            'status' => 'error',
            'message' => $non_www_response->get_error_message()
        );
    } else {
        $results['non_www'] = array(
            'status' => 'success',
            'code' => wp_remote_retrieve_response_code($non_www_response),
            'headers' => wp_remote_retrieve_headers($non_www_response)
        );
    }
    
    // Test versione con www
    $www_url = 'https://www.' . $domain;
    $www_response = wp_remote_head($www_url, array('timeout' => 10, 'redirection' => 0));
    
    if (is_wp_error($www_response)) {
        $results['www'] = array(
            'status' => 'error',
            'message' => $www_response->get_error_message()
        );
    } else {
        $results['www'] = array(
            'status' => 'success',
            'code' => wp_remote_retrieve_response_code($www_response),
            'headers' => wp_remote_retrieve_headers($www_response)
        );
    }
    
    return $results;
}

/**
 * Controlla configurazione WordPress URLs
 */
function check_wordpress_urls() {
    return array(
        'site_url' => get_option('siteurl'),
        'home_url' => get_option('home'),
        'admin_url' => admin_url(),
        'content_url' => content_url(),
        'includes_url' => includes_url()
    );
}

// Estrai dominio dall'URL del sito
$site_url = parse_url(home_url());
$domain = $site_url['host'];
$has_www = strpos($domain, 'www.') === 0;
$clean_domain = $has_www ? substr($domain, 4) : $domain;

// Esegui i test
$dns_status = check_dns_status($clean_domain);
$domain_tests = test_domain_versions($clean_domain);
$wp_urls = check_wordpress_urls();

?>
<!DOCTYPE html>
<html>
<head>
    <title>WWW Domain Redirect Fix - Galleria Catanzaro</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 1200px; margin: 0 auto; }
        h1 { color: #333; border-bottom: 3px solid #0073aa; padding-bottom: 10px; }
        h2 { color: #0073aa; margin-top: 40px; }
        .section { background: #f9f9f9; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .success { background: #d1edff; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .info { background: #e2e3e5; border: 1px solid #d3d6db; color: #383d41; padding: 15px; border-radius: 4px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; font-weight: bold; }
        pre { background: #f8f9fa; padding: 15px; border: 1px solid #e9ecef; border-radius: 4px; overflow-x: auto; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .status-warning { color: #ffc107; font-weight: bold; }
        .metric { display: inline-block; margin: 10px 20px 10px 0; }
        .metric strong { color: #0073aa; }
        .code-box { background: #2d3748; color: #e2e8f0; padding: 20px; border-radius: 8px; margin: 15px 0; }
        .copy-btn { background: #0073aa; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; margin: 10px 0; }
        .copy-btn:hover { background: #005a87; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔗 WWW Domain Redirect Fix</h1>
        <p><strong>Current Site URL:</strong> <?php echo home_url(); ?></p>
        <p><strong>Domain:</strong> <?php echo esc_html($domain); ?></p>
        <p><strong>Generated:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>

        <h2>📊 Current Status Analysis</h2>
        <div class="section">
            <?php if ($has_www): ?>
                <div class="info">
                    <strong>ℹ️ Your site is configured to use WWW</strong><br>
                    Main domain: <?php echo esc_html($domain); ?><br>
                    Alternative: <?php echo esc_html($clean_domain); ?>
                </div>
            <?php else: ?>
                <div class="info">
                    <strong>ℹ️ Your site is configured WITHOUT WWW</strong><br>
                    Main domain: <?php echo esc_html($domain); ?><br>
                    Alternative: www.<?php echo esc_html($domain); ?>
                </div>
            <?php endif; ?>
        </div>

        <h2>🌐 DNS Records Status</h2>
        <div class="section">
            <h3>A Records for <?php echo esc_html($clean_domain); ?></h3>
            <?php if (!empty($dns_status['A_records'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Host</th>
                            <th>Type</th>
                            <th>IP Address</th>
                            <th>TTL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dns_status['A_records'] as $record): ?>
                        <tr>
                            <td><?php echo esc_html($record['host']); ?></td>
                            <td><?php echo esc_html($record['type']); ?></td>
                            <td><?php echo esc_html($record['ip']); ?></td>
                            <td><?php echo esc_html($record['ttl']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="error">❌ No A records found for <?php echo esc_html($clean_domain); ?></div>
            <?php endif; ?>

            <h3>Records for www.<?php echo esc_html($clean_domain); ?></h3>
            <?php if (!empty($dns_status['WWW_records'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Host</th>
                            <th>Type</th>
                            <th>IP Address</th>
                            <th>TTL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dns_status['WWW_records'] as $record): ?>
                        <tr>
                            <td><?php echo esc_html($record['host']); ?></td>
                            <td><?php echo esc_html($record['type']); ?></td>
                            <td><?php echo esc_html($record['ip']); ?></td>
                            <td><?php echo esc_html($record['ttl']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif (!empty($dns_status['CNAME_records'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Host</th>
                            <th>Type</th>
                            <th>Target</th>
                            <th>TTL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dns_status['CNAME_records'] as $record): ?>
                        <tr>
                            <td><?php echo esc_html($record['host']); ?></td>
                            <td><?php echo esc_html($record['type']); ?></td>
                            <td><?php echo esc_html($record['target']); ?></td>
                            <td><?php echo esc_html($record['ttl']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="error">❌ No records found for www.<?php echo esc_html($clean_domain); ?></div>
            <?php endif; ?>
        </div>

        <h2>🔍 Domain Testing Results</h2>
        <div class="section">
            <h3>Test: <?php echo esc_html($clean_domain); ?> (without www)</h3>
            <?php if ($domain_tests['non_www']['status'] === 'success'): ?>
                <div class="success">
                    ✅ <strong>Status:</strong> <?php echo esc_html($domain_tests['non_www']['code']); ?><br>
                    <?php if (isset($domain_tests['non_www']['headers']['location'])): ?>
                        <strong>Redirects to:</strong> <?php echo esc_html($domain_tests['non_www']['headers']['location']); ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="error">
                    ❌ <strong>Error:</strong> <?php echo esc_html($domain_tests['non_www']['message']); ?>
                </div>
            <?php endif; ?>

            <h3>Test: www.<?php echo esc_html($clean_domain); ?> (with www)</h3>
            <?php if ($domain_tests['www']['status'] === 'success'): ?>
                <div class="success">
                    ✅ <strong>Status:</strong> <?php echo esc_html($domain_tests['www']['code']); ?><br>
                    <?php if (isset($domain_tests['www']['headers']['location'])): ?>
                        <strong>Redirects to:</strong> <?php echo esc_html($domain_tests['www']['headers']['location']); ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="error">
                    ❌ <strong>Error:</strong> <?php echo esc_html($domain_tests['www']['message']); ?>
                </div>
            <?php endif; ?>
        </div>

        <h2>⚙️ WordPress URL Configuration</h2>
        <div class="section">
            <table>
                <?php foreach ($wp_urls as $key => $url): ?>
                <tr>
                    <th><?php echo esc_html(str_replace('_', ' ', ucfirst($key))); ?></th>
                    <td><?php echo esc_html($url); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <h2>🔧 Solutions</h2>
        
        <div class="section">
            <h3>1. Fix DNS Configuration (SiteGround cPanel)</h3>
            <div class="info">
                <strong>Steps for SiteGround DNS:</strong>
                <ol>
                    <li>Login to SiteGround Client Area</li>
                    <li>Go to <strong>Websites → Manage → Domain → DNS Zone Editor</strong></li>
                    <li>Add missing records:</li>
                </ol>
            </div>
            
            <?php if (empty($dns_status['WWW_records']) && empty($dns_status['CNAME_records'])): ?>
                <div class="warning">
                    <strong>⚠️ Missing WWW record!</strong> Add one of these records:
                    <ul>
                        <li><strong>Option A (A Record):</strong> www → Same IP as main domain</li>
                        <li><strong>Option B (CNAME):</strong> www → <?php echo esc_html($clean_domain); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="section">
            <h3>2. Add .htaccess Redirect Rules</h3>
            <div class="info">
                <strong>Choose your preferred version:</strong>
            </div>
            
            <h4>Option A: Redirect WWW to Non-WWW (Recommended)</h4>
            <div class="code-box">
                <pre><?php echo esc_html(generate_htaccess_rules('www_to_non_www')); ?></pre>
            </div>
            <button class="copy-btn" onclick="copyToClipboard('htaccess_www_to_non_www')">Copy to Clipboard</button>
            
            <h4>Option B: Redirect Non-WWW to WWW</h4>
            <div class="code-box">
                <pre><?php echo esc_html(generate_htaccess_rules('non_www_to_www')); ?></pre>
            </div>
            <button class="copy-btn" onclick="copyToClipboard('htaccess_non_www_to_www')">Copy to Clipboard</button>

            <div class="warning">
                <strong>⚠️ Instructions:</strong>
                <ol>
                    <li>Choose one option above (don't use both!)</li>
                    <li>Add the rules to your <code>.htaccess</code> file in the root directory</li>
                    <li>Place these rules BEFORE the WordPress rules</li>
                    <li>Test both versions of your domain after implementation</li>
                </ol>
            </div>
        </div>

        <div class="section">
            <h3>3. Update WordPress URLs (if needed)</h3>
            <div class="info">
                <strong>If you want to change your preferred domain version:</strong>
            </div>
            
            <?php if ($has_www): ?>
                <p><strong>To switch to non-WWW:</strong></p>
                <div class="code-box">
                    <pre>
// Add to wp-config.php (before "require_once ABSPATH...")
define('WP_HOME','https://<?php echo esc_html($clean_domain); ?>');
define('WP_SITEURL','https://<?php echo esc_html($clean_domain); ?>');
                    </pre>
                </div>
            <?php else: ?>
                <p><strong>To switch to WWW:</strong></p>
                <div class="code-box">
                    <pre>
// Add to wp-config.php (before "require_once ABSPATH...")
define('WP_HOME','https://www.<?php echo esc_html($clean_domain); ?>');
define('WP_SITEURL','https://www.<?php echo esc_html($clean_domain); ?>');
                    </pre>
                </div>
            <?php endif; ?>
            
            <div class="warning">
                <strong>⚠️ Alternative methods:</strong>
                <ul>
                    <li>WordPress Admin: Settings → General → WordPress Address URL / Site Address URL</li>
                    <li>Database: Update <code>siteurl</code> and <code>home</code> in <code>wp_options</code> table</li>
                    <li>WP-CLI: <code>wp option update home 'https://newdomain.com'</code></li>
                </ul>
            </div>
        </div>

        <div class="section">
            <h3>4. SiteGround Specific Settings</h3>
            <div class="success">
                <strong>SiteGround Site Tools:</strong>
                <ol>
                    <li><strong>Speed → Caching:</strong> Clear all caches after changes</li>
                    <li><strong>Speed → CDN:</strong> Update CDN settings if using Cloudflare</li>
                    <li><strong>Security → SSL Manager:</strong> Ensure SSL covers both www and non-www</li>
                    <li><strong>Domains → Redirects:</strong> Set up redirects via control panel if preferred</li>
                </ol>
            </div>
        </div>

        <h2>✅ Testing Checklist</h2>
        <div class="section">
            <div class="info">
                <strong>After implementing changes, test:</strong>
                <ul>
                    <li>✓ https://<?php echo esc_html($clean_domain); ?> → Should work and redirect if needed</li>
                    <li>✓ https://www.<?php echo esc_html($clean_domain); ?> → Should work and redirect if needed</li>
                    <li>✓ Check that only ONE version is canonical (no duplicates)</li>
                    <li>✓ Verify SSL certificate covers both versions</li>
                    <li>✓ Test from different devices and networks</li>
                    <li>✓ Check Google Search Console for both versions</li>
                </ul>
            </div>
        </div>

        <div class="error">
            <strong>🚨 Important Notes:</strong>
            <ul>
                <li>DNS changes can take 24-48 hours to propagate globally</li>
                <li>Always backup your .htaccess file before making changes</li>
                <li>Test changes on staging environment first if possible</li>
                <li>Contact SiteGround support if DNS issues persist</li>
            </ul>
        </div>

    </div>

    <script>
        function copyToClipboard(type) {
            const rules = {
                'htaccess_www_to_non_www': `<?php echo addslashes(generate_htaccess_rules('www_to_non_www')); ?>`,
                'htaccess_non_www_to_www': `<?php echo addslashes(generate_htaccess_rules('non_www_to_www')); ?>`
            };
            
            navigator.clipboard.writeText(rules[type]).then(function() {
                alert('Copied to clipboard!');
            }).catch(function(err) {
                console.error('Failed to copy: ', err);
                // Fallback
                const textArea = document.createElement('textarea');
                textArea.value = rules[type];
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Copied to clipboard!');
            });
        }
    </script>
</body>
</html>