<?php
/**
 * Template for About Page
 */

get_header(); ?>

<main id="main_content" class="main-content" role="main" aria-label="<?php _e('About page content', 'galleria'); ?>">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('about-page'); ?>>
            <!-- About Hero Section -->


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
                            <?php
                            // Get the image ID from post meta (set by migration script)
                            $image_id = get_post_meta(get_the_ID(), 'about_sidebar_image', true);

                            if ($image_id) :
                            ?>
                                <div class="sidebar-image" style="margin-bottom: 2rem;">
                                    <?php 
                                    // Display the image using the ID
                                    echo wp_get_attachment_image($image_id, 'large', false, array('style' => 'width: 100%; height: auto; border-radius: 4px;')); 
                                    ?>
                                </div>
                            <?php endif; ?>

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

            

        </article>
    <?php endwhile; ?>
</main>


<?php get_footer(); ?>