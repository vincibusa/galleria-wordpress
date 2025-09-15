<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <!-- About Section -->
            <div class="footer-section footer-about">
                <h3><?php _e('Adalberto Catanzaro Arte Contemporanea', 'galleria'); ?></h3>
                <p class="footer-description">
                    <?php echo esc_html(get_theme_mod('galleria_description', __('Una galleria  nel cuore di Palermo, dedicata alla promozione e alla valorizzazione dell\'arte contemporanea.', 'galleria'))); ?>
                </p>
                <div class="footer-social">
                    <?php if (get_theme_mod('galleria_facebook') || get_theme_mod('galleria_instagram') || get_theme_mod('galleria_twitter') || get_theme_mod('galleria_linkedin')) : ?>
                        <div class="social-links">
                            <?php if (get_theme_mod('galleria_facebook')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('galleria_facebook')); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php _e('Seguici su Facebook', 'galleria'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('galleria_instagram')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('galleria_instagram')); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php _e('Seguici su Instagram', 'galleria'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12.017 0C8.396 0 7.989.016 6.756.072 5.526.126 4.73.302 4.032.572c-.706.276-1.305.646-1.902 1.243C1.533 2.412 1.163 3.011.887 3.717c-.27.698-.446 1.494-.5 2.724C.331 7.674.315 8.081.315 11.702s.016 4.028.072 5.261c.054 1.23.23 2.026.5 2.724.276.706.646 1.305 1.243 1.902.597.597 1.196.967 1.902 1.243.698.27 1.494.446 2.724.5C7.989 23.368 8.396 23.384 12.017 23.384s4.028-.016 5.261-.072c1.23-.054 2.026-.23 2.724-.5.706-.276 1.305-.646 1.902-1.243.597-.597.967-1.196 1.243-1.902.27-.698.446-1.494.5-2.724.056-1.233.072-1.64.072-5.261s-.016-4.028-.072-5.261c-.054-1.23-.23-2.026-.5-2.724-.276-.706-.646-1.305-1.243-1.902-.597-.597-1.196-.967-1.902-1.243-.698-.27-1.494-.446-2.724-.5C16.045.016 15.638 0 12.017 0zM12.017 2.154c3.567 0 3.99.016 5.398.072 1.301.059 2.008.277 2.478.46.623.242 1.067.532 1.534.999.467.467.757.911.999 1.534.183.47.401 1.177.46 2.478.056 1.408.072 1.831.072 5.398s-.016 3.99-.072 5.398c-.059 1.301-.277 2.008-.46 2.478-.242.623-.532 1.067-.999 1.534-.467.467-.911.757-1.534.999-.47.183-1.177.401-2.478.46-1.408.056-1.831.072-5.398.072s-3.99-.016-5.398-.072c-1.301-.059-2.008-.277-2.478-.46-.623-.242-1.067-.532-1.534-.999-.467-.467-.757-.911-.999-1.534-.183-.47-.401-1.177-.46-2.478-.056-1.408-.072-1.831-.072-5.398s.016-3.99.072-5.398c.059-1.301.277-2.008.46-2.478.242-.623.532-1.067.999-1.534.467-.467.911-.757 1.534-.999.47-.183 1.177-.401 2.478-.46 1.408-.056 1.831-.072 5.398-.072z"/>
                                        <path d="M12.017 5.838a6.164 6.164 0 1 0 0 12.328 6.164 6.164 0 0 0 0-12.328zM12.017 15.84a3.676 3.676 0 1 1 0-7.352 3.676 3.676 0 0 1 0 7.352zM18.384 4.155a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('galleria_twitter')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('galleria_twitter')); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php _e('Seguici su Twitter', 'galleria'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('galleria_linkedin')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('galleria_linkedin')); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php _e('Seguici su LinkedIn', 'galleria'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
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
                            <p><?php echo esc_html(get_theme_mod('galleria_location_1_name', 'Via Montevergini 3')); ?></p>
                            <p><?php echo esc_html(get_theme_mod('galleria_city', 'Palermo')); ?></p>
                        </div>
                    </div>
                    
              
                    

                    
                    <p class="footer-hours">
                        <?php echo esc_html(get_theme_mod('galleria_hours', 'Martedì–Sabato: 10:00–18:00')); ?>
                    </p>
                </div>
            </div>

            <!-- Secondary Location -->
            <div class="footer-section footer-location-secondary">
                <h3><?php _e('Project Space', 'galleria'); ?></h3>
                <p class="location-name"><?php _e('Corso Vittorio Emanuele', 'galleria'); ?></p>
                <div class="space-y-3">
                    <div class="footer-contact-item">
                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <div>
                            <p><?php echo esc_html(get_theme_mod('galleria_location_2_name', 'Corso Vittorio Emanuele 383')); ?></p>
                            <p><?php echo esc_html(get_theme_mod('galleria_city', 'Palermo')); ?></p>
                        </div>
                    </div>
                    
                    <p class="footer-hours secondary-hours">
                        <?php echo esc_html(get_theme_mod('galleria_hours_2', '')); ?>
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