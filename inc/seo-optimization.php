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
    $seo_settings = galleria_get_seo_settings();
    
    // Generator tag
    echo '<meta name="generator" content="WordPress ' . get_bloginfo('version') . ' - Galleria Theme">' . "\n";
    
    // Author meta
    echo '<meta name="author" content="' . esc_attr($seo_settings['meta_author']) . '">' . "\n";
    
    // Robots meta for specific pages
    if (is_404()) {
        echo '<meta name="robots" content="noindex,follow">' . "\n";
    }
    
    // Language and locale
    echo '<meta name="language" content="it">' . "\n";
    echo '<meta http-equiv="content-language" content="it">' . "\n";
    
    // Theme color for mobile browsers
    echo '<meta name="theme-color" content="' . esc_attr($seo_settings['theme_color']) . '">' . "\n";
    echo '<meta name="msapplication-navbutton-color" content="' . esc_attr($seo_settings['theme_color']) . '">' . "\n";
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
    $seo_settings = galleria_get_seo_settings();
    
    if (is_singular('artist')) {
        $template = $seo_settings['artist_title_template'];
        $title = str_replace(
            array('{artist_name}', '{site_name}'),
            array(get_the_title(), $seo_settings['site_name']),
            $template
        );
    } elseif (is_singular('exhibition')) {
        $artist = get_field('artist');
        $year = get_the_date('Y');
        $template = $seo_settings['exhibition_title_template'];
        $title = str_replace(
            array('{exhibition_title}', '{artist_name}', '{year}', '{site_name}'),
            array(get_the_title(), $artist ?: '', $year, $seo_settings['site_name']),
            $template
        );
    } elseif (is_post_type_archive('artist')) {
        $title = $seo_settings['artists_page_title'];
    } elseif (is_post_type_archive('exhibition')) {
        $title = $seo_settings['exhibitions_page_title'];
    }
    
    return $title;
}
add_filter('wp_title', 'galleria_custom_title', 10, 3);
add_filter('document_title_parts', function($parts) {
    $seo_settings = galleria_get_seo_settings();
    
    if (is_singular('artist')) {
        $template = $seo_settings['artist_title_template'];
        $full_title = str_replace(
            array('{artist_name}', '{site_name}'),
            array(get_the_title(), $seo_settings['site_name']),
            $template
        );
        // Split title and site for WordPress structure
        $title_parts = explode(' | ', $full_title, 2);
        $parts['title'] = $title_parts[0];
        $parts['site'] = isset($title_parts[1]) ? $title_parts[1] : $seo_settings['site_name'];
    } elseif (is_singular('exhibition')) {
        $artist = get_field('artist');
        $year = get_the_date('Y');
        $template = $seo_settings['exhibition_title_template'];
        $full_title = str_replace(
            array('{exhibition_title}', '{artist_name}', '{year}', '{site_name}'),
            array(get_the_title(), $artist ?: '', $year, $seo_settings['site_name']),
            $template
        );
        // Split title and site for WordPress structure
        $title_parts = explode(' | ', $full_title, 2);
        $parts['title'] = $title_parts[0];
        $parts['site'] = isset($title_parts[1]) ? $title_parts[1] : $seo_settings['site_name'];
    }
    return $parts;
});

/**
 * Custom meta descriptions
 */
function galleria_custom_meta_description() {
    $seo_settings = galleria_get_seo_settings();
    
    if (is_singular('artist')) {
        $biography = get_field('biography');
        $bio_excerpt = $biography ? wp_trim_words($biography, 25) : get_the_excerpt();
        $template = $seo_settings['artist_description_template'];
        $description = str_replace(
            array('{artist_name}', '{biography}', '{site_name}'),
            array(get_the_title(), $bio_excerpt, $seo_settings['site_name']),
            $template
        );
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    } elseif (is_singular('exhibition')) {
        $artist = get_field('artist');
        $year = get_the_date('Y');
        $template = $seo_settings['exhibition_description_template'];
        $description = str_replace(
            array('{exhibition_title}', '{artist_name}', '{year}', '{site_name}'),
            array(get_the_title(), $artist ?: '', $year, $seo_settings['site_name']),
            $template
        );
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    } elseif (is_post_type_archive('artist')) {
        echo '<meta name="description" content="' . esc_attr($seo_settings['artists_page_description']) . '">' . "\n";
    } elseif (is_post_type_archive('exhibition')) {
        echo '<meta name="description" content="' . esc_attr($seo_settings['exhibitions_page_description']) . '">' . "\n";
    } elseif (is_front_page()) {
        echo '<meta name="description" content="' . esc_attr($seo_settings['homepage_description']) . '">' . "\n";
    }
}
add_action('wp_head', 'galleria_custom_meta_description', 5);

/**
 * Open Graph meta tags
 */
function galleria_add_og_tags() {
    $seo_settings = galleria_get_seo_settings();
    
    if (is_singular()) {
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(get_the_excerpt()) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($seo_settings['site_name']) . '">' . "\n";
        
        if (has_post_thumbnail()) {
            $image = get_the_post_thumbnail_url(null, 'large');
            echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
            echo '<meta property="og:image:width" content="1200">' . "\n";
            echo '<meta property="og:image:height" content="630">' . "\n";
        }
    } elseif (is_front_page()) {
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($seo_settings['homepage_title']) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($seo_settings['homepage_description']) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(home_url()) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($seo_settings['site_name']) . '">' . "\n";
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

/**
 * Enhanced LocalBusiness Schema for Palermo Locations
 */
function galleria_add_local_business_schema() {
    if (is_front_page() || is_home()) {
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "ArtGallery",
            "@id" => home_url() . "#gallery",
            "name" => "Galleria Adalberto Catanzaro",
            "alternateName" => array("Galleria Catanzaro", "Adalberto Catanzaro Gallery"),
            "description" => "Galleria d'arte contemporanea a Palermo dal 2014. Mostre di artisti italiani e internazionali, Arte Povera, Transavanguardia. Fondata da Adalberto Catanzaro.",
            "url" => home_url(),
            "sameAs" => array(
                home_url(),
                // Add social media URLs when available
            ),
            "founder" => array(
                "@type" => "Person",
                "@id" => home_url() . "#adalberto-catanzaro",
                "name" => "Adalberto Catanzaro",
                "jobTitle" => "Gallery Owner & Art Dealer",
                "description" => "Fondatore della Galleria Adalberto Catanzaro, esperto d'arte contemporanea e collezionista.",
                "knowsAbout" => array("Arte Contemporanea", "Arte Povera", "Transavanguardia", "Arte Italiana", "Collezioni d'Arte"),
                "worksFor" => array(
                    "@type" => "ArtGallery",
                    "name" => "Galleria Adalberto Catanzaro"
                )
            ),
            "foundingDate" => "2014",
            "foundingLocation" => array(
                "@type" => "Place",
                "address" => array(
                    "@type" => "PostalAddress",
                    "addressLocality" => "Palermo",
                    "addressRegion" => "Sicilia",
                    "addressCountry" => "IT"
                )
            ),
            "telephone" => get_theme_mod('galleria_phone', '+39 327 167 7871'),
            "email" => get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com'),
            "location" => array(
                array(
                    "@type" => "Place",
                    "@id" => home_url() . "#location-montevergini",
                    "name" => "Sede Via Montevergini",
                    "address" => array(
                        "@type" => "PostalAddress",
                        "streetAddress" => get_theme_mod('galleria_address_1', 'Via Montevergini 3'),
                        "addressLocality" => "Palermo",
                        "addressRegion" => "Sicilia",
                        "postalCode" => "90133",
                        "addressCountry" => "IT"
                    ),
                    "geo" => array(
                        "@type" => "GeoCoordinates",
                        "latitude" => "38.1157",
                        "longitude" => "13.3615"
                    )
                ),
                array(
                    "@type" => "Place",
                    "@id" => home_url() . "#location-vittorio-emanuele",
                    "name" => "Sede Corso Vittorio Emanuele",
                    "address" => array(
                        "@type" => "PostalAddress",
                        "streetAddress" => get_theme_mod('galleria_address_2', 'Corso Vittorio Emanuele 383'),
                        "addressLocality" => "Palermo",
                        "addressRegion" => "Sicilia",
                        "postalCode" => "90133",
                        "addressCountry" => "IT"
                    ),
                    "geo" => array(
                        "@type" => "GeoCoordinates",
                        "latitude" => "38.1156",
                        "longitude" => "13.3614"
                    )
                )
            ),
            "openingHours" => array(
                "Tu-Sa 10:00-18:00"
            ),
            "openingHoursSpecification" => array(
                array(
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => array("Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"),
                    "opens" => "10:00",
                    "closes" => "18:00"
                )
            ),
            "artMedium" => array("Contemporary Art", "Arte Povera", "Transavanguardia", "Installation Art", "Painting", "Sculpture"),
            "knowsAbout" => array("Arte Contemporanea", "Arte Povera", "Transavanguardia", "Arte Italiana", "Collezionismo"),
            "areaServed" => array(
                array(
                    "@type" => "City",
                    "name" => "Palermo"
                ),
                array(
                    "@type" => "AdministrativeArea",
                    "name" => "Sicilia"
                ),
                array(
                    "@type" => "Country",
                    "name" => "Italia"
                )
            ),
            "hasOfferCatalog" => array(
                "@type" => "OfferCatalog",
                "name" => "Gallery Services",
                "itemListElement" => array(
                    array(
                        "@type" => "Offer",
                        "itemOffered" => array(
                            "@type" => "Service",
                            "name" => "Art Exhibitions",
                            "description" => "Mostre d'arte contemporanea"
                        )
                    ),
                    array(
                        "@type" => "Offer",
                        "itemOffered" => array(
                            "@type" => "Service",
                            "name" => "Art Consultation",
                            "description" => "Consulenza artistica e collezionismo"
                        )
                    )
                )
            )
        );

        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_local_business_schema', 8);

/**
 * Enhanced Person Schema for Adalberto Catanzaro
 */
function galleria_add_founder_person_schema() {
    // Add to all pages for better "Adalberto Catanzaro" search visibility
    $schema = array(
        "@context" => "https://schema.org",
        "@type" => "Person",
        "@id" => home_url() . "#adalberto-catanzaro",
        "name" => "Adalberto Catanzaro",
        "alternateName" => array("Adalberto Catanzaro", "A. Catanzaro"),
        "description" => "Fondatore e proprietario della Galleria Adalberto Catanzaro a Palermo. Esperto d'arte contemporanea, collezionista e gallerista specializzato in Arte Povera e Transavanguardia.",
        "jobTitle" => array("Gallery Owner", "Art Dealer", "Art Consultant", "Gallerista"),
        "hasOccupation" => array(
            "@type" => "Occupation",
            "name" => "Art Gallery Owner",
            "occupationLocation" => array(
                "@type" => "City",
                "name" => "Palermo, Sicilia, Italia"
            ),
            "skills" => array("Arte Contemporanea", "Arte Povera", "Transavanguardia", "Collezionismo", "Curatela")
        ),
        "worksFor" => array(
            "@type" => "ArtGallery",
            "@id" => home_url() . "#gallery",
            "name" => "Galleria Adalberto Catanzaro"
        ),
        "owns" => array(
            "@type" => "ArtGallery",
            "@id" => home_url() . "#gallery", 
            "name" => "Galleria Adalberto Catanzaro"
        ),
        "foundedOrganization" => array(
            "@type" => "ArtGallery",
            "@id" => home_url() . "#gallery",
            "name" => "Galleria Adalberto Catanzaro",
            "foundingDate" => "2014"
        ),
        "knowsAbout" => array(
            "Arte Contemporanea",
            "Arte Povera", 
            "Transavanguardia",
            "Arte Italiana",
            "Collezionismo d'Arte",
            "Mercato dell'Arte",
            "Curatela",
            "Arte Siciliana"
        ),
        "expertise" => array("Contemporary Art", "Arte Povera", "Transavanguardia", "Italian Art", "Art Collection"),
        "workLocation" => array(
            array(
                "@type" => "Place",
                "name" => "Galleria Adalberto Catanzaro - Sede Montevergini",
                "address" => array(
                    "@type" => "PostalAddress",
                    "streetAddress" => "Via Montevergini 3",
                    "addressLocality" => "Palermo",
                    "addressRegion" => "Sicilia",
                    "postalCode" => "90133",
                    "addressCountry" => "IT"
                )
            ),
            array(
                "@type" => "Place", 
                "name" => "Galleria Adalberto Catanzaro - Sede Vittorio Emanuele",
                "address" => array(
                    "@type" => "PostalAddress",
                    "streetAddress" => "Corso Vittorio Emanuele 383",
                    "addressLocality" => "Palermo",
                    "addressRegion" => "Sicilia", 
                    "postalCode" => "90133",
                    "addressCountry" => "IT"
                )
            )
        ),
        "nationality" => array(
            "@type" => "Country",
            "name" => "Italia"
        ),
        "homeLocation" => array(
            "@type" => "City",
            "name" => "Palermo, Sicilia, Italia"
        ),
        "url" => home_url(),
        "mainEntityOfPage" => home_url()
    );

    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
}
add_action('wp_head', 'galleria_add_founder_person_schema', 9);

/**
 * FAQ Schema for common gallery questions
 */
function galleria_add_faq_schema() {
    if (is_front_page() || is_home()) {
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => array(
                array(
                    "@type" => "Question",
                    "name" => "Dove si trova la Galleria Adalberto Catanzaro?",
                    "acceptedAnswer" => array(
                        "@type" => "Answer",
                        "text" => "La Galleria Adalberto Catanzaro ha due sedi a Palermo: Via Montevergini 3 e Corso Vittorio Emanuele 383, nel centro storico di Palermo."
                    )
                ),
                array(
                    "@type" => "Question",
                    "name" => "Quali sono gli orari di apertura?",
                    "acceptedAnswer" => array(
                        "@type" => "Answer",
                        "text" => "La galleria è aperta dal martedì al sabato dalle 10:00 alle 18:00. Chiusa domenica e lunedì."
                    )
                ),
                array(
                    "@type" => "Question",
                    "name" => "Chi è Adalberto Catanzaro?",
                    "acceptedAnswer" => array(
                        "@type" => "Answer",
                        "text" => "Adalberto Catanzaro è il fondatore e proprietario della galleria, esperto d'arte contemporanea specializzato in Arte Povera e Transavanguardia. Ha fondato la galleria nel 2014."
                    )
                ),
                array(
                    "@type" => "Question",
                    "name" => "Che tipo di arte espone la galleria?",
                    "acceptedAnswer" => array(
                        "@type" => "Answer",
                        "text" => "La Galleria Adalberto Catanzaro si specializza in arte contemporanea, con particolare focus su Arte Povera, Transavanguardia e artisti italiani e internazionali."
                    )
                ),
                array(
                    "@type" => "Question",
                    "name" => "Come posso contattare la galleria?",
                    "acceptedAnswer" => array(
                        "@type" => "Answer",
                        "text" => "Puoi contattarci al telefono " . get_theme_mod('galleria_phone', '+39 327 167 7871') . " o via email all'indirizzo " . get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com') . "."
                    )
                ),
                array(
                    "@type" => "Question",
                    "name" => "La galleria organizza mostre temporanee?",
                    "acceptedAnswer" => array(
                        "@type" => "Answer",
                        "text" => "Sì, la Galleria Adalberto Catanzaro organizza regolarmente mostre temporanee di artisti contemporanei, sia personali che collettive."
                    )
                )
            )
        );

        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_faq_schema', 10);

/**
 * Enhanced Event Schema for exhibitions
 */
function galleria_add_enhanced_exhibition_schema() {
    if (is_singular('exhibition')) {
        global $post;
        $artist = get_field('artist', $post->ID);
        $curator = get_field('curator', $post->ID);
        $venue = get_field('venue', $post->ID) ?: 'Galleria Adalberto Catanzaro';
        $start_date = get_field('start_date', $post->ID);
        $end_date = get_field('end_date', $post->ID);
        $exhibition_type = get_field('exhibition_type', $post->ID);
        
        // Determine if it's current, past, or upcoming
        $now = new DateTime();
        $event_status = "https://schema.org/EventScheduled";
        $event_attendance_mode = "https://schema.org/OfflineEventAttendanceMode";
        
        if ($end_date && new DateTime($end_date) < $now) {
            $event_status = "https://schema.org/EventCancelled"; // Past events
        }
        
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "ExhibitionEvent",
            "@id" => get_permalink() . "#exhibition",
            "name" => get_the_title(),
            "alternateName" => array(get_the_title()),
            "description" => get_the_excerpt() ?: wp_trim_words(get_the_content(), 25),
            "url" => get_permalink(),
            "eventStatus" => $event_status,
            "eventAttendanceMode" => $event_attendance_mode,
            "isAccessibleForFree" => true,
            "keywords" => array("arte contemporanea", "mostra", "Palermo", "galleria", $artist ?: 'artista contemporaneo'),
            "inLanguage" => "it-IT"
        );
        
        if ($start_date && $end_date) {
            $schema["startDate"] = $start_date;
            $schema["endDate"] = $end_date;
        }
        
        // Venue information
        $schema["location"] = array(
            "@type" => "ArtGallery",
            "@id" => home_url() . "#gallery",
            "name" => $venue,
            "address" => array(
                "@type" => "PostalAddress",
                "streetAddress" => get_theme_mod('galleria_address_1', 'Via Montevergini 3'),
                "addressLocality" => "Palermo",
                "addressRegion" => "Sicilia",
                "postalCode" => "90133", 
                "addressCountry" => "IT"
            ),
            "geo" => array(
                "@type" => "GeoCoordinates",
                "latitude" => "38.1157",
                "longitude" => "13.3615"
            ),
            "telephone" => get_theme_mod('galleria_phone', '+39 327 167 7871'),
            "url" => home_url()
        );
        
        // Artist information
        if ($artist) {
            $schema["performer"] = array(
                "@type" => "Person",
                "name" => $artist,
                "jobTitle" => "Artist",
                "description" => "Artista contemporaneo in mostra presso la Galleria Adalberto Catanzaro"
            );
        }
        
        // Curator information
        if ($curator) {
            $schema["director"] = array(
                "@type" => "Person", 
                "name" => $curator,
                "jobTitle" => "Curator"
            );
        }
        
        // Organizer
        $schema["organizer"] = array(
            "@type" => "ArtGallery",
            "@id" => home_url() . "#gallery",
            "name" => "Galleria Adalberto Catanzaro",
            "url" => home_url(),
            "founder" => array(
                "@type" => "Person",
                "@id" => home_url() . "#adalberto-catanzaro",
                "name" => "Adalberto Catanzaro"
            )
        );
        
        // Exhibition type
        if ($exhibition_type) {
            $schema["additionalType"] = $exhibition_type;
        }
        
        // Image
        if (has_post_thumbnail()) {
            $schema["image"] = get_the_post_thumbnail_url($post->ID, 'large');
        }
        
        // Offers (free entry)
        $schema["offers"] = array(
            "@type" => "Offer",
            "price" => "0",
            "priceCurrency" => "EUR",
            "availability" => "https://schema.org/InStock",
            "validFrom" => $start_date ?: get_the_date('c'),
            "validThrough" => $end_date ?: date('c', strtotime('+1 month'))
        );
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_enhanced_exhibition_schema', 11);

/**
 * Enhanced Review Schema capability 
 */
function galleria_add_review_schema_capability() {
    if (is_front_page() || is_home()) {
        // Add aggregate rating schema for the gallery (placeholder - can be populated with actual reviews)
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "AggregateRating",
            "itemReviewed" => array(
                "@type" => "ArtGallery",
                "@id" => home_url() . "#gallery",
                "name" => "Galleria Adalberto Catanzaro"
            ),
            "ratingValue" => "4.8",
            "bestRating" => "5",
            "worstRating" => "1", 
            "ratingCount" => "15",
            "reviewCount" => "12"
        );
        
        // Only add if there are actual reviews (this is a placeholder structure)
        // echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}

/**
 * Creative Work Schema for artworks and exhibitions
 */
function galleria_add_creative_work_schema() {
    if (is_singular('artist')) {
        global $post;
        $artist_name = get_the_title();
        $biography = get_field('biography', $post->ID);
        $birth_year = get_field('birth_year', $post->ID);
        $nationality = get_field('nationality', $post->ID);
        $website = get_field('website', $post->ID);
        
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => array("Person", "Artist"),
            "@id" => get_permalink() . "#artist",
            "name" => $artist_name,
            "description" => $biography ?: get_the_excerpt(),
            "url" => get_permalink(),
            "jobTitle" => "Artist",
            "hasOccupation" => array(
                "@type" => "Occupation",
                "name" => "Contemporary Artist",
                "occupationLocation" => array(
                    "@type" => "Country",
                    "name" => $nationality ?: "Italia"
                )
            ),
            "artform" => array("Contemporary Art", "Visual Arts"),
            "genre" => array("Arte Contemporanea"),
            "associatedArtwork" => array(
                "@type" => "VisualArtwork",
                "artform" => "Contemporary Art",
                "creator" => array(
                    "@type" => "Person",
                    "name" => $artist_name
                )
            ),
            "worksFor" => array(
                "@type" => "ArtGallery",
                "@id" => home_url() . "#gallery",
                "name" => "Galleria Adalberto Catanzaro"
            ),
            "mainEntityOfPage" => get_permalink(),
            "subjectOf" => array(
                "@type" => "WebPage", 
                "url" => get_permalink(),
                "name" => $artist_name . " - Galleria Adalberto Catanzaro"
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
            $schema["url"] = $website;
        }
        
        if (has_post_thumbnail()) {
            $schema["image"] = get_the_post_thumbnail_url($post->ID, 'large');
        }
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_creative_work_schema', 12);

/**
 * Dynamic robots.txt generation
 */
function galleria_custom_robots_txt($output, $public) {
    if ('1' == $public) {
        $custom_robots = "# Galleria Adalberto Catanzaro - Custom Robots.txt\n\n";
        $custom_robots .= "User-agent: *\n";
        $custom_robots .= "Allow: /\n\n";
        
        // Disallow unnecessary files and directories
        $custom_robots .= "Disallow: /wp-admin/\n";
        $custom_robots .= "Allow: /wp-admin/admin-ajax.php\n";
        $custom_robots .= "Disallow: /wp-includes/\n";
        $custom_robots .= "Disallow: /wp-content/plugins/\n";
        $custom_robots .= "Disallow: /wp-content/themes/*/inc/\n";
        $custom_robots .= "Disallow: /?s=*\n";
        $custom_robots .= "Disallow: /*?*\n";
        $custom_robots .= "Disallow: /feed/\n";
        $custom_robots .= "Disallow: */feed/\n";
        $custom_robots .= "Disallow: */trackback/\n\n";
        
        // Allow specific content
        $custom_robots .= "Allow: /wp-content/uploads/\n";
        $custom_robots .= "Allow: /wp-content/themes/*/assets/\n\n";
        
        // Sitemaps
        $custom_robots .= "Sitemap: " . home_url('/wp-sitemap.xml') . "\n";
        $custom_robots .= "Sitemap: " . home_url('/sitemap_index.xml') . "\n\n";
        
        // Crawl delay
        $custom_robots .= "Crawl-delay: 1\n\n";
        
        // Special rules for search engines
        $custom_robots .= "User-agent: Googlebot\n";
        $custom_robots .= "Allow: /\n";
        $custom_robots .= "Crawl-delay: 0\n\n";
        
        $custom_robots .= "User-agent: Bingbot\n";
        $custom_robots .= "Allow: /\n";
        $custom_robots .= "Crawl-delay: 1\n\n";
        
        return $custom_robots;
    }
    
    return $output;
}
add_filter('robots_txt', 'galleria_custom_robots_txt', 10, 2);

/**
 * Enhanced sitemap with images
 */
function galleria_add_images_to_sitemap($entry, $post) {
    $images = array();
    
    // Get featured image
    if (has_post_thumbnail($post->ID)) {
        $thumbnail_id = get_post_thumbnail_id($post->ID);
        $image_url = wp_get_attachment_image_url($thumbnail_id, 'large');
        if ($image_url) {
            $images[] = array(
                'loc' => $image_url,
                'title' => get_the_title($post->ID),
                'caption' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: get_the_title($post->ID)
            );
        }
    }
    
    // Get gallery images from content
    if (preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $post->post_content, $matches)) {
        foreach ($matches[1] as $image_url) {
            if (strpos($image_url, home_url()) !== false) {
                $images[] = array(
                    'loc' => $image_url,
                    'title' => get_the_title($post->ID),
                    'caption' => get_the_title($post->ID)
                );
            }
        }
    }
    
    if (!empty($images)) {
        $entry['images'] = array_slice($images, 0, 10); // Max 10 images per URL
    }
    
    return $entry;
}
add_filter('wp_sitemaps_posts_entry', 'galleria_add_images_to_sitemap', 10, 2);

/**
 * Enhanced social meta tags
 */
function galleria_enhanced_social_meta() {
    // Enhanced Twitter Card
    echo '<meta name="twitter:site" content="@galleria_catanzaro">' . "\n";
    echo '<meta name="twitter:creator" content="@adalberto_catanzaro">' . "\n";
    
    if (is_singular()) {
        // Article specific tags
        echo '<meta property="article:publisher" content="' . esc_url(home_url()) . '">' . "\n";
        echo '<meta property="article:author" content="Galleria Adalberto Catanzaro">' . "\n";
        
        if (is_singular('exhibition')) {
            $artist = get_field('artist');
            if ($artist) {
                echo '<meta property="article:tag" content="' . esc_attr($artist) . '">' . "\n";
            }
            echo '<meta property="article:section" content="Mostre">' . "\n";
        } elseif (is_singular('artist')) {
            echo '<meta property="article:section" content="Artisti">' . "\n";
        }
        
        echo '<meta property="article:published_time" content="' . get_the_date('c') . '">' . "\n";
        echo '<meta property="article:modified_time" content="' . get_the_modified_date('c') . '">' . "\n";
    }
    
    // Schema.org for social sharing
    if (is_front_page()) {
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="fb:app_id" content="">' . "\n"; // Add if Facebook app available
    }
    
    // Additional OpenGraph tags for better sharing
    echo '<meta property="og:locale" content="it_IT">' . "\n";
    echo '<meta property="og:site_name" content="Galleria Adalberto Catanzaro">' . "\n";
    
    // Pinterest specific
    echo '<meta name="pinterest-rich-pin" content="true">' . "\n";
}
add_action('wp_head', 'galleria_enhanced_social_meta', 6);

/**
 * SEO Monitoring and Alerts System
 */
function galleria_seo_monitoring_init() {
    // Check if monitoring should run (once daily)
    $last_check = get_option('galleria_last_seo_check', 0);
    if (time() - $last_check < DAY_IN_SECONDS) {
        return;
    }
    
    update_option('galleria_last_seo_check', time());
    
    // Run SEO checks
    galleria_run_seo_checks();
}
add_action('wp_loaded', 'galleria_seo_monitoring_init');

/**
 * Run automated SEO checks
 */
function galleria_run_seo_checks() {
    $issues = array();
    
    // Check if Analytics is configured
    $analytics_settings = galleria_get_analytics_settings();
    if (empty($analytics_settings['ga4_measurement_id'])) {
        $issues[] = array(
            'type' => 'warning',
            'message' => 'Google Analytics non configurato',
            'priority' => 'media'
        );
    }
    
    // Check for missing meta descriptions
    $posts_without_meta = get_posts(array(
        'post_type' => array('page', 'post', 'artist', 'exhibition'),
        'posts_per_page' => 50,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_yoast_wpseo_metadesc',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => '_yoast_wpseo_metadesc',
                'value' => '',
                'compare' => '='
            )
        )
    ));
    
    if (!empty($posts_without_meta) && count($posts_without_meta) > 10) {
        $issues[] = array(
            'type' => 'notice',
            'message' => 'Molti contenuti senza meta description personalizzata',
            'priority' => 'bassa'
        );
    }
    
    // Check for duplicate titles
    global $wpdb;
    $duplicate_titles = $wpdb->get_var("
        SELECT COUNT(*) FROM (
            SELECT post_title, COUNT(*) as cnt
            FROM {$wpdb->posts} 
            WHERE post_status = 'publish' 
            AND post_type IN ('page', 'post', 'artist', 'exhibition')
            GROUP BY post_title
            HAVING cnt > 1
        ) as duplicates
    ");
    
    if ($duplicate_titles > 0) {
        $issues[] = array(
            'type' => 'warning',
            'message' => $duplicate_titles . ' titoli duplicati trovati',
            'priority' => 'alta'
        );
    }
    
    // Store issues for dashboard display
    update_option('galleria_seo_issues', $issues);
    
    // Send email alert for high priority issues
    $high_priority = array_filter($issues, function($issue) {
        return $issue['priority'] === 'alta';
    });
    
    if (!empty($high_priority)) {
        galleria_send_seo_alert($high_priority);
    }
}

/**
 * Send SEO alert email
 */
function galleria_send_seo_alert($issues) {
    $admin_email = get_option('admin_email');
    if (!$admin_email) return;
    
    $subject = 'Alert SEO - Galleria Catanzaro';
    $message = "Sono stati rilevati alcuni problemi SEO prioritari sul sito:\n\n";
    
    foreach ($issues as $issue) {
        $message .= "• " . $issue['message'] . " (Priorità: " . $issue['priority'] . ")\n";
    }
    
    $message .= "\nAccedi alla dashboard SEO per maggiori dettagli: " . admin_url('admin.php?page=galleria-seo-dashboard') . "\n";
    $message .= "\nQuesto è un messaggio automatico del sistema SEO monitoring.";
    
    wp_mail($admin_email, $subject, $message);
}

/**
 * Performance optimization hints
 */
function galleria_add_performance_hints() {
    // DNS prefetch for external resources
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.google-analytics.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.googletagmanager.com">' . "\n";
    
    // Preconnect to critical resources
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    
    // Resource hints for better performance
    if (is_front_page()) {
        // Preload critical CSS (if you have critical CSS)
        // echo '<link rel="preload" href="' . get_template_directory_uri() . '/assets/css/critical.css" as="style">' . "\n";
        
        // Preload hero image if exists
        $hero_image = get_theme_mod('galleria_hero_image');
        if ($hero_image) {
            echo '<link rel="preload" href="' . esc_url($hero_image) . '" as="image">' . "\n";
        }
    }
}
add_action('wp_head', 'galleria_add_performance_hints', 1);

/**
 * Add JSON-LD structured data for entire site
 */
function galleria_add_website_schema() {
    if (is_front_page()) {
        $website_schema = array(
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "@id" => home_url() . "#website",
            "name" => "Galleria Adalberto Catanzaro",
            "alternateName" => array("Galleria Catanzaro", "Adalberto Catanzaro Gallery"),
            "description" => "Sito ufficiale della Galleria Adalberto Catanzaro - Arte Contemporanea a Palermo",
            "url" => home_url(),
            "inLanguage" => "it-IT",
            "copyrightYear" => date('Y'),
            "copyrightHolder" => array(
                "@type" => "Organization",
                "name" => "Galleria Adalberto Catanzaro"
            ),
            "publisher" => array(
                "@type" => "Organization",
                "@id" => home_url() . "#organization",
                "name" => "Galleria Adalberto Catanzaro",
                "url" => home_url()
            ),
            "potentialAction" => array(
                "@type" => "SearchAction",
                "target" => array(
                    "@type" => "EntryPoint",
                    "urlTemplate" => home_url() . "/?s={search_term_string}"
                ),
                "query-input" => "required name=search_term_string"
            ),
            "mainEntity" => array(
                "@id" => home_url() . "#gallery"
            )
        );
        
        echo '<script type="application/ld+json">' . json_encode($website_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_website_schema', 18);