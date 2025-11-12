/**
 * Générateur d'Articles - Admin Scripts
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        initToggleContent();
        initValidateArticle();
        initDeleteIdea();
        initRegenerateIdeas();
    });

    /**
     * Toggle affichage du contenu complet
     */
    function initToggleContent() {
        $(document).on('click', '.gar-toggle-content', function() {
            var $btn = $(this);
            var $card = $btn.closest('.gar-idea-card');
            var $content = $card.find('.gar-idea-content');

            $content.slideToggle(300);

            if ($content.is(':visible')) {
                $btn.text('👁️ Masquer le contenu');
            } else {
                $btn.text('👁️ Voir le contenu complet');
            }
        });
    }

    /**
     * Valider une idée et créer l'article
     */
    function initValidateArticle() {
        $(document).on('click', '.gar-validate-btn', function() {
            var $btn = $(this);
            var ideaId = $btn.data('id');

            if (!confirm('Créer cet article dans WordPress ?\n\nL\'article sera créé en brouillon et vous pourrez le modifier avant de le publier.')) {
                return;
            }

            // Loading state
            $btn.addClass('gar-loading');
            $btn.prop('disabled', true);
            $btn.text('⏳ Création en cours...');

            $.ajax({
                url: garAdmin.ajaxurl,
                type: 'POST',
                data: {
                    action: 'gar_validate_article',
                    nonce: garAdmin.nonce,
                    idea_id: ideaId
                },
                success: function(response) {
                    if (response.success) {
                        // Succès
                        $btn.removeClass('gar-loading');
                        $btn.removeClass('button-primary');
                        $btn.addClass('button-secondary');
                        $btn.text('✅ Article créé !');

                        // Mettre à jour le statut
                        var $card = $btn.closest('.gar-idea-card');
                        $card.find('.gar-idea-status')
                            .removeClass('pending')
                            .addClass('published')
                            .text('✅ Publié');

                        // Remplacer le bouton par un lien vers l'édition
                        var editUrl = response.data.edit_url;
                        $btn.after('<a href="' + editUrl + '" class="button button-secondary">✏️ Modifier l\'article</a>');
                        $btn.remove();

                        // Afficher une notification
                        showNotification('✅ Article créé avec succès en brouillon !', 'success');

                        // Recharger après 2 secondes
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        // Erreur
                        $btn.removeClass('gar-loading');
                        $btn.prop('disabled', false);
                        $btn.text('✅ Valider et créer l\'article');

                        showNotification('❌ Erreur : ' + response.data, 'error');
                    }
                },
                error: function() {
                    $btn.removeClass('gar-loading');
                    $btn.prop('disabled', false);
                    $btn.text('✅ Valider et créer l\'article');

                    showNotification('❌ Erreur de connexion', 'error');
                }
            });
        });
    }

    /**
     * Supprimer une idée
     */
    function initDeleteIdea() {
        $(document).on('click', '.gar-delete-btn', function() {
            var $btn = $(this);
            var ideaId = $btn.data('id');

            if (!confirm('Supprimer définitivement cette idée d\'article ?\n\nCette action est irréversible.')) {
                return;
            }

            // Loading state
            $btn.addClass('gar-loading');
            $btn.prop('disabled', true);

            $.ajax({
                url: garAdmin.ajaxurl,
                type: 'POST',
                data: {
                    action: 'gar_delete_idea',
                    nonce: garAdmin.nonce,
                    idea_id: ideaId
                },
                success: function(response) {
                    if (response.success) {
                        // Succès - supprimer la card avec animation
                        var $card = $btn.closest('.gar-idea-card');
                        $card.fadeOut(300, function() {
                            $(this).remove();

                            // Si plus aucune card, recharger
                            if ($('.gar-idea-card').length === 0) {
                                location.reload();
                            }
                        });

                        showNotification('✅ Idée supprimée', 'success');
                    } else {
                        $btn.removeClass('gar-loading');
                        $btn.prop('disabled', false);

                        showNotification('❌ Erreur : ' + response.data, 'error');
                    }
                },
                error: function() {
                    $btn.removeClass('gar-loading');
                    $btn.prop('disabled', false);

                    showNotification('❌ Erreur de connexion', 'error');
                }
            });
        });
    }

    /**
     * Régénérer les idées
     */
    function initRegenerateIdeas() {
        $('#gar-regenerate-ideas').on('click', function() {
            var $btn = $(this);

            if (!confirm('Régénérer toutes les idées non publiées ?\n\nLes idées en attente seront supprimées et remplacées par de nouvelles idées.')) {
                return;
            }

            // Loading state
            $btn.addClass('gar-loading');
            $btn.prop('disabled', true);
            $btn.text('⏳ Régénération en cours...');

            $.ajax({
                url: garAdmin.ajaxurl,
                type: 'POST',
                data: {
                    action: 'gar_regenerate_ideas',
                    nonce: garAdmin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('✅ Idées régénérées avec succès !', 'success');

                        // Recharger la page après 1 seconde
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $btn.removeClass('gar-loading');
                        $btn.prop('disabled', false);
                        $btn.text('🔄 Régénérer les idées non publiées');

                        showNotification('❌ Erreur : ' + response.data, 'error');
                    }
                },
                error: function() {
                    $btn.removeClass('gar-loading');
                    $btn.prop('disabled', false);
                    $btn.text('🔄 Régénérer les idées non publiées');

                    showNotification('❌ Erreur de connexion', 'error');
                }
            });
        });
    }

    /**
     * Afficher une notification
     */
    function showNotification(message, type) {
        // Supprimer les anciennes notifications
        $('.gar-notification').remove();

        // Créer la notification
        var $notification = $('<div class="gar-notification gar-notification-' + type + '">' + message + '</div>');

        // Ajouter au body
        $('body').append($notification);

        // Animation d'entrée
        setTimeout(function() {
            $notification.addClass('gar-notification-show');
        }, 10);

        // Retirer après 4 secondes
        setTimeout(function() {
            $notification.removeClass('gar-notification-show');
            setTimeout(function() {
                $notification.remove();
            }, 300);
        }, 4000);
    }

})(jQuery);
