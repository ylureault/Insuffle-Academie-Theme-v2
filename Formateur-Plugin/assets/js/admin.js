/**
 * Fiche Formateur - Admin Scripts
 */

(function($) {
    'use strict';

    let statIndex = 1000;
    let mediaFrame;

    $(document).ready(function() {
        initPhotoUpload();
        initStats();
    });

    /**
     * Upload de photo
     */
    function initPhotoUpload() {
        // Upload photo
        $('.ffm-upload-photo').on('click', function(e) {
            e.preventDefault();

            if (mediaFrame) {
                mediaFrame.open();
                return;
            }

            mediaFrame = wp.media({
                title: ffmAdmin.uploadTitle,
                button: {
                    text: ffmAdmin.uploadButton
                },
                multiple: false
            });

            mediaFrame.on('select', function() {
                const attachment = mediaFrame.state().get('selection').first().toJSON();

                // Mettre à jour l'ID
                $('#ffm-photo-id').val(attachment.id);

                // Mettre à jour l'aperçu
                const thumbnailUrl = attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
                $('#ffm-photo-preview').html('<img src="' + thumbnailUrl + '" alt="">');

                // Afficher le bouton retirer
                $('.ffm-remove-photo').show();
            });

            mediaFrame.open();
        });

        // Retirer photo
        $('.ffm-remove-photo').on('click', function(e) {
            e.preventDefault();

            if (confirm(ffmAdmin.confirmDelete)) {
                $('#ffm-photo-id').val('');
                $('#ffm-photo-preview').html(
                    '<div class="ffm-photo-placeholder">' +
                    '<span class="dashicons dashicons-format-image"></span>' +
                    '<p>Aucune photo sélectionnée</p>' +
                    '</div>'
                );
                $(this).hide();
            }
        });
    }

    /**
     * Gestion des stats
     */
    function initStats() {
        // Initialiser le tri
        $('#ffm-stats-container').sortable({
            handle: '.ffm-stat-handle',
            placeholder: 'ffm-sortable-placeholder',
            axis: 'y',
            opacity: 0.7,
            cursor: 'move',
            update: function() {
                reindexStats();
            }
        });

        // Ajouter une stat
        $('.ffm-add-stat').on('click', function(e) {
            e.preventDefault();

            const template = $('#ffm-stat-template').html();
            const html = template.replace(/\{\{INDEX\}\}/g, statIndex);

            $('#ffm-stats-container').append(html);

            statIndex++;

            // Réinitialiser les événements
            initRemoveStat();
        });

        // Initialiser les événements de suppression
        initRemoveStat();
    }

    /**
     * Suppression d'une stat
     */
    function initRemoveStat() {
        $('.ffm-remove-stat').off('click').on('click', function(e) {
            e.preventDefault();

            if (confirm(ffmAdmin.confirmDelete)) {
                $(this).closest('.ffm-stat-item').slideUp(300, function() {
                    $(this).remove();
                    reindexStats();
                });
            }
        });
    }

    /**
     * Réindexe les stats après tri ou suppression
     */
    function reindexStats() {
        $('#ffm-stats-container .ffm-stat-item').each(function(index) {
            $(this).attr('data-index', index);
            $(this).find('input').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    const newName = name.replace(/ffm_stats\[\d+\]/, 'ffm_stats[' + index + ']');
                    $(this).attr('name', newName);
                }
            });
        });
    }

})(jQuery);
