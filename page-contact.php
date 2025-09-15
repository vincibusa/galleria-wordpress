<?php
/**
 * Template for Contact Page
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('contact-page'); ?>>
            <!-- Contact Hero Section -->


            <!-- Contact Content -->
            <section class="contact-content">
                <div class="container py-16">
                    <div class="contact-grid">
                        <!-- Contact Form -->
                        <div class="contact-form-section">
                            <div class="form-container">
                                <h2><?php _e('Contattaci', 'galleria'); ?></h2>
                                
                                <!-- Form Messages -->
                                <?php if (isset($_GET['contact'])) : ?>
                                    <?php if ($_GET['contact'] === 'success') : ?>
                                        <div class="form-message success">
                                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <?php echo esc_html(isset($_GET['message']) ? urldecode($_GET['message']) : __('Messaggio inviato con successo!', 'galleria')); ?>
                                        </div>
                                    <?php elseif ($_GET['contact'] === 'error') : ?>
                                        <div class="form-message error">
                                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <?php echo esc_html(isset($_GET['message']) ? urldecode($_GET['message']) : __('Errore nell\'invio del messaggio.', 'galleria')); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <!-- Contact Form -->
                                <form class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate aria-label="<?php _e('Form di contatto della galleria', 'galleria'); ?>">
                                    <?php wp_nonce_field('galleria_contact_form', 'contact_nonce'); ?>
                                    <input type="hidden" name="action" value="galleria_contact_form">
                                    
                                    <div class="form-group">
                                        <label for="contact_name"><?php _e('Nome *', 'galleria'); ?></label>
                                        <input type="text" id="contact_name" name="contact_name" required 
                                               class="form-control" placeholder="<?php _e('Il tuo nome', 'galleria'); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_email"><?php _e('Email *', 'galleria'); ?></label>
                                        <input type="email" id="contact_email" name="contact_email" required 
                                               class="form-control" placeholder="<?php _e('tua@email.com', 'galleria'); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_phone"><?php _e('Telefono', 'galleria'); ?></label>
                                        <input type="tel" id="contact_phone" name="contact_phone" 
                                               class="form-control" placeholder="<?php _e('Il tuo numero di telefono', 'galleria'); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_subject"><?php _e('Oggetto *', 'galleria'); ?></label>
                                        <select id="contact_subject" name="contact_subject" required class="form-control">
                                            <option value=""><?php _e('Seleziona un oggetto', 'galleria'); ?></option>
                                            <option value="general"><?php _e('Richiesta Generale', 'galleria'); ?></option>
                                            <option value="exhibition"><?php _e('Informazioni Mostre', 'galleria'); ?></option>
                                            <option value="artist"><?php _e('Informazioni Artisti', 'galleria'); ?></option>
                                            <option value="press"><?php _e('Stampa e Media', 'galleria'); ?></option>
                                            <option value="visit"><?php _e('Pianificazione Visita', 'galleria'); ?></option>
                                            <option value="other"><?php _e('Altro', 'galleria'); ?></option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_message"><?php _e('Messaggio *', 'galleria'); ?></label>
                                        <textarea id="contact_message" name="contact_message" required 
                                                  class="form-control" rows="5" 
                                                  placeholder="<?php _e('Il tuo messaggio...', 'galleria'); ?>"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="contact_privacy" required>
                                            <span class="checkmark"></span>
                                            <?php 
                                            echo sprintf(
                                                __('Acconsento al trattamento dei miei dati personali in conformità con la %s', 'galleria'),
                                                '<a href="#" class="underline">privacy policy</a>'
                                            ); 
                                            ?>
                                        </label>
                                    </div>
                                    
                                    <button type="submit" class="btn-submit">
                                        <?php _e('Invia Messaggio', 'galleria'); ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="contact-info-section">
                            <!-- General Information -->
                            <div class="info-card">
                                <h3><?php _e('Informazioni Galleria', 'galleria'); ?></h3>
                                
                                <div class="space-y-4">
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <strong><?php _e('Email:', 'galleria'); ?></strong>
                                            <?php $email = get_theme_mod('galleria_email', 'catanzaroepartners@gmail.com'); ?>
                                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <strong><?php _e('Telefono:', 'galleria'); ?></strong>
                                            <?php $phone = get_theme_mod('galleria_phone', '+39 327 167 7871'); ?>
                                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <strong><?php _e('Orari:', 'galleria'); ?></strong>
                                            <span><?php echo esc_html(get_theme_mod('galleria_hours', 'Martedì–Sabato: 10:00–18:00')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Locations -->
                            <div class="locations-section">
                                <!-- Montevergini Location -->
                                <div class="location-card">
                                    <h3><?php _e('Sede Montevergini', 'galleria'); ?></h3>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <?php $address1 = get_theme_mod('galleria_address_1', 'Via Montevergini 3, Palermo'); ?>
                                            <p><?php echo esc_html($address1); ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Corso Vittorio Emanuele Location -->
                                <div class="location-card">
                                    <h3><?php _e('Sede Corso Vittorio Emanuele', 'galleria'); ?></h3>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <?php $address2 = get_theme_mod('galleria_address_2', 'Corso Vittorio Emanuele 383, Palermo'); ?>
                                            <p><?php echo esc_html($address2); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Directions -->
                            <div class="directions-card">
                                <h3><?php _e('Come Raggiungerci', 'galleria'); ?></h3>
                                <p>
                                    <?php echo esc_html(get_theme_mod('galleria_directions_text', __('La galleria è facilmente raggiungibile con i mezzi pubblici e si trova nel centro storico di Palermo.', 'galleria'))); ?>
                                </p>
                                <?php
                                $map_query = urlencode(get_theme_mod('galleria_location_1_name', 'Via Montevergini 3') . ', ' . get_theme_mod('galleria_city', 'Palermo'));
                                ?>
                                <a href="https://maps.google.com/?q=<?php echo $map_query; ?>" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="directions-link">
                                    <?php _e('Apri in Google Maps', 'galleria'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Map Section -->
            <section class="map-section">
                <div class="container py-16">
                    <div class="text-center mb-16">
                        <h2><?php _e('Dove Trovarci', 'galleria'); ?></h2>
                        <p class="hero-subtitle"><?php echo esc_html(get_theme_mod('galleria_directions_text', __('La galleria è facilmente raggiungibile con i mezzi pubblici nel centro storico di Palermo', 'galleria'))); ?></p>
                    </div>
                    
                    <!-- Interactive Map -->
                    <div class="map-container">
                            <!-- Map -->
                            <div>
                                <div class="map-embed">
                                        <iframe 
                                            src="<?php echo esc_url(galleria_get_maps_embed_url()); ?>" 
                                            width="100%" 
                                            height="100%" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            loading="lazy" 
                                            referrerpolicy="no-referrer-when-downgrade"
                                            title="<?php printf(__('Mappa delle sedi della %s', 'galleria'), esc_attr(get_theme_mod('galleria_name', 'Galleria Adalberto Catanzaro'))); ?>">
                                        </iframe>
                                    </div>
                                </div>
                                
                            <!-- Quick Info -->
                            <div>
                                <h3><?php _e('Le Nostre Sedi', 'galleria'); ?></h3>
                                
                                <div class="space-y-4">
                                        <!-- Sede 1 -->
                                        <div class="location-card">
                                            <div class="flex items-start gap-3">
                                                <div class="location-marker">1</div>
                                                <div>
                                                    <h4><?php _e('Sede Montevergini', 'galleria'); ?></h4>
                                                    <p><?php echo esc_html(get_theme_mod('galleria_address_1', 'Via Montevergini 3, Palermo')); ?></p>
                                                    <a href="https://maps.google.com/?q=<?php echo urlencode(get_theme_mod('galleria_address_1', 'Via Montevergini 3, Palermo')); ?>" 
                                                       target="_blank" rel="noopener noreferrer">
                                                        <?php _e('Apri in Google Maps', 'galleria'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Sede 2 -->
                                        <div class="location-card">
                                            <div class="flex items-start gap-3">
                                                <div class="location-marker">2</div>
                                                <div>
                                                    <h4><?php _e('Sede Corso Vittorio Emanuele', 'galleria'); ?></h4>
                                                    <p><?php echo esc_html(get_theme_mod('galleria_address_2', 'Corso Vittorio Emanuele 383, Palermo')); ?></p>
                                                    <a href="https://maps.google.com/?q=<?php echo urlencode(get_theme_mod('galleria_address_2', 'Corso Vittorio Emanuele 383, Palermo')); ?>" 
                                                       target="_blank" rel="noopener noreferrer">
                                                        <?php _e('Apri in Google Maps', 'galleria'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Info -->
                                        <div class="map-info">
                                            <p>
                                                <strong><?php _e('Orari:', 'galleria'); ?></strong><br>
                                                <?php echo esc_html(get_theme_mod('galleria_hours', 'Martedì–Sabato: 10:00–18:00')); ?>
                                            </p>
                                            <p>
                                                <strong><?php _e('Telefono:', 'galleria'); ?></strong><br>
                                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('galleria_phone', '+39 327 167 7871'))); ?>">
                                                    <?php echo esc_html(get_theme_mod('galleria_phone', '+39 327 167 7871')); ?>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Additional Content -->
            <?php if (get_the_content()) : ?>
                <section class="additional-content py-16">
                    <div class="container">
                        <div class="max-w-4xl mx-auto prose prose-lg">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</main>

<style>
/* Contact Page - Consistent with site design */

/* Hero Section */
.contact-hero {
    margin-bottom: 4rem;
}

.hero-subtitle {
    font-size: 1.125rem;
    font-weight: 300;
    color: #6b7280;
    margin-top: 1rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Main Layout */
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: start;
}

/* Form Section */
.form-container {
    margin-bottom: 4rem;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-size: 0.875rem;
    font-weight: 300;
    color: #111827;
}

.form-control {
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0;
    font-size: 0.875rem;
    font-weight: 300;
    font-family: inherit;
    background: white;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #111827;
}

.form-control::placeholder {
    color: #9ca3af;
    font-weight: 300;
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

/* Checkbox */
.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 300;
    line-height: 1.4;
    cursor: pointer;
}

/* Submit Button - consistent with site */
.btn-submit {
    background-color: #111827;
    color: white;
    padding: 1rem 2rem;
    border: none;
    font-size: 0.875rem;
    font-weight: 300;
    cursor: pointer;
    transition: all 0.3s ease;
    align-self: flex-start;
}

.btn-submit:hover {
    background-color: #374151;
}

/* Info Section */
.info-card {
    margin-bottom: 3rem;
}

.contact-details {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.contact-icon {
    color: #6b7280;
    margin-top: 0.125rem;
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

.contact-item div:last-child {
    flex: 1;
}

.contact-item strong {
    display: block;
    font-size: 0.875rem;
    font-weight: 300;
    color: #111827;
    margin-bottom: 0.25rem;
}

.contact-item a {
    color: #6b7280;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 300;
    transition: color 0.3s ease;
}

.contact-item a:hover {
    color: #111827;
}

.contact-item span {
    font-size: 0.875rem;
    font-weight: 300;
    color: #6b7280;
}

/* Locations */
.locations-section {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin-bottom: 3rem;
}

.location-card {
    padding-bottom: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.location-card:last-child {
    border-bottom: none;
}

/* Directions */
.directions-card p {
    margin-bottom: 1rem;
}

.directions-link {
    font-size: 0.875rem;
    font-weight: 300;
    color: #111827;
    text-decoration: underline;
    transition: color 0.3s ease;
}

.directions-link:hover {
    color: #6b7280;
}

/* Map Section - Redesigned */
.map-section {
    background: #f9fafb;
}

.map-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 0;
    background: white;
    box-shadow: none;
    border-radius: 0;
}

.map-embed {
height: 100%;
    min-height: 500px;
    position: relative;
}

.map-embed iframe {
    width: 100%;
    height: 100%;
}

.map-container > div:last-child {
    padding: 3rem;
    background: #f9fafb;
    border-left: 1px solid #e5e7eb;
}

.location-marker {
    background-color: #111827;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 500;
    flex-shrink: 0;
}

/* Form Messages */
.form-message {
    padding: 1rem;
    margin-bottom: 2rem;
    font-size: 0.875rem;
    font-weight: 300;
}

.form-message.success {
    background-color: #f0fdf4;
    color: #166534;
    border-left: 4px solid #22c55e;
}

.form-message.error {
    background-color: #fef2f2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
}

/* Responsive */
@media (max-width: 1024px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .map-container {
        grid-template-columns: 1fr;
    }
    
    .map-container > div:last-child {
        border-left: none;
        border-top: 1px solid #e5e7eb;
        padding: 2rem;
    }
    
    .map-embed {
        min-height: 300px;
    }
}

@media (max-width: 640px) {
    .container {
        padding: 0 1rem;
    }
    
    .contact-grid {
        gap: 2rem;
    }
    
    .map-container > div:last-child {
        padding: 1.5rem;
    }
}

/* Additional Utility Classes for consistency */
.py-16 {
    padding-top: 4rem;
    padding-bottom: 4rem;
}

.mb-16 {
    margin-bottom: 4rem;
}

.text-center {
    text-align: center;
}

.space-y-4 > * + * {
    margin-top: 1rem;
}

/* Map Info Section */
.map-info {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
}

.map-info p {
    margin-bottom: 1rem;
    font-size: 0.875rem;
    font-weight: 300;
    color: #6b7280;
}

.map-info strong {
    color: #111827;
    font-weight: 300;
}

.map-info a {
    color: #6b7280;
    text-decoration: none;
    transition: color 0.3s ease;
}

.map-info a:hover {
    color: #111827;
}

/* Loading Animation for Form */
.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-submit:disabled::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 16px;
    height: 16px;
    margin: -8px 0 0 -8px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form enhancement
    const form = document.querySelector('.contact-form');
    const submitBtn = form.querySelector('.btn-submit');
    const originalText = submitBtn.textContent;
    
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.textContent = '<?php _e("Invio in corso...", "galleria"); ?>';
        });
        
        // Re-enable on error (if user stays on page)
        setTimeout(function() {
            if (submitBtn.disabled) {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        }, 5000);
    }
    
    // Auto-hide success/error messages
    const messages = document.querySelectorAll('.form-message');
    messages.forEach(function(message) {
        setTimeout(function() {
            message.style.opacity = '0';
            message.style.transform = 'translateY(-20px)';
            setTimeout(function() {
                if (message.parentNode) {
                    message.parentNode.removeChild(message);
                }
            }, 300);
        }, 5000);
    });
    
    // Smooth scroll to form on error
    if (window.location.search.includes('contact=error')) {
        const formSection = document.querySelector('.contact-form-section');
        if (formSection) {
            setTimeout(function() {
                formSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        }
    }
});
</script>

<?php get_footer(); ?>