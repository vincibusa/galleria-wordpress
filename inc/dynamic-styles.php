<?php
/**
 * Dynamic Styles Generator
 * 
 * Generates CSS based on Customizer settings and outputs it in the head.
 * Includes caching for performance.
 *
 * @package    Galleria_Catanzaro
 * @version    1.0.0
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Generate dynamic CSS from theme mods
 *
 * @return string Generated CSS.
 */
function galleria_generate_dynamic_css(): string {
	$cache_key = 'galleria_dynamic_css';
	$cache_version = '2.2'; // Increment this to force cache refresh - CHANGED FOR HERO FIX
	
	// Check if we're in customizer preview mode - don't cache in that case
	$is_customizer = is_customize_preview();
	
	// Check for cache bypass parameter
	$bypass_cache = isset($_GET['refresh_css']) && current_user_can('edit_theme_options');
	
	$cached_data = null;
	if (!$is_customizer && !$bypass_cache) {
		$cached_data = get_transient($cache_key);
		// Return cached CSS if available and version matches
		if (false !== $cached_data && is_array($cached_data) && isset($cached_data['version']) && $cached_data['version'] === $cache_version) {
			return $cached_data['css'];
		}
	}

	$css = ':root {' . "\n";

	// Colors
	$css .= '  --galleria-color-primary: ' . esc_attr(get_theme_mod('galleria_color_primary', '#111827')) . ";\n";
	$css .= '  --galleria-color-secondary: ' . esc_attr(get_theme_mod('galleria_color_secondary', '#374151')) . ";\n";
	$css .= '  --galleria-color-accent: ' . esc_attr(get_theme_mod('galleria_color_accent', '#6b7280')) . ";\n";
	$css .= '  --galleria-color-background: ' . esc_attr(get_theme_mod('galleria_color_background', '#ffffff')) . ";\n";
	$css .= '  --galleria-color-text: ' . esc_attr(get_theme_mod('galleria_color_text', '#374151')) . ";\n";
	$css .= '  --galleria-color-text-dark: ' . esc_attr(get_theme_mod('galleria_color_text_dark', '#111827')) . ";\n";
	$css .= '  --galleria-color-text-light: ' . esc_attr(get_theme_mod('galleria_color_text_light', '#6b7280')) . ";\n";
	$css .= '  --galleria-color-link: ' . esc_attr(get_theme_mod('galleria_color_link', '#111827')) . ";\n";
	$css .= '  --galleria-color-link-hover: ' . esc_attr(get_theme_mod('galleria_color_link_hover', '#6b7280')) . ";\n";
	$css .= '  --galleria-color-border: ' . esc_attr(get_theme_mod('galleria_color_border', '#f3f4f6')) . ";\n";
	$css .= '  --galleria-color-header-bg: ' . esc_attr(get_theme_mod('galleria_color_header_bg', '#ffffff')) . ";\n";
	$css .= '  --galleria-color-footer-bg: ' . esc_attr(get_theme_mod('galleria_color_footer_bg', '#f9fafb')) . ";\n";

	// Typography
	$font_family = get_theme_mod('galleria_font_family', 'Inter');
	$font_family_css = galleria_get_font_family_css($font_family);
	$css .= '  --galleria-font-family: ' . $font_family_css . ";\n";
	$css .= '  --galleria-font-weight-base: ' . esc_attr(get_theme_mod('galleria_font_weight_base', '300')) . ";\n";
	$css .= '  --galleria-font-weight-headings: ' . esc_attr(get_theme_mod('galleria_font_weight_headings', '300')) . ";\n";
	$css .= '  --galleria-font-size-base: ' . esc_attr(get_theme_mod('galleria_font_size_base', '1rem')) . ";\n";
	$css .= '  --galleria-font-size-h1: ' . esc_attr(get_theme_mod('galleria_font_size_h1', '2.25rem')) . ";\n";
	$css .= '  --galleria-font-size-h2: ' . esc_attr(get_theme_mod('galleria_font_size_h2', '1.5rem')) . ";\n";
	$css .= '  --galleria-font-size-h3: ' . esc_attr(get_theme_mod('galleria_font_size_h3', '1.125rem')) . ";\n";
	$css .= '  --galleria-line-height-base: ' . esc_attr(get_theme_mod('galleria_line_height_base', '1.6')) . ";\n";
	$css .= '  --galleria-line-height-headings: ' . esc_attr(get_theme_mod('galleria_line_height_headings', '1.2')) . ";\n";

	// Layout
	$css .= '  --galleria-container-width: ' . esc_attr(get_theme_mod('galleria_container_width', '1280px')) . ";\n";
	$css .= '  --galleria-container-padding-mobile: ' . esc_attr(get_theme_mod('galleria_container_padding_mobile', '1rem')) . ";\n";
	$css .= '  --galleria-container-padding-tablet: ' . esc_attr(get_theme_mod('galleria_container_padding_tablet', '1.5rem')) . ";\n";
	$css .= '  --galleria-container-padding-desktop: ' . esc_attr(get_theme_mod('galleria_container_padding_desktop', '2rem')) . ";\n";
	$css .= '  --galleria-header-height: ' . esc_attr(get_theme_mod('galleria_header_height', '8rem')) . ";\n";
	$css .= '  --galleria-logo-height: ' . esc_attr(get_theme_mod('galleria_logo_height', '12rem')) . ";\n";
	$css .= '  --galleria-footer-columns: ' . esc_attr(get_theme_mod('galleria_footer_columns', '3')) . ";\n";
	$css .= '  --galleria-section-spacing: ' . esc_attr(get_theme_mod('galleria_section_spacing', '5rem')) . ";\n";
	$css .= '  --galleria-card-gap: ' . esc_attr(get_theme_mod('galleria_card_gap', '2rem')) . ";\n";
	$css .= '  --hero-padding: ' . esc_attr(get_theme_mod('galleria_hero_padding', '4rem')) . ";\n";

	$css .= '}' . "\n\n";

	// Apply CSS variables to elements
	$css .= "body {\n";
	$css .= "  font-family: var(--galleria-font-family);\n";
	$css .= "  font-weight: var(--galleria-font-weight-base);\n";
	$css .= "  font-size: var(--galleria-font-size-base);\n";
	$css .= "  line-height: var(--galleria-line-height-base);\n";
	$css .= "  color: var(--galleria-color-text);\n";
	$css .= "  background-color: var(--galleria-color-background);\n";
	$css .= "}\n\n";

	$css .= "h1, h2, h3, h4, h5, h6 {\n";
	$css .= "  font-weight: var(--galleria-font-weight-headings);\n";
	$css .= "  line-height: var(--galleria-line-height-headings);\n";
	$css .= "  color: var(--galleria-color-text-dark);\n";
	$css .= "}\n\n";

	$css .= "h1 { font-size: var(--galleria-font-size-h1); }\n";
	$css .= "h2 { font-size: var(--galleria-font-size-h2); }\n";
	$css .= "h3 { font-size: var(--galleria-font-size-h3); }\n\n";

	$css .= "a {\n";
	$css .= "  color: var(--galleria-color-link);\n";
	$css .= "}\n\n";

	$css .= "a:hover {\n";
	$css .= "  color: var(--galleria-color-link-hover);\n";
	$css .= "}\n\n";

	$css .= ".btn-primary {\n";
	$css .= "  background-color: var(--galleria-color-primary);\n";
	$css .= "  color: #ffffff;\n";
	$css .= "  border-color: var(--galleria-color-primary);\n";
	$css .= "}\n\n";

	$css .= ".btn-primary:hover {\n";
	$css .= "  background-color: var(--galleria-color-secondary);\n";
	$css .= "  border-color: var(--galleria-color-secondary);\n";
	$css .= "}\n\n";

	$css .= ".container {\n";
	$css .= "  max-width: var(--galleria-container-width);\n";
	$css .= "  padding-left: var(--galleria-container-padding-mobile);\n";
	$css .= "  padding-right: var(--galleria-container-padding-mobile);\n";
	$css .= "}\n\n";

	$css .= "@media (min-width: 640px) {\n";
	$css .= "  .container {\n";
	$css .= "    padding-left: var(--galleria-container-padding-tablet);\n";
	$css .= "    padding-right: var(--galleria-container-padding-tablet);\n";
	$css .= "  }\n";
	$css .= "}\n\n";

	$css .= "@media (min-width: 1024px) {\n";
	$css .= "  .container {\n";
	$css .= "    padding-left: var(--galleria-container-padding-desktop);\n";
	$css .= "    padding-right: var(--galleria-container-padding-desktop);\n";
	$css .= "  }\n";
	$css .= "}\n\n";

	$css .= ".site-header {\n";
	$css .= "  background-color: var(--galleria-color-header-bg);\n";
	$css .= "  border-bottom-color: var(--galleria-color-border);\n";
	$css .= "}\n\n";

	$css .= ".site-header .container {\n";
	$css .= "  height: var(--galleria-header-height);\n";
	$css .= "}\n\n";

	$css .= ".site-logo img {\n";
	$css .= "  height: var(--galleria-logo-height);\n";
	$css .= "}\n\n";

	$css .= ".site-footer {\n";
	$css .= "  background-color: var(--galleria-color-footer-bg);\n";
	$css .= "  border-top-color: var(--galleria-color-border);\n";
	$css .= "}\n\n";

	// Footer columns
	$footer_columns = absint(get_theme_mod('galleria_footer_columns', 3));
	$css .= "@media (min-width: 768px) {\n";
	$css .= "  .footer-content {\n";
	$css .= "    grid-template-columns: repeat(" . $footer_columns . ", 1fr);\n";
	$css .= "  }\n";
	$css .= "}\n\n";

	// Header sticky
	if (get_theme_mod('galleria_header_sticky', true)) {
		$css .= ".site-header {\n";
		$css .= "  position: sticky;\n";
		$css .= "  top: 0;\n";
		$css .= "}\n\n";
	} else {
		$css .= ".site-header {\n";
		$css .= "  position: relative;\n";
		$css .= "}\n\n";
	}

	// Card gap
	$css .= ".grid {\n";
	$css .= "  gap: var(--galleria-card-gap);\n";
	$css .= "}\n\n";

	// Section spacing
	$css .= ".space-y-20 > * + * {\n";
	$css .= "  margin-top: var(--galleria-section-spacing);\n";
	$css .= "}\n\n";

	// News section spacing - closer to hero
	$css .= ".news-events {\n";
	$css .= "  margin-top: 0 !important;\n";
	$css .= "  padding-top: 0 !important;\n";
	$css .= "}\n\n";

	// Hero Section - Layout 50/50 elegante e compatto
	// Using high specificity and !important to override all other styles
	// VERSION 2.2 - FORCED REFRESH
	$css .= "/* ===== HERO SECTION STYLES - VERSION 2.2 ===== */\n";
	$css .= "body .hero-section,\n";
	$css .= "body.home .hero-section,\n";
	$css .= "body.page-template-front-page .hero-section {\n";
	$css .= "  position: relative !important;\n";
	$css .= "  width: 100% !important;\n";
	$css .= "  min-height: 50vh !important;\n";
	$css .= "  height: auto !important;\n";
	$css .= "  display: flex !important;\n";
	$css .= "  align-items: center !important;\n";
	$css .= "  justify-content: flex-start !important;\n";
	$css .= "  overflow: visible !important;\n";
	$css .= "  background-color: var(--galleria-color-background, #ffffff) !important;\n";
	$css .= "  margin-top: 3rem !important;\n";
	$css .= "  margin-bottom: 2rem !important;\n";
	$css .= "  padding-top: 0 !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-wrapper,\n";
	$css .= "body.home .hero-section .hero-wrapper,\n";
	$css .= "body.page-template-front-page .hero-section .hero-wrapper {\n";
	$css .= "  display: flex !important;\n";
	$css .= "  width: 100% !important;\n";
	$css .= "  align-items: center !important;\n";
	$css .= "  min-height: 50vh !important;\n";
	$css .= "  flex-direction: row !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-text-panel,\n";
	$css .= "body.home .hero-section .hero-text-panel,\n";
	$css .= "body.page-template-front-page .hero-section .hero-text-panel {\n";
	$css .= "  width: 50% !important;\n";
	$css .= "  display: flex !important;\n";
	$css .= "  flex-direction: column !important;\n";
	$css .= "  justify-content: center !important;\n";
	$css .= "  align-items: center !important;\n";
	$css .= "  padding: 3rem 2.5rem !important;\n";
	$css .= "  background-color: var(--galleria-color-background, #ffffff) !important;\n";
	$css .= "  border-right: 1px solid var(--galleria-color-text-dark, #111827) !important;\n";
	$css .= "  align-self: stretch !important;\n";
	$css .= "  position: relative !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-text-panel .hero-content,\n";
	$css .= "body.home .hero-section .hero-text-panel .hero-content,\n";
	$css .= "body.page-template-front-page .hero-section .hero-text-panel .hero-content {\n";
	$css .= "  width: 100% !important;\n";
	$css .= "  max-width: 70% !important;\n";
	$css .= "  display: flex !important;\n";
	$css .= "  flex-direction: column !important;\n";
	$css .= "  align-items: flex-start !important;\n";
	$css .= "  justify-content: center !important;\n";
	$css .= "  margin: 0 auto !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-artist,\n";
	$css .= "body.home .hero-section .hero-artist,\n";
	$css .= "body.page-template-front-page .hero-section .hero-artist {\n";
	$css .= "  font-size: 0.75rem !important;\n";
	$css .= "  font-weight: 300 !important;\n";
	$css .= "  color: var(--galleria-color-text-light, #6b7280) !important;\n";
	$css .= "  margin-bottom: 0.4rem !important;\n";
	$css .= "  text-transform: none !important;\n";
	$css .= "  letter-spacing: 0.05em !important;\n";
	$css .= "  position: relative !important;\n";
	$css .= "  padding-bottom: 0.4rem !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-artist::after,\n";
	$css .= "body.home .hero-section .hero-artist::after,\n";
	$css .= "body.page-template-front-page .hero-section .hero-artist::after {\n";
	$css .= "  content: '' !important;\n";
	$css .= "  position: absolute !important;\n";
	$css .= "  bottom: 0 !important;\n";
	$css .= "  left: 0 !important;\n";
	$css .= "  width: 50px !important;\n";
	$css .= "  height: 1px !important;\n";
	$css .= "  background-color: var(--galleria-color-text-light, #6b7280) !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-title,\n";
	$css .= "body.home .hero-section .hero-title,\n";
	$css .= "body.page-template-front-page .hero-section .hero-title {\n";
	$css .= "  font-size: 2.5rem !important;\n";
	$css .= "  font-weight: 300 !important;\n";
	$css .= "  line-height: 1.15 !important;\n";
	$css .= "  color: var(--galleria-color-text-dark, #111827) !important;\n";
	$css .= "  margin: 1.2rem 0 1rem 0 !important;\n";
	$css .= "  letter-spacing: -0.01em !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-info,\n";
	$css .= "body.home .hero-section .hero-info,\n";
	$css .= "body.page-template-front-page .hero-section .hero-info {\n";
	$css .= "  font-size: 0.7rem !important;\n";
	$css .= "  font-weight: 300 !important;\n";
	$css .= "  color: var(--galleria-color-text-light, #6b7280) !important;\n";
	$css .= "  letter-spacing: 0.12em !important;\n";
	$css .= "  text-transform: uppercase !important;\n";
	$css .= "  margin-top: 0.5rem !important;\n";
	$css .= "  padding-top: 0 !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-image-panel,\n";
	$css .= "body.home .hero-section .hero-image-panel,\n";
	$css .= "body.page-template-front-page .hero-section .hero-image-panel {\n";
	$css .= "  width: 50% !important;\n";
	$css .= "  position: relative !important;\n";
	$css .= "  overflow: visible !important;\n";
	$css .= "  background-color: var(--galleria-color-background, #ffffff) !important;\n";
	$css .= "  padding: 2rem !important;\n";
	$css .= "  display: flex !important;\n";
	$css .= "  align-items: center !important;\n";
	$css .= "  justify-content: center !important;\n";
	$css .= "  align-self: stretch !important;\n";
	$css .= "  min-height: 50vh !important;\n";
	$css .= "}\n\n";

	$css .= "body .hero-section .hero-image-panel .hero-image,\n";
	$css .= "body.home .hero-section .hero-image-panel .hero-image,\n";
	$css .= "body.page-template-front-page .hero-section .hero-image-panel .hero-image {\n";
	$css .= "  width: 100% !important;\n";
	$css .= "  height: 50vh !important;\n";
	$css .= "  max-height: 50vh !important;\n";
	$css .= "  max-width: 100% !important;\n";
	$css .= "  object-fit: cover !important;\n";
	$css .= "  object-position: center !important;\n";
	$css .= "  display: block !important;\n";
	$css .= "  position: relative !important;\n";
	$css .= "  border-radius: 2px !important;\n";
	$css .= "  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;\n";
	$css .= "  min-height: 50vh !important;\n";
	$css .= "}\n\n";

	// Mobile responsive
	$css .= "@media (max-width: 1024px) {\n";
	$css .= "  .hero-section {\n";
	$css .= "    min-height: auto !important;\n";
	$css .= "    align-items: flex-start !important;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-wrapper {\n";
	$css .= "    flex-direction: column;\n";
	$css .= "    min-height: auto;\n";
	$css .= "    align-items: stretch;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-text-panel {\n";
	$css .= "    width: 100%;\n";
	$css .= "    padding: 2.5rem 2rem;\n";
	$css .= "    border-right: none;\n";
	$css .= "    border-bottom: 1px solid var(--galleria-color-text-dark, #111827);\n";
	$css .= "    min-height: auto;\n";
	$css .= "    align-self: stretch;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-image-panel {\n";
	$css .= "    width: 100%;\n";
	$css .= "    padding: 2rem 1.5rem;\n";
	$css .= "    min-height: auto;\n";
	$css .= "    align-self: stretch;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-image-panel .hero-image {\n";
	$css .= "    height: 40vh !important;\n";
	$css .= "    max-height: 40vh !important;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-title {\n";
	$css .= "    font-size: 2rem;\n";
	$css .= "  }\n";
	$css .= "}\n\n";

	$css .= "@media (max-width: 768px) {\n";
	$css .= "  .hero-section {\n";
	$css .= "    min-height: auto !important;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-text-panel {\n";
	$css .= "    padding: 2rem 1.5rem;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-image-panel {\n";
	$css .= "    padding: 1.5rem 1rem;\n";
	$css .= "    min-height: auto;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-image-panel .hero-image {\n";
	$css .= "    height: 35vh !important;\n";
	$css .= "    max-height: 35vh !important;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-title {\n";
	$css .= "    font-size: 1.75rem;\n";
	$css .= "    margin: 1rem 0 0.8rem 0;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-artist {\n";
	$css .= "    font-size: 0.7rem;\n";
	$css .= "    margin-bottom: 0.3rem;\n";
	$css .= "  }\n\n";
	$css .= "  .hero-info {\n";
	$css .= "    font-size: 0.65rem;\n";
	$css .= "    margin-top: 0.3rem;\n";
	$css .= "  }\n";
	$css .= "}\n\n";

	// Cache the CSS for 1 hour (only if not in customizer)
	if (!$is_customizer && !$bypass_cache) {
		set_transient($cache_key, array(
			'css' => $css,
			'version' => $cache_version,
		), HOUR_IN_SECONDS);
	} else {
		// Force delete old cache when bypassing
		delete_transient($cache_key);
	}

	return $css;
}

/**
 * Get font family CSS based on selection
 *
 * @param string $font_family Font family name.
 *
 * @return string Font family CSS.
 */
function galleria_get_font_family_css(string $font_family): string {
	$google_fonts = galleria_get_google_fonts();

	switch ($font_family) {
		case 'Inter':
			return "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif";
		case 'system':
			return "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif";
		case 'serif':
			return "Georgia, serif";
		case 'times':
			return "'Times New Roman', Times, serif";
		default:
			// Check if it's a Google Font
			if (isset($google_fonts[$font_family])) {
				$font = $google_fonts[$font_family];
				return "'" . $font['name'] . "', " . $font['category'];
			}
			return "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif";
	}
}

/**
 * Output dynamic CSS in head
 *
 * @return void
 */
function galleria_output_dynamic_css(): void {
	$css = galleria_generate_dynamic_css();
	if (!empty($css)) {
		echo '<style id="galleria-dynamic-styles" type="text/css">' . "\n";
		echo '/* Dynamic Hero Styles - Highest Priority */' . "\n";
		echo $css;
		echo '</style>' . "\n";
	}
}
// Priority 9999 to load after ALL other stylesheets and scripts
add_action('wp_head', 'galleria_output_dynamic_css', 9999);

/**
 * Clear CSS cache when customizer settings are saved
 *
 * @return void
 */
function galleria_clear_dynamic_css_cache(): void {
	delete_transient('galleria_dynamic_css');
	// Also clear object cache if available
	if (function_exists('wp_cache_delete')) {
		wp_cache_delete('galleria_dynamic_css', 'transient');
	}
}
add_action('customize_save_after', 'galleria_clear_dynamic_css_cache');

/**
 * Force clear cache on theme activation or update
 *
 * @return void
 */
function galleria_force_clear_css_cache(): void {
	delete_transient('galleria_dynamic_css');
}
add_action('after_switch_theme', 'galleria_force_clear_css_cache');

