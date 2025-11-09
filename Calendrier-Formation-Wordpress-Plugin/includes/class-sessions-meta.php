<?php
/**
 * Gestion des meta boxes pour les sessions de formation
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Sessions_Meta {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_sessions'), 10, 2);
        add_action('wp_ajax_cf_delete_session', array($this, 'ajax_delete_session'));
        add_action('wp_ajax_cf_add_session', array($this, 'ajax_add_session'));
        add_action('wp_ajax_cf_update_session', array($this, 'ajax_update_session'));
    }

    /**
     * Ajoute les meta boxes
     */
    public function add_meta_boxes() {
        // Récupérer l'ID de la page parent des formations
        $settings = get_option('cf_settings', array());
        $parent_id = isset($settings['formations_parent_id']) ? $settings['formations_parent_id'] : 51;

        // Vérifier si on est sur une page enfant de la page Formations
        global $post;
        if ($post && $post->post_type === 'page' && wp_get_post_parent_id($post->ID) == $parent_id) {
            add_meta_box(
                'cf_sessions_meta_box',
                __('Sessions de formation', 'calendrier-formation'),
                array($this, 'render_sessions_meta_box'),
                'page',
                'normal',
                'high'
            );
        }
    }

    /**
     * Affiche la meta box des sessions
     */
    public function render_sessions_meta_box($post) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cf_sessions';

        // Récupérer les sessions existantes
        $sessions = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name WHERE post_id = %d ORDER BY date_debut ASC",
            $post->ID
        ));

        wp_nonce_field('cf_save_sessions', 'cf_sessions_nonce');
        ?>
        <div id="cf-sessions-container">
            <div class="cf-sessions-header">
                <button type="button" class="button button-primary" id="cf-add-session-btn">
                    <span class="dashicons dashicons-plus-alt"></span>
                    <?php _e('Ajouter une session', 'calendrier-formation'); ?>
                </button>
            </div>

            <div id="cf-sessions-list">
                <?php if (!empty($sessions)): ?>
                    <?php foreach ($sessions as $session): ?>
                        <?php $this->render_session_row($session); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="cf-no-sessions"><?php _e('Aucune session créée. Cliquez sur "Ajouter une session" pour commencer.', 'calendrier-formation'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Template pour nouvelle session -->
        <script type="text/template" id="cf-session-template">
            <?php $this->render_session_form(); ?>
        </script>

        <style>
            #cf-sessions-container {
                margin: 20px 0;
            }
            .cf-sessions-header {
                margin-bottom: 20px;
            }
            .cf-session-item {
                background: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 20px;
                margin-bottom: 15px;
                position: relative;
            }
            .cf-session-item.editing {
                background: #fff;
                border-color: #2271b1;
            }
            .cf-session-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }
            .cf-session-title {
                font-size: 16px;
                font-weight: 600;
                margin: 0;
            }
            .cf-session-actions {
                display: flex;
                gap: 5px;
            }
            .cf-session-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
            .cf-form-group {
                margin-bottom: 15px;
            }
            .cf-form-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: 600;
            }
            .cf-form-group input[type="text"],
            .cf-form-group input[type="datetime-local"],
            .cf-form-group input[type="number"],
            .cf-form-group select,
            .cf-form-group textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .cf-form-group textarea {
                min-height: 80px;
                resize: vertical;
            }
            .cf-location-fields {
                display: none;
            }
            .cf-location-fields.active {
                display: block;
            }
            .cf-session-info {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 10px;
            }
            .cf-info-item {
                padding: 8px;
                background: white;
                border-radius: 3px;
            }
            .cf-info-label {
                font-size: 11px;
                color: #666;
                text-transform: uppercase;
                margin-bottom: 3px;
            }
            .cf-info-value {
                font-size: 14px;
                font-weight: 600;
            }
            .cf-status-active {
                color: #46b450;
            }
            .cf-status-inactive {
                color: #dc3232;
            }
            .cf-no-sessions {
                text-align: center;
                color: #666;
                padding: 40px;
                background: #f9f9f9;
                border: 2px dashed #ddd;
                border-radius: 4px;
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            // Ajouter une nouvelle session
            $('#cf-add-session-btn').on('click', function() {
                var template = $('#cf-session-template').html();
                $('.cf-no-sessions').remove();
                $('#cf-sessions-list').append(template);

                // Initialiser les datepickers
                $('#cf-sessions-list .cf-session-item:last .cf-datepicker').each(function() {
                    $(this).attr('type', 'datetime-local');
                });
            });

            // Toggle location fields
            $(document).on('change', '.cf-location-type', function() {
                var $container = $(this).closest('.cf-session-item');
                var $locationFields = $container.find('.cf-location-fields');

                if ($(this).val() === 'lieu') {
                    $locationFields.addClass('active');
                } else {
                    $locationFields.removeClass('active');
                }
            });

            // Supprimer une session
            $(document).on('click', '.cf-delete-session', function() {
                if (!confirm('<?php _e('Êtes-vous sûr de vouloir supprimer cette session ?', 'calendrier-formation'); ?>')) {
                    return;
                }

                var $item = $(this).closest('.cf-session-item');
                var sessionId = $item.data('session-id');

                if (sessionId) {
                    // Session existante - AJAX delete
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'cf_delete_session',
                            session_id: sessionId,
                            nonce: '<?php echo wp_create_nonce('cf_delete_session'); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                $item.fadeOut(function() {
                                    $(this).remove();
                                    if ($('#cf-sessions-list .cf-session-item').length === 0) {
                                        $('#cf-sessions-list').html('<p class="cf-no-sessions"><?php _e('Aucune session créée. Cliquez sur "Ajouter une session" pour commencer.', 'calendrier-formation'); ?></p>');
                                    }
                                });
                            }
                        }
                    });
                } else {
                    // Nouvelle session pas encore enregistrée
                    $item.fadeOut(function() {
                        $(this).remove();
                    });
                }
            });

            // Éditer une session
            $(document).on('click', '.cf-edit-session', function() {
                var $item = $(this).closest('.cf-session-item');
                $item.find('.cf-session-display').hide();
                $item.find('.cf-session-form').show();
                $item.addClass('editing');
            });

            // Annuler l'édition
            $(document).on('click', '.cf-cancel-edit', function() {
                var $item = $(this).closest('.cf-session-item');
                $item.find('.cf-session-form').hide();
                $item.find('.cf-session-display').show();
                $item.removeClass('editing');
            });

            // Sauvegarder une session via AJAX
            $(document).on('click', '.cf-save-session', function() {
                var $item = $(this).closest('.cf-session-item');
                var sessionId = $item.data('session-id');
                var $form = $item.find('.cf-session-form');

                var data = {
                    action: sessionId ? 'cf_update_session' : 'cf_add_session',
                    post_id: <?php echo $post->ID; ?>,
                    session_id: sessionId,
                    session_title: $form.find('[name="session_title"]').val(),
                    date_debut: $form.find('[name="date_debut"]').val(),
                    date_fin: $form.find('[name="date_fin"]').val(),
                    duree: $form.find('[name="duree"]').val(),
                    type_location: $form.find('[name="type_location"]').val(),
                    location_details: $form.find('[name="location_details"]').val(),
                    places_total: $form.find('[name="places_total"]').val(),
                    places_disponibles: $form.find('[name="places_disponibles"]').val(),
                    status: $form.find('[name="status"]').val(),
                    nonce: '<?php echo wp_create_nonce('cf_save_session'); ?>'
                };

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.data.message || 'Erreur lors de la sauvegarde');
                        }
                    }
                });
            });
        });
        </script>
        <?php
    }

    /**
     * Affiche une ligne de session existante
     */
    private function render_session_row($session) {
        $date_debut = new DateTime($session->date_debut);
        $date_fin = new DateTime($session->date_fin);
        ?>
        <div class="cf-session-item" data-session-id="<?php echo esc_attr($session->id); ?>">
            <div class="cf-session-display">
                <div class="cf-session-header">
                    <h3 class="cf-session-title"><?php echo esc_html($session->session_title); ?></h3>
                    <div class="cf-session-actions">
                        <button type="button" class="button cf-edit-session">
                            <span class="dashicons dashicons-edit"></span> <?php _e('Modifier', 'calendrier-formation'); ?>
                        </button>
                        <button type="button" class="button cf-delete-session">
                            <span class="dashicons dashicons-trash"></span> <?php _e('Supprimer', 'calendrier-formation'); ?>
                        </button>
                    </div>
                </div>
                <div class="cf-session-info">
                    <div class="cf-info-item">
                        <div class="cf-info-label"><?php _e('Début', 'calendrier-formation'); ?></div>
                        <div class="cf-info-value"><?php echo esc_html($date_debut->format('d/m/Y H:i')); ?></div>
                    </div>
                    <div class="cf-info-item">
                        <div class="cf-info-label"><?php _e('Fin', 'calendrier-formation'); ?></div>
                        <div class="cf-info-value"><?php echo esc_html($date_fin->format('d/m/Y H:i')); ?></div>
                    </div>
                    <div class="cf-info-item">
                        <div class="cf-info-label"><?php _e('Durée', 'calendrier-formation'); ?></div>
                        <div class="cf-info-value"><?php echo esc_html($session->duree); ?></div>
                    </div>
                    <div class="cf-info-item">
                        <div class="cf-info-label"><?php _e('Type', 'calendrier-formation'); ?></div>
                        <div class="cf-info-value"><?php echo esc_html($session->type_location === 'distance' ? 'À distance' : 'En présentiel'); ?></div>
                    </div>
                    <?php if ($session->type_location === 'lieu'): ?>
                    <div class="cf-info-item">
                        <div class="cf-info-label"><?php _e('Lieu', 'calendrier-formation'); ?></div>
                        <div class="cf-info-value"><?php echo esc_html($session->location_details); ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="cf-info-item">
                        <div class="cf-info-label"><?php _e('Places', 'calendrier-formation'); ?></div>
                        <div class="cf-info-value"><?php echo esc_html($session->places_disponibles . '/' . $session->places_total); ?></div>
                    </div>
                    <div class="cf-info-item">
                        <div class="cf-info-label"><?php _e('Statut', 'calendrier-formation'); ?></div>
                        <div class="cf-info-value <?php echo $session->status === 'active' ? 'cf-status-active' : 'cf-status-inactive'; ?>">
                            <?php echo esc_html($session->status === 'active' ? 'Active' : 'Inactive'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cf-session-form" style="display: none;">
                <?php $this->render_session_form($session); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Affiche le formulaire d'une session
     */
    private function render_session_form($session = null) {
        $session_title = $session ? $session->session_title : '';
        $date_debut = $session ? date('Y-m-d\TH:i', strtotime($session->date_debut)) : '';
        $date_fin = $session ? date('Y-m-d\TH:i', strtotime($session->date_fin)) : '';
        $duree = $session ? $session->duree : '';
        $type_location = $session ? $session->type_location : 'distance';
        $location_details = $session ? $session->location_details : '';
        $places_total = $session ? $session->places_total : 0;
        $places_disponibles = $session ? $session->places_disponibles : 0;
        $status = $session ? $session->status : 'active';
        ?>
        <div class="cf-session-content">
            <div class="cf-form-group">
                <label><?php _e('Titre de la session', 'calendrier-formation'); ?> *</label>
                <input type="text" name="session_title" value="<?php echo esc_attr($session_title); ?>" required>
            </div>

            <div class="cf-form-group">
                <label><?php _e('Date et heure de début', 'calendrier-formation'); ?> *</label>
                <input type="datetime-local" name="date_debut" class="cf-datepicker" value="<?php echo esc_attr($date_debut); ?>" required>
            </div>

            <div class="cf-form-group">
                <label><?php _e('Date et heure de fin', 'calendrier-formation'); ?> *</label>
                <input type="datetime-local" name="date_fin" class="cf-datepicker" value="<?php echo esc_attr($date_fin); ?>" required>
            </div>

            <div class="cf-form-group">
                <label><?php _e('Durée (ex: 2 jours, 14 heures)', 'calendrier-formation'); ?></label>
                <input type="text" name="duree" value="<?php echo esc_attr($duree); ?>">
            </div>

            <div class="cf-form-group">
                <label><?php _e('Type de formation', 'calendrier-formation'); ?> *</label>
                <select name="type_location" class="cf-location-type">
                    <option value="distance" <?php selected($type_location, 'distance'); ?>><?php _e('À distance', 'calendrier-formation'); ?></option>
                    <option value="lieu" <?php selected($type_location, 'lieu'); ?>><?php _e('En présentiel', 'calendrier-formation'); ?></option>
                </select>
            </div>

            <div class="cf-form-group cf-location-fields <?php echo $type_location === 'lieu' ? 'active' : ''; ?>">
                <label><?php _e('Adresse du lieu', 'calendrier-formation'); ?></label>
                <textarea name="location_details"><?php echo esc_textarea($location_details); ?></textarea>
            </div>

            <div class="cf-form-group">
                <label><?php _e('Nombre de places total', 'calendrier-formation'); ?> *</label>
                <input type="number" name="places_total" value="<?php echo esc_attr($places_total); ?>" min="0" required>
            </div>

            <div class="cf-form-group">
                <label><?php _e('Places disponibles', 'calendrier-formation'); ?> *</label>
                <input type="number" name="places_disponibles" value="<?php echo esc_attr($places_disponibles); ?>" min="0" required>
            </div>

            <div class="cf-form-group">
                <label><?php _e('Statut', 'calendrier-formation'); ?></label>
                <select name="status">
                    <option value="active" <?php selected($status, 'active'); ?>><?php _e('Active', 'calendrier-formation'); ?></option>
                    <option value="inactive" <?php selected($status, 'inactive'); ?>><?php _e('Inactive', 'calendrier-formation'); ?></option>
                </select>
            </div>
        </div>

        <div class="cf-form-actions" style="margin-top: 15px; display: flex; gap: 10px;">
            <button type="button" class="button button-primary cf-save-session">
                <span class="dashicons dashicons-yes"></span> <?php _e('Enregistrer', 'calendrier-formation'); ?>
            </button>
            <?php if ($session): ?>
            <button type="button" class="button cf-cancel-edit">
                <?php _e('Annuler', 'calendrier-formation'); ?>
            </button>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Sauvegarde les sessions (legacy - maintenant via AJAX)
     */
    public function save_sessions($post_id, $post) {
        // Vérifications de sécurité
        if (!isset($_POST['cf_sessions_nonce']) || !wp_verify_nonce($_POST['cf_sessions_nonce'], 'cf_save_sessions')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if ($post->post_type !== 'page') {
            return;
        }

        // Vérifier que c'est bien une page enfant de la page Formations
        $settings = get_option('cf_settings', array());
        $parent_id = isset($settings['formations_parent_id']) ? $settings['formations_parent_id'] : 51;

        if (wp_get_post_parent_id($post_id) != $parent_id) {
            return;
        }

        // Les sessions sont maintenant gérées via AJAX
    }

    /**
     * AJAX: Supprimer une session
     */
    public function ajax_delete_session() {
        check_ajax_referer('cf_delete_session', 'nonce');

        if (!current_user_can('edit_posts')) {
            wp_send_json_error(array('message' => 'Permission denied'));
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'cf_sessions';
        $session_id = intval($_POST['session_id']);

        $result = $wpdb->delete($table_name, array('id' => $session_id), array('%d'));

        if ($result) {
            wp_send_json_success();
        } else {
            wp_send_json_error(array('message' => 'Failed to delete session'));
        }
    }

    /**
     * AJAX: Ajouter une session
     */
    public function ajax_add_session() {
        check_ajax_referer('cf_save_session', 'nonce');

        if (!current_user_can('edit_posts')) {
            wp_send_json_error(array('message' => 'Permission denied'));
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'cf_sessions';

        $data = array(
            'post_id' => intval($_POST['post_id']),
            'session_title' => sanitize_text_field($_POST['session_title']),
            'date_debut' => sanitize_text_field($_POST['date_debut']),
            'date_fin' => sanitize_text_field($_POST['date_fin']),
            'duree' => sanitize_text_field($_POST['duree']),
            'type_location' => sanitize_text_field($_POST['type_location']),
            'location_details' => sanitize_textarea_field($_POST['location_details']),
            'places_total' => intval($_POST['places_total']),
            'places_disponibles' => intval($_POST['places_disponibles']),
            'status' => sanitize_text_field($_POST['status']),
        );

        $result = $wpdb->insert($table_name, $data);

        if ($result) {
            wp_send_json_success(array('session_id' => $wpdb->insert_id));
        } else {
            wp_send_json_error(array('message' => 'Failed to add session'));
        }
    }

    /**
     * AJAX: Mettre à jour une session
     */
    public function ajax_update_session() {
        check_ajax_referer('cf_save_session', 'nonce');

        if (!current_user_can('edit_posts')) {
            wp_send_json_error(array('message' => 'Permission denied'));
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'cf_sessions';
        $session_id = intval($_POST['session_id']);

        $data = array(
            'session_title' => sanitize_text_field($_POST['session_title']),
            'date_debut' => sanitize_text_field($_POST['date_debut']),
            'date_fin' => sanitize_text_field($_POST['date_fin']),
            'duree' => sanitize_text_field($_POST['duree']),
            'type_location' => sanitize_text_field($_POST['type_location']),
            'location_details' => sanitize_textarea_field($_POST['location_details']),
            'places_total' => intval($_POST['places_total']),
            'places_disponibles' => intval($_POST['places_disponibles']),
            'status' => sanitize_text_field($_POST['status']),
        );

        $result = $wpdb->update($table_name, $data, array('id' => $session_id));

        if ($result !== false) {
            wp_send_json_success();
        } else {
            wp_send_json_error(array('message' => 'Failed to update session'));
        }
    }
}
