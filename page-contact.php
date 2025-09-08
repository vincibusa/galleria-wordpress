<?php
/**
 * Template for Contact Page
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('contact-page'); ?>>
            <!-- Contact Hero Section -->
            <section class="contact-hero py-16">
                <div class="container">
                    <div class="max-w-4xl mx-auto text-center">
                        <h1 class="text-4xl font-light mb-6"><?php the_title(); ?></h1>
                        <?php if (has_excerpt()) : ?>
                            <div class="text-xl text-gray-600 font-light">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Contact Content -->
            <section class="contact-content py-16 bg-gray-50">
                <div class="container">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Contact Form -->
                        <div class="contact-form-section">
                            <div class="bg-white p-8 rounded-lg shadow-sm">
                                <h2 class="text-2xl font-light mb-6"><?php _e('Get in Touch', 'galleria'); ?></h2>
                                
                                <!-- Contact Form -->
                                <form class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                                    <?php wp_nonce_field('galleria_contact_form', 'contact_nonce'); ?>
                                    <input type="hidden" name="action" value="galleria_contact_form">
                                    
                                    <div class="form-group">
                                        <label for="contact_name"><?php _e('Name *', 'galleria'); ?></label>
                                        <input type="text" id="contact_name" name="contact_name" required 
                                               class="form-control" placeholder="<?php _e('Your name', 'galleria'); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_email"><?php _e('Email *', 'galleria'); ?></label>
                                        <input type="email" id="contact_email" name="contact_email" required 
                                               class="form-control" placeholder="<?php _e('your@email.com', 'galleria'); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_phone"><?php _e('Phone', 'galleria'); ?></label>
                                        <input type="tel" id="contact_phone" name="contact_phone" 
                                               class="form-control" placeholder="<?php _e('Your phone number', 'galleria'); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_subject"><?php _e('Subject *', 'galleria'); ?></label>
                                        <select id="contact_subject" name="contact_subject" required class="form-control">
                                            <option value=""><?php _e('Select a subject', 'galleria'); ?></option>
                                            <option value="general"><?php _e('General Inquiry', 'galleria'); ?></option>
                                            <option value="exhibition"><?php _e('Exhibition Information', 'galleria'); ?></option>
                                            <option value="artist"><?php _e('Artist Information', 'galleria'); ?></option>
                                            <option value="press"><?php _e('Press & Media', 'galleria'); ?></option>
                                            <option value="visit"><?php _e('Visit Planning', 'galleria'); ?></option>
                                            <option value="other"><?php _e('Other', 'galleria'); ?></option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_message"><?php _e('Message *', 'galleria'); ?></label>
                                        <textarea id="contact_message" name="contact_message" required 
                                                  class="form-control" rows="5" 
                                                  placeholder="<?php _e('Your message...', 'galleria'); ?>"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="contact_privacy" required>
                                            <span class="checkmark"></span>
                                            <?php 
                                            echo sprintf(
                                                __('I agree to the processing of my personal data in accordance with the %s', 'galleria'),
                                                '<a href="#" class="underline">privacy policy</a>'
                                            ); 
                                            ?>
                                        </label>
                                    </div>
                                    
                                    <button type="submit" class="btn-submit">
                                        <?php _e('Send Message', 'galleria'); ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="contact-info-section">
                            <!-- General Information -->
                            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                                <h3 class="text-xl font-light mb-4"><?php _e('Gallery Information', 'galleria'); ?></h3>
                                
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
                                            <a href="mailto:catanzaroepartners@gmail.com">catanzaroepartners@gmail.com</a>
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
                                            <strong><?php _e('Phone:', 'galleria'); ?></strong>
                                            <a href="tel:+393271677871">+39 327 167 7871</a>
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
                                            <strong><?php _e('Hours:', 'galleria'); ?></strong>
                                            <span>Martedì–Sabato: 10:00–18:00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Locations -->
                            <div class="locations-grid space-y-6">
                                <!-- Montevergini Location -->
                                <div class="bg-white p-6 rounded-lg shadow-sm">
                                    <h3 class="text-lg font-medium mb-3"><?php _e('Sede Montevergini', 'galleria'); ?></h3>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p>Via Montevergini 3</p>
                                            <p>90133 Palermo</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Corso Vittorio Emanuele Location -->
                                <div class="bg-white p-6 rounded-lg shadow-sm">
                                    <h3 class="text-lg font-medium mb-3"><?php _e('Sede Corso Vittorio Emanuele', 'galleria'); ?></h3>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p>Corso Vittorio Emanuele 383</p>
                                            <p>90133 Palermo</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Directions -->
                            <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
                                <h3 class="text-lg font-medium mb-3"><?php _e('Directions', 'galleria'); ?></h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    <?php _e('The gallery is easily accessible by public transport and is located in the historic center of Palermo.', 'galleria'); ?>
                                </p>
                                <a href="https://maps.google.com/?q=Via+Montevergini+3,+Palermo" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center text-sm hover:underline">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    <?php _e('Open in Google Maps', 'galleria'); ?>
                                </a>
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
/* Contact Form Styles */
.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}

.form-control {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.form-control::placeholder {
    color: #9ca3af;
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
    line-height: 1.4;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    margin: 0;
    width: 1rem;
    height: 1rem;
    flex-shrink: 0;
}

/* Submit Button */
.btn-submit {
    background-color: #111827;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-submit:hover {
    background-color: #374151;
}

.btn-submit:disabled {
    background-color: #9ca3af;
    cursor: not-allowed;
}

/* Contact Items */
.contact-item {
    display: flex;
    gap: 0.75rem;
    align-items: flex-start;
}

.contact-icon {
    color: #6b7280;
    margin-top: 0.125rem;
}

.contact-item strong {
    display: block;
    font-size: 0.875rem;
    color: #374151;
    margin-bottom: 0.25rem;
}

.contact-item a {
    color: #111827;
    text-decoration: none;
    font-size: 0.875rem;
}

.contact-item a:hover {
    text-decoration: underline;
}

.contact-item span {
    font-size: 0.875rem;
    color: #6b7280;
}

/* Responsive */
@media (max-width: 1024px) {
    .contact-content .grid {
        grid-template-columns: 1fr;
    }
    
    .contact-form-section {
        order: 2;
    }
    
    .contact-info-section {
        order: 1;
        margin-bottom: 2rem;
    }
}

/* Form validation styles */
.form-control:invalid:not(:focus):not(:placeholder-shown) {
    border-color: #ef4444;
}

.form-control:valid:not(:focus):not(:placeholder-shown) {
    border-color: #10b981;
}

/* Success/Error messages */
.form-message {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
}

.form-message.success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.form-message.error {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}
</style>

<?php get_footer(); ?>