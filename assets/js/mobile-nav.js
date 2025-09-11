/**
 * Mobile Navigation Functionality
 * Handles mobile menu close button and accessibility
 */

document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNav = document.querySelector('.mobile-nav');
    const closeButton = document.querySelector('.mobile-nav-close');
    
    if (!mobileToggle || !mobileNav) {
        console.warn('Mobile navigation elements not found');
        return;
    }

    // Function to get overlay (created by main.js)
    function getOverlay() {
        return document.querySelector('.mobile-nav-overlay');
    }
    
    // Function to get menu wrapper (created by main.js)
    function getMenuWrapper() {
        return document.querySelector('.mobile-nav-wrapper');
    }

    function closeMenu() {
        const overlay = getOverlay();
        const menuWrapper = getMenuWrapper();
        
        // Use the exact same logic as main.js
        const content = mobileNav.querySelector('.mobile-nav-content');
        if (content) content.style.opacity = '0';
        
        // Then hide menu after short delay
        setTimeout(() => {
            mobileNav.classList.remove('menu-visible', 'open');
            if (overlay) {
                overlay.classList.remove('overlay-visible', 'open');
            }
            if (menuWrapper) {
                menuWrapper.style.pointerEvents = 'none';
            }
            mobileToggle.setAttribute('aria-expanded', 'false');
            
            // Reset content opacity for next time
            if (content) content.style.opacity = '';
        }, 100);
    }

    // DON'T handle toggle - main.js already does this
    // We only handle the close button and other close methods

    // Close button
    if (closeButton) {
        closeButton.addEventListener('click', function(e) {
            e.preventDefault();
            closeMenu();
        });
    }

    // Close on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileNav.classList.contains('menu-visible')) {
            closeMenu();
        }
    });

    // Smooth scroll for back to top button
    const scrollToTopBtn = document.querySelector('.scroll-to-top');
    if (scrollToTopBtn) {
        scrollToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Show/hide scroll to top button based on scroll position
        let scrollTimer;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function() {
                if (window.scrollY > 500) {
                    scrollToTopBtn.style.opacity = '1';
                    scrollToTopBtn.style.pointerEvents = 'auto';
                } else {
                    scrollToTopBtn.style.opacity = '0.6';
                    scrollToTopBtn.style.pointerEvents = 'auto';
                }
            }, 100);
        });
    }
});