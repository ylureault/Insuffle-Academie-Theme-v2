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
        $('#ffm-upload-photo').on('click', function(e) {
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
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            mediaFrame.on('select', function() {
                const attachment = mediaFrame.state().get('selection').first().toJSON();

                // Mettre à jour l'ID
                $('#ffm-photo-id').val(attachment.id);

                // Mettre à jour l'aperçu
                const thumbnailUrl = attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
                $('#ffm-photo-preview-img').replaceWith(
                    '<img id="ffm-photo-preview-img" src="' + thumbnailUrl + '" alt="">'
                );

                // Afficher le bouton retirer
                if ($('#ffm-remove-photo').length === 0) {
                    $('#ffm-upload-photo').after(
                        '<button type="button" class="button button-secondary" id="ffm-remove-photo">' +
                        '<span class="dashicons dashicons-no"></span> ' +
                        ffmAdmin.removePhoto +
                        '</button>'
                    );
                    initRemovePhoto();
                }
            });

            mediaFrame.open();
        });

        initRemovePhoto();
    }

    /**
     * Retirer photo
     */
    function initRemovePhoto() {
        $('#ffm-remove-photo').off('click').on('click', function(e) {
            e.preventDefault();

            if (confirm(ffmAdmin.confirmDelete)) {
                $('#ffm-photo-id').val('');
                $('#ffm-photo-preview-img').replaceWith(
                    '<div id="ffm-photo-preview-img" class="ffm-no-photo">' +
                    '<span class="dashicons dashicons-businessman"></span>' +
                    '<p>Aucune photo</p>' +
                    '</div>'
                );
                $(this).remove();
            }
        });
    }

    /**
     * Gestion des stats
     */
    function initStats() {
        // Initialiser le tri
        $('#ffm-stats-list').sortable({
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

            $('#ffm-stats-list').append(html);

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
        $('#ffm-stats-list .ffm-stat-item').each(function(index) {
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
