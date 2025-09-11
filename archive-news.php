<?php
/**
 * Archive template for News
 * Simple news archive with search and card layout
 */

get_header(); ?>

<main id="main_content" class="main-content news-archive" role="main" aria-label="<?php _e('News archive', 'galleria'); ?>">
    <!-- News Header -->
    <section class="news-header">
        <div class="container">
            <h1 class="news-title"><?php _e('News & Events', 'galleria'); ?></h1>
            
            <!-- Search Bar -->
            <div class="news-search">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/news/')); ?>">
                    <label for="news-search" class="screen-reader-text"><?php _e('Search news', 'galleria'); ?></label>
                    <input type="search" 
                           id="news-search" 
                           class="search-field" 
                           placeholder="<?php esc_attr_e('Search news...', 'galleria'); ?>" 
                           value="<?php echo get_search_query(); ?>" 
                           name="s" />
                    <button type="submit" class="search-submit" aria-label="<?php _e('Search', 'galleria'); ?>">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- News Content -->
    <section class="news-content">
        <div class="container">
            <?php if (have_posts()) : ?>
                <!-- Results count -->
                <div class="results-info">
                    <?php
                    global $wp_query;
                    $total_posts = $wp_query->found_posts;
                    
                    if (get_search_query()) {
                        printf(_n('%s result for "%s"', '%s results for "%s"', $total_posts, 'galleria'), 
                               number_format_i18n($total_posts), 
                               get_search_query());
                    } else {
                        printf(_n('%s article', '%s articles', $total_posts, 'galleria'), 
                               number_format_i18n($total_posts));
                    }
                    ?>
                </div>

                <!-- News Grid -->
                <div class="news-grid">
                    <?php 
                    while (have_posts()) : the_post(); 
                        // Use the existing card template
                        get_template_part('template-parts/content', 'card');
                    endwhile; 
                    ?>
                </div>

                <!-- Pagination -->
                <?php
                the_posts_pagination(array(
                    'prev_text' => sprintf(
                        '<span class="screen-reader-text">%s </span>%s',
                        __('Previous page:', 'galleria'),
                        __('Previous', 'galleria')
                    ),
                    'next_text' => sprintf(
                        '%s <span class="screen-reader-text"> %s</span>',
                        __('Next', 'galleria'),
                        __(':Next page', 'galleria')
                    ),
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'galleria') . ' </span>',
                    'aria_current' => 'page',
                    'screen_reader_text' => __('News pagination', 'galleria'),
                    'class' => 'news-pagination'
                ));
                ?>

            <?php else : ?>
                <!-- No posts found -->
                <div class="no-news-found">
                    <div class="no-news-content">
                        <h2><?php _e('No news found', 'galleria'); ?></h2>
                        <?php if (get_search_query()) : ?>
                            <p><?php printf(__('No results found for "%s". Try a different search term.', 'galleria'), get_search_query()); ?></p>
                            <a href="<?php echo home_url('/news/'); ?>" class="btn btn-primary">
                                <?php _e('View All News', 'galleria'); ?>
                            </a>
                        <?php else : ?>
                            <p><?php _e('There are currently no news articles available.', 'galleria'); ?></p>
                            <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                                <?php _e('Back to Homepage', 'galleria'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>