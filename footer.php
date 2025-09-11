<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <!-- About Section -->
            <div class="footer-section footer-about">
                <h3><?php _e('Galleria d\'Arte', 'galleria'); ?></h3>
                <p class="footer-description">
                    <?php echo esc_html(get_theme_mod('galleria_description', __('Una galleria contemporanea nel cuore di Palermo, dedicata alla promozione dell\'arte moderna e contemporanea.', 'galleria'))); ?>
                </p>
                <div class="footer-social">
                    <!-- Social media links will be added here -->
                </div>
            </div>

            <!-- Primary Location -->
            <div class="footer-section footer-location-primary">
                <h3><?php _e('Sede Principale', 'galleria'); ?></h3>
                <p class="location-name"><?php _e('Via Montevergini', 'galleria'); ?></p>
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

            <!-- Secondary Location -->
            <div class="footer-section footer-location-secondary">
                <h3><?php _e('Seconda Sede', 'galleria'); ?></h3>
                <p class="location-name"><?php _e('Corso Vittorio Emanuele', 'galleria'); ?></p>
                <div class="space-y-3">
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <div>
                            <p><?php echo esc_html(get_theme_mod('galleria_address_2', 'Corso Vittorio Emanuele 383')); ?></p>
                            <p>Palermo</p>
                        </div>
                    </div>
                    
                    <p class="footer-hours secondary-hours">
                        <?php echo esc_html(get_theme_mod('galleria_hours_2', 'Su appuntamento')); ?>
                    </p>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="footer-section footer-contact">
                <h3><?php _e('Contatti', 'galleria'); ?></h3>
                <div class="space-y-3">
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('galleria_phone', '+393271677871'))); ?>" aria-label="<?php _e('Chiamaci', 'galleria'); ?>">
                            <?php echo esc_html(get_theme_mod('galleria_phone', '+39 327 167 7871')); ?>
                        </a>
                    </div>
                    
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>" aria-label="<?php _e('Inviaci una email', 'galleria'); ?>">
                            <?php echo esc_html(get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p class="copyright">
                    © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Tutti i diritti riservati.', 'galleria'); ?>
                </p>
                
                <button class="scroll-to-top" 
                        title="<?php _e('Torna su', 'galleria'); ?>"
                        aria-label="<?php _e('Torna all\'inizio della pagina', 'galleria'); ?>">
                    <span><?php _e('Torna su', 'galleria'); ?></span>
                    <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="19" x2="12" y2="5"></line>
                        <polyline points="5,12 12,5 19,12"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>