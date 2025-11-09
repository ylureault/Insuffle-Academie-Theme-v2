/**
 * Programme Formation - Admin Scripts
 */

(function($) {
    'use strict';

    let moduleIndex = 1000; // Commencer avec un index élevé pour éviter les conflits

    $(document).ready(function() {
        initSortable();
        initAddModule();
        initRemoveModule();
        initToggleModule();
        initPreviewUpdate();
    });

    /**
     * Initialise le tri des modules par glisser-déposer
     */
    function initSortable() {
        $('#pfm-modules-sortable').sortable({
            handle: '.pfm-module-handle',
            placeholder: 'pfm-sortable-placeholder',
            axis: 'y',
            opacity: 0.7,
            cursor: 'move',
            update: function() {
                // Réindexer les modules après le tri
                reindexModules();
            }
        });
    }

    /**
     * Ajoute un nouveau module
     */
    function initAddModule() {
        $('.pfm-add-module').on('click', function(e) {
            e.preventDefault();

            // Récupérer le template
            const template = $('#pfm-module-template').html();

            // Remplacer l'index
            const html = template.replace(/\{\{INDEX\}\}/g, moduleIndex);

            // Ajouter au DOM
            $('#pfm-modules-sortable').append(html);

            // Incrémenter l'index
            moduleIndex++;

            // Réinitialiser les événements
            initRemoveModule();
            initToggleModule();
            initPreviewUpdate();

            // Scroll vers le nouveau module
            const newModule = $('#pfm-modules-sortable .pfm-module-row').last();
            $('html, body').animate({
                scrollTop: newModule.offset().top - 100
            }, 500);
        });
    }

    /**
     * Supprime un module
     */
    function initRemoveModule() {
        $('.pfm-remove-module').off('click').on('click', function(e) {
            e.preventDefault();

            if (confirm(pfmAdmin.confirmDelete)) {
                $(this).closest('.pfm-module-row').slideUp(300, function() {
                    $(this).remove();
                    reindexModules();
                });
            }
        });
    }

    /**
     * Toggle module (replier/déplier)
     */
    function initToggleModule() {
        $('.pfm-toggle-module').off('click').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.pfm-module-row').toggleClass('pfm-collapsed');
        });
    }

    /**
     * Met à jour l'aperçu du module en temps réel
     */
    function initPreviewUpdate() {
        // Mise à jour du numéro
        $('.pfm-module-number-input').off('input').on('input', function() {
            const $row = $(this).closest('.pfm-module-row');
            const value = $(this).val().trim();

            if (value) {
                $row.find('.pfm-module-number-preview').text(value);
            } else {
                $row.find('.pfm-module-number-preview').text('-');
            }
        });

        // Mise à jour du titre
        $('.pfm-module-title-input').off('input').on('input', function() {
            const $row = $(this).closest('.pfm-module-row');
            const value = $(this).val().trim();

            if (value) {
                $row.find('.pfm-module-title-preview').text(value);
            } else {
                $row.find('.pfm-module-title-preview').text('(Sans titre)');
            }
        });
    }

    /**
     * Réindexe les modules après tri ou suppression
     */
    function reindexModules() {
        $('#pfm-modules-sortable .pfm-module-row').each(function(index) {
            $(this).find('input, textarea').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    const newName = name.replace(/pfm_modules\[\d+\]/, 'pfm_modules[' + index + ']');
                    $(this).attr('name', newName);
                }
            });
        });
    }

})(jQuery);
