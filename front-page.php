<?php
/**
 * Homepage Template
 * Replica della homepage del sito Next.js originale
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <!-- Hero Section -->
    <section class="hero-section">
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
        <section class="news-events">
            <h2 class="text-2xl font-light mb-8"><?php _e('News & Events', 'galleria'); ?></h2>
            
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
                        <article class="card">
                            <?php 
                            $image_path = get_post_meta(get_the_ID(), 'image_path', true);
                            if ($image_path) :
                                $image_url = get_template_directory_uri() . '/assets/images/' . $image_path;
                            ?>
                                <div class="card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url($image_url); ?>" 
                                             alt="<?php echo esc_attr(get_the_title()); ?>"
                                             style="width: 100%; height: 250px; object-fit: cover;">
                                    </a>
                                </div>
                            <?php elseif (has_post_thumbnail()) : ?>
                                <div class="card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('gallery-card', array('alt' => get_the_title())); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-content">
                                <div class="space-y-2">
                                    <?php 
                                    $categories = get_the_category();
                                    if (!empty($categories)) :
                                        $category = $categories[0];
                                        $category_name = '';
                                        
                                        // Map category to exhibition type
                                        switch ($category->slug) {
                                            case 'solo-exhibition':
                                                $category_name = __('Solo Exhibition', 'galleria');
                                                break;
                                            case 'group-exhibition':
                                                $category_name = __('Group Exhibition', 'galleria');
                                                break;
                                            default:
                                                $category_name = __('News', 'galleria');
                                                break;
                                        }
                                    ?>
                                        <span class="card-meta"><?php echo esc_html($category_name); ?></span>
                                    <?php endif; ?>
                                    
                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <strong><?php the_title(); ?></strong>
                                        </a>
                                    </h3>
                                    
                                    <div class="card-description">
                                        <?php 
                                        $excerpt = get_the_excerpt();
                                        echo strlen($excerpt) > 150 ? wp_trim_words($excerpt, 25) . '...' : $excerpt;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </article>
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

<style>
/* Hero Section Styles */
.hero-section {
    position: relative;
    height: 60vh;
    min-height: 400px;
    overflow: hidden;
}

.hero-container {
    position: relative;
    width: 100%;
    height: 100%;
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 2rem;
}

.hero-title {
    font-size: 1.875rem;
    font-weight: 300;
    line-height: 1.2;
    margin-bottom: 0.5rem;
}

.hero-subtitle {
    font-size: 1.125rem;
    font-weight: 300;
    opacity: 0.9;
    max-width: 600px;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-content {
        padding: 1.5rem 1rem;
    }
    
    .hero-title {
        font-size: 1.5rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
}

/* Additional styles for Next.js compatibility */
.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1rem;
}

.py-16 {
    padding-top: 4rem;
    padding-bottom: 4rem;
}

.space-y-20 > * + * {
    margin-top: 5rem;
}

.grid {
    display: grid;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
}

.gap-8 {
    gap: 2rem;
}

.card {
    border: 0;
    box-shadow: none;
    display: flex;
    flex-direction: column;
}

.card-content {
    padding: 0;
}

.card-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    margin-bottom: 0.25rem; /* further reduced spacing between image and content */
}

/* News-specific: override aspect-ratio and ensure no descender gap */
.news-events {
   margin-top: 40px;
}
.news-events .card-image {
    aspect-ratio: auto; /* allow fixed image height to control size */
    height: auto;
}

.news-events .card-image img {
    display: block; /* remove inline descender gap */
    height: 250px !important; /* ensure consistent height for images in news cards */
    margin-bottom: 0 !important;
}

/* small vertical spacing utility (used in cards) */
.space-y-2 > * + * {
    margin-top: 0.25rem; /* tighter stack spacing */
}

.card-title {
    font-size: 1.125rem;
    font-weight: 300;
    line-height: 1.4;
    margin-bottom: 0; /* reduced gap under title */
}

.card-title strong {
    font-weight: 500;
}

.card-meta {
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 300;
    margin-bottom: 0.25rem; /* tightened */
}

.card-description {
    font-size: 0.875rem;
    color: #6b7280;
}

.text-2xl {
    font-size: 1.5rem;
}

.font-light {
    font-weight: 300;
}

.mb-8 {
    margin-bottom: 2rem;
}

.text-center {
    text-align: center;
}

.mt-8 {
    margin-top: 2rem;
}

.text-sm {
    font-size: 0.875rem;
}

.hover\:underline:hover {
    text-decoration: underline;
}

@media (min-width: 768px) {
    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    
    .container {
        padding: 0 1.5rem;
    }
}

@media (min-width: 1024px) {
    .lg\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    
    .container {
        padding: 0 2rem;
    }
}
</style>


<?php
get_footer();