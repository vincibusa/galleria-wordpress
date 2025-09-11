<?php
/**
 * Local Business Manager
 * Gestione info business locali per le sedi di Palermo
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Local Business Manager menu
 */
function galleria_local_business_menu() {
    add_submenu_page(
        'galleria-seo-dashboard',
        'Local Business Manager',
        'Business Locale',
        'manage_options',
        'galleria-local-business',
        'galleria_local_business_page'
    );
}
add_action('admin_menu', 'galleria_local_business_menu');

/**
 * Get local business settings with defaults
 */
function galleria_get_local_business_settings() {
    $defaults = array(
        // Main Gallery Info
        'business_name' => 'Galleria Adalberto Catanzaro',
        'business_description' => 'Galleria d\'arte contemporanea a Palermo specializzata in Arte Povera e Transavanguardia. Due sedi nel centro storico.',
        'founder_name' => 'Adalberto Catanzaro',
        'founding_year' => '2014',
        'business_type' => 'art_gallery',
        'price_range' => '$$',
        
        // Contact Info
        'phone' => '+39 327 167 7871',
        'email' => 'catanzaroepartners@gmail.com',
        'website' => home_url(),
        'whatsapp' => '',
        'instagram' => '',
        'facebook' => '',
        
        // Location 1 - Via Montevergini
        'location1_name' => 'Sede Via Montevergini',
        'location1_address' => 'Via Montevergini 3',
        'location1_city' => 'Palermo',
        'location1_region' => 'Sicilia',
        'location1_postal_code' => '90133',
        'location1_country' => 'IT',
        'location1_latitude' => '38.1157',
        'location1_longitude' => '13.3615',
        'location1_is_main' => true,
        
        // Location 2 - Corso Vittorio Emanuele
        'location2_name' => 'Sede Corso Vittorio Emanuele',
        'location2_address' => 'Corso Vittorio Emanuele 383',
        'location2_city' => 'Palermo',
        'location2_region' => 'Sicilia',
        'location2_postal_code' => '90133',
        'location2_country' => 'IT',
        'location2_latitude' => '38.1156',
        'location2_longitude' => '13.3614',
        'location2_is_main' => false,
        
        // Opening Hours
        'opening_hours' => array(
            'monday' => array('closed' => true),
            'tuesday' => array('open' => '10:00', 'close' => '18:00'),
            'wednesday' => array('open' => '10:00', 'close' => '18:00'),
            'thursday' => array('open' => '10:00', 'close' => '18:00'),
            'friday' => array('open' => '10:00', 'close' => '18:00'),
            'saturday' => array('open' => '10:00', 'close' => '18:00'),
            'sunday' => array('closed' => true)
        ),
        
        // Services
        'services' => array(
            'exhibitions' => true,
            'art_consultation' => true,
            'private_viewings' => true,
            'art_valuation' => false,
            'framing' => false,
            'restoration' => false
        ),
        
        // Specialties
        'art_specialties' => array(
            'Arte Povera',
            'Transavanguardia',
            'Arte Contemporanea',
            'Arte Italiana',
            'Installazioni'
        ),
        
        // Payment Methods
        'payment_methods' => array(
            'cash' => true,
            'credit_card' => true,
            'bank_transfer' => true,
            'paypal' => false
        ),
        
        // Accessibility
        'accessibility' => array(
            'wheelchair_accessible' => true,
            'parking_available' => false,
            'public_transport' => true
        )
    );

    $settings = get_option('galleria_local_business_settings', array());
    return wp_parse_args($settings, $defaults);
}

/**
 * Handle Local Business settings form submission
 */
function galleria_handle_local_business_settings() {
    if (!isset($_POST['galleria_local_business_nonce']) || !wp_verify_nonce($_POST['galleria_local_business_nonce'], 'galleria_local_business_settings')) {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    // Sanitize and save all settings
    $settings = array();
    
    // Basic business info
    $settings['business_name'] = sanitize_text_field($_POST['business_name'] ?? '');
    $settings['business_description'] = sanitize_textarea_field($_POST['business_description'] ?? '');
    $settings['founder_name'] = sanitize_text_field($_POST['founder_name'] ?? '');
    $settings['founding_year'] = sanitize_text_field($_POST['founding_year'] ?? '');
    $settings['business_type'] = sanitize_text_field($_POST['business_type'] ?? '');
    $settings['price_range'] = sanitize_text_field($_POST['price_range'] ?? '');
    
    // Contact info
    $settings['phone'] = sanitize_text_field($_POST['phone'] ?? '');
    $settings['email'] = sanitize_email($_POST['email'] ?? '');
    $settings['website'] = esc_url_raw($_POST['website'] ?? '');
    $settings['whatsapp'] = sanitize_text_field($_POST['whatsapp'] ?? '');
    $settings['instagram'] = esc_url_raw($_POST['instagram'] ?? '');
    $settings['facebook'] = esc_url_raw($_POST['facebook'] ?? '');
    
    // Location 1
    $settings['location1_name'] = sanitize_text_field($_POST['location1_name'] ?? '');
    $settings['location1_address'] = sanitize_text_field($_POST['location1_address'] ?? '');
    $settings['location1_city'] = sanitize_text_field($_POST['location1_city'] ?? '');
    $settings['location1_region'] = sanitize_text_field($_POST['location1_region'] ?? '');
    $settings['location1_postal_code'] = sanitize_text_field($_POST['location1_postal_code'] ?? '');
    $settings['location1_country'] = sanitize_text_field($_POST['location1_country'] ?? '');
    $settings['location1_latitude'] = sanitize_text_field($_POST['location1_latitude'] ?? '');
    $settings['location1_longitude'] = sanitize_text_field($_POST['location1_longitude'] ?? '');
    $settings['location1_is_main'] = isset($_POST['location1_is_main']);
    
    // Location 2
    $settings['location2_name'] = sanitize_text_field($_POST['location2_name'] ?? '');
    $settings['location2_address'] = sanitize_text_field($_POST['location2_address'] ?? '');
    $settings['location2_city'] = sanitize_text_field($_POST['location2_city'] ?? '');
    $settings['location2_region'] = sanitize_text_field($_POST['location2_region'] ?? '');
    $settings['location2_postal_code'] = sanitize_text_field($_POST['location2_postal_code'] ?? '');
    $settings['location2_country'] = sanitize_text_field($_POST['location2_country'] ?? '');
    $settings['location2_latitude'] = sanitize_text_field($_POST['location2_latitude'] ?? '');
    $settings['location2_longitude'] = sanitize_text_field($_POST['location2_longitude'] ?? '');
    $settings['location2_is_main'] = isset($_POST['location2_is_main']);
    
    // Opening hours
    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    $settings['opening_hours'] = array();
    
    foreach ($days as $day) {
        $settings['opening_hours'][$day] = array();
        if (isset($_POST[$day . '_closed'])) {
            $settings['opening_hours'][$day]['closed'] = true;
        } else {
            $settings['opening_hours'][$day]['open'] = sanitize_text_field($_POST[$day . '_open'] ?? '');
            $settings['opening_hours'][$day]['close'] = sanitize_text_field($_POST[$day . '_close'] ?? '');
        }
    }
    
    // Services
    $settings['services'] = array(
        'exhibitions' => isset($_POST['service_exhibitions']),
        'art_consultation' => isset($_POST['service_art_consultation']),
        'private_viewings' => isset($_POST['service_private_viewings']),
        'art_valuation' => isset($_POST['service_art_valuation']),
        'framing' => isset($_POST['service_framing']),
        'restoration' => isset($_POST['service_restoration'])
    );
    
    // Art specialties
    $specialties_raw = sanitize_textarea_field($_POST['art_specialties'] ?? '');
    $settings['art_specialties'] = array_filter(array_map('trim', explode("\n", $specialties_raw)));
    
    // Payment methods
    $settings['payment_methods'] = array(
        'cash' => isset($_POST['payment_cash']),
        'credit_card' => isset($_POST['payment_credit_card']),
        'bank_transfer' => isset($_POST['payment_bank_transfer']),
        'paypal' => isset($_POST['payment_paypal'])
    );
    
    // Accessibility
    $settings['accessibility'] = array(
        'wheelchair_accessible' => isset($_POST['accessibility_wheelchair']),
        'parking_available' => isset($_POST['accessibility_parking']),
        'public_transport' => isset($_POST['accessibility_transport'])
    );

    update_option('galleria_local_business_settings', $settings);

    wp_redirect(add_query_arg('business_updated', '1', wp_get_referer()));
    exit;
}
add_action('admin_init', 'galleria_handle_local_business_settings');

/**
 * Local Business Manager page
 */
function galleria_local_business_page() {
    $settings = galleria_get_local_business_settings();
    
    ?>
    <div class="wrap">
        <h1>🏢 Local Business Manager</h1>
        
        <?php if (isset($_GET['business_updated'])) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Impostazioni business aggiornate con successo!</strong></p>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="galleria_local_business_settings">
            <?php wp_nonce_field('galleria_local_business_settings', 'galleria_local_business_nonce'); ?>
            
            <div class="business-tabs">
                <nav class="nav-tab-wrapper">
                    <a href="#business-info" class="nav-tab nav-tab-active">🏢 Info Generali</a>
                    <a href="#locations" class="nav-tab">📍 Sedi</a>
                    <a href="#hours" class="nav-tab">🕒 Orari</a>
                    <a href="#services" class="nav-tab">🎨 Servizi</a>
                    <a href="#contact" class="nav-tab">📞 Contatti</a>
                </nav>
                
                <!-- Business Info Tab -->
                <div id="business-info" class="tab-content active">
                    <div class="card">
                        <h2>Informazioni Azienda</h2>
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="business_name">Nome Attività</label></th>
                                    <td>
                                        <input name="business_name" type="text" id="business_name" 
                                               value="<?php echo esc_attr($settings['business_name']); ?>" class="regular-text" />
                                        <p class="description">Nome ufficiale della galleria</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="business_description">Descrizione</label></th>
                                    <td>
                                        <textarea name="business_description" id="business_description" rows="4" class="large-text"><?php echo esc_textarea($settings['business_description']); ?></textarea>
                                        <p class="description">Descrizione principale per SEO e directory</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="founder_name">Fondatore</label></th>
                                    <td>
                                        <input name="founder_name" type="text" id="founder_name" 
                                               value="<?php echo esc_attr($settings['founder_name']); ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="founding_year">Anno Fondazione</label></th>
                                    <td>
                                        <input name="founding_year" type="number" id="founding_year" 
                                               value="<?php echo esc_attr($settings['founding_year']); ?>" class="small-text" min="1900" max="<?php echo date('Y'); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="business_type">Tipo di Attività</label></th>
                                    <td>
                                        <select name="business_type" id="business_type">
                                            <option value="art_gallery" <?php selected($settings['business_type'], 'art_gallery'); ?>>Galleria d'Arte</option>
                                            <option value="museum" <?php selected($settings['business_type'], 'museum'); ?>>Museo</option>
                                            <option value="art_center" <?php selected($settings['business_type'], 'art_center'); ?>>Centro d'Arte</option>
                                            <option value="cultural_center" <?php selected($settings['business_type'], 'cultural_center'); ?>>Centro Culturale</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="price_range">Fascia Prezzo</label></th>
                                    <td>
                                        <select name="price_range" id="price_range">
                                            <option value="$" <?php selected($settings['price_range'], '$'); ?>>$ - Economico</option>
                                            <option value="$$" <?php selected($settings['price_range'], '$$'); ?>>$$ - Medio</option>
                                            <option value="$$$" <?php selected($settings['price_range'], '$$$'); ?>>$$$ - Alto</option>
                                            <option value="$$$$" <?php selected($settings['price_range'], '$$$$'); ?>>$$$$ - Premium</option>
                                        </select>
                                        <p class="description">Per opere d'arte e consulenze</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Locations Tab -->
                <div id="locations" class="tab-content">
                    <div class="locations-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <!-- Location 1 -->
                        <div class="card">
                            <h2>📍 Sede 1</h2>
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr>
                                        <th scope="row"><label for="location1_name">Nome Sede</label></th>
                                        <td>
                                            <input name="location1_name" type="text" id="location1_name" 
                                                   value="<?php echo esc_attr($settings['location1_name']); ?>" class="regular-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label for="location1_address">Indirizzo</label></th>
                                        <td>
                                            <input name="location1_address" type="text" id="location1_address" 
                                                   value="<?php echo esc_attr($settings['location1_address']); ?>" class="regular-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label for="location1_city">Città</label></th>
                                        <td>
                                            <input name="location1_city" type="text" id="location1_city" 
                                                   value="<?php echo esc_attr($settings['location1_city']); ?>" class="regular-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Coordinate GPS</th>
                                        <td>
                                            <input name="location1_latitude" type="text" 
                                                   value="<?php echo esc_attr($settings['location1_latitude']); ?>" 
                                                   placeholder="Latitudine" class="small-text" />
                                            <input name="location1_longitude" type="text" 
                                                   value="<?php echo esc_attr($settings['location1_longitude']); ?>" 
                                                   placeholder="Longitudine" class="small-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sede Principale</th>
                                        <td>
                                            <label>
                                                <input name="location1_is_main" type="checkbox" <?php checked($settings['location1_is_main']); ?> />
                                                È la sede principale
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Location 2 -->
                        <div class="card">
                            <h2>📍 Sede 2</h2>
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr>
                                        <th scope="row"><label for="location2_name">Nome Sede</label></th>
                                        <td>
                                            <input name="location2_name" type="text" id="location2_name" 
                                                   value="<?php echo esc_attr($settings['location2_name']); ?>" class="regular-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label for="location2_address">Indirizzo</label></th>
                                        <td>
                                            <input name="location2_address" type="text" id="location2_address" 
                                                   value="<?php echo esc_attr($settings['location2_address']); ?>" class="regular-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label for="location2_city">Città</label></th>
                                        <td>
                                            <input name="location2_city" type="text" id="location2_city" 
                                                   value="<?php echo esc_attr($settings['location2_city']); ?>" class="regular-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Coordinate GPS</th>
                                        <td>
                                            <input name="location2_latitude" type="text" 
                                                   value="<?php echo esc_attr($settings['location2_latitude']); ?>" 
                                                   placeholder="Latitudine" class="small-text" />
                                            <input name="location2_longitude" type="text" 
                                                   value="<?php echo esc_attr($settings['location2_longitude']); ?>" 
                                                   placeholder="Longitudine" class="small-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sede Principale</th>
                                        <td>
                                            <label>
                                                <input name="location2_is_main" type="checkbox" <?php checked($settings['location2_is_main']); ?> />
                                                È la sede principale
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Hours Tab -->
                <div id="hours" class="tab-content">
                    <div class="card">
                        <h2>🕒 Orari di Apertura</h2>
                        <table class="form-table" role="presentation">
                            <tbody>
                                <?php
                                $days = array(
                                    'monday' => 'Lunedì',
                                    'tuesday' => 'Martedì',
                                    'wednesday' => 'Mercoledì',
                                    'thursday' => 'Giovedì',
                                    'friday' => 'Venerdì',
                                    'saturday' => 'Sabato',
                                    'sunday' => 'Domenica'
                                );
                                
                                foreach ($days as $day_key => $day_name) :
                                    $day_settings = $settings['opening_hours'][$day_key] ?? array();
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $day_name; ?></th>
                                        <td>
                                            <label style="margin-right: 20px;">
                                                <input type="checkbox" name="<?php echo $day_key; ?>_closed" 
                                                       <?php checked(!empty($day_settings['closed'])); ?> 
                                                       onchange="toggleDayHours('<?php echo $day_key; ?>')" />
                                                Chiuso
                                            </label>
                                            
                                            <div id="<?php echo $day_key; ?>_hours" style="<?php echo !empty($day_settings['closed']) ? 'display:none;' : ''; ?>">
                                                <input type="time" name="<?php echo $day_key; ?>_open" 
                                                       value="<?php echo esc_attr($day_settings['open'] ?? ''); ?>" />
                                                <span style="margin: 0 10px;">-</span>
                                                <input type="time" name="<?php echo $day_key; ?>_close" 
                                                       value="<?php echo esc_attr($day_settings['close'] ?? ''); ?>" />
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Services Tab -->
                <div id="services" class="tab-content">
                    <div class="services-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="card">
                            <h2>🎨 Servizi Offerti</h2>
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr>
                                        <th scope="row">Servizi</th>
                                        <td>
                                            <fieldset>
                                                <label>
                                                    <input type="checkbox" name="service_exhibitions" <?php checked($settings['services']['exhibitions']); ?> />
                                                    Mostre d'Arte
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="service_art_consultation" <?php checked($settings['services']['art_consultation']); ?> />
                                                    Consulenza Artistica
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="service_private_viewings" <?php checked($settings['services']['private_viewings']); ?> />
                                                    Visite Private
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="service_art_valuation" <?php checked($settings['services']['art_valuation']); ?> />
                                                    Valutazioni d'Arte
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="service_framing" <?php checked($settings['services']['framing']); ?> />
                                                    Servizio Cornici
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="service_restoration" <?php checked($settings['services']['restoration']); ?> />
                                                    Restauro Opere
                                                </label>
                                            </fieldset>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label for="art_specialties">Specializzazioni Artistiche</label></th>
                                        <td>
                                            <textarea name="art_specialties" id="art_specialties" rows="6" class="large-text"><?php echo esc_textarea(implode("\n", $settings['art_specialties'])); ?></textarea>
                                            <p class="description">Una specializzazione per riga (es: Arte Povera, Transavanguardia, etc.)</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card">
                            <h2>💳 Metodi di Pagamento</h2>
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr>
                                        <th scope="row">Pagamenti Accettati</th>
                                        <td>
                                            <fieldset>
                                                <label>
                                                    <input type="checkbox" name="payment_cash" <?php checked($settings['payment_methods']['cash']); ?> />
                                                    💰 Contanti
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="payment_credit_card" <?php checked($settings['payment_methods']['credit_card']); ?> />
                                                    💳 Carte di Credito
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="payment_bank_transfer" <?php checked($settings['payment_methods']['bank_transfer']); ?> />
                                                    🏧 Bonifico Bancario
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="payment_paypal" <?php checked($settings['payment_methods']['paypal']); ?> />
                                                    💻 PayPal
                                                </label>
                                            </fieldset>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <h2>♿ Accessibilità</h2>
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr>
                                        <th scope="row">Caratteristiche</th>
                                        <td>
                                            <fieldset>
                                                <label>
                                                    <input type="checkbox" name="accessibility_wheelchair" <?php checked($settings['accessibility']['wheelchair_accessible']); ?> />
                                                    ♿ Accessibile in sedia a rotelle
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="accessibility_parking" <?php checked($settings['accessibility']['parking_available']); ?> />
                                                    🅿️ Parcheggio disponibile
                                                </label><br>
                                                
                                                <label>
                                                    <input type="checkbox" name="accessibility_transport" <?php checked($settings['accessibility']['public_transport']); ?> />
                                                    🚌 Facilmente raggiungibile con mezzi pubblici
                                                </label>
                                            </fieldset>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Tab -->
                <div id="contact" class="tab-content">
                    <div class="card">
                        <h2>📞 Informazioni Contatto</h2>
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="phone">Telefono</label></th>
                                    <td>
                                        <input name="phone" type="tel" id="phone" 
                                               value="<?php echo esc_attr($settings['phone']); ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="email">Email</label></th>
                                    <td>
                                        <input name="email" type="email" id="email" 
                                               value="<?php echo esc_attr($settings['email']); ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="website">Sito Web</label></th>
                                    <td>
                                        <input name="website" type="url" id="website" 
                                               value="<?php echo esc_attr($settings['website']); ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="whatsapp">WhatsApp</label></th>
                                    <td>
                                        <input name="whatsapp" type="tel" id="whatsapp" 
                                               value="<?php echo esc_attr($settings['whatsapp']); ?>" class="regular-text" />
                                        <p class="description">Numero WhatsApp (opzionale)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="instagram">Instagram</label></th>
                                    <td>
                                        <input name="instagram" type="url" id="instagram" 
                                               value="<?php echo esc_attr($settings['instagram']); ?>" class="regular-text" />
                                        <p class="description">URL profilo Instagram</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="facebook">Facebook</label></th>
                                    <td>
                                        <input name="facebook" type="url" id="facebook" 
                                               value="<?php echo esc_attr($settings['facebook']); ?>" class="regular-text" />
                                        <p class="description">URL pagina Facebook</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <?php submit_button('Salva Impostazioni Business'); ?>
        </form>
    </div>
    
    <style>
    .business-tabs .nav-tab-wrapper {
        margin-bottom: 20px;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .card {
        padding: 20px;
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.04);
        margin-bottom: 20px;
    }
    
    .card h2 {
        margin-top: 0;
        margin-bottom: 15px;
    }
    
    .locations-grid .card,
    .services-grid .card {
        margin-bottom: 0;
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        const tabs = document.querySelectorAll('.nav-tab');
        const contents = document.querySelectorAll('.tab-content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('nav-tab-active'));
                contents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('nav-tab-active');
                
                // Show corresponding content
                const target = this.getAttribute('href').substring(1);
                document.getElementById(target).classList.add('active');
            });
        });
    });
    
    function toggleDayHours(day) {
        const checkbox = document.querySelector('input[name="' + day + '_closed"]');
        const hoursDiv = document.getElementById(day + '_hours');
        
        if (checkbox.checked) {
            hoursDiv.style.display = 'none';
        } else {
            hoursDiv.style.display = 'block';
        }
    }
    </script>
    <?php
}

/**
 * Handle Local Business settings form submission action
 */
add_action('admin_post_galleria_local_business_settings', 'galleria_handle_local_business_settings');