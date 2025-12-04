<?php
/**
 * Customizer Colors Section
 * 
 * Registers all color-related customizer settings and controls.
 *
 * @package    Galleria_Catanzaro
 * @version    1.0.0
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Register Colors Section in Customizer
 *
 * @param WP_Customize_Manager $wp_customize WordPress Customizer object.
 *
 * @return void
 */
function galleria_customizer_colors(WP_Customize_Manager $wp_customize): void {
	// Add Colors Section
	$wp_customize->add_section('galleria_colors', array(
		'title' => __('Colori del Tema', 'galleria'),
		'priority' => 20,
		'description' => __('Personalizza i colori del tema. Le modifiche verranno applicate immediatamente.', 'galleria'),
	));

	// Primary Color
	$wp_customize->add_setting('galleria_color_primary', array(
		'default' => '#111827',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_primary', array(
		'label' => __('Colore Primario', 'galleria'),
		'description' => __('Colore principale utilizzato per bottoni, link e elementi di accento.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_primary',
	)));

	// Secondary Color
	$wp_customize->add_setting('galleria_color_secondary', array(
		'default' => '#374151',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_secondary', array(
		'label' => __('Colore Secondario', 'galleria'),
		'description' => __('Colore secondario per elementi di supporto.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_secondary',
	)));

	// Accent Color
	$wp_customize->add_setting('galleria_color_accent', array(
		'default' => '#6b7280',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_accent', array(
		'label' => __('Colore Accento', 'galleria'),
		'description' => __('Colore per elementi di accento e hover.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_accent',
	)));

	// Background Color
	$wp_customize->add_setting('galleria_color_background', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_background', array(
		'label' => __('Colore di Sfondo', 'galleria'),
		'description' => __('Colore di sfondo principale del sito.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_background',
	)));

	// Text Color
	$wp_customize->add_setting('galleria_color_text', array(
		'default' => '#374151',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_text', array(
		'label' => __('Colore del Testo', 'galleria'),
		'description' => __('Colore principale del testo.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_text',
	)));

	// Text Dark Color
	$wp_customize->add_setting('galleria_color_text_dark', array(
		'default' => '#111827',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_text_dark', array(
		'label' => __('Colore Testo Scuro', 'galleria'),
		'description' => __('Colore per titoli e testo in grassetto.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_text_dark',
	)));

	// Text Light Color
	$wp_customize->add_setting('galleria_color_text_light', array(
		'default' => '#6b7280',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_text_light', array(
		'label' => __('Colore Testo Chiaro', 'galleria'),
		'description' => __('Colore per testo secondario e meta informazioni.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_text_light',
	)));

	// Link Color
	$wp_customize->add_setting('galleria_color_link', array(
		'default' => '#111827',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_link', array(
		'label' => __('Colore Link', 'galleria'),
		'description' => __('Colore per i link del testo.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_link',
	)));

	// Link Hover Color
	$wp_customize->add_setting('galleria_color_link_hover', array(
		'default' => '#6b7280',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_link_hover', array(
		'label' => __('Colore Link Hover', 'galleria'),
		'description' => __('Colore per i link al passaggio del mouse.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_link_hover',
	)));

	// Border Color
	$wp_customize->add_setting('galleria_color_border', array(
		'default' => '#f3f4f6',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_border', array(
		'label' => __('Colore Bordo', 'galleria'),
		'description' => __('Colore per bordi e separatori.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_border',
	)));

	// Header Background Color
	$wp_customize->add_setting('galleria_color_header_bg', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_header_bg', array(
		'label' => __('Sfondo Header', 'galleria'),
		'description' => __('Colore di sfondo dell\'header.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_header_bg',
	)));

	// Footer Background Color
	$wp_customize->add_setting('galleria_color_footer_bg', array(
		'default' => '#f9fafb',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'galleria_color_footer_bg', array(
		'label' => __('Sfondo Footer', 'galleria'),
		'description' => __('Colore di sfondo del footer.', 'galleria'),
		'section' => 'galleria_colors',
		'settings' => 'galleria_color_footer_bg',
	)));
}
add_action('customize_register', 'galleria_customizer_colors');



