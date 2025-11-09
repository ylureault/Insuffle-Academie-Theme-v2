/**
 * Frontend JavaScript - Formation Gallery Plugin
 * Initialise la lightbox et les interactions frontend
 */

(function($) {
    'use strict';

    /**
     * Initialisation au chargement du DOM
     */
    $(document).ready(function() {
        initGalleryLightbox();
        initLazyLoading();
    });

    /**
     * Initialise GLightbox pour toutes les galeries
     */
    function initGalleryLightbox() {
        if (typeof GLightbox === 'undefined') {
            console.warn('GLightbox not loaded');
            return;
        }

        // Initialiser une lightbox pour chaque galerie
        $('.fg-gallery').each(function() {
            const galleryId = $(this).attr('id');

            const lightbox = GLightbox({
                selector: `#${galleryId} .glightbox`,
                touchNavigation: true,
                loop: true,
                autoplayVideos: false,
                closeButton: true,
                closeOnOutsideClick: true,
                descPosition: 'bottom',
                skin: 'clean',
                // Paramètres de navigation
                keyboardNavigation: true,
                preload: true,
                // Animations
                openEffect: 'zoom',
                closeEffect: 'fade',
                slideEffect: 'slide',
                // Callbacks
                onOpen: function() {
                    console.log('Gallery opened');
                },
                onClose: function() {
                    console.log('Gallery closed');
                }
            });
        });
    }

    /**
     * Lazy loading pour les images (optionnel, si navigateur ne supporte pas loading="lazy")
     */
    function initLazyLoading() {
        // Vérifier si le navigateur supporte le lazy loading natif
        if ('loading' in HTMLImageElement.prototype) {
            return; // Le navigateur supporte loading="lazy", pas besoin de polyfill
        }

        // Sinon, utiliser Intersection Observer
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            $('.fg-gallery img[loading="lazy"]').each(function() {
                const img = this;
                if (img.dataset.src) {
                    imageObserver.observe(img);
                }
            });
        }
    }

    /**
     * Animation au scroll (optionnel)
     */
    function initScrollAnimations() {
        if ('IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fg-visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            $('.fg-gallery-item').each(function() {
                animationObserver.observe(this);
            });
        }
    }

    // Initialiser les animations au scroll si souhaité
    // initScrollAnimations();

})(jQuery);
