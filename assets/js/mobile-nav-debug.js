/**
 * Mobile Navigation Functionality - DEBUG VERSION
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Mobile nav script loaded');
    
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNav = document.querySelector('.mobile-nav');
    const closeButton = document.querySelector('.mobile-nav-close');
    
    console.log('Elements found:', {
        mobileToggle: !!mobileToggle,
        mobileNav: !!mobileNav,
        closeButton: !!closeButton
    });
    
    if (!mobileToggle || !mobileNav) {
        console.error('Required mobile navigation elements not found');
        return;
    }

    // Function to get overlay (might be created by main.js later)
    function getOverlay() {
        return document.querySelector('.mobile-nav-overlay');
    }
    
    // Function to get menu wrapper (created by main.js)
    function getMenuWrapper() {
        return document.querySelector('.mobile-nav-wrapper');
    }

    function openMenu() {
        console.log('Opening menu');
        mobileNav.classList.add('menu-visible');
        overlay.classList.add('open');
        mobileToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        console.log('Closing menu via close button');
        
        const overlay = getOverlay();
        const menuWrapper = getMenuWrapper();
        
        if (!overlay) {
            console.warn('Overlay not found when trying to close');
        }
        if (!menuWrapper) {
            console.warn('Menu wrapper not found when trying to close');
        }
        
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
            console.log('Close button clicked');
            e.preventDefault();
            closeMenu();
        });
    } else {
        console.error('Close button not found!');
    }

    // Close on overlay click (delegate to main.js overlay handler)
    // Don't add our own overlay click handler to avoid conflicts
    
    // Close on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileNav.classList.contains('menu-visible')) {
            console.log('Escape pressed');
            closeMenu();
        }
    });
});