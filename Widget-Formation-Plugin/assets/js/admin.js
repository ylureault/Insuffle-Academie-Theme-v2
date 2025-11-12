/**
 * Widget Formation - Admin Scripts
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Améliorer l'UX des checkboxes - clic sur le label active la checkbox
        $('.wfm-formation-item, .wfm-checkbox').on('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                var $checkbox = $(this).find('input[type="checkbox"]');
                $checkbox.prop('checked', !$checkbox.prop('checked'));
            }
        });

        // Compteur de formations sélectionnées
        function updateSelectionCount() {
            var count = $('.wfm-formations-list input[type="checkbox"]:checked').length;
            var $counter = $('#wfm-selection-count');

            if ($counter.length === 0) {
                $counter = $('<div id="wfm-selection-count" style="margin-top: 15px; padding: 10px; background: #8E2183; color: white; border-radius: 6px; text-align: center; font-weight: 700;"></div>');
                $('.wfm-formations-list').after($counter);
            }

            if (count === 0) {
                $counter.html('⚠️ Aucune formation sélectionnée');
                $counter.css('background', '#dc3232');
            } else if (count === 1) {
                $counter.html('✅ ' + count + ' formation sélectionnée');
                $counter.css('background', '#8E2183');
            } else {
                $counter.html('✅ ' + count + ' formations sélectionnées');
                $counter.css('background', '#8E2183');
            }
        }

        // Initialiser le compteur
        if ($('.wfm-formations-list').length > 0) {
            updateSelectionCount();

            $('.wfm-formations-list input[type="checkbox"]').on('change', function() {
                updateSelectionCount();
            });
        }

        // Message de confirmation avant publication
        $('#publish').on('click', function(e) {
            var count = $('.wfm-formations-list input[type="checkbox"]:checked').length;

            if (count === 0) {
                e.preventDefault();
                alert('⚠️ Attention : Aucune formation n\'est sélectionnée.\n\nVeuillez sélectionner au moins une formation avant de publier le widget.');
                return false;
            }
        });
    });

})(jQuery);
