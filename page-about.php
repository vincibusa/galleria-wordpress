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
                    <div class="grid grid-cols-1 gap-12">
                        <!-- Main Content (multi-column on larger screens) -->
                        <div>
                            <div class="prose prose-lg about-columns">
                                <?php the_content(); ?>
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
/* About page - multi-column content without sidebar */
.about-page { color: #0f1724; }
.about-hero .max-w-4xl { padding: 0 1rem; }
.about-hero h1, .about-hero .text-4xl { font-size: clamp(2rem, 4.5vw, 3.25rem); line-height: 1.05; font-weight: 300; margin-bottom: 0.5rem; }
.about-hero .text-xl { font-size: 1.125rem; color: #56606b; max-width: 54ch; margin: 0 auto; }

/* Columnized main content: responsive columns */
.about-page .prose { max-width: none; }
.about-columns { column-gap: 2rem; column-fill: auto; }
@media (min-width: 768px) {
    .about-columns { -webkit-column-count: 2; column-count: 2; -webkit-column-width: 28rem; column-width: 28rem; }
}
@media (min-width: 1200px) {
    .about-columns { -webkit-column-count: 3; column-count: 3; -webkit-column-width: 24rem; column-width: 24rem; }
}
.about-columns p, .about-columns ul, .about-columns ol { break-inside: avoid-column; -webkit-column-break-inside: avoid; margin-bottom: 1.25rem; line-height: 1.75; color: #24303a; font-size: 1.02rem; }
.about-columns h2, .about-columns h3 { break-inside: avoid-column; }
.about-columns img, .about-columns figure { break-inside: avoid-column; width: 100%; height: auto; display: block; margin: 0 0 1rem; }

/* Preview grid */
.exhibition-preview { transition: transform .25s ease, box-shadow .25s ease; }
.exhibition-preview:hover { transform: translateY(-6px); }
.preview-image img { width: 100%; height: 220px; object-fit: cover; border-radius: 0.5rem; display: block; }

@media (max-width: 767px) {
    .about-columns { -webkit-column-count: 1; column-count: 1; }
}
</style>

<?php get_footer(); ?>