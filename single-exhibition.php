<?php
/**
 * Single Exhibition Template
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <?php while (have_posts()) : the_post(); 
        $artist = get_field('artist');
        $curator = get_field('curator');
        $venue = get_field('venue');
        $location = get_field('location');
        $start_date = get_field('start_date');
        $end_date = get_field('end_date');
        $featured = get_field('featured');
        
    // ...existing code... (status removed)
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('exhibition-single'); ?>>
            <!-- Exhibition Hero Section -->
            <section class="exhibition-hero">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="hero-image relative">
                        <?php the_post_thumbnail('full', array(
                            'alt' => esc_attr(sprintf(__('Exhibition hero image: %s', 'galleria'), get_the_title())),
                            'class' => 'w-full h-full object-cover'
                        )); ?>
                        
                        <!-- status badge removed -->
                        
                        <!-- Hero Content Overlay -->
                        <div class="hero-content">
                            <div class="container">
                                <div class="hero-info max-w-3xl">
                                    <div class="hero-meta">
                                        <?php if ($location) : ?>
                                            <span class="location"><?php echo esc_html(ucfirst($location)); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($start_date && $end_date) : ?>
                                            <span class="dates">
                                                <?php 
                                                echo date_i18n('d.m.Y', strtotime($start_date)) . ' - ' . 
                                                     date_i18n('d.m.Y', strtotime($end_date));
                                                ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h1 class="hero-title"><?php the_title(); ?></h1>
                                    
                                    <?php if ($artist) : ?>
                                        <p class="hero-artist"><?php echo esc_html($artist); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($curator) : ?>
                                        <p class="hero-curator">
                                            <?php echo sprintf(__('Curated by %s', 'galleria'), esc_html($curator)); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- No image fallback -->
                    <div class="hero-no-image py-16 bg-gray-100">
                        <div class="container">
                            <div class="hero-info max-w-3xl">
                                <!-- status badge removed -->
                                
                                <div class="hero-meta text-gray-600">
                                    <?php if ($location) : ?>
                                        <span class="location"><?php echo esc_html(ucfirst($location)); ?></span>
                                    <?php endif; ?>
                                    
                                    <?php if ($start_date && $end_date) : ?>
                                        <span class="dates">
                                            <?php 
                                            echo date_i18n('d.m.Y', strtotime($start_date)) . ' - ' . 
                                                 date_i18n('d.m.Y', strtotime($end_date));
                                            ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h1 class="hero-title text-gray-900"><?php the_title(); ?></h1>
                                
                                <?php if ($artist) : ?>
                                    <p class="hero-artist text-gray-700"><?php echo esc_html($artist); ?></p>
                                <?php endif; ?>
                                
                                <?php if ($curator) : ?>
                                    <p class="hero-curator text-gray-600">
                                        <?php echo sprintf(__('Curated by %s', 'galleria'), esc_html($curator)); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Exhibition Details -->
            <section class="exhibition-details py-16">
                <div class="container">
                    <div class="grid grid-cols-1 gap-12">
                        <!-- Main Content -->
                        <div class="exhibition-content">
                            <?php if (get_the_content()) : ?>
                                <div class="prose prose-lg">
                                    <?php the_content(); ?>
                                </div>
                            <?php elseif (has_excerpt()) : ?>
                                <div class="prose prose-lg">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Sidebar Info (moved below description, left-aligned) -->
                        <div class="exhibition-sidebar">
                            <div class="sidebar-content space-y-8">
                                <!-- Exhibition Info -->
                                <div class="info-section">
                                    <h3 class="info-title"><?php _e('Exhibition Details', 'galleria'); ?></h3>
                                    <div class="info-content space-y-3">
                                        <?php if ($artist) : ?>
                                            <div class="info-item">
                                                <strong><?php _e('Artist:', 'galleria'); ?></strong>
                                                <span><?php echo esc_html($artist); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($curator) : ?>
                                            <div class="info-item">
                                                <strong><?php _e('Curator:', 'galleria'); ?></strong>
                                                <span><?php echo esc_html($curator); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($venue) : ?>
                                            <div class="info-item">
                                                <strong><?php _e('Venue:', 'galleria'); ?></strong>
                                                <span><?php echo esc_html($venue); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($location) : ?>
                                            <div class="info-item">
                                                <strong><?php _e('Location:', 'galleria'); ?></strong>
                                                <span><?php echo esc_html(ucfirst($location)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($start_date && $end_date) : ?>
                                            <div class="info-item">
                                                <strong><?php _e('Period:', 'galleria'); ?></strong>
                                                <span>
                                                    <?php 
                                                    echo date_i18n('j F Y', strtotime($start_date)) . ' – ' . 
                                                         date_i18n('j F Y', strtotime($end_date));
                                                    ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- status info removed -->
                                    </div>
                                </div>
                                
                                <!-- Gallery Info -->
                                <div class="info-section">
                                    <h3 class="info-title"><?php _e('Gallery Information', 'galleria'); ?></h3>
                                    <div class="info-content space-y-3">
                                        <div class="contact-info">
                                            <p class="font-medium"><?php echo esc_html(get_theme_mod('galleria_name', 'Galleria Adalberto Catanzaro')); ?></p>
                                            
                                            <?php if ($location === 'palermo' || !$location) : ?>
                                                <div class="address">
                                                    <p><?php echo esc_html(get_theme_mod('galleria_address_1', 'Via Montevergini 3')); ?></p>
                                                    <p><?php echo esc_html(get_theme_mod('galleria_city', 'Palermo')); ?></p>
                                                </div>
                                            <?php elseif ($location === 'bagheria') : ?>
                                                <div class="address">
                                                    <p><?php echo esc_html(get_theme_mod('galleria_address_2', 'Corso Vittorio Emanuele 383')); ?></p>
                                                    <p><?php echo esc_html(get_theme_mod('galleria_city', 'Palermo')); ?></p>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="contact-details">
                                                <p>
                                                    <strong><?php _e('Phone:', 'galleria'); ?></strong>
                                                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('galleria_phone', '+393271677871'))); ?>">
                                                        <?php echo esc_html(get_theme_mod('galleria_phone', '+39 327 167 7871')); ?>
                                                    </a>
                                                </p>
                                                
                                                <p>
                                                    <strong><?php _e('Email:', 'galleria'); ?></strong>
                                                    <a href="mailto:<?php echo esc_attr(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>">
                                                        <?php echo esc_html(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>
                                                    </a>
                                                </p>
                                                
                                                <p>
                                                    <strong><?php _e('Hours:', 'galleria'); ?></strong>
                                                    <?php echo esc_html(get_theme_mod('galleria_hours', 'Martedì–Sabato: 10:00–18:00')); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Navigation -->
            <nav class="exhibition-navigation py-8 border-t bg-gray-50" aria-label="<?php _e('Exhibition Navigation', 'galleria'); ?>">
                <div class="container">
                    <div class="flex justify-between items-center">
                        <?php
                        $prev_post = get_previous_post(false, '', 'exhibition');
                        $next_post = get_next_post(false, '', 'exhibition');
                        ?>
                        
                        <div class="nav-previous">
                            <?php if ($prev_post) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" 
                                   class="inline-flex items-center space-x-2 text-sm font-light hover:underline"
                                   aria-label="<?php echo esc_attr(sprintf(__('Previous exhibition: %s', 'galleria'), $prev_post->post_title)); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    <span><?php echo esc_html($prev_post->post_title); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="nav-back">
                            <a href="<?php echo get_post_type_archive_link('exhibition'); ?>" 
                               class="text-sm font-light hover:underline"
                               aria-label="<?php _e('Return to all exhibitions', 'galleria'); ?>">
                                <?php _e('All Exhibitions', 'galleria'); ?>
                            </a>
                        </div>
                        
                        <div class="nav-next">
                            <?php if ($next_post) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" 
                                   class="inline-flex items-center space-x-2 text-sm font-light hover:underline"
                                   aria-label="<?php echo esc_attr(sprintf(__('Next exhibition: %s', 'galleria'), $next_post->post_title)); ?>">
                                    <span><?php echo esc_html($next_post->post_title); ?></span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </nav>
        </article>
    <?php endwhile; ?>
</main>


<?php get_footer(); ?>