<?php
/**
 * Single Post Template
 * Template per la visualizzazione delle singole news/post
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            <div class="container py-16">
                <!-- Post Header -->
                <header class="post-header mb-12">
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
                        <span class="post-meta"><?php echo esc_html($category_name); ?></span>
                    <?php endif; ?>
                    
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    
                    <div class="post-info">
                        <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php 
                $image_path = get_post_meta(get_the_ID(), 'image_path', true);
                if ($image_path) :
                    $image_url = get_template_directory_uri() . '/assets/images/' . $image_path;
                ?>
                    <div class="post-featured-image mb-8">
                        <img src="<?php echo esc_url($image_url); ?>" 
                             alt="<?php echo esc_attr(get_the_title()); ?>"
                             class="featured-image">
                    </div>
                <?php elseif (has_post_thumbnail()) : ?>
                    <div class="post-featured-image mb-8">
                        <?php the_post_thumbnail('large', array('class' => 'featured-image', 'alt' => get_the_title())); ?>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="post-content prose">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Pages:', 'galleria'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <!-- Post Navigation -->
                <nav class="post-navigation mt-16">
                    <div class="nav-links">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        
                        if ($prev_post) :
                        ?>
                            <div class="nav-previous">
                                <span class="nav-subtitle"><?php _e('Precedente', 'galleria'); ?></span>
                                <h3 class="nav-title">
                                    <a href="<?php echo get_permalink($prev_post->ID); ?>" rel="prev">
                                        <?php echo get_the_title($prev_post->ID); ?>
                                    </a>
                                </h3>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <span class="nav-subtitle"><?php _e('Successivo', 'galleria'); ?></span>
                                <h3 class="nav-title">
                                    <a href="<?php echo get_permalink($next_post->ID); ?>" rel="next">
                                        <?php echo get_the_title($next_post->ID); ?>
                                    </a>
                                </h3>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>

                <!-- Back to News -->
                <div class="back-to-news mt-8">
                    <?php
                    if (get_option('page_for_posts')) {
                        $back_url = get_permalink(get_option('page_for_posts'));
                    } else {
                        $back_url = home_url('/news/');
                    }
                    ?>
                    <a href="<?php echo esc_url($back_url); ?>" class="back-link">
                        ← <?php _e('Torna alle News', 'galleria'); ?>
                    </a>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<style>
/* Single Post Styles */
.single-post .container {
    max-width: 800px;
}

.post-header {
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 2rem;
}

.post-meta {
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 300;
    margin-bottom: 1rem;
    display: inline-block;
}

.post-title {
    font-size: 2.5rem;
    font-weight: 300;
    line-height: 1.2;
    margin-bottom: 1rem;
    color: #111827;
}

.post-info {
    color: #6b7280;
    font-size: 0.875rem;
}

.post-featured-image {
    text-align: center;
}

.featured-image {
    width: 100%;
    height: auto;
    max-height: 60vh;
    object-fit: cover;
    border-radius: 4px;
}

.post-content {
    font-size: 1.125rem;
    line-height: 1.7;
    color: #374151;
}

.post-content p {
    margin-bottom: 1.5rem;
}

.post-content h2,
.post-content h3,
.post-content h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 500;
}

.post-content h2 {
    font-size: 1.875rem;
}

.post-content h3 {
    font-size: 1.5rem;
}

.post-content h4 {
    font-size: 1.25rem;
}

.post-navigation {
    border-top: 1px solid #e5e7eb;
    padding-top: 2rem;
}

.nav-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.nav-previous,
.nav-next {
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    transition: border-color 0.2s ease;
}

.nav-previous:hover,
.nav-next:hover {
    border-color: #d1d5db;
}

.nav-next {
    text-align: right;
}

.nav-subtitle {
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 300;
    display: block;
    margin-bottom: 0.5rem;
}

.nav-title {
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.4;
    margin: 0;
}

.nav-title a {
    color: #111827;
    text-decoration: none;
    transition: color 0.2s ease;
}

.nav-title a:hover {
    color: #6b7280;
}

.back-to-news {
    text-align: center;
    border-top: 1px solid #e5e7eb;
    padding-top: 2rem;
}

.back-link {
    color: #6b7280;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 300;
    transition: color 0.2s ease;
}

.back-link:hover {
    color: #111827;
    text-decoration: underline;
}

.page-links {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

/* Responsive */
@media (max-width: 768px) {
    .post-title {
        font-size: 2rem;
    }
    
    .nav-links {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .nav-next {
        text-align: left;
    }
    
    .post-content {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .single-post .container {
        padding: 0 1rem;
    }
    
    .post-header {
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .post-title {
        font-size: 1.75rem;
    }
}
</style>

<?php
get_footer();