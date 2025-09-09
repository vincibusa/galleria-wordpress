<?php
/**
 * Template for displaying exhibition archive
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <div class="container py-16">
        <header class="archive-header mb-8">
            <h1 class="text-2xl font-light"><?php _e('Exhibitions', 'galleria'); ?></h1>
            
            <!-- filters removed -->
        </header>

        <?php
        // Custom query: show ALL exhibitions ordered chronologically by ACF start_date.
        // Assumption: ACF `start_date` is stored in `YYYY-MM-DD` or `YYYYMMDD` format so string ordering works.
        $args = array(
            'post_type' => 'exhibition',
            'posts_per_page' => -1,
            'meta_key' => 'start_date',
            // order by start_date descending so newest exhibitions appear first;
            // keep post date DESC as secondary fallback
            'orderby' => array( 'meta_value' => 'DESC', 'date' => 'DESC' ),
        );

        $exhibitions = new WP_Query($args);

        if ($exhibitions->have_posts()) : ?>
            <div class="exhibitions-grid grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while ($exhibitions->have_posts()) : $exhibitions->the_post(); 
                    $artist = get_field('artist');
                    $curator = get_field('curator');
                    $venue = get_field('venue');
                    $location = get_field('location');
                    $start_date = get_field('start_date');
                    $end_date = get_field('end_date');
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('exhibition-card border-b border-gray-100 pb-8 last:border-b-0'); ?>>
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
                            
                            <?php if ($artist) : ?>
                                <h2 class="text-2xl font-light text-gray-900 uppercase tracking-wide">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo esc_html($artist); ?>
                                    </a>
                                </h2>
                            <?php endif; ?>
                            
                            <?php if (get_the_title()) : ?>
                                <h3 class="text-xl font-light italic text-gray-800">
                                    <a href="<?php the_permalink(); ?>">
                                        &ldquo;<?php the_title(); ?>&rdquo;
                                    </a>
                                </h3>
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
                <h2><?php _e('Nessuna mostra trovata', 'galleria'); ?></h2>
                <p><?php _e('Non ci sono mostre da visualizzare al momento.', 'galleria'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
/* Tailwind-like utilities for consistent styling */
.text-gray-600 {
    color: #4b5563;
}

.text-gray-700 {
    color: #374151;
}

.text-gray-800 {
    color: #1f2937;
}

.text-gray-900 {
    color: #111827;
}

.bg-gray-100 {
    background-color: #f3f4f6;
}

.border-gray-100 {
    border-color: #f3f4f6;
}

.border-b {
    border-bottom-width: 1px;
}

.pb-8 {
    padding-bottom: 2rem;
}

.mt-4 {
    margin-top: 1rem;
}

.space-y-2 > * + * {
    margin-top: 0.5rem;
}

.text-center {
    text-align: center;
}

.text-sm {
    font-size: 0.875rem;
}

.text-xl {
    font-size: 1.25rem;
}

.text-2xl {
    font-size: 1.5rem;
}

.font-light {
    font-weight: 300;
}

.font-medium {
    font-weight: 500;
}

.uppercase {
    text-transform: uppercase;
}

.italic {
    font-style: italic;
}

.tracking-wide {
    letter-spacing: 0.025em;
}

.aspect-video {
    aspect-ratio: 16 / 9;
}

.relative {
    position: relative;
}

.overflow-hidden {
    overflow: hidden;
}

.object-cover {
    object-fit: cover;
}

.w-full {
    width: 100%;
}

.h-full {
    height: 100%;
}

/* Remove last border */
.exhibition-card:last-child {
    border-bottom: none;
}

/* Responsive text alignment */
@media (min-width: 768px) {
    .md\:text-left {
        text-align: left;
    }
}
</style>

<?php get_footer(); ?>