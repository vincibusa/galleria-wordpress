<?php
/**
 * Template for displaying project archive
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <div class="container py-16">
        <header class="archive-header">
            <h1><?php _e('Projects', 'galleria'); ?></h1>
            <p class="archive-description"><?php _e('Discover our artistic projects and cultural initiatives', 'galleria'); ?></p>
        </header>

        <?php
        // Simplified query: show ALL projects without meta field requirements
        $args = array(
            'post_type' => 'project',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $projects = new WP_Query($args);

        if ($projects->have_posts()) : ?>
            <div class="projects-grid grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while ($projects->have_posts()) : $projects->the_post(); 
                    // Use get_post_meta instead of get_field for better compatibility
                    $artist = get_post_meta(get_the_ID(), 'artist', true);
                    $curator = get_post_meta(get_the_ID(), 'curator', true);
                    $venue = get_post_meta(get_the_ID(), 'venue', true);
                    $location = get_post_meta(get_the_ID(), 'location', true);
                    $start_date = get_post_meta(get_the_ID(), 'start_date', true);
                    $end_date = get_post_meta(get_the_ID(), 'end_date', true);
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('project-card border-b border-gray-100 pb-8 last:border-b-0'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="relative aspect-video overflow-hidden bg-gray-100">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('full', array(
                                        'alt' => get_the_title(),
                                        'class' => 'object-cover w-full h-full',
                                        'loading' => 'lazy'
                                    )); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-4 space-y-2 text-center md:text-left">
                            <?php if ($start_date && $end_date) : ?>
                                <p class="text-sm font-light text-gray-600 uppercase tracking-wide">
                                    <?php 
                                    // Format dates to show month names like in Next.js
                                    $start = new DateTime($start_date);
                                    $end = new DateTime($end_date);
                                    $start_month = $start->format('F');
                                    $end_month = $end->format('F');
                                    $start_year = $start->format('Y');
                                    $end_year = $end->format('Y');
                                    
                                    if ($start_year === $end_year) {
                                        if ($start_month === $end_month) {
                                            echo ucfirst($start_month) . ' ' . $start_year;
                                        } else {
                                            echo ucfirst($start_month) . '/' . ucfirst($end_month) . ' ' . $end_year;
                                        }
                                    } else {
                                        echo ucfirst($start_month) . ' ' . $start_year . ' / ' . ucfirst($end_month) . ' ' . $end_year;
                                    }
                                    ?>
                                </p>
                            <?php endif; ?>
                            
                            <h2 class="text-xl font-medium text-gray-900">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <?php if ($artist) : ?>
                                <p class="text-lg font-light text-gray-700 uppercase tracking-wide">
                                    <a href="<?php the_permalink(); ?>"><?php echo esc_html($artist); ?></a>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($curator) : ?>
                                <p class="text-sm text-gray-600">
                                    a cura di <?php echo esc_html($curator); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (has_excerpt()) : ?>
                                <p class="text-sm text-gray-600">
                                    <?php the_excerpt(); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($venue && $venue !== get_the_title()) : ?>
                                <p class="text-sm font-medium text-gray-700">
                                    <?php echo esc_html($venue); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // Reset postdata from custom query
            wp_reset_postdata();
            ?>

        <?php else : ?>
            <div class="no-posts py-16 text-center">
                <h2><?php _e('Nessun progetto trovato', 'galleria'); ?></h2>
                <p><?php _e('Non ci sono progetti da visualizzare al momento.', 'galleria'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>


<?php get_footer(); ?>