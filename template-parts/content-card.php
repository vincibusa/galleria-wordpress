<?php
/**
 * Template part for displaying posts in card format
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package galleria_catanzaro
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?> role="article" aria-labelledby="post-title-<?php the_ID(); ?>">
    <?php 
    // Check for custom image path first, then featured image
    $image_path = get_post_meta(get_the_ID(), 'image_path', true);
    if ($image_path) :
        $image_url = get_template_directory_uri() . '/assets/images/' . $image_path;
    ?>
        <div class="card-image">
            <a href="<?php the_permalink(); ?>" aria-label="<?php printf(__('Leggi di più su %s', 'galleria'), get_the_title()); ?>">
                <img src="<?php echo esc_url($image_url); ?>" 
                     alt="<?php echo esc_attr(get_the_title()); ?>"
                     loading="lazy"
                     style="width: 100%; height: 250px; object-fit: cover;">
            </a>
        </div>
    <?php elseif (has_post_thumbnail()) : ?>
        <div class="card-image">
            <a href="<?php the_permalink(); ?>" aria-label="<?php printf(__('Leggi di più su %s', 'galleria'), get_the_title()); ?>">
                <?php the_post_thumbnail('gallery-card', array(
                    'alt' => get_the_title(),
                    'loading' => 'lazy'
                )); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="card-content">
        <div class="space-y-2">
            <?php 
            // Display category or post type
            if (get_post_type() === 'post') {
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
            <?php 
                endif;
            } else {
                // For custom post types, use the singular name
                $post_type_obj = get_post_type_object(get_post_type());
                if ($post_type_obj) :
            ?>
                <span class="card-meta"><?php echo esc_html($post_type_obj->labels->singular_name); ?></span>
            <?php endif; } ?>
            
            <?php
            // Use appropriate heading level based on context
            $heading_tag = is_front_page() ? 'h3' : 'h2';
            ?>
            <<?php echo $heading_tag; ?> id="post-title-<?php the_ID(); ?>" class="card-title">
                <a href="<?php the_permalink(); ?>" aria-describedby="post-excerpt-<?php the_ID(); ?>">
                    <strong><?php the_title(); ?></strong>
                </a>
            </<?php echo $heading_tag; ?>>
            
            <?php if (has_excerpt() || get_the_content()) : ?>
                <div id="post-excerpt-<?php the_ID(); ?>" class="card-description">
                    <?php 
                    if (has_excerpt()) {
                        the_excerpt();
                    } else {
                        $excerpt = get_the_content();
                        echo strlen($excerpt) > 150 ? wp_trim_words($excerpt, 25) . '...' : $excerpt;
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>