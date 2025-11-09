/**
 * Admin JavaScript - Formation Gallery Plugin
 * Gestion de la meta box galerie avec drag & drop et media uploader
 */

(function($) {
    'use strict';

    let mediaUploader;

    /**
     * Initialisation au chargement du DOM
     */
    $(document).ready(function() {
        initMediaUploader();
        initSortable();
        initRemoveButtons();
        initRemoveAll();
        updateOrderNumbers();
    });

    /**
     * Initialise le Media Uploader WordPress
     */
    function initMediaUploader() {
        $('.fg-add-images').on('click', function(e) {
            e.preventDefault();

            // Si le media uploader existe déjà, l'ouvrir
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Créer un nouveau media uploader
            mediaUploader = wp.media({
                title: fgAdmin.strings.selectImages,
                button: {
                    text: fgAdmin.strings.addToGallery
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });

            // Quand des images sont sélectionnées
            mediaUploader.on('select', function() {
                const selection = mediaUploader.state().get('selection');
                const galleryIds = getGalleryIds();

                selection.map(function(attachment) {
                    attachment = attachment.toJSON();

                    // Vérifier si l'image n'est pas déjà dans la galerie
                    if (galleryIds.indexOf(attachment.id.toString()) === -1) {
                        addImageToGallery(attachment);
                        galleryIds.push(attachment.id.toString());
                    }
                });

                // Mettre à jour le champ caché avec tous les IDs
                updateGalleryIds();
                updateOrderNumbers();
            });

            mediaUploader.open();
        });
    }

    /**
     * Ajoute une image à la galerie
     */
    function addImageToGallery(attachment) {
        const imageUrl = attachment.sizes && attachment.sizes.medium
            ? attachment.sizes.medium.url
            : attachment.url;

        const template = `
            <div class="fg-gallery-item" data-id="${attachment.id}">
                <div class="fg-gallery-item-order">1</div>
                <div class="fg-gallery-item-actions">
                    <button type="button" class="fg-gallery-item-action remove" title="${fgAdmin.strings.removeImage}">
                        <span class="dashicons dashicons-no-alt"></span>
                    </button>
                </div>
                <img src="${imageUrl}" class="fg-gallery-item-image" alt="">
                <div class="fg-gallery-item-caption">
                    <input type="text"
                           name="fg_gallery_captions[${attachment.id}]"
                           value=""
                           placeholder="Légende (optionnel)"
                           class="fg-caption-input">
                </div>
            </div>
        `;

        $('#fg-gallery-preview').append(template);
        initRemoveButtons(); // Réinitialiser les événements de suppression
    }

    /**
     * Initialise le drag & drop avec jQuery UI Sortable
     */
    function initSortable() {
        $('#fg-gallery-preview').sortable({
            items: '.fg-gallery-item',
            cursor: 'move',
            opacity: 0.8,
            placeholder: 'ui-sortable-placeholder',
            forcePlaceholderSize: true,
            tolerance: 'pointer',
            update: function(event, ui) {
                updateGalleryIds();
                updateOrderNumbers();
            },
            start: function(event, ui) {
                ui.placeholder.height(ui.item.height());
            }
        });
    }

    /**
     * Initialise les boutons de suppression
     */
    function initRemoveButtons() {
        $('.fg-gallery-item-action.remove').off('click').on('click', function(e) {
            e.preventDefault();

            const $item = $(this).closest('.fg-gallery-item');

            // Animation de suppression
            $item.fadeOut(300, function() {
                $item.remove();
                updateGalleryIds();
                updateOrderNumbers();
            });
        });
    }

    /**
     * Initialise le bouton "Tout supprimer"
     */
    function initRemoveAll() {
        $('.fg-remove-all').on('click', function(e) {
            e.preventDefault();

            if (!confirm('Êtes-vous sûr de vouloir supprimer toutes les images de la galerie ?')) {
                return;
            }

            $('#fg-gallery-preview').fadeOut(300, function() {
                $('#fg-gallery-preview').empty().fadeIn(300);
                updateGalleryIds();
            });
        });
    }

    /**
     * Récupère tous les IDs des images de la galerie
     */
    function getGalleryIds() {
        const ids = [];
        $('#fg-gallery-preview .fg-gallery-item').each(function() {
            ids.push($(this).data('id').toString());
        });
        return ids;
    }

    /**
     * Met à jour le champ caché avec les IDs des images
     */
    function updateGalleryIds() {
        const ids = getGalleryIds();
        $('#fg_gallery_ids').val(ids.join(','));
    }

    /**
     * Met à jour les numéros d'ordre affichés
     */
    function updateOrderNumbers() {
        $('#fg-gallery-preview .fg-gallery-item').each(function(index) {
            $(this).find('.fg-gallery-item-order').text(index + 1);
        });
    }

    /**
     * Prévenir la perte de données non sauvegardées
     */
    let galleryChanged = false;

    $(document).on('change input', '.fg-gallery-container', function() {
        galleryChanged = true;
    });

    $(window).on('beforeunload', function() {
        if (galleryChanged) {
            return 'Vous avez des modifications non sauvegardées dans la galerie.';
        }
    });

    $('form#post').on('submit', function() {
        galleryChanged = false;
    });

})(jQuery);
