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
                        <?php if (has_post_thumbnail()) : ?>
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

<?php
get_footer();