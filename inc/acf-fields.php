<?php
/**
 * ACF Field Groups Configuration
 * Questo file configura i campi personalizzati per i Custom Post Types
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Field Groups
 */
function galleria_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Artist Fields
    acf_add_local_field_group(array(
        'key' => 'group_artist_fields',
        'title' => 'Artist Information',
        'fields' => array(
            array(
                'key' => 'field_artist_biography',
                'label' => 'Biography',
                'name' => 'biography',
                'type' => 'textarea',
                'instructions' => 'Artist biography and description',
                'required' => 0,
                'rows' => 5,
            ),
            array(
                'key' => 'field_artist_birth_year',
                'label' => 'Birth Year',
                'name' => 'birth_year',
                'type' => 'number',
                'instructions' => 'Year the artist was born',
                'required' => 0,
                'min' => 1800,
                'max' => date('Y'),
            ),
            array(
                'key' => 'field_artist_nationality',
                'label' => 'Nationality',
                'name' => 'nationality',
                'type' => 'text',
                'instructions' => 'Artist nationality',
                'required' => 0,
            ),
            array(
                'key' => 'field_artist_website',
                'label' => 'Website',
                'name' => 'website',
                'type' => 'url',
                'instructions' => 'Artist official website',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'artist',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));

    // Exhibition Fields
    acf_add_local_field_group(array(
        'key' => 'group_exhibition_fields',
        'title' => 'Exhibition Information',
        'fields' => array(
            array(
                'key' => 'field_exhibition_artist',
                'label' => 'Artist(s)',
                'name' => 'artist',
                'type' => 'text',
                'instructions' => 'Featured artist(s) for this exhibition',
                'required' => 1,
            ),
            array(
                'key' => 'field_exhibition_curator',
                'label' => 'Curator',
                'name' => 'curator',
                'type' => 'text',
                'instructions' => 'Exhibition curator',
                'required' => 0,
            ),
            array(
                'key' => 'field_exhibition_venue',
                'label' => 'Venue',
                'name' => 'venue',
                'type' => 'text',
                'instructions' => 'Exhibition venue/location name',
                'required' => 0,
            ),
            array(
                'key' => 'field_exhibition_location',
                'label' => 'Location',
                'name' => 'location',
                'type' => 'select',
                'instructions' => 'Select the location',
                'required' => 1,
                'choices' => array(
                    'palermo' => 'Palermo',
                    'bagheria' => 'Bagheria',
                    'other' => 'Other',
                ),
                'default_value' => 'palermo',
            ),
            array(
                'key' => 'field_exhibition_start_date',
                'label' => 'Start Date',
                'name' => 'start_date',
                'type' => 'date_picker',
                'instructions' => 'Exhibition start date',
                'required' => 1,
                'display_format' => 'd/m/Y',
                'return_format' => 'Y-m-d',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_exhibition_end_date',
                'label' => 'End Date',
                'name' => 'end_date',
                'type' => 'date_picker',
                'instructions' => 'Exhibition end date',
                'required' => 1,
                'display_format' => 'd/m/Y',
                'return_format' => 'Y-m-d',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_exhibition_featured',
                'label' => 'Featured Exhibition',
                'name' => 'featured',
                'type' => 'true_false',
                'instructions' => 'Show this exhibition in the homepage carousel',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'exhibition',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));

    // Publication Fields
    acf_add_local_field_group(array(
        'key' => 'group_publication_fields',
        'title' => 'Publication Information',
        'fields' => array(
            array(
                'key' => 'field_publication_author',
                'label' => 'Author(s)',
                'name' => 'author',
                'type' => 'text',
                'instructions' => 'Publication author(s)',
                'required' => 0,
            ),
            array(
                'key' => 'field_publication_isbn',
                'label' => 'ISBN',
                'name' => 'isbn',
                'type' => 'text',
                'instructions' => 'ISBN number',
                'required' => 0,
            ),
            array(
                'key' => 'field_publication_year',
                'label' => 'Publication Year',
                'name' => 'publication_year',
                'type' => 'number',
                'instructions' => 'Year of publication',
                'required' => 0,
                'min' => 1900,
                'max' => date('Y') + 1,
            ),
            array(
                'key' => 'field_publication_pages',
                'label' => 'Pages',
                'name' => 'pages',
                'type' => 'number',
                'instructions' => 'Number of pages',
                'required' => 0,
                'min' => 1,
            ),
            array(
                'key' => 'field_publication_price',
                'label' => 'Price',
                'name' => 'price',
                'type' => 'text',
                'instructions' => 'Publication price (e.g., €25.00)',
                'required' => 0,
            ),
            array(
                'key' => 'field_publication_buy_link',
                'label' => 'Buy Link',
                'name' => 'buy_link',
                'type' => 'url',
                'instructions' => 'Link to purchase the publication',
                'required' => 0,
            ),
            array(
                'key' => 'field_publication_featured',
                'label' => 'Featured Publication',
                'name' => 'featured',
                'type' => 'true_false',
                'instructions' => 'Show this publication on homepage',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'publication',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));

    // Homepage Options
    acf_add_local_field_group(array(
        'key' => 'group_homepage_options',
        'title' => 'Homepage Settings',
        'fields' => array(
            array(
                'key' => 'field_homepage_hero_text',
                'label' => 'Hero Text',
                'name' => 'hero_text',
                'type' => 'textarea',
                'instructions' => 'Text to display on homepage hero section',
                'required' => 0,
                'rows' => 3,
            ),
            array(
                'key' => 'field_homepage_show_publications',
                'label' => 'Show Publications Section',
                'name' => 'show_publications',
                'type' => 'true_false',
                'instructions' => 'Display publications section on homepage',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
            ),
            array(
                'key' => 'field_homepage_news_count',
                'label' => 'News Items Count',
                'name' => 'news_count',
                'type' => 'number',
                'instructions' => 'Number of news items to show on homepage',
                'required' => 0,
                'default_value' => 6,
                'min' => 3,
                'max' => 12,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'galleria-options',
                ),
            ),
        ),
        'menu_order' => 0,
    ));

    // Gallery Contact Information
    acf_add_local_field_group(array(
        'key' => 'group_gallery_contact',
        'title' => 'Gallery Information',
        'fields' => array(
            array(
                'key' => 'field_gallery_phone',
                'label' => 'Phone Number',
                'name' => 'gallery_phone',
                'type' => 'text',
                'instructions' => 'Main phone number',
                'required' => 0,
                'default_value' => '+39 327 167 7871',
            ),
            array(
                'key' => 'field_gallery_email',
                'label' => 'Email Address',
                'name' => 'gallery_email',
                'type' => 'email',
                'instructions' => 'Main email address',
                'required' => 0,
                'default_value' => 'catanzaroepartners@gmail.com',
            ),
            array(
                'key' => 'field_gallery_address_1',
                'label' => 'Address 1 (Montevergini)',
                'name' => 'gallery_address_1',
                'type' => 'textarea',
                'instructions' => 'First gallery address',
                'required' => 0,
                'rows' => 3,
                'default_value' => 'Via Montevergini 3
90133 Palermo',
            ),
            array(
                'key' => 'field_gallery_address_2',
                'label' => 'Address 2 (Corso Vittorio Emanuele)',
                'name' => 'gallery_address_2',
                'type' => 'textarea',
                'instructions' => 'Second gallery address',
                'required' => 0,
                'rows' => 3,
                'default_value' => 'Corso Vittorio Emanuele 383
90133 Palermo',
            ),
            array(
                'key' => 'field_gallery_hours',
                'label' => 'Opening Hours',
                'name' => 'gallery_hours',
                'type' => 'text',
                'instructions' => 'Gallery opening hours',
                'required' => 0,
                'default_value' => 'Martedì–Sabato: 10:00–18:00',
            ),
            array(
                'key' => 'field_gallery_social_links',
                'label' => 'Social Media Links',
                'name' => 'gallery_social_links',
                'type' => 'repeater',
                'instructions' => 'Add social media profiles',
                'required' => 0,
                'layout' => 'table',
                'button_label' => 'Add Social Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_social_platform',
                        'label' => 'Platform',
                        'name' => 'platform',
                        'type' => 'select',
                        'choices' => array(
                            'facebook' => 'Facebook',
                            'instagram' => 'Instagram',
                            'twitter' => 'Twitter',
                            'linkedin' => 'LinkedIn',
                            'youtube' => 'YouTube',
                        ),
                    ),
                    array(
                        'key' => 'field_social_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                        'required' => 1,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'galleria-options',
                ),
            ),
        ),
        'menu_order' => 1,
    ));
}

// Hook to initialize ACF fields
add_action('acf/init', 'galleria_register_acf_fields');

/**
 * Auto-set exhibition status based on dates
 */
function galleria_auto_set_exhibition_status($post_id) {
    if (get_post_type($post_id) !== 'exhibition') {
        return;
    }

    $start_date = get_field('start_date', $post_id);
    $end_date = get_field('end_date', $post_id);
    
    if (!$start_date || !$end_date) {
        return;
    }

    $now = current_time('Y-m-d');
    $start = date('Y-m-d', strtotime($start_date));
    $end = date('Y-m-d', strtotime($end_date));

    // Determine status
    $status_slug = '';
    if ($now < $start) {
        $status_slug = 'upcoming';
    } elseif ($now >= $start && $now <= $end) {
        $status_slug = 'current';
    } else {
        $status_slug = 'past';
    }

    // Get or create the term
    $term = get_term_by('slug', $status_slug, 'exhibition_status');
    if (!$term) {
        $status_names = array(
            'upcoming' => 'Upcoming',
            'current' => 'Current',
            'past' => 'Past'
        );
        
        $term_data = wp_insert_term(
            $status_names[$status_slug],
            'exhibition_status',
            array('slug' => $status_slug)
        );
        
        if (!is_wp_error($term_data)) {
            $term = get_term($term_data['term_id']);
        }
    }

    // Set the term
    if ($term && !is_wp_error($term)) {
        wp_set_post_terms($post_id, array($term->term_id), 'exhibition_status');
    }
}

add_action('acf/save_post', 'galleria_auto_set_exhibition_status', 20);