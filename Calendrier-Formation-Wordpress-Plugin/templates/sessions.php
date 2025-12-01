<?php
/**
 * Template: Gestion des sessions (vue tableau)
 * Variables: $sessions, $formations, $formation_filter, $status_filter, $search
 */

if (!defined('ABSPATH')) exit;
?>

<div class="wrap cf-sessions-page">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-list-view"></span>
        <?php _e('Gestion des sessions', 'calendrier-formation'); ?>
    </h1>

    <button class="page-title-action cf-add-session-btn">
        <span class="dashicons dashicons-plus-alt"></span>
        <?php _e('Nouvelle session', 'calendrier-formation'); ?>
    </button>

    <!-- Filtres -->
    <div class="cf-filters-bar">
        <form method="get" class="cf-filters-form">
            <input type="hidden" name="page" value="cf-sessions">

            <div class="cf-filter-group">
                <select name="formation_id" onchange="this.form.submit()">
                    <option value=""><?php _e('Toutes les formations', 'calendrier-formation'); ?></option>
                    <?php foreach ($formations as $id => $title): ?>
                        <option value="<?php echo esc_attr($id); ?>" <?php selected($formation_filter, $id); ?>>
                            <?php echo esc_html($title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="cf-filter-group">
                <select name="status" onchange="this.form.submit()">
                    <option value="all" <?php selected($status_filter, 'all'); ?>><?php _e('Tous les statuts', 'calendrier-formation'); ?></option>
                    <option value="active" <?php selected($status_filter, 'active'); ?>><?php _e('Actives', 'calendrier-formation'); ?></option>
                    <option value="inactive" <?php selected($status_filter, 'inactive'); ?>><?php _e('Inactives', 'calendrier-formation'); ?></option>
                </select>
            </div>

            <div class="cf-filter-group">
                <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="<?php _e('Rechercher...', 'calendrier-formation'); ?>">
            </div>

            <button type="submit" class="button"><?php _e('Filtrer', 'calendrier-formation'); ?></button>
            <?php if ($formation_filter || $status_filter !== 'all' || $search): ?>
                <a href="?page=cf-sessions" class="button"><?php _e('Réinitialiser', 'calendrier-formation'); ?></a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (!empty($sessions)): ?>
        <!-- Tableau des sessions -->
        <table class="wp-list-table widefat fixed striped cf-sessions-table">
            <thead>
                <tr>
                    <th style="width: 50px;"><?php _e('ID', 'calendrier-formation'); ?></th>
                    <th><?php _e('Formation', 'calendrier-formation'); ?></th>
                    <th><?php _e('Session', 'calendrier-formation'); ?></th>
                    <th><?php _e('Date début', 'calendrier-formation'); ?></th>
                    <th><?php _e('Date fin', 'calendrier-formation'); ?></th>
                    <th><?php _e('Durée', 'calendrier-formation'); ?></th>
                    <th><?php _e('Type', 'calendrier-formation'); ?></th>
                    <th><?php _e('Places', 'calendrier-formation'); ?></th>
                    <th><?php _e('Statut', 'calendrier-formation'); ?></th>
                    <th><?php _e('Actions', 'calendrier-formation'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $session): ?>
                    <?php
                    $is_full = $session->places_disponibles <= 0;
                    $is_limited = $session->places_disponibles <= 3 && !$is_full;
                    $is_past = strtotime($session->date_debut) < time();
                    ?>
                    <tr class="<?php echo $is_past ? 'cf-session-past' : ''; ?>">
                        <td><?php echo esc_html($session->id); ?></td>
                        <td>
                            <strong><?php echo esc_html($session->formation_title); ?></strong>
                            <div class="row-actions">
                                <span><a href="<?php echo get_permalink($session->post_id); ?>" target="_blank"><?php _e('Voir', 'calendrier-formation'); ?></a></span>
                            </div>
                        </td>
                        <td>
                            <strong><?php echo esc_html($session->session_title); ?></strong>
                        </td>
                        <td><?php echo esc_html(date('d/m/Y', strtotime($session->date_debut))); ?></td>
                        <td><?php echo esc_html(date('d/m/Y', strtotime($session->date_fin))); ?></td>
                        <td><?php echo esc_html($session->duree); ?></td>
                        <td>
                            <?php if ($session->type_location === 'distance'): ?>
                                <span class="dashicons dashicons-desktop"></span> <?php _e('Distance', 'calendrier-formation'); ?>
                            <?php else: ?>
                                <span class="dashicons dashicons-location"></span> <?php _e('Présentiel', 'calendrier-formation'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="cf-places-control">
                                <button class="button button-small cf-place-btn cf-place-minus"
                                        data-session-id="<?php echo $session->id; ?>"
                                        data-action="remove"
                                        title="<?php _e('Réserver une place (diminuer)', 'calendrier-formation'); ?>"
                                        <?php echo ($session->places_disponibles <= 0) ? 'disabled' : ''; ?>>
                                    −
                                </button>
                                <span class="cf-places-display" data-session-id="<?php echo $session->id; ?>">
                                    <strong><?php echo esc_html($session->places_disponibles); ?></strong> / <?php echo esc_html($session->places_total); ?>
                                </span>
                                <button class="button button-small cf-place-btn cf-place-plus"
                                        data-session-id="<?php echo $session->id; ?>"
                                        data-action="add"
                                        title="<?php _e('Libérer une place (augmenter)', 'calendrier-formation'); ?>"
                                        <?php echo ($session->places_disponibles >= $session->places_total) ? 'disabled' : ''; ?>>
                                    +
                                </button>
                            </div>
                            <?php if ($is_full): ?>
                                <span class="cf-badge cf-badge-full"><?php _e('Complet', 'calendrier-formation'); ?></span>
                            <?php elseif ($is_limited): ?>
                                <span class="cf-badge cf-badge-warning"><?php _e('Limité', 'calendrier-formation'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($session->status === 'active'): ?>
                                <span style="color: #46b450;">●</span> <?php _e('Active', 'calendrier-formation'); ?>
                            <?php else: ?>
                                <span style="color: #dc3232;">●</span> <?php _e('Inactive', 'calendrier-formation'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="button button-small cf-edit-session-btn" data-session-id="<?php echo $session->id; ?>">
                                <?php _e('Modifier', 'calendrier-formation'); ?>
                            </button>
                            <button class="button button-small button-link-delete cf-delete-session-btn" data-session-id="<?php echo $session->id; ?>">
                                <?php _e('Supprimer', 'calendrier-formation'); ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="cf-empty-state">
            <span class="dashicons dashicons-calendar-alt"></span>
            <p><?php _e('Aucune session trouvée', 'calendrier-formation'); ?></p>
            <button class="button button-primary cf-add-session-btn"><?php _e('Créer votre première session', 'calendrier-formation'); ?></button>
        </div>
    <?php endif; ?>
</div>

<!-- Inclure la même modale que dans calendar.php -->
<div id="cf-session-modal" class="cf-modal" style="display: none;">
    <div class="cf-modal-overlay"></div>
    <div class="cf-modal-container">
        <div class="cf-modal-header">
            <h2 id="cf-modal-title"><?php _e('Nouvelle session', 'calendrier-formation'); ?></h2>
            <button type="button" class="cf-modal-close">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </div>

        <div class="cf-modal-body">
            <form id="cf-session-form">
                <input type="hidden" id="cf-session-id" name="session_id">

                <div class="cf-form-row">
                    <div class="cf-form-group cf-form-group-full">
                        <label for="cf-formation-id"><?php _e('Formation', 'calendrier-formation'); ?> *</label>
                        <select id="cf-formation-id" name="formation_id" required>
                            <option value=""><?php _e('Sélectionnez une formation', 'calendrier-formation'); ?></option>
                            <?php foreach ($formations as $id => $title): ?>
                                <option value="<?php echo esc_attr($id); ?>"><?php echo esc_html($title); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="cf-form-row">
                    <div class="cf-form-group cf-form-group-full">
                        <label for="cf-session-title"><?php _e('Titre de la session', 'calendrier-formation'); ?> *</label>
                        <input type="text" id="cf-session-title" name="session_title" required>
                    </div>
                </div>

                <div class="cf-form-row">
                    <div class="cf-form-group">
                        <label for="cf-date-debut"><?php _e('Date de début', 'calendrier-formation'); ?> *</label>
                        <input type="date" id="cf-date-debut" name="date_debut" required>
                    </div>

                    <div class="cf-form-group">
                        <label for="cf-date-fin"><?php _e('Date de fin', 'calendrier-formation'); ?> *</label>
                        <input type="date" id="cf-date-fin" name="date_fin" required>
                    </div>
                </div>

                <div class="cf-form-row">
                    <div class="cf-form-group cf-form-group-full">
                        <label for="cf-duree"><?php _e('Durée', 'calendrier-formation'); ?></label>
                        <input type="text" id="cf-duree" name="duree" placeholder="Ex: 2 jours">
                    </div>
                </div>

                <div class="cf-form-row">
                    <div class="cf-form-group">
                        <label for="cf-type-location"><?php _e('Type', 'calendrier-formation'); ?> *</label>
                        <select id="cf-type-location" name="type_location" required>
                            <option value="distance"><?php _e('À distance', 'calendrier-formation'); ?></option>
                            <option value="lieu"><?php _e('En présentiel', 'calendrier-formation'); ?></option>
                        </select>
                    </div>

                    <div class="cf-form-group">
                        <label for="cf-status"><?php _e('Statut', 'calendrier-formation'); ?></label>
                        <select id="cf-status" name="status">
                            <option value="active"><?php _e('Active', 'calendrier-formation'); ?></option>
                            <option value="inactive"><?php _e('Inactive', 'calendrier-formation'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="cf-form-row cf-location-details" style="display: none;">
                    <div class="cf-form-group cf-form-group-full">
                        <label for="cf-location-details"><?php _e('Adresse', 'calendrier-formation'); ?></label>
                        <textarea id="cf-location-details" name="location_details" rows="3"></textarea>
                    </div>
                </div>

                <div class="cf-form-row">
                    <div class="cf-form-group">
                        <label for="cf-places-total"><?php _e('Places total', 'calendrier-formation'); ?> *</label>
                        <input type="number" id="cf-places-total" name="places_total" min="0" required>
                    </div>

                    <div class="cf-form-group">
                        <label for="cf-places-disponibles"><?php _e('Places disponibles', 'calendrier-formation'); ?> *</label>
                        <input type="number" id="cf-places-disponibles" name="places_disponibles" min="0" required>
                    </div>
                </div>

                <div class="cf-form-row">
                    <div class="cf-form-group cf-form-group-full">
                        <label for="cf-reservation-url">
                            <?php _e('Lien de réservation personnalisé', 'calendrier-formation'); ?>
                            <span style="color: #999; font-weight: normal; font-size: 12px;">(Facultatif - ex: lien Digiforma)</span>
                        </label>
                        <input type="url" id="cf-reservation-url" name="reservation_url" placeholder="https://app.digiforma.com/guest/...">
                        <p style="margin: 5px 0 0; font-size: 12px; color: #666;">
                            Si vous utilisez un outil externe (Digiforma, etc.), collez le lien ici. Il sera automatiquement encapsulé dans le site.
                        </p>
                    </div>
                </div>
            </form>
        </div>

        <div class="cf-modal-footer">
            <button type="button" class="button cf-modal-cancel"><?php _e('Annuler', 'calendrier-formation'); ?></button>
            <button type="submit" form="cf-session-form" class="button button-primary cf-modal-submit">
                <span class="cf-submit-text"><?php _e('Enregistrer', 'calendrier-formation'); ?></span>
                <span class="cf-submit-loading" style="display: none;">
                    <span class="spinner is-active" style="float: none; margin: 0;"></span>
                </span>
            </button>
        </div>
    </div>
</div>

<style>
.cf-sessions-page {
    padding: 20px 20px 20px 0;
}

.cf-filters-bar {
    background: #fff;
    padding: 16px 20px;
    border-radius: 8px;
    margin: 20px 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.cf-filters-form {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.cf-filter-group select,
.cf-filter-group input[type="search"] {
    min-width: 200px;
}

.cf-sessions-table {
    margin-top: 20px;
}

.cf-session-past {
    opacity: 0.6;
}

/* Contrôles de places */
.cf-places-control {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.cf-place-btn {
    width: 28px;
    height: 28px;
    padding: 0 !important;
    font-size: 16px;
    font-weight: bold;
    line-height: 1;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.cf-place-btn:hover:not(:disabled) {
    transform: scale(1.1);
}

.cf-place-btn:active:not(:disabled) {
    transform: scale(0.95);
}

.cf-place-minus {
    background: #dc3232;
    border-color: #dc3232;
    color: white;
}

.cf-place-minus:hover:not(:disabled) {
    background: #c0392b;
    border-color: #c0392b;
}

.cf-place-plus {
    background: #46b450;
    border-color: #46b450;
    color: white;
}

.cf-place-plus:hover:not(:disabled) {
    background: #27ae60;
    border-color: #27ae60;
}

.cf-place-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.cf-places-display {
    min-width: 80px;
    text-align: center;
    display: inline-block;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Gestion modale
    function openEditModal(sessionId) {
        $('#cf-modal-title').text('Modifier la session');

        $.ajax({
            url: cfAdmin.ajaxUrl,
            type: 'GET',
            data: {
                action: 'cf_get_session',
                nonce: cfAdmin.nonce,
                session_id: sessionId
            },
            success: function(response) {
                if (response.success) {
                    const session = response.data;

                    $('#cf-session-id').val(session.id);
                    $('#cf-formation-id').val(session.post_id);
                    $('#cf-session-title').val(session.session_title);
                    $('#cf-date-debut').val(formatDateForInput(session.date_debut));
                    $('#cf-date-fin').val(formatDateForInput(session.date_fin));
                    $('#cf-duree').val(session.duree);
                    $('#cf-type-location').val(session.type_location).trigger('change');
                    $('#cf-location-details').val(session.location_details);
                    $('#cf-places-total').val(session.places_total);
                    $('#cf-places-disponibles').val(session.places_disponibles);
                    $('#cf-status').val(session.status);
                    $('#cf-reservation-url').val(session.reservation_url || '');

                    $('#cf-session-modal').fadeIn(200);
                } else {
                    showNotification('error', response.data.message);
                }
            }
        });
    }

    function formatDateForInput(dateStr) {
        // Extraire uniquement la partie date (YYYY-MM-DD) sans conversion de fuseau horaire
        // Les dates MySQL sont au format "YYYY-MM-DD HH:MM:SS"
        // On prend juste les 10 premiers caractères pour éviter les problèmes de timezone
        if (!dateStr) return '';
        return dateStr.substring(0, 10);
    }

    function showNotification(type, message) {
        const bgColor = type === 'success' ? '#46b450' : '#dc3232';
        const $notification = $('<div>')
            .addClass('cf-notification')
            .css({
                position: 'fixed',
                top: '32px',
                right: '20px',
                padding: '16px 24px',
                background: bgColor,
                color: 'white',
                borderRadius: '8px',
                boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
                zIndex: 999999,
                fontSize: '14px',
                fontWeight: '500'
            })
            .text(message)
            .appendTo('body');

        setTimeout(function() {
            $notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    // Nouvelle session
    $('.cf-add-session-btn').on('click', function() {
        $('#cf-modal-title').text('Nouvelle session');
        $('#cf-session-form')[0].reset();
        $('#cf-session-id').val('');
        $('.cf-location-details').hide();
        $('#cf-session-modal').fadeIn(200);
    });

    // Éditer session depuis le tableau
    $('.cf-edit-session-btn').on('click', function() {
        const sessionId = $(this).data('session-id');
        openEditModal(sessionId);
    });

    // Fermer modale
    $('.cf-modal-close, .cf-modal-cancel').on('click', function() {
        $('#cf-session-modal').fadeOut(200);
        $('#cf-session-form')[0].reset();
    });

    $('.cf-modal-overlay').on('click', function() {
        $('#cf-session-modal').fadeOut(200);
    });

    // Toggle location details
    $('#cf-type-location').on('change', function() {
        if ($(this).val() === 'lieu') {
            $('.cf-location-details').show();
        } else {
            $('.cf-location-details').hide();
        }
    });

    // Sync places
    $('#cf-places-total').on('input', function() {
        if (!$('#cf-session-id').val()) {
            $('#cf-places-disponibles').val($(this).val());
        }
    });

    // Soumission formulaire
    $('#cf-session-form').on('submit', function(e) {
        e.preventDefault();

        const sessionId = $('#cf-session-id').val();
        const action = sessionId ? 'cf_update_session' : 'cf_create_session';

        const formData = {
            action: action,
            nonce: cfAdmin.nonce,
            session_id: sessionId,
            formation_id: $('#cf-formation-id').val(),
            session_title: $('#cf-session-title').val(),
            date_debut: $('#cf-date-debut').val(),
            date_fin: $('#cf-date-fin').val(),
            duree: $('#cf-duree').val(),
            type_location: $('#cf-type-location').val(),
            location_details: $('#cf-location-details').val(),
            places_total: $('#cf-places-total').val(),
            places_disponibles: $('#cf-places-disponibles').val(),
            status: $('#cf-status').val(),
            reservation_url: $('#cf-reservation-url').val()
        };

        $('.cf-submit-text').hide();
        $('.cf-submit-loading').show();
        $('.cf-modal-submit').prop('disabled', true);

        $.ajax({
            url: cfAdmin.ajaxUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showNotification('success', response.data.message);
                    $('#cf-session-modal').fadeOut(200);
                    location.reload();
                } else {
                    showNotification('error', response.data.message);
                }
            },
            error: function() {
                showNotification('error', cfAdmin.strings.error);
            },
            complete: function() {
                $('.cf-submit-text').show();
                $('.cf-submit-loading').hide();
                $('.cf-modal-submit').prop('disabled', false);
            }
        });
    });

    // Supprimer session
    $('.cf-delete-session-btn').on('click', function() {
        if (!confirm(cfAdmin.strings.confirmDelete)) {
            return;
        }

        const sessionId = $(this).data('session-id');
        const $row = $(this).closest('tr');

        $.ajax({
            url: cfAdmin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'cf_delete_session',
                nonce: cfAdmin.nonce,
                session_id: sessionId
            },
            success: function(response) {
                if (response.success) {
                    $row.fadeOut(function() {
                        $(this).remove();
                        if ($('.cf-sessions-table tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                } else {
                    alert(response.data.message);
                }
            }
        });
    });

    // Gestion des boutons +/- pour les places
    $('.cf-place-btn').on('click', function() {
        const $btn = $(this);
        const sessionId = $btn.data('session-id');
        const action = $btn.data('action'); // 'add' ou 'remove'

        // Désactiver temporairement les boutons
        $btn.prop('disabled', true);

        $.ajax({
            url: cfAdmin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'cf_adjust_places',
                nonce: cfAdmin.nonce,
                session_id: sessionId,
                adjustment: action
            },
            success: function(response) {
                if (response.success) {
                    // Mettre à jour l'affichage
                    const $display = $('.cf-places-display[data-session-id="' + sessionId + '"]');
                    $display.find('strong').text(response.data.places_disponibles);

                    // Gérer l'état des boutons +/-
                    const $plusBtn = $('.cf-place-plus[data-session-id="' + sessionId + '"]');
                    const $minusBtn = $('.cf-place-minus[data-session-id="' + sessionId + '"]');

                    // Activer/désactiver selon les limites
                    $minusBtn.prop('disabled', response.data.places_disponibles <= 0);
                    $plusBtn.prop('disabled', response.data.places_disponibles >= response.data.places_total);

                    // Mettre à jour les badges
                    const $td = $display.closest('td');
                    $td.find('.cf-badge').remove();

                    if (response.data.places_disponibles <= 0) {
                        $td.append('<span class="cf-badge cf-badge-full">Complet</span>');
                    } else if (response.data.places_disponibles <= 3) {
                        $td.append('<span class="cf-badge cf-badge-warning">Limité</span>');
                    }

                    showNotification('success', response.data.message);
                } else {
                    showNotification('error', response.data.message);
                    $btn.prop('disabled', false);
                }
            },
            error: function() {
                showNotification('error', 'Erreur lors de la mise à jour');
                $btn.prop('disabled', false);
            }
        });
    });
});
</script>
