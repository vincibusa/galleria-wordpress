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