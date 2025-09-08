<?php
/**
 * SEO Optimization Functions
 * Ottimizzazioni SEO specifiche per la Galleria
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add custom meta tags to head
 */
function galleria_add_meta_tags() {
    // Generator tag
    echo '<meta name="generator" content="WordPress ' . get_bloginfo('version') . ' - Galleria Theme">' . "\n";
    
    // Author meta
    echo '<meta name="author" content="Galleria Adalberto Catanzaro">' . "\n";
    
    // Robots meta for specific pages
    if (is_404()) {
        echo '<meta name="robots" content="noindex,follow">' . "\n";
    }
    
    // Language and locale
    echo '<meta name="language" content="it">' . "\n";
    echo '<meta http-equiv="content-language" content="it">' . "\n";
    
    // Theme color for mobile browsers
    echo '<meta name="theme-color" content="#111827">' . "\n";
    echo '<meta name="msapplication-navbutton-color" content="#111827">' . "\n";
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n";
}
add_action('wp_head', 'galleria_add_meta_tags', 1);

/**
 * Enhanced structured data for different post types
 */
function galleria_add_post_structured_data() {
    if (is_singular('artist')) {
        global $post;
        $biography = get_field('biography', $post->ID);
        $birth_year = get_field('birth_year', $post->ID);
        $nationality = get_field('nationality', $post->ID);
        $website = get_field('website', $post->ID);
        
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "Person",
            "name" => get_the_title(),
            "description" => $biography ?: get_the_excerpt(),
            "url" => get_permalink(),
            "jobTitle" => "Artist",
            "worksFor" => array(
                "@type" => "ArtGallery",
                "name" => "Galleria Adalberto Catanzaro"
            )
        );
        
        if ($birth_year) {
            $schema["birthDate"] = $birth_year . "-01-01";
        }
        
        if ($nationality) {
            $schema["nationality"] = array(
                "@type" => "Country",
                "name" => $nationality
            );
        }
        
        if ($website) {
            $schema["sameAs"] = array($website);
        }
        
        if (has_post_thumbnail()) {
            $schema["image"] = get_the_post_thumbnail_url($post->ID, 'large');
        }
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    
    if (is_singular('exhibition')) {
        global $post;
        $artist = get_field('artist', $post->ID);
        $curator = get_field('curator', $post->ID);
        $venue = get_field('venue', $post->ID);
        $start_date = get_field('start_date', $post->ID);
        $end_date = get_field('end_date', $post->ID);
        
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "Event",
            "@id" => get_permalink(),
            "name" => get_the_title(),
            "description" => get_the_excerpt() ?: strip_tags(get_the_content()),
            "url" => get_permalink(),
            "eventStatus" => "https://schema.org/EventScheduled"
        );
        
        if ($start_date && $end_date) {
            $schema["startDate"] = $start_date;
            $schema["endDate"] = $end_date;
        }
        
        if ($venue) {
            $schema["location"] = array(
                "@type" => "Place",
                "name" => $venue,
                "address" => array(
                    "@type" => "PostalAddress",
                    "addressLocality" => "Palermo",
                    "addressCountry" => "IT"
                )
            );
        }
        
        if ($artist) {
            $schema["performer"] = array(
                "@type" => "Person",
                "name" => $artist
            );
        }
        
        $schema["organizer"] = array(
            "@type" => "ArtGallery",
            "name" => "Galleria Adalberto Catanzaro",
            "url" => home_url()
        );
        
        if (has_post_thumbnail()) {
            $schema["image"] = get_the_post_thumbnail_url($post->ID, 'large');
        }
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    
    // Breadcrumb structured data
    if (!is_front_page()) {
        $breadcrumbs = array(
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => array()
        );
        
        // Home
        $breadcrumbs["itemListElement"][] = array(
            "@type" => "ListItem",
            "position" => 1,
            "name" => "Home",
            "item" => home_url()
        );
        
        $position = 2;
        
        if (is_post_type_archive()) {
            $post_type_obj = get_post_type_object(get_post_type());
            if ($post_type_obj && isset($post_type_obj->labels->name)) {
                $breadcrumbs["itemListElement"][] = array(
                    "@type" => "ListItem",
                    "position" => $position,
                    "name" => $post_type_obj->labels->name,
                    "item" => get_post_type_archive_link(get_post_type())
                );
            }
        }
        
        if (is_singular()) {
            if (get_post_type() !== 'page') {
                $post_type_obj = get_post_type_object(get_post_type());
                if ($post_type_obj && isset($post_type_obj->labels->name)) {
                    $breadcrumbs["itemListElement"][] = array(
                        "@type" => "ListItem",
                        "position" => $position,
                        "name" => $post_type_obj->labels->name,
                        "item" => get_post_type_archive_link(get_post_type())
                    );
                    $position++;
                }
            }
            
            $breadcrumbs["itemListElement"][] = array(
                "@type" => "ListItem",
                "position" => $position,
                "name" => get_the_title(),
                "item" => get_permalink()
            );
        }
        
        echo '<script type="application/ld+json">' . json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_post_structured_data');

/**
 * Custom title tags for better SEO
 */
function galleria_custom_title($title, $sep, $seplocation) {
    if (is_singular('artist')) {
        $title = get_the_title() . ' - Artista | Galleria Adalberto Catanzaro';
    } elseif (is_singular('exhibition')) {
        $artist = get_field('artist');
        $year = get_the_date('Y');
        $title = get_the_title();
        if ($artist) {
            $title .= ' - ' . $artist;
        }
        $title .= ' (' . $year . ') | Galleria Adalberto Catanzaro';
    } elseif (is_post_type_archive('artist')) {
        $title = 'Artisti - Arte Contemporanea | Galleria Adalberto Catanzaro Palermo';
    } elseif (is_post_type_archive('exhibition')) {
        $title = 'Mostre - Arte Contemporanea | Galleria Adalberto Catanzaro Palermo';
    }
    
    return $title;
}
add_filter('wp_title', 'galleria_custom_title', 10, 3);
add_filter('document_title_parts', function($parts) {
    if (is_singular('artist')) {
        $parts['title'] = get_the_title() . ' - Artista';
        $parts['site'] = 'Galleria Adalberto Catanzaro';
    } elseif (is_singular('exhibition')) {
        $artist = get_field('artist');
        $year = get_the_date('Y');
        $parts['title'] = get_the_title();
        if ($artist) {
            $parts['title'] .= ' - ' . $artist;
        }
        $parts['title'] .= ' (' . $year . ')';
        $parts['site'] = 'Galleria Adalberto Catanzaro';
    }
    return $parts;
});

/**
 * Custom meta descriptions
 */
function galleria_custom_meta_description() {
    if (is_singular('artist')) {
        $biography = get_field('biography');
        $description = $biography ? wp_trim_words($biography, 25) : get_the_excerpt();
        $description = 'Scopri le opere di ' . get_the_title() . ', artista contemporaneo. ' . $description . ' | Galleria Adalberto Catanzaro, Palermo.';
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    } elseif (is_singular('exhibition')) {
        $artist = get_field('artist');
        $year = get_the_date('Y');
        $description = get_the_excerpt() ?: 'Mostra di arte contemporanea';
        $description = 'Mostra "' . get_the_title() . '"';
        if ($artist) {
            $description .= ' di ' . $artist;
        }
        $description .= ' (' . $year . ') presso la Galleria Adalberto Catanzaro, Palermo. ' . $description;
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    } elseif (is_post_type_archive('artist')) {
        echo '<meta name="description" content="Scopri gli artisti contemporanei rappresentati dalla Galleria Adalberto Catanzaro di Palermo. Arte Povera, Transavanguardia e ricerca artistica contemporanea.">' . "\n";
    } elseif (is_post_type_archive('exhibition')) {
        echo '<meta name="description" content="Mostre di arte contemporanea presso la Galleria Adalberto Catanzaro di Palermo. Esposizioni di artisti italiani e internazionali, Arte Povera e Transavanguardia.">' . "\n";
    }
}
add_action('wp_head', 'galleria_custom_meta_description', 5);

/**
 * Open Graph meta tags
 */
function galleria_add_og_tags() {
    if (is_singular()) {
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(get_the_excerpt()) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta property="og:site_name" content="Galleria Adalberto Catanzaro">' . "\n";
        
        if (has_post_thumbnail()) {
            $image = get_the_post_thumbnail_url(null, 'large');
            echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
            echo '<meta property="og:image:width" content="1200">' . "\n";
            echo '<meta property="og:image:height" content="630">' . "\n";
        }
    } elseif (is_front_page()) {
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:title" content="Galleria Adalberto Catanzaro - Arte Contemporanea Palermo">' . "\n";
        echo '<meta property="og:description" content="Galleria d\'arte contemporanea a Palermo dal 2014. Mostre di artisti italiani e internazionali, Arte Povera, Transavanguardia.">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(home_url()) . '">' . "\n";
        echo '<meta property="og:site_name" content="Galleria Adalberto Catanzaro">' . "\n";
    }
    
    // Twitter Card tags
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
    
    if (is_singular() && has_post_thumbnail()) {
        echo '<meta name="twitter:image" content="' . esc_url(get_the_post_thumbnail_url(null, 'large')) . '">' . "\n";
    }
}
add_action('wp_head', 'galleria_add_og_tags', 6);

/**
 * XML Sitemap customization
 */
function galleria_sitemap_custom_urls($urls, $post_type) {
    // Only add custom URLs to the 'page' post type sitemap
    if ($post_type === 'page') {
        $urls[] = array(
            'loc' => home_url('/artists/'),
            'lastmod' => date('c'),
            'changefreq' => 'weekly',
            'priority' => 0.8
        );
        
        $urls[] = array(
            'loc' => home_url('/exhibitions/'),
            'lastmod' => date('c'),
            'changefreq' => 'weekly', 
            'priority' => 0.8
        );
    }
    
    return $urls;
}
add_filter('wp_sitemaps_posts_entry', 'galleria_sitemap_custom_urls', 10, 2);

/**
 * Canonical URL optimization
 */
function galleria_canonical_url() {
    if (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
    } elseif (is_post_type_archive()) {
        echo '<link rel="canonical" href="' . esc_url(get_post_type_archive_link(get_post_type())) . '">' . "\n";
    }
}
add_action('wp_head', 'galleria_canonical_url', 2);

/**
 * Hreflang tags for international SEO (if needed)
 */
function galleria_hreflang_tags() {
    if (is_front_page()) {
        echo '<link rel="alternate" hreflang="it" href="' . esc_url(home_url()) . '">' . "\n";
        echo '<link rel="alternate" hreflang="x-default" href="' . esc_url(home_url()) . '">' . "\n";
    }
}
add_action('wp_head', 'galleria_hreflang_tags', 3);

/**
 * Performance optimization
 */
function galleria_performance_optimization() {
    // Preconnect to external domains
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    
    // DNS prefetch
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
}
add_action('wp_head', 'galleria_performance_optimization', 1);

/**
 * Remove unnecessary meta tags
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Clean up head section
 */
function galleria_cleanup_head() {
    // Remove emoji scripts and styles
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove unnecessary REST API links
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
}
add_action('init', 'galleria_cleanup_head');

/**
 * Add proper image alt texts
 */
function galleria_image_alt_text($attr, $attachment, $size) {
    if (empty($attr['alt'])) {
        $post = get_post($attachment->ID);
        if ($post) {
            // Try to get alt text from attachment
            $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            if (empty($alt)) {
                // Fallback to attachment title or description
                $alt = $post->post_title ?: $post->post_content;
            }
            $attr['alt'] = $alt;
        }
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'galleria_image_alt_text', 10, 3);

/**
 * Optimize images loading
 */
function galleria_add_image_loading_attr($attr, $attachment, $size) {
    // Add loading="lazy" for better performance
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'galleria_add_image_loading_attr', 10, 3);