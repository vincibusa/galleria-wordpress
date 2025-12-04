<?php
/**
 * Customizer Typography Section
 * 
 * Registers all typography-related customizer settings and controls.
 *
 * @package    Galleria_Catanzaro
 * @version    1.0.0
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Get available Google Fonts
 *
 * @return array List of Google Fonts with their variants.
 */
function galleria_get_google_fonts(): array {
	return array(
		'Inter' => array(
			'name' => 'Inter',
			'weights' => array('300', '400', '500', '600', '700'),
			'category' => 'sans-serif',
		),
		'Roboto' => array(
			'name' => 'Roboto',
			'weights' => array('300', '400', '500', '700'),
			'category' => 'sans-serif',
		),
		'Open Sans' => array(
			'name' => 'Open Sans',
			'weights' => array('300', '400', '600', '700'),
			'category' => 'sans-serif',
		),
		'Lato' => array(
			'name' => 'Lato',
			'weights' => array('300', '400', '700'),
			'category' => 'sans-serif',
		),
		'Montserrat' => array(
			'name' => 'Montserrat',
			'weights' => array('300', '400', '500', '600', '700'),
			'category' => 'sans-serif',
		),
		'Playfair Display' => array(
			'name' => 'Playfair Display',
			'weights' => array('400', '500', '600', '700'),
			'category' => 'serif',
		),
		'Merriweather' => array(
			'name' => 'Merriweather',
			'weights' => array('300', '400', '700'),
			'category' => 'serif',
		),
		'Lora' => array(
			'name' => 'Lora',
			'weights' => array('400', '500', '600', '700'),
			'category' => 'serif',
		),
		'Source Sans Pro' => array(
			'name' => 'Source Sans Pro',
			'weights' => array('300', '400', '600', '700'),
			'category' => 'sans-serif',
		),
		'Raleway' => array(
			'name' => 'Raleway',
			'weights' => array('300', '400', '500', '600', '700'),
			'category' => 'sans-serif',
		),
	);
}

/**
 * Register Typography Section in Customizer
 *
 * @param WP_Customize_Manager $wp_customize WordPress Customizer object.
 *
 * @return void
 */
function galleria_customizer_typography(WP_Customize_Manager $wp_customize): void {
	// Add Typography Section
	$wp_customize->add_section('galleria_typography', array(
		'title' => __('Tipografia', 'galleria'),
		'priority' => 21,
		'description' => __('Personalizza i font e le dimensioni del testo del tema.', 'galleria'),
	));

	// Font Family
	$google_fonts = galleria_get_google_fonts();
	$font_choices = array(
		'Inter' => 'Inter (Google Font)',
		'system' => 'System Fonts',
		'serif' => 'Serif',
		'times' => 'Times New Roman',
	);

	foreach ($google_fonts as $key => $font) {
		if ($key !== 'Inter') {
			$font_choices[$key] = $font['name'] . ' (Google Font)';
		}
	}

	$wp_customize->add_setting('galleria_font_family', array(
		'default' => 'Inter',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_font_family', array(
		'label' => __('Famiglia Font', 'galleria'),
		'description' => __('Seleziona il font principale del tema.', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'select',
		'choices' => $font_choices,
	));

	// Font Weight Base
	$wp_customize->add_setting('galleria_font_weight_base', array(
		'default' => '300',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_font_weight_base', array(
		'label' => __('Peso Font Base', 'galleria'),
		'description' => __('Peso del font per il testo normale.', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'select',
		'choices' => array(
			'300' => 'Light (300)',
			'400' => 'Regular (400)',
			'500' => 'Medium (500)',
			'600' => 'Semi Bold (600)',
			'700' => 'Bold (700)',
		),
	));

	// Font Weight Headings
	$wp_customize->add_setting('galleria_font_weight_headings', array(
		'default' => '300',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_font_weight_headings', array(
		'label' => __('Peso Font Titoli', 'galleria'),
		'description' => __('Peso del font per i titoli (H1-H6).', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'select',
		'choices' => array(
			'300' => 'Light (300)',
			'400' => 'Regular (400)',
			'500' => 'Medium (500)',
			'600' => 'Semi Bold (600)',
			'700' => 'Bold (700)',
		),
	));

	// Base Font Size
	$wp_customize->add_setting('galleria_font_size_base', array(
		'default' => '1rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_font_size_base', array(
		'label' => __('Dimensione Font Base', 'galleria'),
		'description' => __('Dimensione del testo normale (es: 1rem, 16px).', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'text',
	));

	// H1 Font Size
	$wp_customize->add_setting('galleria_font_size_h1', array(
		'default' => '2.25rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_font_size_h1', array(
		'label' => __('Dimensione H1', 'galleria'),
		'description' => __('Dimensione del titolo H1 (es: 2.25rem, 36px).', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'text',
	));

	// H2 Font Size
	$wp_customize->add_setting('galleria_font_size_h2', array(
		'default' => '1.5rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_font_size_h2', array(
		'label' => __('Dimensione H2', 'galleria'),
		'description' => __('Dimensione del titolo H2 (es: 1.5rem, 24px).', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'text',
	));

	// H3 Font Size
	$wp_customize->add_setting('galleria_font_size_h3', array(
		'default' => '1.125rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_font_size_h3', array(
		'label' => __('Dimensione H3', 'galleria'),
		'description' => __('Dimensione del titolo H3 (es: 1.125rem, 18px).', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'text',
	));

	// Line Height Base
	$wp_customize->add_setting('galleria_line_height_base', array(
		'default' => '1.6',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_line_height_base', array(
		'label' => __('Altezza Riga Base', 'galleria'),
		'description' => __('Altezza della riga per il testo normale (es: 1.6, 1.5).', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'text',
	));

	// Line Height Headings
	$wp_customize->add_setting('galleria_line_height_headings', array(
		'default' => '1.2',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_line_height_headings', array(
		'label' => __('Altezza Riga Titoli', 'galleria'),
		'description' => __('Altezza della riga per i titoli (es: 1.2, 1.3).', 'galleria'),
		'section' => 'galleria_typography',
		'type' => 'text',
	));
}
add_action('customize_register', 'galleria_customizer_typography');



