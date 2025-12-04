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
	<!-- Hero Section - Carosello Esibizioni -->
	<?php
	// Query per le 3 esibizioni più recenti
	$exhibitions_query = new WP_Query(array(
		'post_type' => 'exhibition',
		'posts_per_page' => 3,
		'orderby' => 'date',
		'order' => 'DESC',
		'post_status' => 'publish'
	));

	if ($exhibitions_query->have_posts()) :
	?>
	<section class="hero-section" role="banner" aria-label="<?php esc_attr_e('Carosello esibizioni', 'galleria'); ?>">
		<div id="carousel-slides" class="hero-wrapper">
			<?php
			$slide_index = 0;
			while ($exhibitions_query->have_posts()) :
				$exhibitions_query->the_post();
				$slide_index++;
				$is_active = ($slide_index === 1) ? 'active' : '';
				
				// Recupera campi ACF
				$artist = get_field('artist');
				$location = get_field('location');
				$start_date = get_field('start_date');
				$end_date = get_field('end_date');
				
				// Formatta location
				$location_formatted = '';
				if ($location) {
					$location_formatted = ucfirst($location);
				}
				
				// Formatta date
				$dates_formatted = '';
				if ($start_date && $end_date) {
					$start_formatted = date_i18n('d.m.Y', strtotime($start_date));
					$end_formatted = date_i18n('d.m.Y', strtotime($end_date));
					$dates_formatted = $start_formatted . ' – ' . $end_formatted;
				}
				
				// Combina location e date
				$info_parts = array();
				if ($location_formatted) {
					$info_parts[] = strtoupper($location_formatted);
				}
				if ($dates_formatted) {
					$info_parts[] = strtoupper($dates_formatted);
				}
			?>
				<div class="carousel-slide <?php echo esc_attr($is_active); ?>">
					<div class="hero-text-panel">
						<div class="hero-content">
							<?php if ($artist) : ?>
								<div class="hero-artist">
									<?php echo esc_html($artist); ?>
								</div>
							<?php endif; ?>

							<?php if (get_the_title()) : ?>
								<h1 class="hero-title"><?php the_title(); ?></h1>
							<?php endif; ?>

							<?php if (!empty($info_parts)) : ?>
								<div class="hero-info">
									<?php echo esc_html(implode(' / ', $info_parts)); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<div class="hero-image-panel">
						<?php if (has_post_thumbnail()) : ?>
							<?php
							the_post_thumbnail('full', array(
								'alt' => esc_attr(get_the_title()),
								'class' => 'hero-image'
							));
							?>
						<?php else : ?>
							<div class="hero-image-placeholder">
								<span><?php esc_html_e('Nessuna immagine', 'galleria'); ?></span>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		
		<?php if ($exhibitions_query->post_count > 1) : ?>
			<!-- Indicatori Dots -->
			<div class="carousel-dots-container">
				<?php for ($i = 0; $i < $exhibitions_query->post_count; $i++) : ?>
					<button class="carousel-dot <?php echo ($i === 0) ? 'active' : ''; ?>" 
							data-slide="<?php echo esc_attr($i); ?>"
							aria-label="<?php echo esc_attr(sprintf(__('Vai alla slide %d', 'galleria'), $i + 1)); ?>">
					</button>
				<?php endfor; ?>
			</div>
		<?php endif; ?>
	</section>
	<?php
	endif;
	wp_reset_postdata();
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

		<!-- Publications Section (commented out for now like in original) -->
		<!-- 
		<section class="publications">
			<h2 class="text-2xl font-light mb-8"><?php esc_html_e('Publications', 'galleria'); ?></h2>
			
			<?php
			$publications = new WP_Query(array(
				'post_type'      => 'publication',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC'
			));
			
			if ($publications->have_posts()) :
			?>
				<div class="grid grid-cols-1 md-grid-cols-2 lg-grid-cols-3">
					<?php
					while ($publications->have_posts()) :
						$publications->the_post();
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
										<span class="card-meta"><?php esc_html_e('Publications', 'galleria'); ?></span>
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
											<?php esc_html_e('Buy now', 'galleria'); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</article>
					<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</section>
		-->
	</div>
</main>

<?php
get_footer();