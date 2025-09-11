<?php
/**
 * Local SEO Optimizations for Palermo
 * Ottimizzazioni SEO locali specifiche per Palermo
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add geo-specific meta tags for Palermo locations
 */
function galleria_add_geo_meta_tags() {
    // Add to all pages for local search visibility
    echo '<meta name="geo.region" content="IT-PA">' . "\n";
    echo '<meta name="geo.placename" content="Palermo, Sicilia, Italia">' . "\n";
    echo '<meta name="geo.position" content="38.1157;13.3615">' . "\n";
    echo '<meta name="ICBM" content="38.1157, 13.3615">' . "\n";
    echo '<meta name="DC.title" content="' . esc_attr(wp_get_document_title()) . ' - Palermo">' . "\n";
    
    // Location-specific keywords
    echo '<meta name="keywords" content="galleria arte Palermo, arte contemporanea Palermo, Adalberto Catanzaro, mostre Palermo, Via Montevergini, Corso Vittorio Emanuele, centro storico Palermo, Arte Povera Sicilia, Transavanguardia Palermo">' . "\n";
    
    // Language and region targeting
    echo '<meta name="language" content="Italian">' . "\n";
    echo '<meta name="content-language" content="it-IT">' . "\n";
    echo '<meta name="geo.country" content="IT">' . "\n";
}
add_action('wp_head', 'galleria_add_geo_meta_tags', 3);

/**
 * Enhanced OpenGraph tags for local business
 */
function galleria_add_local_og_tags() {
    if (is_front_page() || is_home()) {
        echo '<meta property="business:contact_data:street_address" content="Via Montevergini 3">' . "\n";
        echo '<meta property="business:contact_data:locality" content="Palermo">' . "\n";
        echo '<meta property="business:contact_data:region" content="Sicilia">' . "\n";
        echo '<meta property="business:contact_data:postal_code" content="90133">' . "\n";
        echo '<meta property="business:contact_data:country_name" content="Italia">' . "\n";
        echo '<meta property="business:contact_data:phone_number" content="' . esc_attr(get_theme_mod('galleria_phone', '+39 327 167 7871')) . '">' . "\n";
        echo '<meta property="business:contact_data:website" content="' . esc_url(home_url()) . '">' . "\n";
        
        // Place-specific tags
        echo '<meta property="place:location:latitude" content="38.1157">' . "\n";
        echo '<meta property="place:location:longitude" content="13.3615">' . "\n";
        
        // Article tags for better local discovery
        echo '<meta property="article:author" content="Galleria Adalberto Catanzaro">' . "\n";
        echo '<meta property="article:published_time" content="2014-01-01T00:00:00Z">' . "\n";
        echo '<meta property="article:section" content="Arte Contemporanea">' . "\n";
        echo '<meta property="article:tag" content="Palermo">' . "\n";
        echo '<meta property="article:tag" content="Arte Contemporanea">' . "\n";
        echo '<meta property="article:tag" content="Adalberto Catanzaro">' . "\n";
        echo '<meta property="article:tag" content="Galleria">' . "\n";
    }
}
add_action('wp_head', 'galleria_add_local_og_tags', 7);

/**
 * Add location-specific structured data for both gallery locations
 */
function galleria_add_multiple_locations_schema() {
    if (is_front_page() || is_home()) {
        // Via Montevergini Location
        $montevergini_schema = array(
            "@context" => "https://schema.org",
            "@type" => "ArtGallery",
            "@id" => home_url() . "#location-montevergini",
            "name" => "Galleria Adalberto Catanzaro - Via Montevergini",
            "alternateName" => "Galleria Catanzaro Montevergini",
            "description" => "Sede principale della Galleria Adalberto Catanzaro nel centro storico di Palermo, Via Montevergini.",
            "url" => home_url(),
            "telephone" => get_theme_mod('galleria_phone', '+39 327 167 7871'),
            "email" => get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com'),
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
            "openingHours" => get_theme_mod('galleria_hours', 'Tu-Sa 10:00-18:00'),
            "areaServed" => array(
                array(
                    "@type" => "City",
                    "name" => "Palermo"
                ),
                array(
                    "@type" => "AdministrativeArea", 
                    "name" => "Sicilia"
                )
            ),
            "hasMap" => "https://maps.google.com/maps?q=Via+Montevergini+3,+Palermo",
            "isAccessibleForFree" => true,
            "publicAccess" => true
        );
        
        // Corso Vittorio Emanuele Location
        $vittorio_schema = array(
            "@context" => "https://schema.org",
            "@type" => "ArtGallery",
            "@id" => home_url() . "#location-vittorio-emanuele",
            "name" => "Galleria Adalberto Catanzaro - Corso Vittorio Emanuele",
            "alternateName" => "Galleria Catanzaro Vittorio Emanuele",
            "description" => "Seconda sede della Galleria Adalberto Catanzaro sul prestigioso Corso Vittorio Emanuele di Palermo.",
            "url" => home_url(),
            "telephone" => get_theme_mod('galleria_phone', '+39 327 167 7871'),
            "email" => get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com'),
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
            ),
            "openingHours" => get_theme_mod('galleria_hours', 'Tu-Sa 10:00-18:00'),
            "areaServed" => array(
                array(
                    "@type" => "City",
                    "name" => "Palermo"
                ),
                array(
                    "@type" => "AdministrativeArea",
                    "name" => "Sicilia"
                )
            ),
            "hasMap" => "https://maps.google.com/maps?q=Corso+Vittorio+Emanuele+383,+Palermo",
            "isAccessibleForFree" => true,
            "publicAccess" => true
        );
        
        echo '<script type="application/ld+json">' . json_encode($montevergini_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
        echo '<script type="application/ld+json">' . json_encode($vittorio_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_multiple_locations_schema', 13);

/**
 * Add local event schema for current exhibitions
 */
function galleria_add_local_event_schema() {
    // Get current exhibitions
    $current_exhibitions = get_current_exhibitions(3);
    
    if ($current_exhibitions->have_posts()) {
        while ($current_exhibitions->have_posts()) {
            $current_exhibitions->the_post();
            $exhibition_id = get_the_ID();
            $artist = get_field('artist', $exhibition_id);
            $start_date = get_field('start_date', $exhibition_id);
            $end_date = get_field('end_date', $exhibition_id);
            
            $event_schema = array(
                "@context" => "https://schema.org",
                "@type" => "ExhibitionEvent",
                "@id" => get_permalink($exhibition_id) . "#local-event",
                "name" => get_the_title($exhibition_id),
                "description" => get_the_excerpt($exhibition_id) ?: "Mostra presso la Galleria Adalberto Catanzaro a Palermo",
                "startDate" => $start_date,
                "endDate" => $end_date,
                "eventStatus" => "https://schema.org/EventScheduled",
                "eventAttendanceMode" => "https://schema.org/OfflineEventAttendanceMode",
                "location" => array(
                    "@type" => "Place",
                    "name" => "Galleria Adalberto Catanzaro",
                    "address" => array(
                        "@type" => "PostalAddress",
                        "streetAddress" => get_theme_mod('galleria_address_1', 'Via Montevergini 3'),
                        "addressLocality" => "Palermo",
                        "addressRegion" => "Sicilia",
                        "addressCountry" => "IT",
                        "postalCode" => "90133"
                    ),
                    "geo" => array(
                        "@type" => "GeoCoordinates",
                        "latitude" => "38.1157",
                        "longitude" => "13.3615"
                    )
                ),
                "organizer" => array(
                    "@type" => "Organization",
                    "name" => "Galleria Adalberto Catanzaro",
                    "url" => home_url()
                ),
                "offers" => array(
                    "@type" => "Offer",
                    "price" => "0",
                    "priceCurrency" => "EUR",
                    "availability" => "https://schema.org/InStock"
                ),
                "keywords" => "mostra arte Palermo, " . ($artist ? $artist . ', ' : '') . "arte contemporanea Palermo, galleria Palermo",
                "inLanguage" => "it-IT"
            );
            
            if ($artist) {
                $event_schema["performer"] = array(
                    "@type" => "Person",
                    "name" => $artist
                );
            }
            
            if (has_post_thumbnail($exhibition_id)) {
                $event_schema["image"] = get_the_post_thumbnail_url($exhibition_id, 'large');
            }
            
            echo '<script type="application/ld+json">' . json_encode($event_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
        }
        wp_reset_postdata();
    }
}
add_action('wp_head', 'galleria_add_local_event_schema', 14);

/**
 * Add local business hours structured data
 */
function galleria_add_business_hours_schema() {
    if (is_front_page() || is_home()) {
        $hours_schema = array(
            "@context" => "https://schema.org",
            "@type" => "OpeningHoursSpecification",
            "dayOfWeek" => array(
                "https://schema.org/Tuesday",
                "https://schema.org/Wednesday", 
                "https://schema.org/Thursday",
                "https://schema.org/Friday",
                "https://schema.org/Saturday"
            ),
            "opens" => "10:00",
            "closes" => "18:00",
            "validFrom" => date('Y-01-01'),
            "validThrough" => date('Y-12-31')
        );
        
        echo '<script type="application/ld+json">' . json_encode($hours_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_business_hours_schema', 15);

/**
 * Add local sitemap enhancements
 */
function galleria_add_local_sitemap_urls($urls, $post_type) {
    if ($post_type === 'page') {
        // Add location-specific URLs
        $local_urls = array(
            array(
                'loc' => home_url('/contatti/'),
                'lastmod' => date('c'),
                'changefreq' => 'monthly',
                'priority' => 0.8,
                'images' => array()
            ),
            array(
                'loc' => home_url('/dove-siamo/'),
                'lastmod' => date('c'),
                'changefreq' => 'monthly', 
                'priority' => 0.7,
                'images' => array()
            )
        );
        
        $urls = array_merge($urls, $local_urls);
    }
    
    return $urls;
}
add_filter('wp_sitemaps_posts_entry', 'galleria_add_local_sitemap_urls', 10, 2);

/**
 * Enhance robots.txt with local SEO directives
 */
function galleria_enhance_robots_txt($output, $public) {
    if ('1' == $public) {
        $output .= "\n# Local SEO Enhancements\n";
        $output .= "Sitemap: " . home_url('/wp-sitemap.xml') . "\n";
        $output .= "Sitemap: " . home_url('/sitemap_index.xml') . "\n\n";
        
        // Add location-specific crawling hints
        $output .= "# Gallery Locations\n";
        $output .= "Allow: /artisti/\n";
        $output .= "Allow: /mostre/\n";
        $output .= "Allow: /progetti/\n";
        $output .= "Allow: /contatti/\n";
        $output .= "Allow: /assets/images/\n\n";
        
        // Crawl-delay for better server performance
        $output .= "Crawl-delay: 1\n";
    }
    
    return $output;
}
add_filter('robots_txt', 'galleria_enhance_robots_txt', 10, 2);

/**
 * Add hreflang for local variations (if needed for regional targeting)
 */
function galleria_add_regional_hreflang() {
    if (is_front_page() || is_home()) {
        // Italian variations
        echo '<link rel="alternate" hreflang="it" href="' . esc_url(home_url()) . '">' . "\n";
        echo '<link rel="alternate" hreflang="it-IT" href="' . esc_url(home_url()) . '">' . "\n";
        echo '<link rel="alternate" hreflang="x-default" href="' . esc_url(home_url()) . '">' . "\n";
    }
}
add_action('wp_head', 'galleria_add_regional_hreflang', 4);

/**
 * Local keyword optimization for titles and descriptions
 */
function galleria_enhance_local_seo_content($title) {
    // Add "Palermo" to titles when appropriate for local SEO
    if (is_front_page() && strpos($title, 'Palermo') === false) {
        $title = str_replace('Galleria Adalberto Catanzaro', 'Galleria Adalberto Catanzaro Palermo', $title);
    }
    
    return $title;
}
add_filter('wp_title', 'galleria_enhance_local_seo_content');
add_filter('document_title_parts', function($parts) {
    if (is_front_page() && isset($parts['title']) && strpos($parts['title'], 'Palermo') === false) {
        $parts['title'] = str_replace('Galleria Adalberto Catanzaro', 'Galleria Adalberto Catanzaro Palermo', $parts['title']);
    }
    return $parts;
});

/**
 * Add local business JSON-LD for Google My Business integration
 */
function galleria_add_google_my_business_schema() {
    if (is_front_page() || is_home()) {
        $gmb_schema = array(
            "@context" => "https://schema.org",
            "@type" => "LocalBusiness",
            "@id" => home_url() . "#local-business",
            "name" => "Galleria Adalberto Catanzaro",
            "image" => get_template_directory_uri() . '/assets/images/logo.png',
            "description" => "Galleria d'arte contemporanea a Palermo specializzata in Arte Povera e Transavanguardia. Due sedi nel centro storico.",
            "url" => home_url(),
            "telephone" => get_theme_mod('galleria_phone', '+39 327 167 7871'),
            "email" => get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com'),
            "address" => array(
                "@type" => "PostalAddress",
                "streetAddress" => get_theme_mod('galleria_address_1', 'Via Montevergini 3'),
                "addressLocality" => "Palermo", 
                "addressRegion" => "PA",
                "postalCode" => "90133",
                "addressCountry" => "IT"
            ),
            "geo" => array(
                "@type" => "GeoCoordinates",
                "latitude" => 38.1157,
                "longitude" => 13.3615
            ),
            "openingHoursSpecification" => array(
                array(
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => array(
                        "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
                    ),
                    "opens" => "10:00",
                    "closes" => "18:00"
                )
            ),
            "servesCuisine" => null,
            "priceRange" => "$$",
            "currenciesAccepted" => "EUR",
            "paymentAccepted" => array("Cash", "Credit Card"),
            "founder" => array(
                "@type" => "Person",
                "name" => "Adalberto Catanzaro"
            ),
            "areaServed" => array("Palermo", "Sicilia", "Italia"),
            "knowsAbout" => array("Arte Contemporanea", "Arte Povera", "Transavanguardia"),
            "hasOfferCatalog" => array(
                "@type" => "OfferCatalog", 
                "name" => "Servizi Galleria",
                "itemListElement" => array(
                    array(
                        "@type" => "Offer",
                        "itemOffered" => array(
                            "@type" => "Service",
                            "name" => "Mostre d'Arte",
                            "description" => "Esposizioni di arte contemporanea"
                        )
                    ),
                    array(
                        "@type" => "Offer",
                        "itemOffered" => array(
                            "@type" => "Service", 
                            "name" => "Consulenza Artistica",
                            "description" => "Valutazione e consulenza per collezioni d'arte"
                        )
                    )
                )
            )
        );
        
        echo '<script type="application/ld+json">' . json_encode($gmb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_google_my_business_schema', 16);

/**
 * Add local search appearance enhancements
 */
function galleria_add_local_search_enhancements() {
    // Add dublin core metadata for better local discovery
    echo '<meta name="DC.Title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
    echo '<meta name="DC.Description" content="Galleria d\'arte contemporanea Palermo - Adalberto Catanzaro">' . "\n";
    echo '<meta name="DC.Creator" content="Galleria Adalberto Catanzaro">' . "\n";
    echo '<meta name="DC.Subject" content="Arte Contemporanea, Palermo, Sicilia">' . "\n";
    echo '<meta name="DC.Publisher" content="Galleria Adalberto Catanzaro">' . "\n";
    echo '<meta name="DC.Rights" content="© Galleria Adalberto Catanzaro">' . "\n";
    echo '<meta name="DC.Language" content="it-IT">' . "\n";
    echo '<meta name="DC.Coverage" content="Palermo, Sicilia, Italia">' . "\n";
    
    // Local business schema breadcrumbs
    if (!is_front_page()) {
        $breadcrumb_schema = array(
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => array(
                array(
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Palermo",
                    "item" => "https://www.google.com/maps/place/Palermo"
                ),
                array(
                    "@type" => "ListItem", 
                    "position" => 2,
                    "name" => "Gallerie Arte",
                    "item" => home_url()
                ),
                array(
                    "@type" => "ListItem",
                    "position" => 3, 
                    "name" => "Adalberto Catanzaro",
                    "item" => home_url()
                )
            )
        );
        
        echo '<script type="application/ld+json">' . json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'galleria_add_local_search_enhancements', 17);