<?php
/**
 * Template for About Page
 */

get_header(); ?>

<main id="main_content" class="main-content" role="main" aria-label="<?php _e('About page content', 'galleria'); ?>">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('about-page'); ?>>
            <!-- About Hero Section -->
            <section class="about-hero" role="banner" aria-labelledby="about-title">
                <div class="container">
                    <div class="hero-container">
                        <h1 id="about-title"><?php the_title(); ?></h1>
                        <?php if (has_excerpt()) : ?>
                            <div class="hero-subtitle">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- About Content -->
            <section class="about-content" role="region" aria-labelledby="about-content-title">
                <div class="container">
                    <div class="content-grid">
                        <div class="main-content">
                            <div class="prose">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <aside class="sidebar-content" role="complementary">
                            <!-- Space for additional content like quick facts, contact info, etc. -->
                            <?php if (function_exists('get_field')) : 
                                $gallery_founded = get_field('gallery_founded');
                                $gallery_focus = get_field('gallery_focus');
                                $gallery_location = get_field('gallery_location');
                                
                                if ($gallery_founded || $gallery_focus || $gallery_location) :
                            ?>
                                <div class="about-facts">
                                    <h3><?php _e('In Brief', 'galleria'); ?></h3>
                                    <?php if ($gallery_founded) : ?>
                                        <div class="fact-item">
                                            <strong><?php _e('Founded:', 'galleria'); ?></strong>
                                            <span><?php echo esc_html($gallery_founded); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($gallery_focus) : ?>
                                        <div class="fact-item">
                                            <strong><?php _e('Focus:', 'galleria'); ?></strong>
                                            <span><?php echo esc_html($gallery_focus); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($gallery_location) : ?>
                                        <div class="fact-item">
                                            <strong><?php _e('Location:', 'galleria'); ?></strong>
                                            <span><?php echo esc_html($gallery_location); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; endif; ?>
                        </aside>
                    </div>
                </div>
            </section>
            <!-- Featured Artists/Exhibitions Section -->
            <section class="about-featured" role="region" aria-labelledby="exhibitions-title">
                <div class="container">
                    <h2 id="exhibitions-title"><?php _e('Recent Exhibitions', 'galleria'); ?></h2>
                    
                    <?php
                    $recent_exhibitions = new WP_Query(array(
                        'post_type' => 'exhibition',
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));
                    
                    if ($recent_exhibitions->have_posts()) :
                    ?>
                        <div class="exhibitions-grid">
                            <?php while ($recent_exhibitions->have_posts()) : $recent_exhibitions->the_post(); ?>
                                <article class="exhibition-preview" role="article" aria-labelledby="exhibition-title-<?php the_ID(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="preview-image">
                                            <a href="<?php the_permalink(); ?>" aria-label="<?php printf(__('View exhibition: %s', 'galleria'), get_the_title()); ?>">
                                                <?php the_post_thumbnail('gallery-card', array(
                                                    'alt' => get_the_title(),
                                                    'loading' => 'lazy'
                                                )); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="preview-content">
                                        <h3 id="exhibition-title-<?php the_ID(); ?>">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <?php 
                                        $artist = get_field('artist');
                                        $exhibition_start = get_field('exhibition_start_date');
                                        $exhibition_end = get_field('exhibition_end_date');
                                        
                                        if ($artist) :
                                        ?>
                                            <div class="exhibition-artist"><?php echo esc_html($artist); ?></div>
                                        <?php endif; ?>
                                        
                                        <?php if ($exhibition_start || $exhibition_end) : ?>
                                            <div class="exhibition-meta">
                                                <?php 
                                                if ($exhibition_start && $exhibition_end) {
                                                    echo date('d M', strtotime($exhibition_start)) . ' - ' . date('d M Y', strtotime($exhibition_end));
                                                } elseif ($exhibition_start) {
                                                    echo __('From ', 'galleria') . date('d M Y', strtotime($exhibition_start));
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                        
                        <div class="exhibitions-cta">
                            <a href="<?php echo get_post_type_archive_link('exhibition'); ?>" class="btn btn-secondary">
                                <?php _e('View All Exhibitions', 'galleria'); ?>
                            </a>
                        </div>
                    <?php else : ?>
                        <p class="no-exhibitions-message">
                            <?php _e('No recent exhibitions to display.', 'galleria'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </section>
            

        </article>
    <?php endwhile; ?>
</main>


<?php get_footer(); ?>