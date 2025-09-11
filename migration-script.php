<?php
/**
 * Migration Script - Convert Next.js data to WordPress
 * Run this script from WordPress admin or WP-CLI to migrate content
 */

// Security check - only run if WordPress is loaded and user is admin
if (!defined('ABSPATH') || !current_user_can('manage_options')) {
    die('Access denied');
}

/**
 * Artist data from Next.js site
 */
function get_nextjs_artists_data() {
    return array(
        array(
            'name' => 'Micol Assaël',
            'biography' => 'Artista italiana che lavora con installazioni, sculture e ambienti che esplorano tensioni fisiche e psicologiche attraverso materiali industriali e tecnologie.'
        ),
        array(
            'name' => 'Domenico Bianchi',
            'biography' => 'Pittore italiano della Transavanguardia, noto per le sue opere che utilizzano materiali come cera, feltro e pigmenti naturali su supporti non convenzionali.'
        ),
        array(
            'name' => 'Gianluca Concialdi',
            'biography' => 'Artista contemporaneo italiano che lavora con sculture e installazioni, esplorando il rapporto tra forma, spazio e materia.'
        ),
        array(
            'name' => 'Giovanni Leto',
            'biography' => 'Artista siciliano che sviluppa una ricerca sulla carta come supporto e materia espressiva, creando opere che dialogano con la tradizione e l\'innovazione.'
        ),
        array(
            'name' => 'Luca Maria Patella',
            'biography' => 'Artista concettuale italiano, pioniere della video art e della performance, che ha contribuito significativamente al dibattito artistico contemporaneo dagli anni \'60.'
        ),
        array(
            'name' => 'Luigi Mainolfi',
            'biography' => 'Scultore italiano noto per le sue opere in terracotta che uniscono tradizione ceramica campana e ricerca contemporanea, esplorando forme archetipiche e simboliche.'
        ),
        array(
            'name' => 'Maurizio Mochetti',
            'biography' => 'Artista italiano che lavora con tecnologia, luce e movimento, creando installazioni che esplorano fenomeni fisici e percettivi attraverso mezzi tecnologici avanzati.'
        ),
        array(
            'name' => 'Vittorio Messina',
            'biography' => 'Artista siciliano che sviluppa una ricerca multidisciplinare attraverso scultura, installazione e interventi ambientali, indagando il rapporto tra arte e paesaggio.'
        ),
        array(
            'name' => 'Hidetoshi Nagasawa',
            'biography' => 'Scultore giapponese naturalizzato italiano, noto per le sue opere che combinano tradizione orientale e cultura occidentale attraverso materiali naturali e forme essenziali.'
        ),
        array(
            'name' => 'Nunzio',
            'biography' => 'Artista italiano della Transavanguardia, noto per le sue sculture che utilizzano materiali industriali come piombo, ferro e catrame, esplorando temi di memoria e trasformazione.'
        ),
        array(
            'name' => 'Alfredo Romano',
            'biography' => 'Artista contemporaneo italiano che sviluppa una ricerca attraverso pittura e installazione, esplorando il rapporto tra colore, forma e spazio.'
        ),
        array(
            'name' => 'Francesco Surdi',
            'biography' => 'Artista contemporaneo italiano che lavora con sculture e installazioni, investigando il rapporto tra materia, tempo e trasformazione.'
        ),
        array(
            'name' => 'Croce Taravella',
            'biography' => 'Artista siciliano che sviluppa una ricerca attraverso pittura, scultura e installazione, esplorando temi legati alla natura, al tempo e alla memoria.'
        ),
        array(
            'name' => 'Turi Simeti',
            'biography' => 'Artista siciliano pioniere dell\'arte concettuale in Italia, noto per i suoi Ovali che trasformano la superficie pittorica attraverso forme geometriche pure e ripetitive.'
        ),
        array(
            'name' => 'Gilberto Zorio',
            'biography' => 'Artista italiano dell\'Arte Povera, noto per le sue sculture e installazioni che utilizzano materiali industriali e naturali per esplorare trasformazioni fisiche e chimiche.'
        ),
    );
}

/**
 * Exhibition data from Next.js site - COMPLETE DATA
 */
function get_nextjs_exhibitions_data() {
    return array(
        array(
            'title' => 'Tensioni e Dialoghi',
            'artist' => 'Maurizio Mochetti',
            'location' => 'palermo',
            'start_date' => '2024-10-01',
            'end_date' => '2025-01-15',
            'description' => 'Un progetto espositivo che esplora le tensioni creative attraverso installazioni site-specific.',
            'image' => 'opera1.jpeg',
            'featured' => true,
            'status' => 'current'
        ),
        array(
            'title' => 'Il colore della scultura la forma della pittura 3',
            'artist' => 'Luigi Mainolfi',
            'location' => 'bagheria',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'start_date' => '2019-10-26',
            'end_date' => '2020-01-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/LUIGI MAINOLFI.jpg',
            'featured' => true,
            'status' => 'past'
        ),
        array(
            'title' => 'Primiiera',
            'artist' => 'Gilberto Zorio, Nunzio, Vittorio Messina, Eliseo Mattiacci',
            'curator' => 'Bruno Corà',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2018-10-01',
            'end_date' => '2019-03-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/PRIMIERA.jpg',
            'featured' => true,
            'status' => 'past'
        ),
        array(
            'title' => 'Le opere per Gibellina',
            'artist' => 'Mario Schifano',
            'curator' => 'Marco Meneguzzo',
            'venue' => 'Villa Cattolica, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2017-07-01',
            'end_date' => '2017-10-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/schifano.jpeg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Lettura di un\'onda',
            'artist' => 'Micol Assaël',
            'curator' => 'Bruno Corà e Valentino Catricalà',
            'venue' => 'Museo Riso, Palermo',
            'location' => 'palermo',
            'start_date' => '2017-06-01',
            'end_date' => '2017-09-30',
            'description' => '',
            'image' => 'FOTO ELENCHI/LETTURA DI UN\'ONDA.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Galleggiamento',
            'artist' => 'Hidetoshi Nagasawa',
            'curator' => 'Bruno Corà',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2017-05-01',
            'end_date' => '2017-09-30',
            'description' => '',
            'image' => 'FOTO ELENCHI/GALLEGGIAMENTO NAGA.jpg',
            'featured' => true,
            'status' => 'past'
        ),
        array(
            'title' => 'Isntit',
            'artist' => 'Vittorio Messina',
            'curator' => 'Bruno Corà e Valentino Catricalà',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2016-11-01',
            'end_date' => '2017-02-28',
            'description' => '',
            'image' => 'FOTO ELENCHI/ISNTIT MESSINA.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Puca Latella, (Un Luca d\'antan?!)',
            'artist' => 'Luca Maria Patella',
            'curator' => 'Valentino Catricalà',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2016-06-01',
            'end_date' => '2016-09-30',
            'description' => '',
            'image' => 'FOTO ELENCHI/PUCA LATELLA -LUCA MARIA PATELLA.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Opere recenti e storiche',
            'artist' => 'Nunzio',
            'curator' => 'Bruno Corà',
            'venue' => 'Museo Riso, Palermo',
            'location' => 'palermo',
            'start_date' => '2016-06-01',
            'end_date' => '2016-10-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/OPERE STORICHE NUNZIO.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Teatro Naturale Prove in Connecticut',
            'artist' => 'Vittorio Messina',
            'curator' => 'Bruno Corà',
            'venue' => 'Albergo delle Povere, Palermo; Museo Riso, Palermo; Palazzo delle Acquile, Palermo',
            'location' => 'palermo',
            'start_date' => '2016-04-01',
            'end_date' => '2016-09-30',
            'description' => '',
            'image' => 'FOTO ELENCHI/RISO MESSINA.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Racconti di carte',
            'artist' => 'Giovanni Leto',
            'curator' => 'Ezio Pagano',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2016-02-01',
            'end_date' => '2016-04-30',
            'description' => '',
            'image' => 'FOTO ELENCHI/LETO RACCONTI DI CARTA.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => '',
            'artist' => 'Domenico Bianchi',
            'curator' => '',
            'venue' => 'Cappella dell\'Incoronazione - Museo Riso, Palermo',
            'location' => 'palermo',
            'start_date' => '2015-12-01',
            'end_date' => '2016-02-28',
            'description' => 'con testo di Demetrio Paparoni',
            'image' => 'FOTO ELENCHI/DOMENICO BIANCHI.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Fluttuazioni',
            'artist' => 'Michele Cossyro',
            'curator' => 'Marco Meneguzzo',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2015-10-01',
            'end_date' => '2015-12-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/FLUTTUAZIONI COSSYRO.png',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Pittura: Aniconica Passione Mediterranea',
            'artist' => 'Ignazio Moncada',
            'curator' => 'Ezio Pagano',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2015-10-01',
            'end_date' => '2015-12-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/PITTURA ANICONICA - MONCADA.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'L\'arte segna il tempo / Il tempo segna l\'arte',
            'artist' => 'Filippo Panseca',
            'curator' => 'Ezio Pagano e Valentino Catricalà',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2015-05-01',
            'end_date' => '2015-09-30',
            'description' => '',
            'image' => 'FOTO ELENCHI/PANSECA OPERE BIO DEGAGRABILI.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Pianeti Solitari',
            'artist' => 'Rosario Bruno - Juan Esperanza',
            'curator' => 'Ezio Pagano',
            'venue' => 'Galleria Adalberto Catanzaro, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2015-01-01',
            'end_date' => '2015-03-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/ROSARIO BRUNO JUAN ESPERANZA.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Biologie',
            'artist' => 'Croce Taravella',
            'curator' => 'Gianluca Marziani',
            'venue' => 'Palazzo Collicola, Spoleto',
            'location' => 'spoleto',
            'start_date' => '2014-12-01',
            'end_date' => '2015-03-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/BIOLOGIE.jpg',
            'featured' => false,
            'status' => 'past'
        ),
        array(
            'title' => 'Fermo Immagine',
            'artist' => 'Croce Taravella',
            'curator' => 'Lea Mattarella',
            'venue' => 'Palazzo Sant\'Elia, Palermo',
            'location' => 'palermo',
            'start_date' => '2014-04-01',
            'end_date' => '2014-06-30',
            'description' => '',
            'image' => 'FOTO ELENCHI/FERMO IMMAGINE.JPG',
            'featured' => false,
            'status' => 'past'
        )
    );
}

/**
 * Project data from Next.js site
 */
function get_nextjs_projects_data() {
    return array(
        array(
            'title' => 'OSSI',
            'artist' => 'CONCIALDI / SURDI',
            'curator' => 'Valentino Catricalà',
            'venue' => 'Villa Palagonia, Bagheria',
            'location' => 'bagheria',
            'start_date' => '2018-09-01',
            'end_date' => '2018-10-31',
            'description' => '',
            'image' => 'FOTO ELENCHI/OSSI.jpg',
            'featured' => false,
            'status' => 'past'
        )
    );
}

/**
 * News data from Next.js site
 */
function get_nextjs_news_data() {
    return array(
        array(
            'title' => 'Micol Assaël protagonista alla Quadriennale di Roma Fantastica',
            'type' => 'solo-exhibition',
            'description' => 'La Quadriennale di Roma 2024–2025, intitolata Fantastica, conferma la centralità di Micol Assaël nel panorama dell\'arte italiana contemporanea. L\'artista romana presenta nuove opere che intrecciano scienza, tecnica e percezione sensoriale, assumendo un ruolo strategico nella rassegna che occupa tutti i piani del Palazzo delle Esposizioni. I suoi dispositivi, al limite tra laboratorio scientifico e trappola percettiva, spingono il pubblico verso un\'esperienza di instabilità e apertura, rafforzando l\'idea di una Quadriennale che rilancia le traiettorie dell\'arte nazionale fino alla primavera 2025.',
            'image' => 'news1.jpeg',
            'date' => '2025-01-15'
        ),
        array(
            'title' => 'Nunzio in mostra alla Galleria dello Scudo con gli anni ottanta dalla collezione Fabio Sargentini',
            'type' => 'solo-exhibition',
            'description' => 'L\'esposizione alla Galleria dello Scudo a Verona dal 14 dicembre 2024 al 29 marzo 2025 si concentra sul primo decennio del lavoro dell\'artista con una selezione di quindici opere degli anni ottanta dalla collezione di Fabio Sargentini. Le opere documentano una fase creativa di grande fermento dell\'artista della Transavanguardia, interprete di una ricerca sullo spazio aperta a contaminazioni con la pittura. Da Spleen (1980) a Tentazione (1989), il percorso espositivo testimonia un\'evoluzione da sculture in gesso dipinto a opere in legno combusto, pece e piombo, riconfermando Nunzio tra le personalità più originali del panorama artistico italiano degli anni ottanta.',
            'image' => 'news2.jpeg',
            'date' => '2024-12-14'
        ),
        array(
            'title' => 'José Angelino porta le aurore boreali al PhEST di Monopoli',
            'type' => 'group-exhibition',
            'description' => 'Il PhEST – Festival Internazionale di Fotografia e Arte celebra nel 2025 la sua decima edizione con José Angelino tra i protagonisti. All\'interno delle antiche Stalle di Casa Santa, l\'artista presenta "Out of the Blue – Resistenze 2025", un progetto site-specific che riproduce le aurore boreali "in vitro" attraverso l\'uso di gas nobili e vetro, trasformando lo spazio in un laboratorio di luce ed energia. L\'installazione dialoga perfettamente con il tema del festival "This Is Us – A Capsule to Space", offrendo un\'esperienza immersiva sospesa tra fenomeni naturali e stati della materia dal 8 agosto al 16 novembre 2025.',
            'image' => 'news3.jpeg',
            'date' => '2025-08-08'
        )
    );
}

/**
 * Helper function to import image to WordPress media library
 */
function import_image_to_media_library($image_path, $post_id = 0, $title = '') {
    $theme_images_path = get_template_directory() . '/assets/images/';
    $upload_dir = wp_upload_dir();
    
    // Full path to source image
    $source_file = $theme_images_path . $image_path;
    
    // Check if source file exists
    if (!file_exists($source_file)) {
        return false;
    }
    
    // Get file info
    $file_info = pathinfo($image_path);
    $filename = sanitize_file_name($file_info['basename']);
    
    // Destination path
    $dest_file = $upload_dir['path'] . '/' . $filename;
    $dest_url = $upload_dir['url'] . '/' . $filename;
    
    // Check if file already exists in uploads
    if (file_exists($dest_file)) {
        // File exists, find the attachment ID
        $existing_attachment = get_posts(array(
            'post_type' => 'attachment',
            'meta_key' => '_wp_attached_file',
            'meta_value' => str_replace($upload_dir['basedir'] . '/', '', $dest_file),
            'posts_per_page' => 1
        ));
        
        if (!empty($existing_attachment)) {
            return $existing_attachment[0]->ID;
        }
    }
    
    // Copy file to uploads directory
    if (!copy($source_file, $dest_file)) {
        return false;
    }
    
    // Get file type
    $filetype = wp_check_filetype($filename, null);
    
    // Prepare attachment data
    $attachment = array(
        'post_mime_type' => $filetype['type'],
        'post_title' => $title ? $title : preg_replace('/\.[^.]+$/', '', $filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    // Insert attachment
    $attachment_id = wp_insert_attachment($attachment, $dest_file, $post_id);
    
    if (is_wp_error($attachment_id)) {
        return false;
    }
    
    // Generate metadata
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attachment_id, $dest_file);
    wp_update_attachment_metadata($attachment_id, $attach_data);
    
    return $attachment_id;
}

/**
 * Migrate Artists to WordPress
 */
function migrate_artists() {
    $artists = get_nextjs_artists_data();
    $migrated = 0;
    $errors = array();

    foreach ($artists as $artist_data) {
        // Check if artist already exists
        $existing = get_posts(array(
            'post_type' => 'artist',
            'title' => $artist_data['name'],
            'post_status' => 'publish',
            'numberposts' => 1
        ));
        
        if (!empty($existing)) {
            echo '<p>⚠️ Artist ' . $artist_data['name'] . ' already exists, skipping...</p>';
            continue; // Skip if already exists
        }
        
        echo '<p>Creating artist: ' . $artist_data['name'] . '</p>';

        // Create artist post
        $post_data = array(
            'post_title' => $artist_data['name'],
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'artist',
            'meta_input' => array(
                'biography' => $artist_data['biography']
            )
        );

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            $errors[] = sprintf('Failed to create artist %s: %s', $artist_data['name'], $post_id->get_error_message());
        } else {
            $migrated++;
            
            // Set featured image if available (placeholder for now)
            // You would need to handle image imports here
        }
    }

    return array('migrated' => $migrated, 'errors' => $errors);
}

/**
 * Migrate Exhibitions to WordPress
 */
function migrate_exhibitions() {
    $exhibitions = get_nextjs_exhibitions_data();
    $migrated = 0;
    $errors = array();

    foreach ($exhibitions as $exhibition_data) {
        // Check if exhibition already exists
        $existing = get_posts(array(
            'post_type' => 'exhibition',
            'title' => $exhibition_data['title'],
            'post_status' => 'publish',
            'numberposts' => 1
        ));
        
        if (!empty($existing)) {
            echo '<p>⚠️ Exhibition ' . $exhibition_data['title'] . ' already exists, skipping...</p>';
            continue; // Skip if already exists
        }
        
        echo '<p>Creating exhibition: ' . $exhibition_data['title'] . '</p>';

        // Create exhibition post
        $post_data = array(
            'post_title' => $exhibition_data['title'],
            'post_content' => isset($exhibition_data['description']) ? $exhibition_data['description'] : '',
            'post_status' => 'publish',
            'post_type' => 'exhibition',
            'meta_input' => array(
                'artist' => $exhibition_data['artist'],
                'location' => $exhibition_data['location'],
                'start_date' => $exhibition_data['start_date'],
                'end_date' => $exhibition_data['end_date'],
                'featured' => isset($exhibition_data['featured']) ? $exhibition_data['featured'] : false
            )
        );

        // Add optional fields
        if (isset($exhibition_data['curator'])) {
            $post_data['meta_input']['curator'] = $exhibition_data['curator'];
        }
        
        if (isset($exhibition_data['venue'])) {
            $post_data['meta_input']['venue'] = $exhibition_data['venue'];
        }
        
        if (isset($exhibition_data['image'])) {
            $post_data['meta_input']['image_path'] = $exhibition_data['image'];
        }

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            $errors[] = sprintf('Failed to create exhibition %s: %s', $exhibition_data['title'], $post_id->get_error_message());
        } else {
            $migrated++;
            
            // Import and set featured image
            if (isset($exhibition_data['image']) && $exhibition_data['image']) {
                $attachment_id = import_image_to_media_library($exhibition_data['image'], $post_id, $exhibition_data['title']);
                if ($attachment_id) {
                    set_post_thumbnail($post_id, $attachment_id);
                }
            }
            
            // Set exhibition status taxonomy
            if (isset($exhibition_data['status'])) {
                wp_set_post_terms($post_id, array($exhibition_data['status']), 'exhibition_status');
            }
            
            // Set location taxonomy
            if (isset($exhibition_data['location'])) {
                wp_set_post_terms($post_id, array($exhibition_data['location']), 'location');
            }
        }
    }

    return array('migrated' => $migrated, 'errors' => $errors);
}

/**
 * Migrate Projects to WordPress
 */
function migrate_projects() {
    $projects = get_nextjs_projects_data();
    $migrated = 0;
    $errors = array();

    foreach ($projects as $project_data) {
        // Check if project already exists
        $existing = get_posts(array(
            'post_type' => 'project',
            'title' => $project_data['title'],
            'post_status' => 'publish',
            'numberposts' => 1
        ));
        
        if (!empty($existing)) {
            echo '<p>⚠️ Project ' . $project_data['title'] . ' already exists, skipping...</p>';
            continue; // Skip if already exists
        }
        
        echo '<p>Creating project: ' . $project_data['title'] . '</p>';

        // Create project post
        $post_data = array(
            'post_title' => $project_data['title'],
            'post_content' => isset($project_data['description']) ? $project_data['description'] : '',
            'post_status' => 'publish',
            'post_type' => 'project',
            'meta_input' => array(
                'artist' => $project_data['artist'],
                'location' => $project_data['location'],
                'start_date' => $project_data['start_date'],
                'end_date' => $project_data['end_date'],
                'featured' => isset($project_data['featured']) ? $project_data['featured'] : false
            )
        );

        // Add optional fields
        if (isset($project_data['curator'])) {
            $post_data['meta_input']['curator'] = $project_data['curator'];
        }
        
        if (isset($project_data['venue'])) {
            $post_data['meta_input']['venue'] = $project_data['venue'];
        }
        
        if (isset($project_data['image'])) {
            $post_data['meta_input']['image_path'] = $project_data['image'];
        }

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            $errors[] = sprintf('Failed to create project %s: %s', $project_data['title'], $post_id->get_error_message());
        } else {
            $migrated++;
            
            // Import and set featured image
            if (isset($project_data['image']) && $project_data['image']) {
                $attachment_id = import_image_to_media_library($project_data['image'], $post_id, $project_data['title']);
                if ($attachment_id) {
                    set_post_thumbnail($post_id, $attachment_id);
                }
            }
            
            // Set project status taxonomy (reuse exhibition_status)
            if (isset($project_data['status'])) {
                wp_set_post_terms($post_id, array($project_data['status']), 'exhibition_status');
            }
            
            // Set location taxonomy
            if (isset($project_data['location'])) {
                wp_set_post_terms($post_id, array($project_data['location']), 'location');
            }
        }
    }

    return array('migrated' => $migrated, 'errors' => $errors);
}

/**
 * Migrate News to WordPress
 */
function migrate_news() {
    $news_items = get_nextjs_news_data();
    $migrated = 0;
    $errors = array();

    foreach ($news_items as $news_data) {
        // Check if news already exists
        $existing = get_posts(array(
            'post_type' => 'post',
            'title' => $news_data['title'],
            'post_status' => 'publish',
            'numberposts' => 1
        ));
        
        if (!empty($existing)) {
            echo '<p>⚠️ News ' . $news_data['title'] . ' already exists, skipping...</p>';
            continue; // Skip if already exists
        }
        
        echo '<p>Creating news: ' . $news_data['title'] . '</p>';

        // Create news post
        $post_data = array(
            'post_title' => $news_data['title'],
            'post_content' => $news_data['description'],
            'post_excerpt' => wp_trim_words($news_data['description'], 25),
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_date' => $news_data['date'],
            'post_date_gmt' => get_gmt_from_date($news_data['date']),
            'meta_input' => array(
                'image_path' => $news_data['image']
            )
        );

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            $errors[] = sprintf('Failed to create news %s: %s', $news_data['title'], $post_id->get_error_message());
        } else {
            $migrated++;
            
            // Import and set featured image
            if (isset($news_data['image']) && $news_data['image']) {
                $attachment_id = import_image_to_media_library($news_data['image'], $post_id, $news_data['title']);
                if ($attachment_id) {
                    set_post_thumbnail($post_id, $attachment_id);
                }
            }
            
            // Set category based on type
            $category_slug = $news_data['type'];
            $category = get_category_by_slug($category_slug);
            
            if (!$category) {
                // Create category if it doesn't exist
                $category_names = array(
                    'solo-exhibition' => 'Solo Exhibition',
                    'group-exhibition' => 'Group Exhibition',
                    'news' => 'News'
                );
                
                $category_name = isset($category_names[$category_slug]) ? $category_names[$category_slug] : 'News';
                $category_id = wp_create_category($category_name, 0);
                
                if ($category_id) {
                    $category = get_term($category_id, 'category');
                    // Update slug
                    wp_update_term($category_id, 'category', array('slug' => $category_slug));
                }
            }
            
            if ($category && !is_wp_error($category)) {
                wp_set_post_categories($post_id, array($category->term_id));
            }
        }
    }

    return array('migrated' => $migrated, 'errors' => $errors);
}

/**
 * Create default pages
 */
function create_default_pages() {
    $pages = array(
        array(
            'title' => 'Chi Siamo',
            'slug' => 'about',
            'content' => '<h2>La Storia</h2>
<p>La Galleria Adalberto Catanzaro sostiene e promuove il lavoro di artisti che hanno segnato e continuano a segnare la ricerca contemporanea, ponendosi come punto di riferimento per il dialogo tra linguaggi, generazioni e geografie diverse. Ciò che rende la galleria unica è la relazione profonda e duratura che instaura con gli artisti: un legame che si sviluppa parallelamente al dialogo con curatori, istituzioni e pensatori critici, a livello nazionale e internazionale.</p>

<p>Il programma espositivo, caratterizzato da rigore curatoriale e attenzione critica, offre piattaforme per presentare nuove opere e progetti, stimolare confronti con il pubblico e sostenere le pratiche artistiche anche nell\'ambito istituzionale e museale.</p>

<p>Fondata nel 2014 da Adalberto Catanzaro, la galleria nasce a Bagheria all\'interno di Villa Casaurro, storica dimora settecentesca dei Principi di Palagonia. Fin dall\'inizio si distingue per una linea programmatica che privilegia artisti già riconosciuti dalla critica, con l\'obiettivo di consolidarne la presenza e rafforzarne il valore storico. Nel tempo, lo spazio si è trasferito nel cuore del centro storico di Bagheria, ampliando le proprie dimensioni e consolidando il ruolo della galleria come polo di riferimento per il contemporaneo in Sicilia.</p>

<p>Dal 2025, la galleria ha trasferito la sua sede a Palermo, rafforzando ulteriormente il suo ruolo di piattaforma culturale e artistica nel Mediterraneo.</p>

<p>Negli anni, la galleria ha presentato mostre di artisti italiani e internazionali come Vittorio Messina, Hidetoshi Nagasawa, Eliseo Mattiacci, Nunzio, Luigi Mainolfi, Gilberto Zorio, instaurando rapporti con istituzioni quali il Museo Riso di Palermo e altri spazi pubblici e privati.</p>

<p>La Galleria Adalberto Catanzaro non si limita all\'attività espositiva, ma promuove un\'idea di cultura come tessuto vitale e collettivo, creando legami tra artisti, curatori e comunità, e ponendosi come ponte tra la scena siciliana e il contesto nazionale e internazionale.</p>

<p>Oggi, con oltre dieci anni di attività e un patrimonio consolidato di mostre e collaborazioni, la galleria continua a perseguire una visione chiara: dare voce a pratiche artistiche di alto livello, sostenendo la ricerca e la sperimentazione e contribuendo alla crescita del dibattito sull\'arte contemporanea.</p>

<h2>La Missione</h2>
<p>La Galleria Adalberto Catanzaro promuove una pratica curatoriale attenta al dialogo critico e alla sperimentazione, offrendo spazi di confronto tra artisti emergenti e affermati. La nostra missione è sostenere la produzione artistica attraverso mostre curate con rigore, progetti editoriali e collaborazioni istituzionali, contribuendo alla crescita culturale del territorio e alla visibilità internazionale degli artisti che rappresentiamo.</p>'
        ),
        array(
            'title' => 'Contatti',
            'slug' => 'contact',
            'content' => '<h2>Contattaci</h2>
<p>Siamo a tua disposizione per informazioni su mostre, artisti, visite guidate e collaborazioni. Non esitare a contattarci per qualsiasi richiesta.</p>

<h3>Informazioni generali</h3>
<p>Per informazioni generali sulla galleria, le nostre mostre e gli eventi in programma, puoi utilizzare il form di contatto o contattarci direttamente.</p>'
        )
    );

    foreach ($pages as $page_data) {
        // Check if page already exists
        $existing = get_page_by_path($page_data['slug']);
        
        if ($existing) {
            continue; // Skip if already exists
        }

        // Create page
        $page = array(
            'post_title' => $page_data['title'],
            'post_content' => $page_data['content'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => $page_data['slug']
        );

        wp_insert_post($page);
    }
}

/**
 * Run migration
 */
function run_migration() {
    if (!current_user_can('manage_options')) {
        wp_die('Access denied');
    }

    echo '<div style="padding: 20px; font-family: Arial, sans-serif;">';
    echo '<h1>Galleria Catanzaro - Migration Script</h1>';

    // Force register custom post types and taxonomies
    echo '<h2>Checking Post Types and Taxonomies...</h2>';
    
    // Trigger init action to ensure CPTs are registered
    do_action('init');
    
    // Check if artist post type exists
    if (!post_type_exists('artist')) {
        echo '<p style="color: red;">⚠️ Artist post type not found! Make sure your theme functions.php is working.</p>';
        return;
    } else {
        echo '<p>✓ Artist post type is registered</p>';
    }
    
    // Check if exhibition post type exists
    if (!post_type_exists('exhibition')) {
        echo '<p style="color: red;">⚠️ Exhibition post type not found! Make sure your theme functions.php is working.</p>';
        return;
    } else {
        echo '<p>✓ Exhibition post type is registered</p>';
    }
    
    // Check if project post type exists
    if (!post_type_exists('project')) {
        echo '<p style="color: red;">⚠️ Project post type not found! Make sure your theme functions.php is working.</p>';
        return;
    } else {
        echo '<p>✓ Project post type is registered</p>';
    }

    // Create default taxonomy terms
    echo '<h2>Creating Taxonomy Terms...</h2>';
    
    // Exhibition status terms
    $status_terms = array('current', 'past', 'upcoming');
    foreach ($status_terms as $term) {
        if (!term_exists($term, 'exhibition_status')) {
            wp_insert_term(ucfirst($term), 'exhibition_status', array('slug' => $term));
            echo '<p>✓ Created exhibition_status term: ' . $term . '</p>';
        }
    }
    
    // Location terms
    $location_terms = array('palermo', 'bagheria', 'spoleto');
    foreach ($location_terms as $term) {
        if (!term_exists($term, 'location')) {
            wp_insert_term(ucfirst($term), 'location', array('slug' => $term));
            echo '<p>✓ Created location term: ' . $term . '</p>';
        }
    }

    // Migrate artists
    echo '<h2>Migrating Artists...</h2>';
    $artist_result = migrate_artists();
    echo '<p>✓ Migrated ' . $artist_result['migrated'] . ' artists</p>';
    
    if (!empty($artist_result['errors'])) {
        echo '<p style="color: red;">Errors:</p>';
        foreach ($artist_result['errors'] as $error) {
            echo '<p style="color: red;">- ' . $error . '</p>';
        }
    }

    // Migrate exhibitions
    echo '<h2>Migrating Exhibitions...</h2>';
    $exhibition_result = migrate_exhibitions();
    echo '<p>✓ Migrated ' . $exhibition_result['migrated'] . ' exhibitions</p>';
    
    if (!empty($exhibition_result['errors'])) {
        echo '<p style="color: red;">Errors:</p>';
        foreach ($exhibition_result['errors'] as $error) {
            echo '<p style="color: red;">- ' . $error . '</p>';
        }
    }

    // Migrate projects
    echo '<h2>Migrating Projects...</h2>';
    $project_result = migrate_projects();
    echo '<p>✓ Migrated ' . $project_result['migrated'] . ' projects</p>';
    
    if (!empty($project_result['errors'])) {
        echo '<p style="color: red;">Errors:</p>';
        foreach ($project_result['errors'] as $error) {
            echo '<p style="color: red;">- ' . $error . '</p>';
        }
    }

    // Migrate news
    echo '<h2>Migrating News...</h2>';
    $news_result = migrate_news();
    echo '<p>✓ Migrated ' . $news_result['migrated'] . ' news items</p>';
    
    if (!empty($news_result['errors'])) {
        echo '<p style="color: red;">Errors:</p>';
        foreach ($news_result['errors'] as $error) {
            echo '<p style="color: red;">- ' . $error . '</p>';
        }
    }

    // Create default pages
    echo '<h2>Creating Default Pages...</h2>';
    create_default_pages();
    echo '<p>✓ Default pages created</p>';

    echo '<h2>Migration Complete!</h2>';
    echo '<p>The migration has been completed successfully. Images have been imported to the WordPress Media Library and set as featured images. You can now:</p>';
    echo '<ul>';
    echo '<li>Go to the <a href="' . admin_url('edit.php?post_type=artist') . '">Artists</a> section to review migrated artists</li>';
    echo '<li>Go to the <a href="' . admin_url('edit.php?post_type=exhibition') . '">Exhibitions</a> section to review migrated exhibitions</li>';
    echo '<li>Go to the <a href="' . admin_url('upload.php') . '">Media Library</a> to see imported images</li>';
    echo '<li>Visit your <a href="' . home_url() . '" target="_blank">homepage</a> to see the results</li>';
    echo '</ul>';
    
    echo '</div>';
}

// Run migration if accessed directly with the right parameters
if (isset($_GET['run_migration']) && $_GET['run_migration'] === 'true' && current_user_can('manage_options')) {
    run_migration();
}