/**
 * Main JavaScript file for Galleria Catanzaro theme
 */

(function($) {
    'use strict';

    console.log('🚀 Main JavaScript loaded');

    // DOM Ready
    $(document).ready(function() {
        console.log('🚀 Document ready, initializing functions...');
        
        // Mobile Menu
        initMobileMenu();
        
        // Carousel
        initCarousel();
        
        // Smooth Scrolling
        initSmoothScrolling();
        
        // Image Lazy Loading
        initLazyLoading();
        
        // AJAX Load More (if needed)
        initLoadMore();
        
    });

    /**
     * Mobile Menu Functionality
     */
    function initMobileMenu() {
        console.log('🍔 initMobileMenu called');
        
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('.mobile-nav');
        
        console.log('🍔 Elements found:', {
            mobileToggle: mobileToggle,
            mobileNav: mobileNav
        });
        
        if (mobileToggle && mobileNav) {
            console.log('🍔 Both elements found, setting up menu...');
            
            // Create overlay
            const overlay = document.createElement('div');
            overlay.className = 'mobile-nav-overlay js-ready';
            document.body.appendChild(overlay);
            console.log('🍔 Overlay created and added to body');
            
            // Create a wrapper container to isolate the menu completely
            const menuWrapper = document.createElement('div');
            menuWrapper.className = 'mobile-nav-wrapper';
            menuWrapper.style.cssText = `
                position: fixed !important;
                top: 0 !important;
                right: 0 !important;
                width: 320px !important;
                height: 100vh !important;
                z-index: 999999 !important;
                pointer-events: none !important;
                background: transparent !important;
            `;
            
            // Move the mobile nav inside the wrapper
            document.body.appendChild(menuWrapper);
            menuWrapper.appendChild(mobileNav);
            
            // Allow pointer events on the menu when visible
            mobileNav.style.pointerEvents = 'auto';
            
            console.log('🍔 Menu wrapper created and menu moved inside');
            
            // Add js-ready class to mobile nav and ensure it's closed initially
            console.log('🍔 Menu classes BEFORE setup:', mobileNav.classList.toString());
            mobileNav.classList.add('js-ready');
            mobileNav.classList.remove('open', 'menu-visible'); // Remove both classes
            overlay.classList.remove('open', 'overlay-visible'); // Remove both classes
            mobileToggle.setAttribute('aria-expanded', 'false');
            console.log('🍔 Menu classes AFTER setup:', mobileNav.classList.toString());
            
            // Watch for changes to the mobile nav classes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        console.log('🔍 Class changed on mobile-nav:', mobileNav.classList.toString());
                        if (mobileNav.classList.contains('open')) {
                            console.log('⚠️ SOMEONE ADDED "open" CLASS!');
                            console.trace('Stack trace of who added open class');
                        }
                    }
                });
            });
            observer.observe(mobileNav, { attributes: true, attributeFilter: ['class'] });
            
            mobileToggle.addEventListener('click', function(e) {
                console.log('🍔 Mobile toggle clicked!');
                e.preventDefault();
                
                // Use our own class instead of conflicting 'open'
                const isOpen = mobileNav.classList.contains('menu-visible');
                console.log('🍔 Menu is currently:', isOpen ? 'open' : 'closed');
                
                if (isOpen) {
                    console.log('🍔 Closing menu...');
                    // First hide content immediately
                    const content = mobileNav.querySelector('.mobile-nav-content');
                    if (content) content.style.opacity = '0';
                    
                    // Then hide menu after short delay to allow content to fade
                    setTimeout(() => {
                        mobileNav.classList.remove('menu-visible', 'open'); // Remove both
                        overlay.classList.remove('overlay-visible', 'open'); // Remove both
                        menuWrapper.style.pointerEvents = 'none';
                        mobileToggle.setAttribute('aria-expanded', 'false');
                    }, 100);
                } else {
                    console.log('🍔 Opening menu...');
                    mobileNav.classList.add('menu-visible');
                    overlay.classList.add('overlay-visible');
                    menuWrapper.style.pointerEvents = 'auto';
                    mobileToggle.setAttribute('aria-expanded', 'true');
                    
                    // Show content after menu is positioned
                    setTimeout(() => {
                        const content = mobileNav.querySelector('.mobile-nav-content');
                        if (content) content.style.opacity = '1';
                    }, 50);
                }
                
                console.log('🍔 Menu classes after toggle:', mobileNav.classList.toString());
            });
            
            // Close on overlay click
            overlay.addEventListener('click', function() {
                console.log('🍔 Overlay clicked, closing menu');
                // First hide content immediately
                const content = mobileNav.querySelector('.mobile-nav-content');
                if (content) content.style.opacity = '0';
                
                // Then hide menu after short delay
                setTimeout(() => {
                    mobileNav.classList.remove('menu-visible', 'open');
                    overlay.classList.remove('overlay-visible', 'open');
                    menuWrapper.style.pointerEvents = 'none';
                    mobileToggle.setAttribute('aria-expanded', 'false');
                }, 100);
            });
            
            // Close on menu link click
            const mobileMenuLinks = mobileNav.querySelectorAll('a');
            console.log('🍔 Found', mobileMenuLinks.length, 'menu links');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    console.log('🍔 Menu link clicked, closing menu');
                    // First hide content immediately
                    const content = mobileNav.querySelector('.mobile-nav-content');
                    if (content) content.style.opacity = '0';
                    
                    // Then hide menu after short delay
                    setTimeout(() => {
                        mobileNav.classList.remove('menu-visible', 'open');
                        overlay.classList.remove('overlay-visible', 'open');
                        menuWrapper.style.pointerEvents = 'none';
                        mobileToggle.setAttribute('aria-expanded', 'false');
                    }, 100);
                });
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                // Check if menu is open
                if (mobileNav.classList.contains('menu-visible')) {
                    // Check if click is outside menu and not on toggle button
                    if (!mobileNav.contains(e.target) && !mobileToggle.contains(e.target)) {
                        console.log('🍔 Clicked outside menu, closing...');
                        // First hide content immediately
                        const content = mobileNav.querySelector('.mobile-nav-content');
                        if (content) content.style.opacity = '0';
                        
                        // Then hide menu after short delay
                        setTimeout(() => {
                            mobileNav.classList.remove('menu-visible', 'open');
                            overlay.classList.remove('overlay-visible', 'open');
                            menuWrapper.style.pointerEvents = 'none';
                            mobileToggle.setAttribute('aria-expanded', 'false');
                        }, 100);
                    }
                }
            });
            
            // Close menu with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileNav.classList.contains('menu-visible')) {
                    console.log('🍔 Escape key pressed, closing menu...');
                    // First hide content immediately
                    const content = mobileNav.querySelector('.mobile-nav-content');
                    if (content) content.style.opacity = '0';
                    
                    // Then hide menu after short delay
                    setTimeout(() => {
                        mobileNav.classList.remove('menu-visible', 'open');
                        overlay.classList.remove('overlay-visible', 'open');
                        menuWrapper.style.pointerEvents = 'none';
                        mobileToggle.setAttribute('aria-expanded', 'false');
                    }, 100);
                }
            });
            
            console.log('🍔 Mobile menu setup complete!');
        } else {
            console.log('🍔 ERROR: Missing elements for mobile menu');
        }
    }

    /**
     * Homepage Carousel
     */
    function initCarousel() {
        const carousel = document.getElementById('carousel-slides');
        
        if (!carousel) return;
        
        const slides = carousel.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.querySelector('.carousel-prev');
        const nextBtn = document.querySelector('.carousel-next');
        
        let currentSlide = 0;
        const totalSlides = slides.length;
        
        if (totalSlides <= 1) return; // Don't init if only one slide
        
        function showSlide(index) {
            // Remove active class from all slides and dots
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            // Add active class to current slide and dot
            if (slides[index]) {
                slides[index].classList.add('active');
            }
            if (dots[index]) {
                dots[index].classList.add('active');
            }
            
            currentSlide = index;
        }
        
        function nextSlide() {
            const next = (currentSlide + 1) % totalSlides;
            showSlide(next);
        }
        
        function prevSlide() {
            const prev = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(prev);
        }
        
        // Event listeners
        if (nextBtn) {
            nextBtn.addEventListener('click', nextSlide);
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', prevSlide);
        }
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });
        
        // Auto-play
        let autoPlayInterval;
        
        function startAutoPlay() {
            autoPlayInterval = setInterval(nextSlide, 3000);
        }
        
        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }
        
        // Start auto-play
        startAutoPlay();
        
        // Pause on hover
        carousel.addEventListener('mouseenter', stopAutoPlay);
        carousel.addEventListener('mouseleave', startAutoPlay);
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        });
    }

    /**
     * Smooth Scrolling for anchor links
     */
    function initSmoothScrolling() {
        // Smooth scroll for skip links and anchor links
        $('a[href^="#"]').click(function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500);
            }
        });
        
        // Scroll to top button functionality (if it exists)
        $('.scroll-to-top').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        });
    }

    /**
     * Lazy Loading for images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.add('loaded');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Load More functionality for archives
     */
    function initLoadMore() {
        $('.load-more-button').on('click', function(e) {
            e.preventDefault();
            
            const button = $(this);
            const page = button.data('page') || 1;
            const maxPages = button.data('max-pages') || 1;
            const postType = button.data('post-type') || 'post';
            const container = $('.posts-grid, .artists-grid, .exhibitions-grid');
            
            if (page >= maxPages) {
                button.hide();
                return;
            }
            
            button.addClass('loading').text('Loading...');
            
            $.ajax({
                url: galleria_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'galleria_load_more',
                    page: page + 1,
                    post_type: postType,
                    nonce: galleria_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        container.append(response.data.html);
                        button.data('page', page + 1);
                        
                        if (page + 1 >= maxPages) {
                            button.hide();
                        }
                    } else {
                        button.hide();
                    }
                },
                error: function() {
                    button.hide();
                },
                complete: function() {
                    button.removeClass('loading').text('Load More');
                }
            });
        });
    }

    /**
     * WooCommerce Cart Updates
     */
    if (typeof wc_add_to_cart_params !== 'undefined') {
        $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
            // Update cart count in header
            updateCartCount();
        });
    }
    
    function updateCartCount() {
        $.ajax({
            url: galleria_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'galleria_get_cart_count',
                nonce: galleria_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    const cartBadge = $('.cart-toggle .count-badge');
                    const count = response.data.count;
                    
                    if (count > 0) {
                        cartBadge.text(count).show();
                    } else {
                        cartBadge.hide();
                    }
                }
            }
        });
    }

    /**
     * Search functionality enhancements
     */
    function initSearch() {
        const searchForms = document.querySelectorAll('.search-form');
        
        searchForms.forEach(form => {
            const input = form.querySelector('input[type="search"]');
            
            if (input) {
                // Add autocomplete functionality here if needed
                input.addEventListener('focus', function() {
                    this.setAttribute('placeholder', 'Search artists, exhibitions...');
                });
                
                input.addEventListener('blur', function() {
                    this.setAttribute('placeholder', 'Search...');
                });
            }
        });
    }

    /**
     * Accessibility enhancements
     */
    function initAccessibility() {
        // Focus management for mobile menu
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('.mobile-nav');
        
        if (mobileToggle && mobileNav) {
            mobileToggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        }
        
        // Skip to content link
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.focus();
                    target.scrollIntoView();
                }
            });
        }
    }

    // Initialize on DOM ready
    $(document).ready(function() {
        initSearch();
        initAccessibility();
    });

})(jQuery);