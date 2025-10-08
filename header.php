<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to main content - accessibility -->
<a class="skip-link screen-reader-text" href="#main_content">
	<?php esc_html_e('Skip to main content', 'galleria'); ?>
</a>

<header class="site-header">
	<div class="container">
		<!-- Logo -->
		<div class="site-logo">
			<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php esc_attr_e('Torna alla homepage', 'galleria'); ?>">
				<?php
				$custom_logo_id = get_theme_mod('custom_logo');
				if ($custom_logo_id) :
					$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
					if ($logo) :
						echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="logo-image">';
					endif;
				else :
					echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo.png') . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="logo-image">';
				endif;
				?>
			</a>
		</div>

		<!-- Desktop Navigation -->
		<nav class="main-nav" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'galleria'); ?>">
			<?php
			wp_nav_menu(array(
				'theme_location' => 'primary',
				'menu_class'     => 'nav-menu',
				'container'      => false,
				'walker'         => new Galleria_Walker_Nav_Menu(),
				'fallback_cb'    => function() {
					echo '<ul class="nav-menu">';
					echo '<li><a href="' . esc_url(get_post_type_archive_link('artist')) . '">' . esc_html__('Artists', 'galleria') . '</a></li>';
					echo '<li><a href="' . esc_url(get_post_type_archive_link('exhibition')) . '">' . esc_html__('Exhibitions', 'galleria') . '</a></li>';
					echo '<li><a href="' . esc_url(get_post_type_archive_link('project')) . '">' . esc_html__('Projects', 'galleria') . '</a></li>';
					
					// Prioritize: custom page for posts > /news/ route > home page
					$news_url = get_option('page_for_posts') 
						? get_permalink(get_option('page_for_posts'))
						: home_url('/news/');
					echo '<li><a href="' . esc_url($news_url) . '">' . esc_html__('News', 'galleria') . '</a></li>';
					
					if (class_exists('WooCommerce')) {
						echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . esc_html__('Shop', 'galleria') . '</a></li>';
					}
					
					$contact_page = get_page_by_path('contact');
					if ($contact_page) {
						echo '<li><a href="' . esc_url(get_page_link($contact_page)) . '">' . esc_html__('Contact', 'galleria') . '</a></li>';
					}
					
					$about_page = get_page_by_path('about');
					if ($about_page) {
						echo '<li><a href="' . esc_url(get_page_link($about_page)) . '">' . esc_html__('About', 'galleria') . '</a></li>';
					}
					echo '</ul>';
				}
			));
			?>
		</nav>

		<!-- Right Actions -->
		<div class="header-actions">
			<?php if (class_exists('WooCommerce')) : ?>
				<!-- Wishlist Button -->
				<button class="btn btn-icon wishlist-toggle" 
						title="<?php esc_attr_e('Lista dei desideri', 'galleria'); ?>"
						aria-label="<?php esc_attr_e('Visualizza lista dei desideri', 'galleria'); ?>">
					<svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
					</svg>
					<?php
					$wishlist_count = 0; // Implement wishlist count logic
					if ($wishlist_count > 0) :
					?>
						<span class="count-badge"><?php echo absint($wishlist_count); ?></span>
					<?php endif; ?>
				</button>

				<!-- Cart Button -->
				<a href="<?php echo esc_url(wc_get_cart_url()); ?>" 
				   class="btn btn-icon cart-toggle" 
				   title="<?php esc_attr_e('Carrello', 'galleria'); ?>"
				   aria-label="<?php esc_attr_e('Visualizza carrello della spesa', 'galleria'); ?>">
					<svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
						<line x1="3" y1="6" x2="21" y2="6"></line>
						<path d="M16 10a4 4 0 0 1-8 0"></path>
					</svg>
					<?php
					$cart_count = WC()->cart->get_cart_contents_count();
					if ($cart_count > 0) :
					?>
						<span class="count-badge"><?php echo absint($cart_count); ?></span>
					<?php endif; ?>
				</a>
			<?php endif; ?>

			<!-- Mobile Menu Toggle -->
			<button class="mobile-menu-toggle" 
					aria-label="<?php esc_attr_e('Apri menu di navigazione', 'galleria'); ?>" 
					aria-expanded="false"
					aria-controls="mobile-nav">
				<svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<line x1="3" y1="6" x2="21" y2="6"></line>
					<line x1="3" y1="12" x2="21" y2="12"></line>
					<line x1="3" y1="18" x2="21" y2="18"></line>
				</svg>
			</button>
		</div>
	</div>

	<!-- Mobile Navigation -->
	<div class="mobile-nav" id="mobile-nav" role="dialog" aria-modal="true" aria-labelledby="mobile-nav-title">
		<div class="mobile-nav-content">
			<div class="mobile-nav-header">
				<h2 class="mobile-nav-title" id="mobile-nav-title"><?php esc_html_e('Menu', 'galleria'); ?></h2>
				<p class="mobile-nav-description"><?php echo esc_html(get_theme_mod('galleria_mobile_nav_description', __('Navigate through our gallery sections', 'galleria'))); ?></p>
				<button class="mobile-nav-close" aria-label="<?php esc_attr_e('Chiudi menu', 'galleria'); ?>">
					<svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<line x1="18" y1="6" x2="6" y2="18"></line>
						<line x1="6" y1="6" x2="18" y2="18"></line>
					</svg>
				</button>
			</div>
			
			<nav class="mobile-nav-menu" role="navigation" aria-label="<?php esc_attr_e('Mobile Menu', 'galleria'); ?>">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'menu_class'     => 'mobile-menu',
					'container'      => false,
					'walker'         => new Galleria_Walker_Nav_Menu(),
					'fallback_cb'    => function() {
						echo '<ul class="mobile-menu">';
						echo '<li><a href="' . esc_url(get_post_type_archive_link('artist')) . '">' . esc_html__('Artists', 'galleria') . '</a></li>';
						echo '<li><a href="' . esc_url(get_post_type_archive_link('exhibition')) . '">' . esc_html__('Exhibitions', 'galleria') . '</a></li>';
						echo '<li><a href="' . esc_url(get_post_type_archive_link('project')) . '">' . esc_html__('Projects', 'galleria') . '</a></li>';
						
						// Prioritize: custom page for posts > /news/ route > home page
						$news_url = get_option('page_for_posts')
							? get_permalink(get_option('page_for_posts'))
							: home_url('/news/');
						echo '<li><a href="' . esc_url($news_url) . '">' . esc_html__('News', 'galleria') . '</a></li>';
						
						if (class_exists('WooCommerce')) {
							echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . esc_html__('Shop', 'galleria') . '</a></li>';
						}
						
						$contact_page = get_page_by_path('contact');
						if ($contact_page) {
							echo '<li><a href="' . esc_url(get_page_link($contact_page)) . '">' . esc_html__('Contact', 'galleria') . '</a></li>';
						}
						
						$about_page = get_page_by_path('about');
						if ($about_page) {
							echo '<li><a href="' . esc_url(get_page_link($about_page)) . '">' . esc_html__('About', 'galleria') . '</a></li>';
						}
						echo '</ul>';
					}
				));
				?>
			</nav>
		</div>
	</div>
</header>