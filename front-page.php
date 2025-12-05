<?php
/**
 * Homepage Template
 *
 * Replica della homepage del sito Next.js originale.
 *
 * @package    Galleria_Catanzaro
 * @version    1.0.0
 */

declare(strict_types=1);

// Security: Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<main id="main_content" class="main-content" role="main" aria-label="<?php esc_attr_e('Contenuto principale', 'galleria'); ?>">
	<!-- Hero Section - Carosello Personalizzato -->
	<?php if (get_theme_mod('galleria_hero_show', true)) : ?>
	<?php
	// Conta quante slide hanno almeno un'immagine
	$slides_count = 0;
	for ($i = 1; $i <= 3; $i++) {
		if (get_theme_mod('galleria_hero_slide' . $i . '_image', '')) {
			$slides_count++;
		}
	}
	
	if ($slides_count > 0) :
	?>
	<section class="hero-section" role="banner" aria-label="<?php esc_attr_e('Carosello hero', 'galleria'); ?>">
		<div id="carousel-slides" class="hero-wrapper">
			<?php
			for ($i = 1; $i <= 3; $i++) {
				$image = get_theme_mod('galleria_hero_slide' . $i . '_image', '');
				$title = get_theme_mod('galleria_hero_slide' . $i . '_title', '');
				$artist = get_theme_mod('galleria_hero_slide' . $i . '_artist', '');
				$location = get_theme_mod('galleria_hero_slide' . $i . '_location', '');
				$dates = get_theme_mod('galleria_hero_slide' . $i . '_dates', '');
				
				// Salta slide senza immagine
				if (empty($image)) {
					continue;
				}
				
				$is_active = ($i === 1) ? 'active' : '';
				$slide_index = $i - 1;
			?>
				<div class="carousel-slide <?php echo esc_attr($is_active); ?>" data-slide-index="<?php echo esc_attr($slide_index); ?>">
					<!-- Main Content: Title and Image -->
					<div class="slide-main-content">
						<div class="slide-text-column">
							<?php if ($title) : ?>
								<h1 class="hero-title"><span class="highlight"><?php echo esc_html($title); ?></span></h1>
							<?php endif; ?>
						</div>
						<div class="slide-image-column">
							<img src="<?php echo esc_url($image); ?>" 
								 alt="<?php echo esc_attr($title ? $title : sprintf(__('Slide %d', 'galleria'), $i)); ?>" 
								 class="hero-image">
						</div>
					</div>

					<!-- Meta Footer: Artist, Date, Location -->
					<div class="slide-meta-footer">
						<div class="meta-column">
							<span class="meta-label"><?php esc_html_e('ARTISTA', 'galleria'); ?></span>
							<span class="meta-value"><?php echo esc_html($artist ? $artist : '-'); ?></span>
						</div>
						<div class="meta-column">
							<span class="meta-label"><?php esc_html_e('DATA', 'galleria'); ?></span>
							<span class="meta-value"><?php echo esc_html($dates ? $dates : '-'); ?></span>
						</div>
						<div class="meta-column">
							<span class="meta-label"><?php esc_html_e('LOCATION', 'galleria'); ?></span>
							<div class="meta-value-group">
								<span class="meta-value"><?php echo esc_html($location ? $location : '-'); ?></span>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		
		<?php if ($slides_count > 1) : ?>
			<!-- Indicatori Dots -->
			<div class="carousel-dots-container">
				<?php 
				$dot_index = 0;
				for ($i = 1; $i <= 3; $i++) {
					if (get_theme_mod('galleria_hero_slide' . $i . '_image', '')) :
				?>
					<button class="carousel-dot <?php echo ($dot_index === 0) ? 'active' : ''; ?>" 
							data-slide="<?php echo esc_attr($dot_index); ?>"
							aria-label="<?php echo esc_attr(sprintf(__('Vai alla slide %d', 'galleria'), $dot_index + 1)); ?>">
					</button>
				<?php
						$dot_index++;
					endif;
				}
				?>
			</div>
		<?php endif; ?>
	</section>
	<?php
	endif;
	endif;
	?>

	<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
		<!-- News & Events Section -->
		<?php if (get_theme_mod('galleria_homepage_show_news', true)) : ?>
		<section class="news-events" role="region" aria-labelledby="news-events-title">
			<h2 id="news-events-title" class="text-2xl font-light mb-8"><?php esc_html_e('News & Events', 'galleria'); ?></h2>
			
			<?php
			$news_count = absint(get_theme_mod('galleria_homepage_news_count', 6));
			$news_columns = get_theme_mod('galleria_homepage_news_columns', '3');
			$grid_class = 'grid grid-cols-1';
			
			// Set grid columns based on customizer setting
			if ($news_columns === '2') {
				$grid_class .= ' md:grid-cols-2';
			} elseif ($news_columns === '3') {
				$grid_class .= ' md:grid-cols-2 lg:grid-cols-3';
			} elseif ($news_columns === '4') {
				$grid_class .= ' md:grid-cols-2 lg:grid-cols-4';
			}
			
			$news_posts = new WP_Query(array(
				'post_type'      => 'post',
				'posts_per_page' => $news_count,
				'orderby'        => 'date',
				'order'          => 'DESC'
			));
			
			if ($news_posts->have_posts()) :
			?>
				<div class="<?php echo esc_attr($grid_class); ?> gap-8">
					<?php
					while ($news_posts->have_posts()) :
						$news_posts->the_post();
						get_template_part('template-parts/content', 'card');
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				
				<?php if ($news_posts->found_posts > $news_count) : ?>
					<div class="text-center mt-8">
						<a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
						   class="text-sm font-light hover:underline">
							<?php esc_html_e('Vedi di più', 'galleria'); ?>
						</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</section>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
