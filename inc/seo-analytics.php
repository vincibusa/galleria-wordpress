<?php
/**
 * SEO Analytics Integration
 * Google Analytics 4 e Search Console integration per Galleria Catanzaro
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Google Analytics Settings menu to WordPress admin
 */
function galleria_analytics_admin_menu() {
    add_options_page(
        'Google Analytics',
        'Google Analytics', 
        'manage_options',
        'galleria-analytics',
        'galleria_analytics_settings_page'
    );
}
add_action('admin_menu', 'galleria_analytics_admin_menu');

/**
 * Get Analytics settings with defaults
 */
function galleria_get_analytics_settings() {
    $defaults = array(
        'ga4_measurement_id' => '',
        'gsc_verification_code' => '',
        'gtag_events_enabled' => true,
        'track_downloads' => true,
        'track_external_links' => true,
        'track_email_clicks' => true,
        'track_phone_clicks' => true,
        'custom_events' => array(
            'contact_form_submit' => true,
            'gallery_visit_intent' => true,
            'artist_page_view' => true,
            'exhibition_interest' => true
        ),
        'exclude_admin_tracking' => true,
        'anonymize_ip' => true,
        'consent_mode' => false
    );

    $settings = get_option('galleria_analytics_settings', array());
    return wp_parse_args($settings, $defaults);
}

/**
 * Handle Analytics Settings form submission
 */
function galleria_handle_analytics_settings() {
    if (!isset($_POST['galleria_analytics_nonce']) || !wp_verify_nonce($_POST['galleria_analytics_nonce'], 'galleria_analytics_settings')) {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    // Sanitize and save settings
    $settings = array();
    
    // Basic settings
    $settings['ga4_measurement_id'] = sanitize_text_field($_POST['ga4_measurement_id'] ?? '');
    $settings['gsc_verification_code'] = sanitize_text_field($_POST['gsc_verification_code'] ?? '');
    
    // Boolean settings
    $settings['gtag_events_enabled'] = isset($_POST['gtag_events_enabled']);
    $settings['track_downloads'] = isset($_POST['track_downloads']);
    $settings['track_external_links'] = isset($_POST['track_external_links']);
    $settings['track_email_clicks'] = isset($_POST['track_email_clicks']);
    $settings['track_phone_clicks'] = isset($_POST['track_phone_clicks']);
    $settings['exclude_admin_tracking'] = isset($_POST['exclude_admin_tracking']);
    $settings['anonymize_ip'] = isset($_POST['anonymize_ip']);
    $settings['consent_mode'] = isset($_POST['consent_mode']);
    
    // Custom events
    $settings['custom_events'] = array(
        'contact_form_submit' => isset($_POST['track_contact_form']),
        'gallery_visit_intent' => isset($_POST['track_gallery_intent']),
        'artist_page_view' => isset($_POST['track_artist_views']),
        'exhibition_interest' => isset($_POST['track_exhibition_interest'])
    );

    update_option('galleria_analytics_settings', $settings);

    wp_redirect(add_query_arg('analytics_updated', '1', wp_get_referer()));
    exit;
}
add_action('admin_init', 'galleria_handle_analytics_settings');

/**
 * Analytics Settings page content
 */
function galleria_analytics_settings_page() {
    $settings = galleria_get_analytics_settings();
    
    ?>
    <div class="wrap">
        <h1>📊 Google Analytics - Galleria Catanzaro</h1>
        
        <?php if (isset($_GET['analytics_updated'])) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Impostazioni Google Analytics aggiornate con successo!</strong></p>
            </div>
        <?php endif; ?>
        
        <div class="analytics-settings-container" style="display: flex; gap: 20px;">
            <div class="analytics-form" style="flex: 2;">
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                    <input type="hidden" name="action" value="galleria_analytics_settings">
                    <?php wp_nonce_field('galleria_analytics_settings', 'galleria_analytics_nonce'); ?>
                    
                    <div class="card">
                        <h2>🔧 Configurazione Base</h2>
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="ga4_measurement_id">GA4 Measurement ID</label></th>
                                    <td>
                                        <input name="ga4_measurement_id" type="text" id="ga4_measurement_id" 
                                               value="<?php echo esc_attr($settings['ga4_measurement_id']); ?>" 
                                               class="regular-text" placeholder="G-XXXXXXXXXX" />
                                        <p class="description">Es: G-XXXXXXXXXX (trovalo in Google Analytics > Admin > Data Streams)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="gsc_verification_code">Search Console Verification</label></th>
                                    <td>
                                        <input name="gsc_verification_code" type="text" id="gsc_verification_code" 
                                               value="<?php echo esc_attr($settings['gsc_verification_code']); ?>" 
                                               class="large-text" placeholder="google1234567890abcdef.html" />
                                        <p class="description">Codice di verifica HTML per Google Search Console</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="card">
                        <h2>📈 Tracking Eventi</h2>
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row">Eventi Base</th>
                                    <td>
                                        <fieldset>
                                            <label>
                                                <input type="checkbox" name="gtag_events_enabled" <?php checked($settings['gtag_events_enabled']); ?>>
                                                Abilita tracking eventi avanzati
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="track_downloads" <?php checked($settings['track_downloads']); ?>>
                                                Track download file (PDF cataloghi, etc.)
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="track_external_links" <?php checked($settings['track_external_links']); ?>>
                                                Track click link esterni
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="track_email_clicks" <?php checked($settings['track_email_clicks']); ?>>
                                                Track click email
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="track_phone_clicks" <?php checked($settings['track_phone_clicks']); ?>>
                                                Track click telefono
                                            </label>
                                        </fieldset>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">Eventi Galleria</th>
                                    <td>
                                        <fieldset>
                                            <label>
                                                <input type="checkbox" name="track_contact_form" <?php checked($settings['custom_events']['contact_form_submit']); ?>>
                                                Track invio form contatto
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="track_gallery_intent" <?php checked($settings['custom_events']['gallery_visit_intent']); ?>>
                                                Track intenzione visita galleria
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="track_artist_views" <?php checked($settings['custom_events']['artist_page_view']); ?>>
                                                Track visualizzazioni pagine artisti
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="track_exhibition_interest" <?php checked($settings['custom_events']['exhibition_interest']); ?>>
                                                Track interesse mostre
                                            </label>
                                        </fieldset>
                                        <p class="description">Eventi personalizzati specifici per la galleria</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="card">
                        <h2>🔒 Privacy & Conformità</h2>
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row">Impostazioni Privacy</th>
                                    <td>
                                        <fieldset>
                                            <label>
                                                <input type="checkbox" name="exclude_admin_tracking" <?php checked($settings['exclude_admin_tracking']); ?>>
                                                Escludi amministratori dal tracking
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="anonymize_ip" <?php checked($settings['anonymize_ip']); ?>>
                                                Anonimizza indirizzi IP (GDPR)
                                            </label><br>
                                            
                                            <label>
                                                <input type="checkbox" name="consent_mode" <?php checked($settings['consent_mode']); ?>>
                                                Abilita Consent Mode (per banner cookie)
                                            </label>
                                        </fieldset>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php submit_button('Salva Impostazioni Analytics'); ?>
                </form>
            </div>
            
            <div class="analytics-info" style="flex: 1; background: #f9f9f9; padding: 20px; border-radius: 5px;">
                <h3>📋 Status Configurazione</h3>
                <?php if (!empty($settings['ga4_measurement_id'])) : ?>
                    <div class="status-item" style="padding: 10px; background: #d1e7dd; border-left: 4px solid #0f5132; margin: 10px 0;">
                        <strong>✅ Google Analytics Attivo</strong><br>
                        <small>ID: <?php echo esc_html($settings['ga4_measurement_id']); ?></small>
                    </div>
                <?php else : ?>
                    <div class="status-item" style="padding: 10px; background: #f8d7da; border-left: 4px solid #842029; margin: 10px 0;">
                        <strong>❌ Google Analytics Non Configurato</strong><br>
                        <small>Inserisci Measurement ID per attivare</small>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($settings['gsc_verification_code'])) : ?>
                    <div class="status-item" style="padding: 10px; background: #d1e7dd; border-left: 4px solid #0f5132; margin: 10px 0;">
                        <strong>✅ Search Console Verificato</strong>
                    </div>
                <?php else : ?>
                    <div class="status-item" style="padding: 10px; background: #fff3cd; border-left: 4px solid #664d03; margin: 10px 0;">
                        <strong>⚠️ Search Console Non Verificato</strong><br>
                        <small>Aggiungi codice verifica per dati search</small>
                    </div>
                <?php endif; ?>
                
                <h4>🎯 Keywords Target</h4>
                <ul style="font-size: 12px; margin: 10px 0;">
                    <li><strong>"Adalberto Catanzaro"</strong></li>
                    <li>"galleria arte Palermo"</li>
                    <li>"arte contemporanea Palermo"</li>
                    <li>"mostre arte Palermo"</li>
                    <li>"Arte Povera Sicilia"</li>
                </ul>
                
                <h4>📊 Setup Consigliato</h4>
                <ol style="font-size: 12px;">
                    <li>Crea account Google Analytics 4</li>
                    <li>Aggiungi proprietà per il sito</li>
                    <li>Copia Measurement ID qui</li>
                    <li>Verifica Search Console</li>
                    <li>Attiva eventi personalizzati</li>
                </ol>
                
                <h4>🔗 Link Utili</h4>
                <ul style="font-size: 12px;">
                    <li><a href="https://analytics.google.com/" target="_blank">Google Analytics</a></li>
                    <li><a href="https://search.google.com/search-console" target="_blank">Search Console</a></li>
                    <li><a href="https://support.google.com/analytics/answer/9304153" target="_blank">Guida GA4</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Add Google Analytics tracking code to head
 */
function galleria_add_google_analytics() {
    $settings = galleria_get_analytics_settings();
    
    if (empty($settings['ga4_measurement_id'])) {
        return;
    }
    
    // Skip tracking for admin users if enabled
    if ($settings['exclude_admin_tracking'] && current_user_can('manage_options')) {
        return;
    }
    
    $measurement_id = esc_attr($settings['ga4_measurement_id']);
    
    ?>
    <!-- Google Analytics 4 - Galleria Catanzaro -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $measurement_id; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        
        <?php if ($settings['consent_mode']) : ?>
        // Consent Mode (for GDPR compliance)
        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'analytics_storage': 'denied',
            'wait_for_update': 500
        });
        <?php endif; ?>
        
        gtag('config', '<?php echo $measurement_id; ?>', {
            <?php if ($settings['anonymize_ip']) : ?>
            'anonymize_ip': true,
            <?php endif; ?>
            'custom_map': {
                'custom_parameter_1': 'gallery_section',
                'custom_parameter_2': 'artist_name',
                'custom_parameter_3': 'exhibition_type'
            }
        });
        
        <?php if ($settings['gtag_events_enabled']) : ?>
        // Enhanced ecommerce for gallery context
        gtag('config', '<?php echo $measurement_id; ?>', {
            'enhanced_ecommerce': true
        });
        <?php endif; ?>
    </script>
    <?php
}
add_action('wp_head', 'galleria_add_google_analytics', 1);

/**
 * Add Search Console verification meta tag
 */
function galleria_add_search_console_verification() {
    $settings = galleria_get_analytics_settings();
    
    if (!empty($settings['gsc_verification_code'])) {
        $verification_code = esc_attr($settings['gsc_verification_code']);
        echo '<meta name="google-site-verification" content="' . $verification_code . '">' . "\n";
    }
}
add_action('wp_head', 'galleria_add_search_console_verification', 2);

/**
 * Add custom tracking events JavaScript
 */
function galleria_add_tracking_events() {
    $settings = galleria_get_analytics_settings();
    
    if (empty($settings['ga4_measurement_id']) || !$settings['gtag_events_enabled']) {
        return;
    }
    
    // Skip for admin users if enabled
    if ($settings['exclude_admin_tracking'] && current_user_can('manage_options')) {
        return;
    }
    
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Track Adalberto Catanzaro specific searches
        const searchForms = document.querySelectorAll('form[role="search"], .search-form');
        searchForms.forEach(form => {
            form.addEventListener('submit', function() {
                const query = form.querySelector('input[type="search"]').value.toLowerCase();
                if (query.includes('adalberto') || query.includes('catanzaro')) {
                    gtag('event', 'founder_search', {
                        'event_category': 'search',
                        'event_label': 'adalberto_catanzaro_search',
                        'search_term': query
                    });
                }
            });
        });
        
        <?php if ($settings['track_phone_clicks']) : ?>
        // Track phone number clicks
        const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
        phoneLinks.forEach(link => {
            link.addEventListener('click', function() {
                gtag('event', 'phone_click', {
                    'event_category': 'contact',
                    'event_label': 'phone_number_click',
                    'phone_number': this.href
                });
            });
        });
        <?php endif; ?>
        
        <?php if ($settings['track_email_clicks']) : ?>
        // Track email clicks
        const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
        emailLinks.forEach(link => {
            link.addEventListener('click', function() {
                gtag('event', 'email_click', {
                    'event_category': 'contact',
                    'event_label': 'email_click',
                    'email_address': this.href
                });
            });
        });
        <?php endif; ?>
        
        <?php if ($settings['track_external_links']) : ?>
        // Track external link clicks
        const externalLinks = document.querySelectorAll('a[href^="http"]:not([href*="' + window.location.hostname + '"])');
        externalLinks.forEach(link => {
            link.addEventListener('click', function() {
                gtag('event', 'external_link_click', {
                    'event_category': 'outbound',
                    'event_label': this.href,
                    'transport_type': 'beacon'
                });
            });
        });
        <?php endif; ?>
        
        <?php if ($settings['track_downloads']) : ?>
        // Track file downloads (catalogs, brochures, etc.)
        const downloadLinks = document.querySelectorAll('a[href$=".pdf"], a[href$=".doc"], a[href$=".docx"], a[href$=".zip"]');
        downloadLinks.forEach(link => {
            link.addEventListener('click', function() {
                const fileName = this.href.split('/').pop();
                gtag('event', 'file_download', {
                    'event_category': 'download',
                    'event_label': fileName,
                    'file_extension': fileName.split('.').pop()
                });
            });
        });
        <?php endif; ?>
        
        <?php if ($settings['custom_events']['artist_page_view']) : ?>
        // Track artist page engagement
        if (document.body.classList.contains('single-artist')) {
            const artistName = document.querySelector('h1.entry-title, .artist-name')?.textContent || 'Unknown Artist';
            gtag('event', 'artist_page_view', {
                'event_category': 'content',
                'event_label': artistName,
                'artist_name': artistName
            });
            
            // Track time spent on artist page
            let startTime = Date.now();
            window.addEventListener('beforeunload', function() {
                const timeSpent = Math.round((Date.now() - startTime) / 1000);
                gtag('event', 'artist_page_time', {
                    'event_category': 'engagement',
                    'event_label': artistName,
                    'value': timeSpent
                });
            });
        }
        <?php endif; ?>
        
        <?php if ($settings['custom_events']['exhibition_interest']) : ?>
        // Track exhibition interest
        if (document.body.classList.contains('single-exhibition')) {
            const exhibitionTitle = document.querySelector('h1.entry-title, .exhibition-title')?.textContent || 'Unknown Exhibition';
            gtag('event', 'exhibition_view', {
                'event_category': 'content',
                'event_label': exhibitionTitle,
                'exhibition_title': exhibitionTitle
            });
        }
        <?php endif; ?>
        
        <?php if ($settings['custom_events']['gallery_visit_intent']) : ?>
        // Track gallery visit intent (contact info views, directions clicks)
        const contactElements = document.querySelectorAll('.contact-info, .address, .opening-hours');
        contactElements.forEach(element => {
            element.addEventListener('click', function() {
                gtag('event', 'gallery_visit_intent', {
                    'event_category': 'engagement',
                    'event_label': 'contact_info_interaction'
                });
            });
        });
        
        // Track directions/map clicks
        const mapLinks = document.querySelectorAll('a[href*="maps.google"], a[href*="goo.gl/maps"]');
        mapLinks.forEach(link => {
            link.addEventListener('click', function() {
                gtag('event', 'directions_click', {
                    'event_category': 'navigation',
                    'event_label': 'gallery_directions',
                    'gallery_location': this.href
                });
            });
        });
        <?php endif; ?>
    });
    </script>
    <?php
}
add_action('wp_footer', 'galleria_add_tracking_events');

/**
 * Track contact form submissions
 */
function galleria_track_contact_form_submission() {
    $settings = galleria_get_analytics_settings();
    
    if (empty($settings['ga4_measurement_id']) || !$settings['custom_events']['contact_form_submit']) {
        return;
    }
    
    // Add tracking to existing contact form handler
    if (isset($_POST['contact_nonce']) && wp_verify_nonce($_POST['contact_nonce'], 'galleria_contact_form')) {
        ?>
        <script>
        gtag('event', 'form_submit', {
            'event_category': 'contact',
            'event_label': 'contact_form_submission',
            'form_type': 'gallery_contact'
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'galleria_track_contact_form_submission');

/**
 * Handle Analytics Settings form submission action
 */
add_action('admin_post_galleria_analytics_settings', 'galleria_handle_analytics_settings');

/**
 * Add enhanced ecommerce tracking for WooCommerce (if active)
 */
function galleria_add_ecommerce_tracking() {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    $settings = galleria_get_analytics_settings();
    
    if (empty($settings['ga4_measurement_id']) || !$settings['gtag_events_enabled']) {
        return;
    }
    
    // Track art purchases and gallery shop interactions
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Track add to cart events
        jQuery(document.body).on('added_to_cart', function(event, fragments, cart_hash, button) {
            gtag('event', 'add_to_cart', {
                'event_category': 'ecommerce',
                'event_label': 'gallery_shop_add_to_cart'
            });
        });
        
        // Track remove from cart
        jQuery(document.body).on('removed_from_cart', function() {
            gtag('event', 'remove_from_cart', {
                'event_category': 'ecommerce',
                'event_label': 'gallery_shop_remove_from_cart'
            });
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'galleria_add_ecommerce_tracking');