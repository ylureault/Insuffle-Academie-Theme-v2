/**
 * Programme Formation - Admin Scripts
 */

(function($) {
    'use strict';

    let moduleIndex = 1000;

    $(document).ready(function() {
        initSortable();
        initAddModule();
        initRemoveModule();
        initToggleModule();
        initPreviewUpdate();
        initInfoTableRows();
        initBenefices();
    });

    /**
     * Initialise le tri des modules par glisser-déposer
     */
    function initSortable() {
        $('#pfm-modules-list').sortable({
            handle: '.pfm-module-handle',
            placeholder: 'pfm-sortable-placeholder',
            axis: 'y',
            opacity: 0.7,
            cursor: 'move',
            update: function() {
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
            const html = template.replace(/\{\{INDEX\}\}/g, moduleIndex);

            // Ajouter au DOM
            $('#pfm-modules-list').append(html);

            // Incrémenter l'index
            moduleIndex++;

            // Réinitialiser les événements
            initRemoveModule();
            initToggleModule();
            initPreviewUpdate();

            // Scroll vers le nouveau module
            const $newModule = $('#pfm-modules-list .pfm-module-item:last');
            $('html, body').animate({
                scrollTop: $newModule.offset().top - 100
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
                $(this).closest('.pfm-module-item').slideUp(300, function() {
                    $(this).remove();
                    reindexModules();
                });
            }
        });
    }

    /**
     * Toggle (replier/déplier) un module
     */
    function initToggleModule() {
        $('.pfm-toggle-module').off('click').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.pfm-module-item').toggleClass('collapsed');
        });
    }

    /**
     * Met à jour l'aperçu en temps réel
     */
    function initPreviewUpdate() {
        // Numéro
        $(document).on('input', '.pfm-input-number', function() {
            const value = $(this).val();
            $(this).closest('.pfm-module-item').find('.pfm-preview-number').text(value);
        });

        // Titre
        $(document).on('input', '.pfm-input-title', function() {
            const value = $(this).val() || 'Nouveau module';
            $(this).closest('.pfm-module-item').find('.pfm-preview-title').text(value);
        });
    }

    /**
     * Réindexe les modules après tri ou suppression
     */
    function reindexModules() {
        $('#pfm-modules-list .pfm-module-item').each(function(index) {
            $(this).attr('data-index', index);
            $(this).find('input, textarea').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    const newName = name.replace(/pfm_modules\[\d+\]/, 'pfm_modules[' + index + ']');
                    $(this).attr('name', newName);
                }
            });
        });
    }

    /**
     * Gestion du tableau d'informations
     */
    function initInfoTableRows() {
        // Utiliser la délégation d'événements
        $(document).on('click', '.pfm-add-info-row', function(e) {
            e.preventDefault();

            const rowIndex = $('#pfm-info-tableau-list .pfm-info-row').length;

            const html = `
                <div class="pfm-info-row">
                    <input type="text" name="pfm_info_tableau[${rowIndex}][element]" class="regular-text" placeholder="Ex: Durée totale">
                    <input type="text" name="pfm_info_tableau[${rowIndex}][detail]" class="large-text" placeholder="Ex: 21 heures (3 jours consécutifs)">
                    <button type="button" class="button pfm-remove-row">Supprimer</button>
                </div>
            `;

            $('#pfm-info-tableau-list').append(html);
        });

        initRemoveInfoRow();
    }

    /**
     * Supprime une ligne du tableau
     */
    function initRemoveInfoRow() {
        $(document).on('click', '.pfm-remove-row', function(e) {
            e.preventDefault();
            $(this).closest('.pfm-info-row').slideUp(300, function() {
                $(this).remove();
            });
        });
    }

    /**
     * Gestion des bénéfices
     */
    function initBenefices() {
        // Utiliser la délégation d'événements pour le bouton add
        $(document).on('click', '.pfm-add-benefice', function(e) {
            e.preventDefault();

            const beneficeIndex = $('#pfm-benefices-list .pfm-benefice-card').length;

            const html = `
                <div class="pfm-benefice-card">
                    <input type="text" name="pfm_benefices[${beneficeIndex}][icone]" class="small-text" placeholder="🧘" style="width: 60px;">
                    <input type="text" name="pfm_benefices[${beneficeIndex}][titre]" class="regular-text" placeholder="Ex: Posture de facilitateur">
                    <textarea name="pfm_benefices[${beneficeIndex}][description]" rows="3" class="large-text" placeholder="Description du bénéfice..."></textarea>
                    <button type="button" class="button pfm-remove-benefice">Supprimer</button>
                </div>
            `;

            $('#pfm-benefices-list').append(html);
        });

        initRemoveBenefice();
    }

    /**
     * Supprime un bénéfice
     */
    function initRemoveBenefice() {
        $(document).on('click', '.pfm-remove-benefice', function(e) {
            e.preventDefault();
            if (confirm('Supprimer ce bénéfice ?')) {
                $(this).closest('.pfm-benefice-card').slideUp(300, function() {
                    $(this).remove();
                });
            }
        });
    }

})(jQuery);
