<?php
/**
 * Single Artist Template
 *
 * Template for displaying individual artist pages.
 *
 * @package    Galleria_Catanzaro
 * @version    1.0.0
 */

declare(strict_types=1);

// Security: Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

get_header(); ?>

<main id="main_content" class="main-content">
    <?php while (have_posts()) : the_post(); 
        $biography = get_field('biography');
        $birth_year = get_field('birth_year');
        $nationality = get_field('nationality');
        $website = get_field('website');
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('artist-single'); ?>>
            <!-- Artist Hero Section -->
            <section class="artist-hero py-16">
                <div class="container">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                        <!-- Artist Image -->
                        <div class="artist-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array(
                                    'alt' => get_the_title(),
                                    'class' => 'w-full h-auto object-cover'
                                )); ?>
                            <?php else : ?>
                                <div class="placeholder-image aspect-square bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-400 text-lg"><?php _e('No image available', 'galleria'); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Artist Info -->
                        <div class="artist-info space-y-6">
                            <div>
                                <h1 class="text-4xl font-light mb-4"><?php the_title(); ?></h1>
                                
                                <?php if ($birth_year || $nationality) : ?>
                                    <div class="artist-details text-lg text-gray-600 space-y-2">
                                        <?php if ($birth_year) : ?>
                                            <p><?php echo sprintf(__('Born in %s', 'galleria'), esc_html($birth_year)); ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if ($nationality) : ?>
                                            <p><?php echo esc_html($nationality); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($biography) : ?>
                                <div class="artist-biography">
                                    <div class="prose prose-lg">
                                        <?php echo wpautop($biography); ?>
                                    </div>
                                </div>
                            <?php elseif (get_the_content()) : ?>
                                <div class="artist-content">
                                    <div class="prose prose-lg">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($website) : ?>
                                <div class="artist-website">
                                    <a href="<?php echo esc_url($website); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="inline-flex items-center space-x-2 text-sm font-light hover:underline">
                                        <span><?php _e('Visit artist website', 'galleria'); ?></span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Artist Exhibitions -->
            <section class="artist-exhibitions py-16 bg-gray-50">
                <div class="container">
                    <h2 class="text-2xl font-light mb-8"><?php _e('Exhibitions', 'galleria'); ?></h2>
                    
                    <?php
                    // Get exhibitions featuring this artist
                    $exhibitions = new WP_Query(array(
                        'post_type' => 'exhibition',
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            array(
                                'key' => 'artist',
                                'value' => get_the_title(),
                                'compare' => 'LIKE'
                            )
                        ),
                        'orderby' => 'meta_value',
                        'meta_key' => 'start_date',
                        'order' => 'DESC'
                    ));
                    
                    if ($exhibitions->have_posts()) :
                    ?>
                        <div class="exhibitions-timeline">
                            <?php while ($exhibitions->have_posts()) : $exhibitions->the_post(); 
                                $start_date = get_field('start_date');
                                $end_date = get_field('end_date');
                                $curator = get_field('curator');
                                $venue = get_field('venue');
                                $location = get_field('location');
                                $status_terms = get_the_terms(get_the_ID(), 'exhibition_status');
                                $status = $status_terms && !is_wp_error($status_terms) ? $status_terms[0]->slug : '';
                            ?>
                                <div class="exhibition-item <?php echo esc_attr($status); ?>">
                                    <div class="exhibition-content grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                                        <!-- Date -->
                                        <div class="exhibition-date">
                                            <?php if ($start_date && $end_date) : ?>
                                                <span class="date-range">
                                                    <?php 
                                                    echo date_i18n('Y', strtotime($start_date));
                                                    if (date_i18n('Y', strtotime($start_date)) !== date_i18n('Y', strtotime($end_date))) {
                                                        echo '–' . date_i18n('Y', strtotime($end_date));
                                                    }
                                                    ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Exhibition Details -->
                                        <div class="exhibition-details md:col-span-2">
                                            <h3 class="exhibition-title font-medium">
                                                <a href="<?php the_permalink(); ?>" class="hover:underline">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                            
                                            <?php if ($curator) : ?>
                                                <p class="curator text-sm text-gray-600 italic">
                                                    <?php echo sprintf(__('Curated by %s', 'galleria'), esc_html($curator)); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <?php if ($venue) : ?>
                                                <p class="venue text-sm text-gray-600">
                                                    <?php echo esc_html($venue); ?>
                                                    <?php if ($location) : ?>
                                                        <span class="location">, <?php echo esc_html(ucfirst($location)); ?></span>
                                                    <?php endif; ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <?php if ($start_date && $end_date && (date_i18n('d.m', strtotime($start_date)) !== date_i18n('d.m', strtotime($end_date)))) : ?>
                                                <p class="full-dates text-xs text-gray-500">
                                                    <?php 
                                                    echo date_i18n('d.m.Y', strtotime($start_date)) . ' – ' . 
                                                         date_i18n('d.m.Y', strtotime($end_date));
                                                    ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    <?php else : ?>
                        <p class="text-gray-600"><?php _e('No exhibitions found for this artist.', 'galleria'); ?></p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Navigation -->
            <section class="artist-navigation py-8 border-t">
                <div class="container">
                    <div class="flex justify-between items-center">
                        <?php
                        $prev_post = get_previous_post(false, '', 'artist');
                        $next_post = get_next_post(false, '', 'artist');
                        ?>
                        
                        <div class="nav-previous">
                            <?php if ($prev_post) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" 
                                   class="inline-flex items-center space-x-2 text-sm font-light hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    <span><?php echo esc_html($prev_post->post_title); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="nav-back">
                            <a href="<?php echo get_post_type_archive_link('artist'); ?>" 
                               class="text-sm font-light hover:underline">
                                <?php _e('All Artists', 'galleria'); ?>
                            </a>
                        </div>
                        
                        <div class="nav-next">
                            <?php if ($next_post) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" 
                                   class="inline-flex items-center space-x-2 text-sm font-light hover:underline">
                                    <span><?php echo esc_html($next_post->post_title); ?></span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer();