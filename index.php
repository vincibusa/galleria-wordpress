<?php
/**
 * The main template file
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-grid grid grid-cols-1 md-grid-cols-2 lg-grid-cols-3">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
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
                                <div class="card-meta">
                                    <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                </div>
                                
                                <h2 class="card-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <strong><?php the_title(); ?></strong>
                                    </a>
                                </h2>
                                
                                <?php if (has_excerpt()) : ?>
                                    <div class="card-description">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination(array(
                'prev_text' => __('Precedente', 'galleria'),
                'next_text' => __('Successivo', 'galleria'),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Pagina', 'galleria') . ' </span>',
            ));
            ?>

        <?php else : ?>
            <div class="no-posts py-16 text-center">
                <h1><?php _e('Nessun contenuto trovato', 'galleria'); ?></h1>
                <p><?php _e('Non è stato possibile trovare contenuti corrispondenti alla tua ricerca.', 'galleria'); ?></p>
                
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
/* Archive/Index Page Styles */
.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 4rem 1rem;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(1, minmax(0, 1fr));
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
    margin-bottom: 0.25rem;
    display: block;
}

.space-y-2 > * + * {
    margin-top: 0.25rem;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 300;
    line-height: 1.4;
    margin-bottom: 0;
}

.card-title strong {
    font-weight: 500;
}

.card-title a {
    color: #111827;
    text-decoration: none;
    transition: color 0.2s ease;
}

.card-title a:hover {
    color: #6b7280;
}

.card-meta {
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 300;
    margin-bottom: 0.25rem;
}

.card-description {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.5;
}

.no-posts {
    text-align: center;
    padding: 4rem 1rem;
}

.no-posts h1 {
    font-size: 2rem;
    font-weight: 300;
    margin-bottom: 1rem;
    color: #111827;
}

.no-posts p {
    color: #6b7280;
    margin-bottom: 2rem;
}

/* Pagination */
.navigation.pagination {
    margin-top: 3rem;
    text-align: center;
}

.page-numbers {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    color: #6b7280;
    text-decoration: none;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.page-numbers:hover,
.page-numbers.current {
    background-color: #f9fafb;
    border-color: #d1d5db;
    color: #111827;
}

.page-numbers.current {
    background-color: #111827;
    color: white;
    border-color: #111827;
}

@media (min-width: 768px) {
    .posts-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    
    .container {
        padding: 4rem 1.5rem;
    }
}

@media (min-width: 1024px) {
    .posts-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    
    .container {
        padding: 4rem 2rem;
    }
}
</style>

<?php
get_footer();