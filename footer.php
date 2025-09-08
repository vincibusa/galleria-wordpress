<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <!-- Navigation -->
            <div class="footer-section">
                <h3><?php _e('Navigazione', 'galleria'); ?></h3>
                <ul>
                    <li><a href="<?php echo esc_url(get_page_link(get_page_by_path('about'))); ?>"><?php _e('Chi Siamo', 'galleria'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('artist')); ?>"><?php _e('Artisti', 'galleria'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('exhibition')); ?>"><?php _e('Mostre', 'galleria'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php _e('News', 'galleria'); ?></a></li>
                    <?php if (class_exists('WooCommerce')) : ?>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php _e('Shop', 'galleria'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Sede Montevergini -->
            <div class="footer-section">
                <h3><?php _e('Sede Montevergini', 'galleria'); ?></h3>
                <div class="space-y-3">
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <div>
                            <p><?php echo esc_html(get_theme_mod('galleria_address_1', 'Via Montevergini 3')); ?></p>
                            <p>Palermo</p>
                        </div>
                    </div>
                    
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('galleria_phone', '+393271677871'))); ?>">
                            <?php echo esc_html(get_theme_mod('galleria_phone', '+39 327 167 7871')); ?>
                        </a>
                    </div>
                    
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>">
                            <?php echo esc_html(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>
                        </a>
                    </div>
                    
                    <p class="footer-hours">
                        <?php echo esc_html(get_theme_mod('galleria_hours', 'Martedì–Sabato: 10:00–18:00')); ?>
                    </p>
                </div>
            </div>

            <!-- Sede Corso Vittorio Emanuele -->
            <div class="footer-section">
                <h3><?php _e('Sede Corso Vittorio Emanuele', 'galleria'); ?></h3>
                <div class="space-y-3">
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <div>
                            <p><?php echo esc_html(get_theme_mod('galleria_address_2', 'Corso Vittorio Emanuele 383')); ?></p>
                            <p>Palermo</p>
                        </div>
                    </div>
                    
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('galleria_phone', '+393271677871'))); ?>">
                            <?php echo esc_html(get_theme_mod('galleria_phone', '+39 327 167 7871')); ?>
                        </a>
                    </div>
                    
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>">
                            <?php echo esc_html(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>
                        </a>
                    </div>
                    
                    <p class="footer-hours">
                        <?php echo esc_html(get_theme_mod('galleria_hours', 'Martedì–Sabato: 10:00–18:00')); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p class="copyright">
                    © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Tutti i diritti riservati.', 'galleria'); ?>
                </p>
                
                <button class="scroll-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" title="<?php _e('Torna su', 'galleria'); ?>">
                    <span><?php _e('Torna su', 'galleria'); ?></span>
                    <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="19" x2="12" y2="5"></line>
                        <polyline points="5,12 12,5 19,12"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<style>
/* Additional footer styles */
.footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.footer-contact-item .icon {
    width: 16px;
    height: 16px;
    color: #9ca3af;
    margin-top: 2px;
    flex-shrink: 0;
}

.footer-contact-item div {
    flex: 1;
}

.footer-contact-item p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.footer-contact-item a {
    font-size: 0.875rem;
    color: #6b7280;
    transition: color 0.3s ease;
}

.footer-contact-item a:hover {
    color: #111827;
}

.footer-hours {
    font-size: 0.875rem;
    color: #9ca3af;
    margin: 0;
}

.footer-bottom {
    border-top: 1px solid #e5e7eb;
    margin-top: 3rem;
    padding-top: 2rem;
}

.footer-bottom-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

@media (min-width: 768px) {
    .footer-bottom-content {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.copyright {
    font-size: 0.875rem;
    color: #9ca3af;
    margin: 0;
}

.scroll-to-top {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: none;
    border: none;
    font-size: 0.875rem;
    font-weight: 300;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s ease;
}

.scroll-to-top:hover {
    color: #111827;
}

.scroll-to-top .icon {
    transition: transform 0.3s ease;
}

.scroll-to-top:hover .icon {
    transform: translateY(-2px);
}

/* Header actions styles */
.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn-icon {
    position: relative;
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    color: inherit;
    transition: color 0.3s ease;
}

.btn-icon:hover {
    color: #6b7280;
}

.btn-icon .icon {
    width: 16px;
    height: 16px;
}

.count-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 16px;
    height: 16px;
    font-size: 0.75rem;
    color: white;
    border-radius: 50%;
    min-width: 16px;
}

.wishlist-toggle .count-badge {
    background-color: #ef4444;
}

.cart-toggle .count-badge {
    background-color: #3b82f6;
}

/* Mobile navigation */
.mobile-nav {
    position: fixed;
    top: 0;
    right: 0;
    width: 320px;
    height: 100vh;
    background: white;
    box-shadow: -4px 0 10px rgba(0,0,0,0.1);
    transform: translateX(100%);
    transition: transform 0.3s ease;
    z-index: 1000;
}

.mobile-nav.open {
    transform: translateX(0);
}

.mobile-nav-content {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.mobile-nav-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    background: #f9fafb;
}

.mobile-nav-title {
    font-size: 1.125rem;
    font-weight: 500;
    color: #111827;
    margin: 0 0 0.25rem 0;
}

.mobile-nav-description {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.mobile-nav-menu {
    flex: 1;
    padding: 1.5rem;
}

.mobile-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.mobile-menu li {
    margin-bottom: 0.25rem;
}

.mobile-menu a {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    font-size: 1rem;
    font-weight: 300;
    color: #374151;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.mobile-menu a:hover {
    background: #f3f4f6;
    color: #111827;
}

/* Mobile overlay */
.mobile-nav-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.mobile-nav-overlay.open {
    opacity: 1;
    pointer-events: auto;
}
</style>

<script>
// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNav = document.querySelector('.mobile-nav');
    
    if (mobileToggle && mobileNav) {
        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'mobile-nav-overlay';
        document.body.appendChild(overlay);
        
        mobileToggle.addEventListener('click', function() {
            const isOpen = mobileNav.classList.contains('open');
            
            if (isOpen) {
                mobileNav.classList.remove('open');
                overlay.classList.remove('open');
                mobileToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            } else {
                mobileNav.classList.add('open');
                overlay.classList.add('open');
                mobileToggle.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }
        });
        
        // Close on overlay click
        overlay.addEventListener('click', function() {
            mobileNav.classList.remove('open');
            overlay.classList.remove('open');
            mobileToggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        });
        
        // Close on menu link click
        const mobileMenuLinks = mobileNav.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileNav.classList.remove('open');
                overlay.classList.remove('open');
                mobileToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });
    }
});
</script>

</body>
</html>