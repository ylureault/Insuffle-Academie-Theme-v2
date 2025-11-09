/**
 * Galerie Formation - Admin Scripts
 */

(function($) {
    'use strict';

    let imageIndex = 1000;
    let currentFrame;

    $(document).ready(function() {
        initSortable();
        initAddImage();
        initChangeImage();
        initRemoveImage();
    });

    /**
     * Initialise le tri des images par glisser-déposer
     */
    function initSortable() {
        $('#gfm-images-sortable').sortable({
            handle: '.gfm-image-handle',
            placeholder: 'gfm-sortable-placeholder',
            axis: 'y',
            opacity: 0.7,
            cursor: 'move',
            update: function() {
                reindexImages();
            }
        });
    }

    /**
     * Ajoute une nouvelle image
     */
    function initAddImage() {
        $('.gfm-add-image').on('click', function(e) {
            e.preventDefault();

            // Créer le media frame
            if (currentFrame) {
                currentFrame.open();
                return;
            }

            currentFrame = wp.media({
                title: gfmAdmin.uploadTitle,
                button: {
                    text: gfmAdmin.uploadButton
                },
                multiple: false
            });

            currentFrame.on('select', function() {
                const attachment = currentFrame.state().get('selection').first().toJSON();

                // Récupérer le template
                const template = $('#gfm-image-template').html();
                const html = template.replace(/\{\{INDEX\}\}/g, imageIndex);

                // Créer un élément temporaire
                const $newItem = $(html);

                // Définir l'ID de l'image
                $newItem.find('.gfm-image-id').val(attachment.id);

                // Définir l'aperçu
                const thumbnailUrl = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                $newItem.find('.gfm-image-preview').html('<img src="' + thumbnailUrl + '" alt="">');

                // Ajouter au DOM
                $('#gfm-images-sortable').append($newItem);

                // Incrémenter l'index
                imageIndex++;

                // Réinitialiser les événements
                initChangeImage();
                initRemoveImage();

                // Scroll vers le nouvel élément
                $('html, body').animate({
                    scrollTop: $newItem.offset().top - 100
                }, 500);
            });

            currentFrame.open();
        });
    }

    /**
     * Change une image existante
     */
    function initChangeImage() {
        $('.gfm-change-image').off('click').on('click', function(e) {
            e.preventDefault();

            const $button = $(this);
            const $item = $button.closest('.gfm-image-item');

            const frame = wp.media({
                title: gfmAdmin.uploadTitle,
                button: {
                    text: gfmAdmin.uploadButton
                },
                multiple: false
            });

            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();

                // Mettre à jour l'ID
                $item.find('.gfm-image-id').val(attachment.id);

                // Mettre à jour l'aperçu
                const thumbnailUrl = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                $item.find('.gfm-image-preview').html('<img src="' + thumbnailUrl + '" alt="">');
            });

            frame.open();
        });
    }

    /**
     * Supprime une image
     */
    function initRemoveImage() {
        $('.gfm-remove-image').off('click').on('click', function(e) {
            e.preventDefault();

            if (confirm(gfmAdmin.confirmDelete)) {
                $(this).closest('.gfm-image-item').slideUp(300, function() {
                    $(this).remove();
                    reindexImages();
                });
            }
        });
    }

    /**
     * Réindexe les images après tri ou suppression
     */
    function reindexImages() {
        $('#gfm-images-sortable .gfm-image-item').each(function(index) {
            $(this).attr('data-index', index);
            $(this).find('input, textarea').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    const newName = name.replace(/gfm_gallery_images\[\d+\]/, 'gfm_gallery_images[' + index + ']');
                    $(this).attr('name', newName);
                }
            });
        });
    }

})(jQuery);
