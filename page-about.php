<?php
/**
 * Template for About Page
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('about-page'); ?>>
            <!-- About Hero Section -->
            <section class="about-hero py-16">
                <div class="container">
                    <div class="max-w-4xl mx-auto text-center">
                        <h1 class="text-4xl font-light mb-6"><?php the_title(); ?></h1>
                        <?php if (has_excerpt()) : ?>
                            <div class="text-xl text-gray-600 font-light">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- About Content -->
            <section class="about-content py-16 bg-gray-50">
                <div class="container">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <!-- Main Content -->
                        <div class="lg:col-span-2">
                            <div class="prose prose-lg">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <!-- Sidebar with Gallery Info -->
                        <div class="about-sidebar">
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <h3 class="text-xl font-light mb-4"><?php _e('Galleria Adalberto Catanzaro', 'galleria'); ?></h3>
                                
                                <div class="space-y-4">
                                    <div class="info-item">
                                        <strong><?php _e('Founded:', 'galleria'); ?></strong>
                                        <span>2014</span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <strong><?php _e('Founder:', 'galleria'); ?></strong>
                                        <span>Adalberto Catanzaro</span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <strong><?php _e('Focus:', 'galleria'); ?></strong>
                                        <span><?php _e('Contemporary Art, Arte Povera, Transavanguardia', 'galleria'); ?></span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <strong><?php _e('Locations:', 'galleria'); ?></strong>
                                        <div class="mt-2 space-y-2">
                                            <div class="text-sm">
                                                <p>Via Montevergini 3</p>
                                                <p class="text-gray-600">90133 Palermo</p>
                                            </div>
                                            <div class="text-sm">
                                                <p>Corso Vittorio Emanuele 383</p>
                                                <p class="text-gray-600">90133 Palermo</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <strong><?php _e('Opening Hours:', 'galleria'); ?></strong>
                                        <span>Martedì–Sabato: 10:00–18:00</span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <strong><?php _e('Contact:', 'galleria'); ?></strong>
                                        <div class="mt-2 space-y-1">
                                            <p>
                                                <a href="tel:+393271677871" class="text-sm hover:underline">
                                                    +39 327 167 7871
                                                </a>
                                            </p>
                                            <p>
                                                <a href="mailto:catanzaroepartners@gmail.com" class="text-sm hover:underline">
                                                    catanzaroepartners@gmail.com
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Gallery Statistics -->
                            <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
                                <h3 class="text-xl font-light mb-4"><?php _e('Gallery in Numbers', 'galleria'); ?></h3>
                                
                                <div class="space-y-3">
                                    <?php
                                    // Get statistics
                                    $artists_count = wp_count_posts('artist')->publish ?? 0;
                                    $exhibitions_count = wp_count_posts('exhibition')->publish ?? 0;
                                    $years_active = date('Y') - 2014;
                                    ?>
                                    
                                    <div class="stat-item">
                                        <span class="stat-number"><?php echo $years_active; ?>+</span>
                                        <span class="stat-label"><?php _e('Years Active', 'galleria'); ?></span>
                                    </div>
                                    
                                    <div class="stat-item">
                                        <span class="stat-number"><?php echo $exhibitions_count; ?>+</span>
                                        <span class="stat-label"><?php _e('Exhibitions', 'galleria'); ?></span>
                                    </div>
                                    
                                    <div class="stat-item">
                                        <span class="stat-number"><?php echo $artists_count; ?>+</span>
                                        <span class="stat-label"><?php _e('Artists', 'galleria'); ?></span>
                                    </div>
                                    
                                    <div class="stat-item">
                                        <span class="stat-number">2</span>
                                        <span class="stat-label"><?php _e('Locations', 'galleria'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Featured Artists/Exhibitions Section -->
            <section class="about-featured py-16">
                <div class="container">
                    <h2 class="text-2xl font-light mb-8 text-center"><?php _e('Recent Exhibitions', 'galleria'); ?></h2>
                    
                    <?php
                    $recent_exhibitions = new WP_Query(array(
                        'post_type' => 'exhibition',
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));
                    
                    if ($recent_exhibitions->have_posts()) :
                    ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <?php while ($recent_exhibitions->have_posts()) : $recent_exhibitions->the_post(); ?>
                                <div class="exhibition-preview">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="preview-image mb-4">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('gallery-card', array('alt' => get_the_title())); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <h3 class="font-medium mb-2">
                                        <a href="<?php the_permalink(); ?>" class="hover:underline">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    
                                    <?php 
                                    $artist = get_field('artist');
                                    if ($artist) :
                                    ?>
                                        <p class="text-gray-600 text-sm"><?php echo esc_html($artist); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </article>
    <?php endwhile; ?>
</main>

<style>
.about-page .prose {
    max-width: none;
}

.about-page .prose p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
}

.about-page .prose h2 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 300;
}

.about-page .prose h3 {
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 400;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-item strong {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

.info-item span,
.info-item div {
    font-size: 0.875rem;
    color: #111827;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-number {
    font-size: 1.25rem;
    font-weight: 500;
    color: #111827;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.preview-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 0.5rem;
}

@media (max-width: 1024px) {
    .about-sidebar {
        margin-top: 2rem;
    }
}
</style>

<?php get_footer(); ?>