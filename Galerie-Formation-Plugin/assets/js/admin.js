/**
 * Galerie Formation - Admin Scripts
 */

(function($) {
    'use strict';

    let imageIndex = 1000;
    let mediaFrame;

    $(document).ready(function() {
        initSortable();
        initAddImages();
        initRemoveImage();
    });

    /**
     * Initialise le tri des images par glisser-déposer
     */
    function initSortable() {
        $('#gfm-images-list').sortable({
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
     * Ajoute de nouvelles images (sélection multiple)
     */
    function initAddImages() {
        $('.gfm-add-images').on('click', function(e) {
            e.preventDefault();

            // Créer le media frame avec sélection multiple
            if (mediaFrame) {
                mediaFrame.open();
                return;
            }

            mediaFrame = wp.media({
                title: gfmAdmin.uploadTitle,
                button: {
                    text: gfmAdmin.uploadButton
                },
                multiple: true, // Permettre sélection multiple
                library: {
                    type: 'image'
                }
            });

            mediaFrame.on('select', function() {
                const selection = mediaFrame.state().get('selection');

                selection.forEach(function(attachment) {
                    attachment = attachment.toJSON();

                    // Récupérer le template
                    const template = $('#gfm-image-template').html();
                    const html = template.replace(/\{\{INDEX\}\}/g, imageIndex);

                    // Créer un élément temporaire
                    const $newItem = $(html);

                    // Définir l'ID de l'image
                    $newItem.find('.gfm-image-id').val(attachment.id);

                    // Définir l'aperçu
                    const thumbnailUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                    $newItem.find('.gfm-image-preview').html('<img src="' + thumbnailUrl + '" alt="">');

                    // Ajouter au DOM
                    $('#gfm-images-list').append($newItem);

                    // Incrémenter l'index
                    imageIndex++;
                });

                // Réinitialiser les événements
                initRemoveImage();
            });

            mediaFrame.open();
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
        $('#gfm-images-list .gfm-image-item').each(function(index) {
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
