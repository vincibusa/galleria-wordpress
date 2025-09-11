<?php
/**
 * The main template file
 */

get_header(); ?>

<main id="main_content" class="main-content" role="main" aria-label="<?php _e('Contenuto principale', 'galleria'); ?>">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination with accessibility improvements
            the_posts_pagination(array(
                'prev_text' => sprintf('<span class="screen-reader-text">%s </span>%s', __('Pagina precedente:', 'galleria'), __('Precedente', 'galleria')),
                'next_text' => sprintf('%s <span class="screen-reader-text">%s</span>', __('Successivo', 'galleria'), __(':Pagina seguente', 'galleria')),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Pagina', 'galleria') . ' </span>',
                'aria_current' => 'page',
                'screen_reader_text' => __('Navigazione pagine', 'galleria'),
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