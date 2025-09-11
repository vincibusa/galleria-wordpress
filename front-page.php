<?php
/**
 * Homepage Template
 * Replica della homepage del sito Next.js originale
 */

get_header(); ?>

<main id="main_content" class="main-content" role="main" aria-label="<?php _e('Contenuto principale', 'galleria'); ?>">
    <!-- Hero Section -->
    <section class="hero-section" role="banner" aria-label="<?php _e('Sezione hero', 'galleria'); ?>">
        <?php
        $hero_image = get_theme_mod('galleria_hero_image');
        $hero_title = get_theme_mod('galleria_hero_title', get_bloginfo('name'));
        $hero_subtitle = get_theme_mod('galleria_hero_subtitle', get_bloginfo('description'));
        
        if ($hero_image) :
        ?>
            <div class="hero-container">
                <img src="<?php echo esc_url($hero_image); ?>" 
                     alt="<?php echo esc_attr($hero_title); ?>"
                     class="hero-image">
                
                <?php if ($hero_title || $hero_subtitle) : ?>
                    <div class="hero-content">
                        <?php if ($hero_title) : ?>
                            <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
                        <?php endif; ?>
                        
                        <?php if ($hero_subtitle) : ?>
                            <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    <div class="container py-16 space-y-20">
        <!-- News & Events Section -->
        <section class="news-events" role="region" aria-labelledby="news-events-title">
            <h2 id="news-events-title" class="text-2xl font-light mb-8"><?php _e('News & Events', 'galleria'); ?></h2>
            
            <?php
            $news_posts = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($news_posts->have_posts()) :
            ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while ($news_posts->have_posts()) : $news_posts->the_post(); ?>
                        <?php get_template_part('template-parts/content', 'card'); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
                
                <?php if ($news_posts->found_posts > 6) : ?>
                    <div class="text-center mt-8">
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
                           class="text-sm font-light hover:underline">
                            <?php _e('Vedi di più', 'galleria'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>

        <!-- Publications Section (commented out for now like in original) -->
        <!-- 
        <section class="publications">
            <h2 class="text-2xl font-light mb-8"><?php _e('Publications', 'galleria'); ?></h2>
            
            <?php
            $publications = new WP_Query(array(
                'post_type' => 'publication',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($publications->have_posts()) :
            ?>
                <div class="grid grid-cols-1 md-grid-cols-2 lg-grid-cols-3">
                    <?php while ($publications->have_posts()) : $publications->the_post(); 
                        $buy_link = get_field('buy_link');
                    ?>
                        <article class="card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-image">
                                    <?php the_post_thumbnail('gallery-card', array('alt' => get_the_title())); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-content">
                                <div class="space-y-4">
                                    <div>
                                        <span class="card-meta"><?php _e('Publications', 'galleria'); ?></span>
                                        <h3 class="card-title"><strong><?php the_title(); ?></strong></h3>
                                        
                                        <?php if (get_the_excerpt()) : ?>
                                            <div class="card-description">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($buy_link) : ?>
                                        <a href="<?php echo esc_url($buy_link); ?>" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="inline-block text-sm font-light hover:underline">
                                            <?php _e('Buy now', 'galleria'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>
        </section>
        -->
    </div>
</main>



<?php
get_footer();