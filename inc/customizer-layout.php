<?php
/**
 * Customizer Layout Section
 * 
 * Registers all layout-related customizer settings and controls.
 *
 * @package    Galleria_Catanzaro
 * @version    1.0.0
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Register Layout Section in Customizer
 *
 * @param WP_Customize_Manager $wp_customize WordPress Customizer object.
 *
 * @return void
 */
function galleria_customizer_layout(WP_Customize_Manager $wp_customize): void {
	// Add Layout Section
	$wp_customize->add_section('galleria_layout', array(
		'title' => __('Layout', 'galleria'),
		'priority' => 22,
		'description' => __('Personalizza il layout e le spaziature del tema.', 'galleria'),
	));

	// Container Max Width
	$wp_customize->add_setting('galleria_container_width', array(
		'default' => '1280px',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_container_width', array(
		'label' => __('Larghezza Container', 'galleria'),
		'description' => __('Larghezza massima del container principale (es: 1280px, 1200px).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'text',
	));

	// Container Padding Mobile
	$wp_customize->add_setting('galleria_container_padding_mobile', array(
		'default' => '1rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_container_padding_mobile', array(
		'label' => __('Padding Container Mobile', 'galleria'),
		'description' => __('Padding laterale del container su schermi piccoli (es: 1rem, 16px).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'text',
	));

	// Container Padding Tablet
	$wp_customize->add_setting('galleria_container_padding_tablet', array(
		'default' => '1.5rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_container_padding_tablet', array(
		'label' => __('Padding Container Tablet', 'galleria'),
		'description' => __('Padding laterale del container su schermi medi (es: 1.5rem, 24px).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'text',
	));

	// Container Padding Desktop
	$wp_customize->add_setting('galleria_container_padding_desktop', array(
		'default' => '2rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_container_padding_desktop', array(
		'label' => __('Padding Container Desktop', 'galleria'),
		'description' => __('Padding laterale del container su schermi grandi (es: 2rem, 32px).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'text',
	));

	// Header Height
	$wp_customize->add_setting('galleria_header_height', array(
		'default' => '8rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_header_height', array(
		'label' => __('Altezza Header', 'galleria'),
		'description' => __('Altezza dell\'header (es: 8rem, 128px).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'text',
	));

	// Header Sticky
	$wp_customize->add_setting('galleria_header_sticky', array(
		'default' => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_header_sticky', array(
		'label' => __('Header Sticky', 'galleria'),
		'description' => __('Mantieni l\'header fisso in alto durante lo scroll.', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'checkbox',
	));

	// Logo Height
	$wp_customize->add_setting('galleria_logo_height', array(
		'default' => '12rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_logo_height', array(
		'label' => __('Altezza Logo', 'galleria'),
		'description' => __('Altezza del logo nell\'header (es: 12rem, 192px).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'text',
	));

	// Footer Columns Layout
	$wp_customize->add_setting('galleria_footer_columns', array(
		'default' => '3',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_footer_columns', array(
		'label' => __('Numero Colonne Footer', 'galleria'),
		'description' => __('Numero di colonne nel footer (1-4).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 1,
			'max' => 4,
			'step' => 1,
		),
	));

	// Section Spacing
	$wp_customize->add_setting('galleria_section_spacing', array(
		'default' => '5rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_section_spacing', array(
		'label' => __('Spaziatura Sezioni', 'galleria'),
		'description' => __('Spaziatura verticale tra le sezioni (es: 5rem, 80px).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'text',
	));

	// Card Gap
	$wp_customize->add_setting('galleria_card_gap', array(
		'default' => '2rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('galleria_card_gap', array(
		'label' => __('Spaziatura Card', 'galleria'),
		'description' => __('Spaziatura tra le card nella griglia (es: 2rem, 32px).', 'galleria'),
		'section' => 'galleria_layout',
		'type' => 'text',
	));
}
add_action('customize_register', 'galleria_customizer_layout');



