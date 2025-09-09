 <?php
/**
 * Galleria Adalberto Catanzaro Theme Functions
 */

// Security: Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include migration script
require_once get_template_directory() . '/migration-script.php';

// Add admin menu for migration
add_action('admin_menu', 'galleria_add_migration_menu');

function galleria_add_migration_menu() {
    add_management_page(
        'Galleria Migration',
        'Galleria Migration', 
        'manage_options',
        'galleria-migration',
        'galleria_migration_page'
    );
}

function galleria_migration_page() {
    if (isset($_POST['run_migration'])) {
        run_migration();
        return;
    }
    ?>
    <div class="wrap">
        <h1>Galleria Migration Script</h1>
        <p>This will migrate artists, exhibitions, and news from your Next.js data to WordPress.</p>
        
        <form method="post" style="margin-top: 20px;">
            <?php wp_nonce_field('galleria_migration', 'migration_nonce'); ?>
            <input type="submit" name="run_migration" class="button button-primary" value="Run Migration" onclick="return confirm('Are you sure you want to run the migration? This will create new posts in your database.');" />
        </form>
    </div>
    <?php
}

/**
 * Theme Customizer
 */
add_action('customize_register', 'galleria_customize_register');

function galleria_customize_register($wp_customize) {
    // Add Hero Section
    $wp_customize->add_section('galleria_hero', array(
        'title' => __('Hero Section', 'galleria'),
        'priority' => 30,
    ));
    
    // Hero Image
    $wp_customize->add_setting('galleria_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'galleria_hero_image', array(
        'label' => __('Hero Image', 'galleria'),
        'section' => 'galleria_hero',
        'settings' => 'galleria_hero_image',
    )));
    
    // Hero Title
    $wp_customize->add_setting('galleria_hero_title', array(
        'default' => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('galleria_hero_title', array(
        'type' => 'text',
        'label' => __('Hero Title', 'galleria'),
        'section' => 'galleria_hero',
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('galleria_hero_subtitle', array(
        'default' => get_bloginfo('description'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('galleria_hero_subtitle', array(
        'type' => 'text',
        'label' => __('Hero Subtitle', 'galleria'),
        'section' => 'galleria_hero',
    ));

    // Gallery Settings Section
    $wp_customize->add_section('galleria_settings', array(
        'title' => __('Impostazioni Galleria', 'galleria'),
        'priority' => 35,
    ));

    // Contact Information
    $wp_customize->add_setting('galleria_phone', array(
        'default' => '+39 327 167 7871',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('galleria_phone', array(
        'label' => __('Numero di Telefono', 'galleria'),
        'section' => 'galleria_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('galleria_email', array(
        'default' => 'catanzaroepartners@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('galleria_email', array(
        'label' => __('Email', 'galleria'),
        'section' => 'galleria_settings',
        'type' => 'email',
    ));

    // Addresses
    $wp_customize->add_setting('galleria_address_1', array(
        'default' => 'Via Montevergini 3, Palermo',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('galleria_address_1', array(
        'label' => __('Indirizzo Sede 1', 'galleria'),
        'section' => 'galleria_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('galleria_address_2', array(
        'default' => 'Corso Vittorio Emanuele 383, Palermo',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('galleria_address_2', array(
        'label' => __('Indirizzo Sede 2', 'galleria'),
        'section' => 'galleria_settings',
        'type' => 'text',
    ));

    // Opening Hours
    $wp_customize->add_setting('galleria_hours', array(
        'default' => 'Martedì–Sabato: 10:00–18:00',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('galleria_hours', array(
        'label' => __('Orari di Apertura', 'galleria'),
        'section' => 'galleria_settings',
        'type' => 'text',
    ));
}

/**
 * Theme setup
 */
function galleria_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'galleria'),
        'footer' => __('Footer Menu', 'galleria'),
    ));

    // Add image sizes
    add_image_size('gallery-card', 400, 400, true);
    add_image_size('gallery-hero', 1920, 800, true);
    add_image_size('gallery-medium', 800, 600, true);
}
add_action('after_setup_theme', 'galleria_theme_setup');

/**
 * Enqueue scripts and styles
 */
function galleria_scripts() {
    // Enqueue styles
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap', array(), null);
    wp_enqueue_style('galleria-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

    // Enqueue scripts
    wp_enqueue_script('galleria-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), wp_get_theme()->get('Version'), true);
    
    // Localize script for AJAX
    wp_localize_script('galleria-main', 'galleria_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('galleria_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'galleria_scripts');

/**
 * Register Custom Post Types
 */
function galleria_register_post_types() {
    // Artists Custom Post Type
    register_post_type('artist', array(
        'labels' => array(
            'name' => 'Artisti',
            'singular_name' => 'Artista',
            'add_new' => 'Aggiungi Artista',
            'add_new_item' => 'Aggiungi Nuovo Artista',
            'edit_item' => 'Modifica Artista',
            'new_item' => 'Nuovo Artista',
            'view_item' => 'Visualizza Artista',
            'search_items' => 'Cerca Artisti',
            'not_found' => 'Nessun artista trovato',
            'not_found_in_trash' => 'Nessun artista nel cestino',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'artists'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-admin-users',
        'show_in_rest' => true,
    ));

    // Exhibitions Custom Post Type
    register_post_type('exhibition', array(
        'labels' => array(
            'name' => 'Mostre',
            'singular_name' => 'Mostra',
            'add_new' => 'Aggiungi Mostra',
            'add_new_item' => 'Aggiungi Nuova Mostra',
            'edit_item' => 'Modifica Mostra',
            'new_item' => 'Nuova Mostra',
            'view_item' => 'Visualizza Mostra',
            'search_items' => 'Cerca Mostre',
            'not_found' => 'Nessuna mostra trovata',
            'not_found_in_trash' => 'Nessuna mostra nel cestino',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'exhibitions'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-format-gallery',
        'show_in_rest' => true,
    ));

    // Publications Custom Post Type
    register_post_type('publication', array(
        'labels' => array(
            'name' => 'Pubblicazioni',
            'singular_name' => 'Pubblicazione',
            'add_new' => 'Aggiungi Pubblicazione',
            'add_new_item' => 'Aggiungi Nuova Pubblicazione',
            'edit_item' => 'Modifica Pubblicazione',
            'new_item' => 'Nuova Pubblicazione',
            'view_item' => 'Visualizza Pubblicazione',
            'search_items' => 'Cerca Pubblicazioni',
            'not_found' => 'Nessuna pubblicazione trovata',
            'not_found_in_trash' => 'Nessuna pubblicazione nel cestino',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'publications'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-book',
        'show_in_rest' => true,
    ));

    // Projects Custom Post Type
    register_post_type('project', array(
        'labels' => array(
            'name' => 'Progetti',
            'singular_name' => 'Progetto',
            'add_new' => 'Aggiungi Progetto',
            'add_new_item' => 'Aggiungi Nuovo Progetto',
            'edit_item' => 'Modifica Progetto',
            'new_item' => 'Nuovo Progetto',
            'view_item' => 'Visualizza Progetto',
            'search_items' => 'Cerca Progetti',
            'not_found' => 'Nessun progetto trovato',
            'not_found_in_trash' => 'Nessun progetto nel cestino',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'projects'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-portfolio',
        'show_in_rest' => true,
    ));
}
add_action('init', 'galleria_register_post_types');

/**
 * Register Custom Taxonomies
 */
function galleria_register_taxonomies() {
    // Exhibition Status Taxonomy
    register_taxonomy('exhibition_status', 'exhibition', array(
        'labels' => array(
            'name' => 'Status Mostra',
            'singular_name' => 'Status',
            'search_items' => 'Cerca Status',
            'all_items' => 'Tutti gli Status',
            'edit_item' => 'Modifica Status',
            'update_item' => 'Aggiorna Status',
            'add_new_item' => 'Aggiungi Nuovo Status',
            'new_item_name' => 'Nuovo Nome Status',
            'menu_name' => 'Status',
        ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'exhibition-status'),
        'show_in_rest' => true,
    ));

    // Location Taxonomy
    register_taxonomy('location', array('exhibition', 'artist'), array(
        'labels' => array(
            'name' => 'Sedi',
            'singular_name' => 'Sede',
            'search_items' => 'Cerca Sedi',
            'all_items' => 'Tutte le Sedi',
            'edit_item' => 'Modifica Sede',
            'update_item' => 'Aggiorna Sede',
            'add_new_item' => 'Aggiungi Nuova Sede',
            'new_item_name' => 'Nuovo Nome Sede',
            'menu_name' => 'Sedi',
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'location'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'galleria_register_taxonomies');

/**
 * Custom excerpt length
 */
function galleria_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'galleria_excerpt_length');

/**
 * Custom excerpt more
 */
function galleria_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'galleria_excerpt_more');

/**
 * Add ACF Options Page
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Impostazioni Galleria',
        'menu_title' => 'Opzioni Galleria',
        'menu_slug' => 'galleria-options',
        'capability' => 'edit_posts',
    ));
}

/**
 * Get featured exhibitions for homepage carousel
 */
function get_featured_exhibitions($limit = 5) {
    $args = array(
        'post_type' => 'exhibition',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => 'featured',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    return new WP_Query($args);
}

/**
 * Get current exhibitions
 */
function get_current_exhibitions($limit = -1) {
    $args = array(
        'post_type' => 'exhibition',
        'posts_per_page' => $limit,
        'tax_query' => array(
            array(
                'taxonomy' => 'exhibition_status',
                'field' => 'slug',
                'terms' => 'current',
            ),
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    return new WP_Query($args);
}

/**
 * Get past exhibitions
 */
function get_past_exhibitions($limit = -1) {
    $args = array(
        'post_type' => 'exhibition',
        'posts_per_page' => $limit,
        'tax_query' => array(
            array(
                'taxonomy' => 'exhibition_status',
                'field' => 'slug',
                'terms' => 'past',
            ),
        ),
        'orderby' => 'meta_value',
        'meta_key' => 'start_date',
        'order' => 'DESC'
    );
    
    return new WP_Query($args);
}

/**
 * Custom walker for navigation menu
 */
class Galleria_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Add structured data for gallery
 */
function galleria_add_structured_data() {
    if (is_front_page() || is_home()) {
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "ArtGallery",
            "name" => "Galleria Adalberto Catanzaro",
            "foundingDate" => "2014",
            "founder" => array(
                "@type" => "Person",
                "name" => "Adalberto Catanzaro"
            ),
            "description" => "Galleria d'arte contemporanea a Palermo dal 2014. Mostre di artisti italiani e internazionali, Arte Povera, Transavanguardia.",
            "url" => home_url(),
            "telephone" => "+39 327 167 7871",
            "email" => "catanzaroepartners@gmail.com",
            "address" => array(
                array(
                    "@type" => "PostalAddress",
                    "streetAddress" => "Via Montevergini 3",
                    "addressLocality" => "Palermo",
                    "postalCode" => "90133",
                    "addressCountry" => "IT"
                ),
                array(
                    "@type" => "PostalAddress",
                    "streetAddress" => "Corso Vittorio Emanuele 383",
                    "addressLocality" => "Palermo",
                    "postalCode" => "90133",
                    "addressCountry" => "IT"
                )
            ),
            "openingHours" => "Tu-Sa 10:00-18:00",
            "sameAs" => array(
                get_site_url()
            )
        );

        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'galleria_add_structured_data');


/**
 * Add custom rewrite rule for /news/
 */
function galleria_add_news_rewrite_rule() {
    add_rewrite_rule('^news/?$', 'index.php?post_type=post', 'top');
    add_rewrite_rule('^news/page/([0-9]+)/?$', 'index.php?post_type=post&paged=$matches[1]', 'top');
}
add_action('init', 'galleria_add_news_rewrite_rule');

/**
 * Flush rewrite rules on theme activation
 */
function galleria_flush_rewrite_rules() {
    galleria_add_news_rewrite_rule();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'galleria_flush_rewrite_rules');

/**
 * SMTP Configuration for Email Delivery
 * Configures WordPress to send emails via SMTP without plugins
 */

// Get SMTP settings from database or constants
function galleria_get_smtp_settings() {
    // Priority 1: Constants (backward compatibility)
    if (defined('GALLERIA_SMTP_HOST') && defined('GALLERIA_SMTP_USER') && defined('GALLERIA_SMTP_PASS')) {
        return array(
            'host' => GALLERIA_SMTP_HOST,
            'port' => defined('GALLERIA_SMTP_PORT') ? GALLERIA_SMTP_PORT : 587,
            'secure' => defined('GALLERIA_SMTP_SECURE') ? GALLERIA_SMTP_SECURE : 'tls',
            'username' => GALLERIA_SMTP_USER,
            'password' => GALLERIA_SMTP_PASS,
            'from_email' => defined('GALLERIA_SMTP_FROM') ? GALLERIA_SMTP_FROM : GALLERIA_SMTP_USER,
            'from_name' => defined('GALLERIA_SMTP_FROM_NAME') ? GALLERIA_SMTP_FROM_NAME : 'Galleria Adalberto Catanzaro',
            'debug' => defined('GALLERIA_SMTP_DEBUG') ? GALLERIA_SMTP_DEBUG : false,
            'source' => 'constants'
        );
    }
    
    // Priority 2: Database settings
    $db_settings = get_option('galleria_smtp_settings', array());
    if (!empty($db_settings['host']) && !empty($db_settings['username']) && !empty($db_settings['password'])) {
        // Decrypt password
        $db_settings['password'] = galleria_decrypt_password($db_settings['password']);
        $db_settings['source'] = 'database';
        return $db_settings;
    }
    
    return false;
}

// Encrypt password for database storage
function galleria_encrypt_password($password) {
    if (empty($password)) return '';
    
    $key = wp_salt('secure_auth');
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Decrypt password from database
function galleria_decrypt_password($encrypted_password) {
    if (empty($encrypted_password)) return '';
    
    $key = wp_salt('secure_auth');
    $data = base64_decode($encrypted_password);
    if (strpos($data, '::') === false) return $encrypted_password; // Not encrypted
    
    list($encrypted, $iv) = explode('::', $data);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}

// Configure SMTP settings
function galleria_configure_smtp($phpmailer) {
    $settings = galleria_get_smtp_settings();
    if (!$settings) {
        return;
    }
    
    $phpmailer->isSMTP();
    $phpmailer->Host       = $settings['host'];
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = $settings['port'];
    $phpmailer->Username   = $settings['username'];
    $phpmailer->Password   = $settings['password'];
    $phpmailer->SMTPSecure = $settings['secure'];
    $phpmailer->From       = $settings['from_email'];
    $phpmailer->FromName   = $settings['from_name'];
    
    // Enable SMTP debug if enabled
    if (!empty($settings['debug'])) {
        $phpmailer->SMTPDebug = 1;
        $phpmailer->Debugoutput = function($str, $level) {
            error_log("SMTP Debug Level $level: $str");
        };
    }
    
    // Additional SMTP options for better compatibility
    $phpmailer->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
}
add_action('phpmailer_init', 'galleria_configure_smtp');

/**
 * Set default From email and name for all emails
 */
function galleria_wp_mail_from($original_email_address) {
    $settings = galleria_get_smtp_settings();
    if ($settings && !empty($settings['from_email'])) {
        return $settings['from_email'];
    }
    return $original_email_address;
}

function galleria_wp_mail_from_name($original_email_from) {
    $settings = galleria_get_smtp_settings();
    if ($settings && !empty($settings['from_name'])) {
        return $settings['from_name'];
    }
    return $original_email_from;
}

add_filter('wp_mail_from', 'galleria_wp_mail_from');
add_filter('wp_mail_from_name', 'galleria_wp_mail_from_name');

/**
 * SMTP Error Handling and Logging
 */
function galleria_wp_mail_failed($wp_error) {
    error_log('WordPress Email Failed: ' . $wp_error->get_error_message());
    
    // Store error in transient for admin notice (if needed)
    if (is_admin()) {
        set_transient('galleria_smtp_error', $wp_error->get_error_message(), 60);
    }
}
add_action('wp_mail_failed', 'galleria_wp_mail_failed');

/**
 * Test email function for admin (optional)
 */
function galleria_smtp_test_email() {
    // Only allow for administrators
    if (!current_user_can('administrator')) {
        wp_die('Unauthorized');
    }
    
    if (!isset($_GET['galleria_test_email']) || !wp_verify_nonce($_GET['_wpnonce'], 'galleria_test_email')) {
        return;
    }
    
    $settings = galleria_get_smtp_settings();
    
    // Robust fallback logic for recipient email
    $to = '';
    $email_source = 'unknown';
    
    if ($settings) {
        // Priority 1: from_email if set and valid
        if (!empty($settings['from_email']) && is_email($settings['from_email'])) {
            $to = $settings['from_email'];
            $email_source = 'SMTP from_email';
        }
        // Priority 2: username if valid email
        elseif (!empty($settings['username']) && is_email($settings['username'])) {
            $to = $settings['username'];
            $email_source = 'SMTP username';
        }
    }
    
    // Priority 3: WordPress admin email
    if (empty($to)) {
        $admin_email = get_option('admin_email');
        if (!empty($admin_email) && is_email($admin_email)) {
            $to = $admin_email;
            $email_source = 'WordPress admin email';
        }
    }
    
    // Priority 4: Current user email
    if (empty($to)) {
        $current_user = wp_get_current_user();
        if ($current_user->user_email && is_email($current_user->user_email)) {
            $to = $current_user->user_email;
            $email_source = 'Current user email';
        }
    }
    
    // Final validation
    if (empty($to) || !is_email($to)) {
        error_log('SMTP Test Error: No valid recipient email found. Settings: ' . print_r($settings, true));
        wp_redirect(add_query_arg(array('smtp_test' => 'failed', 'smtp_error' => 'no_recipient'), wp_get_referer()));
        exit;
    }
    
    // Log test attempt
    error_log('SMTP Test: Sending to ' . $to . ' (source: ' . $email_source . ')');
    
    $subject = 'Test Email - Galleria Catanzaro SMTP';
    $message = 'Questo è un test per verificare che la configurazione SMTP funzioni correttamente.' . "\n\n";
    $message .= 'Destinatario: ' . $to . ' (' . $email_source . ')' . "\n";
    $message .= 'Configurazione utilizzata: ' . ($settings ? $settings['source'] : 'nessuna') . "\n";
    
    if ($settings) {
        $message .= 'Host: ' . $settings['host'] . "\n";
        $message .= 'Porta: ' . $settings['port'] . "\n";
        $message .= 'Sicurezza: ' . $settings['secure'] . "\n";
        $message .= 'Username: ' . $settings['username'] . "\n";
    }
    
    $message .= 'Data/Ora: ' . current_time('mysql') . "\n";
    $message .= 'IP Server: ' . ($_SERVER['SERVER_ADDR'] ?? 'unknown') . "\n";
    
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    $sent = wp_mail($to, $subject, $message, $headers);
    
    // Log result
    if ($sent) {
        error_log('SMTP Test: Email sent successfully to ' . $to);
        wp_redirect(add_query_arg(array('smtp_test' => 'success', 'test_email' => urlencode($to)), wp_get_referer()));
    } else {
        error_log('SMTP Test: Failed to send email to ' . $to);
        wp_redirect(add_query_arg('smtp_test', 'failed', wp_get_referer()));
    }
    exit;
}
add_action('admin_init', 'galleria_smtp_test_email');

/**
 * Add SMTP Settings menu to WordPress admin
 */
function galleria_smtp_admin_menu() {
    add_options_page(
        'SMTP Settings',
        'SMTP Settings', 
        'manage_options',
        'galleria-smtp-settings',
        'galleria_smtp_settings_page'
    );
}
add_action('admin_menu', 'galleria_smtp_admin_menu');

/**
 * Admin notice for SMTP configuration
 */
function galleria_smtp_admin_notice() {
    $settings = galleria_get_smtp_settings();
    
    // Show configuration notice if SMTP is not configured
    if (!$settings && current_user_can('administrator')) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Galleria SMTP:</strong> Configurazione email non trovata. ';
        echo '<a href="' . admin_url('options-general.php?page=galleria-smtp-settings') . '">Configura SMTP</a> ';
        echo 'per garantire la consegna delle email del form di contatto.</p>';
        echo '</div>';
    }
    
    // Show configuration source info
    if ($settings && isset($_GET['page']) && $_GET['page'] === 'galleria-smtp-settings') {
        $source = $settings['source'] === 'constants' ? 'file wp-config.php' : 'database WordPress';
        echo '<div class="notice notice-info">';
        echo '<p><strong>Info:</strong> Configurazione SMTP attiva dal ' . $source . '.</p>';
        if ($settings['source'] === 'constants') {
            echo '<p><em>Le impostazioni da wp-config.php hanno priorità su quelle del database.</em></p>';
        }
        echo '</div>';
    }
    
    // Show test results
    if (isset($_GET['smtp_test'])) {
        if ($_GET['smtp_test'] === 'success') {
            echo '<div class="notice notice-success is-dismissible"><p><strong>Email Test:</strong> Email inviata con successo!</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Email Test:</strong> Invio fallito. Controlla la configurazione SMTP.</p></div>';
        }
    }
    
    // Show settings saved message
    if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true' && isset($_GET['page']) && $_GET['page'] === 'galleria-smtp-settings') {
        echo '<div class="notice notice-success is-dismissible"><p><strong>Impostazioni salvate!</strong> Puoi testare l\'invio email.</p></div>';
    }
    
    // Show SMTP errors
    $error = get_transient('galleria_smtp_error');
    if ($error) {
        echo '<div class="notice notice-error is-dismissible">';
        echo '<p><strong>SMTP Error:</strong> ' . esc_html($error) . '</p>';
        echo '</div>';
        delete_transient('galleria_smtp_error');
    }
}
add_action('admin_notices', 'galleria_smtp_admin_notice');

/**
 * Add SMTP test link to admin bar (for administrators)
 */
function galleria_smtp_admin_bar($wp_admin_bar) {
    if (!current_user_can('administrator')) {
        return;
    }
    
    $settings = galleria_get_smtp_settings();
    if (!$settings) {
        return;
    }
    
    $test_url = wp_nonce_url(add_query_arg('galleria_test_email', '1'), 'galleria_test_email');
    
    $wp_admin_bar->add_node(array(
        'id'    => 'smtp-test',
        'title' => 'Test SMTP',
        'href'  => $test_url,
        'meta'  => array(
            'title' => 'Invia email di test per verificare configurazione SMTP'
        )
    ));
}
add_action('admin_bar_menu', 'galleria_smtp_admin_bar', 999);

/**
 * Handle SMTP Settings form submissions (before any output)
 */
function galleria_handle_smtp_settings() {
    // Only process on our admin page
    if (!isset($_GET['page']) || $_GET['page'] !== 'galleria-smtp-settings') {
        return;
    }
    
    // Handle form submission
    if (isset($_POST['submit']) && wp_verify_nonce($_POST['smtp_nonce'], 'galleria_smtp_settings')) {
        $settings = array(
            'host' => sanitize_text_field($_POST['smtp_host']),
            'port' => intval($_POST['smtp_port']),
            'secure' => sanitize_text_field($_POST['smtp_secure']),
            'username' => sanitize_email($_POST['smtp_username']),
            'password' => galleria_encrypt_password($_POST['smtp_password']),
            'from_email' => sanitize_email($_POST['smtp_from_email']),
            'from_name' => sanitize_text_field($_POST['smtp_from_name']),
            'debug' => isset($_POST['smtp_debug']) ? true : false
        );
        
        update_option('galleria_smtp_settings', $settings);
        wp_redirect(add_query_arg(array('page' => 'galleria-smtp-settings', 'settings-updated' => 'true'), admin_url('options-general.php')));
        exit;
    }
    
    // Handle reset
    if (isset($_POST['reset']) && wp_verify_nonce($_POST['smtp_nonce'], 'galleria_smtp_settings')) {
        delete_option('galleria_smtp_settings');
        wp_redirect(add_query_arg(array('page' => 'galleria-smtp-settings', 'reset' => 'true'), admin_url('options-general.php')));
        exit;
    }
}
add_action('admin_init', 'galleria_handle_smtp_settings');

/**
 * SMTP Settings Page
 */
function galleria_smtp_settings_page() {
    
    $current_settings = galleria_get_smtp_settings();
    $db_settings = get_option('galleria_smtp_settings', array());
    
    // Get presets
    $presets = array(
        'gmail' => array(
            'name' => 'Gmail',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'secure' => 'tls'
        ),
        'outlook' => array(
            'name' => 'Outlook/Hotmail',
            'host' => 'smtp-mail.outlook.com',
            'port' => 587,
            'secure' => 'tls'
        ),
        'yahoo' => array(
            'name' => 'Yahoo Mail',
            'host' => 'smtp.mail.yahoo.com',
            'port' => 587,
            'secure' => 'tls'
        )
    );
    
    ?>
    <div class="wrap">
        <h1>📧 SMTP Settings - Galleria Catanzaro</h1>
        
        <?php if (isset($_GET['reset'])): ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Configurazione SMTP eliminata!</strong></p>
            </div>
        <?php endif; ?>
        
        <div class="smtp-settings-container" style="display: flex; gap: 20px;">
            <div class="smtp-form" style="flex: 2;">
                <form method="post" action="">
                    <?php wp_nonce_field('galleria_smtp_settings', 'smtp_nonce'); ?>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label>Preset Rapidi</label>
                            </th>
                            <td>
                                <select id="smtp-preset" onchange="applyPreset()">
                                    <option value="">Seleziona preset...</option>
                                    <?php foreach ($presets as $key => $preset): ?>
                                        <option value="<?php echo $key; ?>"><?php echo esc_html($preset['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description">Seleziona un preset per compilare automaticamente i campi</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="smtp_host">Host SMTP *</label>
                            </th>
                            <td>
                                <input type="text" id="smtp_host" name="smtp_host" 
                                       value="<?php echo esc_attr($db_settings['host'] ?? ''); ?>" 
                                       class="regular-text" required
                                       <?php echo ($current_settings && $current_settings['source'] === 'constants') ? 'readonly' : ''; ?>>
                                <p class="description">Es: smtp.gmail.com</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="smtp_port">Porta *</label>
                            </th>
                            <td>
                                <input type="number" id="smtp_port" name="smtp_port" 
                                       value="<?php echo esc_attr($db_settings['port'] ?? '587'); ?>" 
                                       min="1" max="65535" required
                                       <?php echo ($current_settings && $current_settings['source'] === 'constants') ? 'readonly' : ''; ?>>
                                <p class="description">Solitamente 587 (TLS) o 465 (SSL)</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="smtp_secure">Crittografia *</label>
                            </th>
                            <td>
                                <select id="smtp_secure" name="smtp_secure" required
                                        <?php echo ($current_settings && $current_settings['source'] === 'constants') ? 'disabled' : ''; ?>>
                                    <option value="tls" <?php selected($db_settings['secure'] ?? 'tls', 'tls'); ?>>TLS</option>
                                    <option value="ssl" <?php selected($db_settings['secure'] ?? '', 'ssl'); ?>>SSL</option>
                                </select>
                                <p class="description">TLS è raccomandato per la maggior parte dei provider</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="smtp_username">Username *</label>
                            </th>
                            <td>
                                <input type="email" id="smtp_username" name="smtp_username" 
                                       value="<?php echo esc_attr($db_settings['username'] ?? ''); ?>" 
                                       class="regular-text" required
                                       <?php echo ($current_settings && $current_settings['source'] === 'constants') ? 'readonly' : ''; ?>>
                                <p class="description">La tua email completa (es: nome@gmail.com)</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="smtp_password">Password *</label>
                            </th>
                            <td>
                                <input type="password" id="smtp_password" name="smtp_password" 
                                       value="" class="regular-text" required
                                       placeholder="<?php echo !empty($db_settings['password']) ? '••••••••••••••••' : 'Inserisci password...'; ?>"
                                       <?php echo ($current_settings && $current_settings['source'] === 'constants') ? 'readonly' : ''; ?>>
                                <p class="description">
                                    <strong>Per Gmail:</strong> Usa una "App Password", non la password normale.<br>
                                    <a href="https://myaccount.google.com/apppasswords" target="_blank">Genera App Password per Gmail</a>
                                </p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="smtp_from_email">Email Mittente</label>
                            </th>
                            <td>
                                <input type="email" id="smtp_from_email" name="smtp_from_email" 
                                       value="<?php echo esc_attr($db_settings['from_email'] ?? ''); ?>" 
                                       class="regular-text"
                                       <?php echo ($current_settings && $current_settings['source'] === 'constants') ? 'readonly' : ''; ?>>
                                <p class="description">Lascia vuoto per usare lo username</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="smtp_from_name">Nome Mittente</label>
                            </th>
                            <td>
                                <input type="text" id="smtp_from_name" name="smtp_from_name" 
                                       value="<?php echo esc_attr($db_settings['from_name'] ?? 'Galleria Adalberto Catanzaro'); ?>" 
                                       class="regular-text"
                                       <?php echo ($current_settings && $current_settings['source'] === 'constants') ? 'readonly' : ''; ?>>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="smtp_debug">Debug SMTP</label>
                            </th>
                            <td>
                                <label>
                                    <input type="checkbox" id="smtp_debug" name="smtp_debug" 
                                           <?php checked($db_settings['debug'] ?? false); ?>
                                           <?php echo ($current_settings && $current_settings['source'] === 'constants') ? 'disabled' : ''; ?>>
                                    Abilita debug SMTP (per troubleshooting)
                                </label>
                                <p class="description">I log di debug verranno scritti nel file di log di WordPress</p>
                            </td>
                        </tr>
                    </table>
                    
                    <?php if (!$current_settings || $current_settings['source'] !== 'constants'): ?>
                        <p class="submit">
                            <input type="submit" name="submit" class="button-primary" value="Salva Configurazione">
                            <input type="submit" name="reset" class="button" value="Reset Configurazione" 
                                   onclick="return confirm('Sei sicuro di voler eliminare la configurazione SMTP?')">
                        </p>
                    <?php else: ?>
                        <div class="notice notice-info inline">
                            <p><strong>Nota:</strong> La configurazione è definita nel file wp-config.php e ha priorità su queste impostazioni.</p>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="smtp-info" style="flex: 1; background: #f9f9f9; padding: 20px; border-radius: 5px;">
                <h3>📋 Status Configurazione</h3>
                <?php if ($current_settings): ?>
                    <div class="smtp-status" style="padding: 10px; background: #d1e7dd; border-left: 4px solid #0f5132; margin: 10px 0;">
                        <strong>✅ SMTP Configurato</strong><br>
                        <small>
                            Host: <?php echo esc_html($current_settings['host']); ?><br>
                            Porta: <?php echo esc_html($current_settings['port']); ?><br>
                            Username: <?php echo esc_html($current_settings['username']); ?><br>
                            Fonte: <?php echo esc_html($current_settings['source'] === 'constants' ? 'wp-config.php' : 'Database'); ?>
                        </small>
                    </div>
                    
                    <a href="<?php echo wp_nonce_url(add_query_arg('galleria_test_email', '1'), 'galleria_test_email'); ?>" 
                       class="button button-secondary" style="width: 100%; text-align: center; margin: 10px 0;">
                        📤 Invia Test Email
                    </a>
                <?php else: ?>
                    <div class="smtp-status" style="padding: 10px; background: #f8d7da; border-left: 4px solid #842029; margin: 10px 0;">
                        <strong>❌ SMTP Non Configurato</strong><br>
                        <small>Configura SMTP per garantire la consegna delle email</small>
                    </div>
                <?php endif; ?>
                
                <h4>🔧 Provider Popolari</h4>
                <ul style="font-size: 12px;">
                    <li><strong>Gmail:</strong> smtp.gmail.com:587 (TLS)</li>
                    <li><strong>Outlook:</strong> smtp-mail.outlook.com:587 (TLS)</li>
                    <li><strong>Yahoo:</strong> smtp.mail.yahoo.com:587 (TLS)</li>
                </ul>
                
                <h4>💡 Suggerimenti</h4>
                <ul style="font-size: 12px;">
                    <li>Per Gmail, usa sempre una "App Password"</li>
                    <li>Attiva la verifica a 2 fattori</li>
                    <li>Testa sempre dopo la configurazione</li>
                    <li>Controlla la cartella spam se non ricevi l'email</li>
                </ul>
            </div>
        </div>
    </div>
    
    <script>
    const presets = <?php echo json_encode($presets); ?>;
    
    function applyPreset() {
        const select = document.getElementById('smtp-preset');
        const presetKey = select.value;
        
        if (presetKey && presets[presetKey]) {
            const preset = presets[presetKey];
            document.getElementById('smtp_host').value = preset.host;
            document.getElementById('smtp_port').value = preset.port;
            document.getElementById('smtp_secure').value = preset.secure;
        }
    }
    </script>
    
    <style>
    .smtp-settings-container .form-table th {
        width: 150px;
    }
    .smtp-settings-container input[readonly],
    .smtp-settings-container select[disabled] {
        background-color: #f0f0f0;
        color: #666;
    }
    .smtp-info h3, .smtp-info h4 {
        margin-top: 0;
    }
    .smtp-info ul {
        margin: 5px 0;
        padding-left: 20px;
    }
    </style>
    <?php
}

/**
 * Include additional files
 */
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/seo-optimization.php';

/**
 * AJAX handlers for theme functionality
 */
function galleria_load_more_posts() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'galleria_nonce')) {
        wp_die('Security check failed');
    }

    $page = intval($_POST['page']);
    $post_type = sanitize_text_field($_POST['post_type']);
    
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 6,
        'paged' => $page,
        'post_status' => 'publish'
    );

    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        ob_start();
        
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/content', $post_type);
        endwhile;
        
        $html = ob_get_clean();
        wp_reset_postdata();
        
        wp_send_json_success(array('html' => $html));
    } else {
        wp_send_json_error('No more posts');
    }
}
add_action('wp_ajax_galleria_load_more', 'galleria_load_more_posts');
add_action('wp_ajax_nopriv_galleria_load_more', 'galleria_load_more_posts');

/**
 * Get WooCommerce cart count via AJAX
 */
function galleria_get_cart_count() {
    if (!wp_verify_nonce($_POST['nonce'], 'galleria_nonce')) {
        wp_die('Security check failed');
    }

    $count = 0;
    if (class_exists('WooCommerce')) {
        $count = WC()->cart->get_cart_contents_count();
    }

    wp_send_json_success(array('count' => $count));
}
add_action('wp_ajax_galleria_get_cart_count', 'galleria_get_cart_count');
add_action('wp_ajax_nopriv_galleria_get_cart_count', 'galleria_get_cart_count');

/**
 * Handle contact form submission
 */
function galleria_handle_contact_form() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['contact_nonce'], 'galleria_contact_form')) {
        wp_die('Security check failed');
    }

    // Sanitize form data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    $privacy = isset($_POST['contact_privacy']);

    // Validation
    $errors = array();
    
    if (empty($name)) {
        $errors[] = 'Nome è richiesto';
    }
    
    if (empty($email) || !is_email($email)) {
        $errors[] = 'Email valida è richiesta';
    }
    
    if (empty($subject)) {
        $errors[] = 'Oggetto è richiesto';
    }
    
    if (empty($message)) {
        $errors[] = 'Messaggio è richiesto';
    }
    
    if (!$privacy) {
        $errors[] = 'Consenso privacy è richiesto';
    }

    // If there are errors, redirect with error message
    if (!empty($errors)) {
        $redirect_url = add_query_arg(array(
            'contact' => 'error',
            'message' => urlencode(implode(', ', $errors))
        ), wp_get_referer());
        wp_redirect($redirect_url);
        exit;
    }

    // Prepare email
    $to = get_option('admin_email');
    $email_subject = sprintf('[%s] Nuovo messaggio da %s', get_bloginfo('name'), $name);
    
    $email_message = sprintf(
        "Nuovo messaggio dal sito web:\n\n" .
        "Nome: %s\n" .
        "Email: %s\n" .
        "Telefono: %s\n" .
        "Oggetto: %s\n\n" .
        "Messaggio:\n%s\n\n" .
        "---\n" .
        "Inviato da: %s\n" .
        "IP: %s\n" .
        "Data: %s",
        $name,
        $email,
        $phone ?: 'Non fornito',
        $subject,
        $message,
        home_url(),
        $_SERVER['REMOTE_ADDR'],
        current_time('mysql')
    );

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $email
    );

    // Send email
    $mail_sent = wp_mail($to, $email_subject, $email_message, $headers);

    // Redirect with success/failure message
    if ($mail_sent) {
        $redirect_url = add_query_arg(array(
            'contact' => 'success',
            'message' => urlencode('Grazie! Il tuo messaggio è stato inviato correttamente.')
        ), wp_get_referer());
    } else {
        $redirect_url = add_query_arg(array(
            'contact' => 'error',
            'message' => urlencode('Errore nell\'invio del messaggio. Riprova più tardi.')
        ), wp_get_referer());
    }

    wp_redirect($redirect_url);
    exit;
}
add_action('admin_post_galleria_contact_form', 'galleria_handle_contact_form');
add_action('admin_post_nopriv_galleria_contact_form', 'galleria_handle_contact_form');

/**
 * SEO Settings Management
 * Gestione SEO dalla dashboard WordPress
 */

/**
 * Add SEO Settings menu to WordPress admin
 */
function galleria_seo_admin_menu() {
    add_options_page(
        'Impostazioni SEO Galleria',
        'SEO Galleria', 
        'manage_options',
        'galleria-seo-settings',
        'galleria_seo_settings_page'
    );
}
add_action('admin_menu', 'galleria_seo_admin_menu');

/**
 * Get SEO settings with defaults
 */
function galleria_get_seo_settings() {
    $defaults = array(
        'site_name' => 'Galleria Adalberto Catanzaro',
        'site_tagline' => 'Arte Contemporanea Palermo',
        'meta_author' => 'Galleria Adalberto Catanzaro',
        'theme_color' => '#111827',
        'homepage_title' => 'Galleria Adalberto Catanzaro - Arte Contemporanea Palermo',
        'homepage_description' => 'Galleria d\'arte contemporanea a Palermo dal 2014. Mostre di artisti italiani e internazionali, Arte Povera, Transavanguardia.',
        'artists_page_title' => 'Artisti - Arte Contemporanea | Galleria Adalberto Catanzaro Palermo',
        'artists_page_description' => 'Scopri gli artisti contemporanei rappresentati dalla Galleria Adalberto Catanzaro di Palermo. Arte Povera, Transavanguardia e ricerca artistica contemporanea.',
        'exhibitions_page_title' => 'Mostre - Arte Contemporanea | Galleria Adalberto Catanzaro Palermo',
        'exhibitions_page_description' => 'Mostre di arte contemporanea presso la Galleria Adalberto Catanzaro di Palermo. Esposizioni di artisti italiani e internazionali, Arte Povera e Transavanguardia.',
        'artist_title_template' => '{artist_name} - Artista | {site_name}',
        'exhibition_title_template' => '{exhibition_title} - {artist_name} ({year}) | {site_name}',
        'artist_description_template' => 'Scopri le opere di {artist_name}, artista contemporaneo. {biography} | {site_name}, Palermo.',
        'exhibition_description_template' => 'Mostra "{exhibition_title}" di {artist_name} ({year}) presso la {site_name}, Palermo.'
    );

    $settings = get_option('galleria_seo_settings', array());
    return wp_parse_args($settings, $defaults);
}

/**
 * Handle SEO Settings form submission
 */
function galleria_handle_seo_settings() {
    if (!isset($_POST['galleria_seo_nonce']) || !wp_verify_nonce($_POST['galleria_seo_nonce'], 'galleria_seo_settings')) {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    // Sanitize and save settings
    $settings = array();
    $fields = array(
        'site_name', 'site_tagline', 'meta_author', 'theme_color',
        'homepage_title', 'homepage_description',
        'artists_page_title', 'artists_page_description',
        'exhibitions_page_title', 'exhibitions_page_description',
        'artist_title_template', 'exhibition_title_template',
        'artist_description_template', 'exhibition_description_template'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            // Special handling for textarea fields
            if (in_array($field, array('homepage_description', 'artists_page_description', 'exhibitions_page_description', 'artist_description_template', 'exhibition_description_template'))) {
                $settings[$field] = sanitize_textarea_field($value);
            } else {
                $settings[$field] = sanitize_text_field($value);
            }
            
            // Validate color field
            if ($field === 'theme_color' && !preg_match('/^#[a-fA-F0-9]{6}$/', $settings[$field])) {
                $settings[$field] = '#111827'; // default color
            }
            
            // Ensure templates have required variables
            if ($field === 'artist_title_template' && strpos($settings[$field], '{artist_name}') === false) {
                $settings[$field] = '{artist_name} - Artista | {site_name}'; // fallback
            }
            if ($field === 'exhibition_title_template' && strpos($settings[$field], '{exhibition_title}') === false) {
                $settings[$field] = '{exhibition_title} - {artist_name} ({year}) | {site_name}'; // fallback
            }
        }
    }

    update_option('galleria_seo_settings', $settings);

    wp_redirect(add_query_arg('seo_updated', '1', wp_get_referer()));
    exit;
}
add_action('admin_init', 'galleria_handle_seo_settings');

/**
 * SEO Settings page content
 */
function galleria_seo_settings_page() {
    $settings = galleria_get_seo_settings();
    
    ?>
    <div class="wrap">
        <h1>Impostazioni SEO Galleria</h1>
        
        <?php if (isset($_GET['seo_updated'])) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Impostazioni SEO aggiornate con successo!</strong></p>
            </div>
        <?php endif; ?>
        
        <div class="card" style="max-width: none;">
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="galleria_seo_settings">
                <?php wp_nonce_field('galleria_seo_settings', 'galleria_seo_nonce'); ?>
                
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th colspan="2"><h2>Informazioni Generali</h2></th>
                        </tr>
                        <tr>
                            <th scope="row"><label for="site_name">Nome Sito</label></th>
                            <td>
                                <input name="site_name" type="text" id="site_name" value="<?php echo esc_attr($settings['site_name']); ?>" class="regular-text" />
                                <p class="description">Nome della galleria utilizzato nei meta tag e titoli</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="site_tagline">Tagline Sito</label></th>
                            <td>
                                <input name="site_tagline" type="text" id="site_tagline" value="<?php echo esc_attr($settings['site_tagline']); ?>" class="regular-text" />
                                <p class="description">Breve descrizione che accompagna il nome</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="meta_author">Autore Meta Tag</label></th>
                            <td>
                                <input name="meta_author" type="text" id="meta_author" value="<?php echo esc_attr($settings['meta_author']); ?>" class="regular-text" />
                                <p class="description">Valore del meta tag author</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="theme_color">Theme Color</label></th>
                            <td>
                                <input name="theme_color" type="color" id="theme_color" value="<?php echo esc_attr($settings['theme_color']); ?>" />
                                <p class="description">Colore del tema per browser mobile</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th colspan="2"><h2>Homepage</h2></th>
                        </tr>
                        <tr>
                            <th scope="row"><label for="homepage_title">Titolo Homepage</label></th>
                            <td>
                                <input name="homepage_title" type="text" id="homepage_title" value="<?php echo esc_attr($settings['homepage_title']); ?>" class="large-text" />
                                <p class="description">Titolo principale della homepage</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="homepage_description">Descrizione Homepage</label></th>
                            <td>
                                <textarea name="homepage_description" id="homepage_description" rows="3" class="large-text"><?php echo esc_textarea($settings['homepage_description']); ?></textarea>
                                <p class="description">Meta description per la homepage</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th colspan="2"><h2>Pagina Artisti</h2></th>
                        </tr>
                        <tr>
                            <th scope="row"><label for="artists_page_title">Titolo Pagina Artisti</label></th>
                            <td>
                                <input name="artists_page_title" type="text" id="artists_page_title" value="<?php echo esc_attr($settings['artists_page_title']); ?>" class="large-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="artists_page_description">Descrizione Pagina Artisti</label></th>
                            <td>
                                <textarea name="artists_page_description" id="artists_page_description" rows="3" class="large-text"><?php echo esc_textarea($settings['artists_page_description']); ?></textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <th colspan="2"><h2>Pagina Mostre</h2></th>
                        </tr>
                        <tr>
                            <th scope="row"><label for="exhibitions_page_title">Titolo Pagina Mostre</label></th>
                            <td>
                                <input name="exhibitions_page_title" type="text" id="exhibitions_page_title" value="<?php echo esc_attr($settings['exhibitions_page_title']); ?>" class="large-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="exhibitions_page_description">Descrizione Pagina Mostre</label></th>
                            <td>
                                <textarea name="exhibitions_page_description" id="exhibitions_page_description" rows="3" class="large-text"><?php echo esc_textarea($settings['exhibitions_page_description']); ?></textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <th colspan="2"><h2>Template Singoli Artisti/Mostre</h2></th>
                        </tr>
                        <tr>
                            <th scope="row"><label for="artist_title_template">Template Titolo Artista</label></th>
                            <td>
                                <input name="artist_title_template" type="text" id="artist_title_template" value="<?php echo esc_attr($settings['artist_title_template']); ?>" class="large-text" />
                                <p class="description">Variabili disponibili: {artist_name}, {site_name}</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="exhibition_title_template">Template Titolo Mostra</label></th>
                            <td>
                                <input name="exhibition_title_template" type="text" id="exhibition_title_template" value="<?php echo esc_attr($settings['exhibition_title_template']); ?>" class="large-text" />
                                <p class="description">Variabili: {exhibition_title}, {artist_name}, {year}, {site_name}</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="artist_description_template">Template Descrizione Artista</label></th>
                            <td>
                                <textarea name="artist_description_template" id="artist_description_template" rows="3" class="large-text"><?php echo esc_textarea($settings['artist_description_template']); ?></textarea>
                                <p class="description">Variabili: {artist_name}, {biography}, {site_name}</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="exhibition_description_template">Template Descrizione Mostra</label></th>
                            <td>
                                <textarea name="exhibition_description_template" id="exhibition_description_template" rows="3" class="large-text"><?php echo esc_textarea($settings['exhibition_description_template']); ?></textarea>
                                <p class="description">Variabili: {exhibition_title}, {artist_name}, {year}, {site_name}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <?php submit_button('Salva Impostazioni SEO'); ?>
            </form>
        </div>
        
        <div class="card">
            <h2>Informazioni</h2>
            <p><strong>Come utilizzare i template:</strong></p>
            <ul>
                <li>I template utilizzano variabili tra parentesi graffe {} che vengono sostituite automaticamente</li>
                <li>Le impostazioni vengono applicate immediatamente a tutti i contenuti del sito</li>
                <li>Lasciare vuoto un campo per utilizzare il valore predefinito</li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * Handle SEO Settings form submission action
 */
add_action('admin_post_galleria_seo_settings', 'galleria_handle_seo_settings');