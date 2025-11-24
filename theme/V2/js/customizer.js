/**
 * Customizer Live Preview
 *
 * Met à jour l'aperçu en direct lors de la modification des options du CTA Formations
 */

(function($) {
    'use strict';

    // Titre du CTA
    wp.customize('insuffle_formation_cta_title', function(value) {
        value.bind(function(newval) {
            $('.formation-cta-title').text(newval);
        });
    });

    // Sous-titre du CTA
    wp.customize('insuffle_formation_cta_subtitle', function(value) {
        value.bind(function(newval) {
            $('.formation-cta-subtitle').text(newval);
        });
    });

    // Texte bouton 1
    wp.customize('insuffle_formation_cta_button1_text', function(value) {
        value.bind(function(newval) {
            $('.formation-cta-btn-primary').text(newval);
        });
    });

    // Texte bouton 2
    wp.customize('insuffle_formation_cta_button2_text', function(value) {
        value.bind(function(newval) {
            $('.formation-cta-btn-secondary').text(newval);
        });
    });

    // Informations complémentaires
    wp.customize('insuffle_formation_cta_info', function(value) {
        value.bind(function(newval) {
            $('.formation-cta-info').text(newval);
        });
    });

})(jQuery);
