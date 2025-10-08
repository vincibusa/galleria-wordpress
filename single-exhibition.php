<?php
/**
 * Single Exhibition Template
 *
 * Template for displaying individual exhibition pages.
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

<main id="main_content" class="main-content">
	<?php
	while (have_posts()) :
		the_post();
		$artist = get_field('artist');
		$curator = get_field('curator');
		$venue = get_field('venue');
		$location = get_field('location');
		$start_date = get_field('start_date');
		$end_date = get_field('end_date');
		$featured = get_field('featured');
	?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('exhibition-single'); ?>>
			<!-- Exhibition Hero Image -->
			<section class="exhibition-hero">
				<?php if (has_post_thumbnail()) : ?>
					<div class="hero-image">
						<?php
						the_post_thumbnail('full', array(
							'alt'   => esc_attr(sprintf(__('Exhibition hero image: %s', 'galleria'), get_the_title())),
							'class' => 'w-full h-auto object-cover'
						));
						?>
					</div>
				<?php endif; ?>
			</section>

			<!-- Exhibition Info Section (sotto l'immagine) -->
			<section class="exhibition-info py-12 bg-white">
				<div class="container">
					<div class="max-w-3xl mx-auto">
						<!-- Meta Information -->
						<div class="exhibition-meta mb-6 flex flex-wrap gap-4 text-sm text-gray-600">
							<?php if ($location) : ?>
								<span class="location font-medium"><?php echo esc_html(ucfirst($location)); ?></span>
							<?php endif; ?>
							
							<?php if ($start_date && $end_date) : ?>
								<span class="dates">
									<?php
									echo esc_html(
										date_i18n('d.m.Y', strtotime($start_date)) . ' – ' .
										date_i18n('d.m.Y', strtotime($end_date))
									);
									?>
								</span>
							<?php endif; ?>
						</div>

						<!-- Title -->
						<h1 class="exhibition-title text-4xl md:text-5xl font-light mb-6"><?php the_title(); ?></h1>

						<!-- Artist -->
						<?php if ($artist) : ?>
							<p class="exhibition-artist text-2xl text-gray-700 mb-4"><?php echo esc_html($artist); ?></p>
						<?php endif; ?>

						<!-- Curator -->
						<?php if ($curator) : ?>
							<p class="exhibition-curator text-lg text-gray-600 italic">
								<?php echo esc_html(sprintf(__('Curated by %s', 'galleria'), $curator)); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</section>

			<!-- Exhibition Details -->
			<section class="exhibition-details py-16">
				<div class="container">
					<div class="max-w-4xl mx-auto">
						<!-- Main Content -->
						<div class="exhibition-content mb-12">
							<?php if (get_the_content()) : ?>
								<div class="prose prose-lg max-w-none">
									<?php the_content(); ?>
								</div>
							<?php elseif (has_excerpt()) : ?>
								<div class="prose prose-lg max-w-none">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>
						</div>
						
						<!-- Exhibition Info - Clean Layout without labels -->
						<div class="exhibition-info border-t border-gray-200 pt-8 space-y-3 text-sm text-gray-700">
							<?php if ($artist) : ?>
								<p><?php echo esc_html($artist); ?></p>
							<?php endif; ?>
							
							<?php if ($curator) : ?>
								<p class="italic"><?php echo esc_html($curator); ?></p>
							<?php endif; ?>
							
							<?php if ($venue) : ?>
								<p><?php echo esc_html($venue); ?></p>
							<?php endif; ?>
							
							<?php if ($location) : ?>
								<p><?php echo esc_html(ucfirst($location)); ?></p>
							<?php endif; ?>
							
							<?php if ($start_date && $end_date) : ?>
								<p>
									<?php
									echo esc_html(
										date_i18n('j F Y', strtotime($start_date)) . ' – ' .
										date_i18n('j F Y', strtotime($end_date))
									);
									?>
								</p>
							<?php endif; ?>
							
							<!-- Gallery Contact Info -->
							<div class="gallery-info border-t border-gray-200 pt-6 mt-8 space-y-2">
								<p class="font-medium text-gray-900"><?php echo esc_html(get_theme_mod('galleria_name', 'Galleria Adalberto Catanzaro')); ?></p>
								
								<?php if ($location === 'palermo' || !$location) : ?>
									<p>
										<?php echo esc_html(get_theme_mod('galleria_address_1', 'Via Montevergini 3')); ?><br>
										<?php echo esc_html(get_theme_mod('galleria_city', 'Palermo')); ?>
									</p>
								<?php elseif ($location === 'bagheria') : ?>
									<p>
										<?php echo esc_html(get_theme_mod('galleria_address_2', 'Corso Vittorio Emanuele 383')); ?><br>
										<?php echo esc_html(get_theme_mod('galleria_city', 'Palermo')); ?>
									</p>
								<?php endif; ?>
								
								<p>
									<a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('galleria_phone', '+393271677871'))); ?>" class="hover:underline">
										<?php echo esc_html(get_theme_mod('galleria_phone', '+39 327 167 7871')); ?>
									</a>
								</p>
								
								<p>
									<a href="mailto:<?php echo esc_attr(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>" class="hover:underline">
										<?php echo esc_html(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>
									</a>
								</p>
								
								<p class="text-xs">
									<?php echo esc_html(get_theme_mod('galleria_hours', 'Martedì–Sabato: 10:00–18:00')); ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- Navigation -->
			<nav class="exhibition-navigation py-8 border-t bg-white" aria-label="<?php esc_attr_e('Exhibition Navigation', 'galleria'); ?>">
				<div class="container">
					<div class="flex flex-col md:flex-row justify-between items-center gap-4">
						<?php
						$prev_post = get_previous_post(false, '', 'exhibition');
						$next_post = get_next_post(false, '', 'exhibition');
						?>
						
						<div class="nav-previous">
							<?php if ($prev_post) : ?>
								<a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" 
								   class="inline-flex items-center space-x-2 text-sm font-light hover:underline"
								   aria-label="<?php echo esc_attr(sprintf(__('Previous exhibition: %s', 'galleria'), $prev_post->post_title)); ?>">
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
									</svg>
									<span><?php echo esc_html($prev_post->post_title); ?></span>
								</a>
							<?php endif; ?>
						</div>
						
						<div class="nav-back">
							<a href="<?php echo esc_url(get_post_type_archive_link('exhibition')); ?>" 
							   class="text-sm font-light hover:underline"
							   aria-label="<?php esc_attr_e('Return to all exhibitions', 'galleria'); ?>">
								<?php esc_html_e('All Exhibitions', 'galleria'); ?>
							</a>
						</div>
						
						<div class="nav-next">
							<?php if ($next_post) : ?>
								<a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" 
								   class="inline-flex items-center space-x-2 text-sm font-light hover:underline"
								   aria-label="<?php echo esc_attr(sprintf(__('Next exhibition: %s', 'galleria'), $next_post->post_title)); ?>">
									<span><?php echo esc_html($next_post->post_title); ?></span>
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
									</svg>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</nav>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer();