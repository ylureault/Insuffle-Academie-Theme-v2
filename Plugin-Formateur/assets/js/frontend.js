/**
 * Frontend JavaScript - Plugin Formateur
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Animations au scroll (optionnel)
        initScrollAnimations();
    });

    /**
     * Animations au scroll
     */
    function initScrollAnimations() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('formateur-visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            $('.formateur-highlight-box').each(function() {
                observer.observe(this);
            });
        }
    }

})(jQuery);
