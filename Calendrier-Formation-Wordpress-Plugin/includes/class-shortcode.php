<?php
/**
 * Gestion du shortcode pour afficher les sessions
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Shortcode {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_shortcode('calendrier_formation', array($this, 'render_shortcode'));
    }

    /**
     * Rendu du shortcode
     */
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'post_id' => get_the_ID(),
            'limit' => 0,
            'show_past' => 'non',
            'debug' => 'non',
            'display' => 'cards', // 'cards' ou 'table'
        ), $atts, 'calendrier_formation');

        $post_id = intval($atts['post_id']);
        $limit = intval($atts['limit']);
        $show_past = ($atts['show_past'] === 'oui');
        $debug = ($atts['debug'] === 'oui');
        $display = sanitize_text_field($atts['display']);

        // Vérifier si la page est une page de formation (enfant de la page Formations OU la page parent elle-même)
        $settings = get_option('cf_settings', array());
        $parent_id = isset($settings['formations_parent_id']) ? $settings['formations_parent_id'] : 51;

        $current_parent = wp_get_post_parent_id($post_id);

        // Mode debug
        if ($debug && current_user_can('manage_options')) {
            $debug_info = '<div style="background: #f0f0f0; padding: 15px; margin: 10px 0; border-left: 4px solid #2271b1;">';
            $debug_info .= '<strong>DEBUG MODE</strong><br>';
            $debug_info .= 'post_id actuel: ' . $post_id . '<br>';
            $debug_info .= 'parent de la page: ' . $current_parent . '<br>';
            $debug_info .= 'formations_parent_id (config): ' . $parent_id . '<br>';
            $debug_info .= 'show_past: ' . ($show_past ? 'oui' : 'non') . '<br>';

            global $wpdb;
            $table_name = $wpdb->prefix . 'cf_sessions';
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE post_id = %d", $post_id));
            $debug_info .= 'Nombre de sessions dans la BDD pour ce post_id: ' . $count . '<br>';

            $count_active = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE post_id = %d AND status = 'active'", $post_id));
            $debug_info .= 'Sessions actives: ' . $count_active . '<br>';

            $debug_info .= '</div>';

            echo $debug_info;
        }

        // Permettre l'affichage si c'est une page enfant OU la page parent elle-même
        if ($current_parent != $parent_id && $post_id != $parent_id) {
            return '<div class="cf-notice">' . __('Cette page n\'est pas une page de formation. Les sessions ne peuvent être affichées que sur les pages enfants de la page Formations.', 'calendrier-formation') . '</div>';
        }

        // Récupérer les sessions
        $sessions = $this->get_sessions($post_id, $limit, $show_past);

        if (empty($sessions)) {
            return '<div class="cf-no-sessions-message">' . __('Aucune session programmée pour le moment.', 'calendrier-formation') . '</div>';
        }

        // Récupérer l'URL du formulaire
        $settings = get_option('cf_settings', array());
        $form_url = isset($settings['form_url']) ? $settings['form_url'] : '';

        // Générer le HTML selon le mode d'affichage
        if ($display === 'table') {
            return $this->render_table_view($sessions, $form_url);
        } else {
            return $this->render_cards_view($sessions, $form_url);
        }
    }

    /**
     * Affichage en mode cartes (défaut)
     */
    private function render_cards_view($sessions, $form_url) {
        ob_start();
        ?>
        <div class="cf-sessions-container">
            <div class="cf-sessions-header">
                <h2 class="cf-sessions-title"><?php _e('Sessions de formation disponibles', 'calendrier-formation'); ?></h2>
            </div>

            <div class="cf-sessions-grid">
                <?php foreach ($sessions as $session): ?>
                    <?php $this->render_session_card($session, $form_url); ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Affichage en mode tableau
     */
    private function render_table_view($sessions, $form_url) {
        ob_start();
        ?>
        <div class="cf-sessions-container cf-sessions-table-view">
            <div class="cf-sessions-header">
                <h2 class="cf-sessions-title"><?php _e('Sessions de formation disponibles', 'calendrier-formation'); ?></h2>
            </div>

            <div class="cf-table-responsive">
                <table class="cf-sessions-table-display">
                    <thead>
                        <tr>
                            <th><?php _e('Session', 'calendrier-formation'); ?></th>
                            <th><?php _e('Date début', 'calendrier-formation'); ?></th>
                            <th><?php _e('Date fin', 'calendrier-formation'); ?></th>
                            <th><?php _e('Durée', 'calendrier-formation'); ?></th>
                            <th><?php _e('Localisation', 'calendrier-formation'); ?></th>
                            <th><?php _e('Places', 'calendrier-formation'); ?></th>
                            <th><?php _e('Actions', 'calendrier-formation'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sessions as $session): ?>
                            <?php $this->render_session_row($session, $form_url); ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }


    /**
     * Récupère les sessions d'une formation
     */
    private function get_sessions($post_id, $limit = 0, $show_past = false) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cf_sessions';

        $query = "SELECT * FROM $table_name WHERE post_id = %d AND status = 'active'";
        $params = array($post_id);

        if (!$show_past) {
            $query .= " AND date_debut >= NOW()";
        }

        $query .= " ORDER BY date_debut ASC";

        if ($limit > 0) {
            $query .= " LIMIT %d";
            $params[] = $limit;
        }

        return $wpdb->get_results($wpdb->prepare($query, $params));
    }

    /**
     * Affiche une ligne de tableau pour une session
     */
    private function render_session_row($session, $form_url) {
        $date_debut = new DateTime($session->date_debut);
        $date_fin = new DateTime($session->date_fin);

        // Vérifier si la session est complète
        $is_full = $session->places_disponibles <= 0;

        // Construire l'URL de réservation
        $booking_url = $this->generate_booking_url($session, $form_url);

        // Récupérer l'URL de la page contact pour le bouton "+ d'infos"
        $settings = get_option('cf_settings', array());
        $contact_page_id = isset($settings['contact_page_id']) ? $settings['contact_page_id'] : 0;
        $contact_url = $contact_page_id ? get_permalink($contact_page_id) : '#';

        // Calculer le pourcentage de disponibilité
        $availability_percentage = ($session->places_total > 0)
            ? round(($session->places_disponibles / $session->places_total) * 100)
            : 0;

        // Déterminer la classe de couleur
        $status_class = 'cf-status-green';
        if ($availability_percentage < 30) {
            $status_class = 'cf-status-red';
        } elseif ($availability_percentage < 70) {
            $status_class = 'cf-status-orange';
        }
        ?>
        <tr class="cf-session-table-row <?php echo $is_full ? 'cf-row-full' : ''; ?>">
            <td data-label="<?php _e('Session', 'calendrier-formation'); ?>">
                <strong><?php echo esc_html($session->session_title); ?></strong>
            </td>
            <td data-label="<?php _e('Date début', 'calendrier-formation'); ?>">
                <?php echo esc_html($date_debut->format('d/m/Y')); ?>
            </td>
            <td data-label="<?php _e('Date fin', 'calendrier-formation'); ?>">
                <?php echo esc_html($date_fin->format('d/m/Y')); ?>
            </td>
            <td data-label="<?php _e('Durée', 'calendrier-formation'); ?>">
                <?php echo esc_html($session->duree); ?>
            </td>
            <td data-label="<?php _e('Localisation', 'calendrier-formation'); ?>">
                <?php if ($session->type_location === 'distance'): ?>
                    <span class="cf-location-badge cf-location-distance">
                        <span class="dashicons dashicons-desktop"></span>
                        <?php _e('À distance', 'calendrier-formation'); ?>
                    </span>
                <?php else: ?>
                    <span class="cf-location-badge cf-location-lieu">
                        <span class="dashicons dashicons-location"></span>
                        <?php echo esc_html($session->location_details ? $session->location_details : __('En présentiel', 'calendrier-formation')); ?>
                    </span>
                <?php endif; ?>
            </td>
            <td data-label="<?php _e('Places', 'calendrier-formation'); ?>">
                <span class="cf-places-indicator <?php echo esc_attr($status_class); ?>">
                    <strong><?php echo esc_html($session->places_disponibles); ?></strong> / <?php echo esc_html($session->places_total); ?>
                </span>
                <?php if ($is_full): ?>
                    <span class="cf-badge cf-badge-full"><?php _e('Complet', 'calendrier-formation'); ?></span>
                <?php elseif ($session->places_disponibles <= 3): ?>
                    <span class="cf-badge cf-badge-warning"><?php _e('Limité', 'calendrier-formation'); ?></span>
                <?php endif; ?>
            </td>
            <td data-label="<?php _e('Actions', 'calendrier-formation'); ?>" class="cf-table-actions">
                <?php if ($is_full): ?>
                    <button class="cf-btn-table cf-btn-disabled" disabled>
                        <?php _e('Complet', 'calendrier-formation'); ?>
                    </button>
                <?php else: ?>
                    <a href="<?php echo esc_url($booking_url); ?>" class="cf-btn-table cf-btn-primary">
                        <?php _e('Réserver', 'calendrier-formation'); ?>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url($contact_url); ?>" class="cf-btn-table cf-btn-secondary">
                    <?php _e('+ d\'infos', 'calendrier-formation'); ?>
                </a>
            </td>
        </tr>
        <?php
    }

    /**
     * Affiche une carte de session
     */
    private function render_session_card($session, $form_url) {
        $date_debut = new DateTime($session->date_debut);
        $date_fin = new DateTime($session->date_fin);

        // Vérifier si la session est complète
        $is_full = $session->places_disponibles <= 0;

        // Construire l'URL de réservation
        $booking_url = $this->generate_booking_url($session, $form_url);

        // Calculer le pourcentage de places PRISES (pour la largeur de la jauge)
        $places_prises = $session->places_total - $session->places_disponibles;
        $places_percentage = ($session->places_total > 0)
            ? round(($places_prises / $session->places_total) * 100)
            : 0;

        // Calculer le pourcentage de places DISPONIBLES (pour la couleur de la jauge)
        $availability_percentage = ($session->places_total > 0)
            ? round(($session->places_disponibles / $session->places_total) * 100)
            : 0;

        // Déterminer la classe de couleur selon la disponibilité
        $progress_class = 'cf-progress-green'; // Par défaut: bonne disponibilité
        if ($availability_percentage < 30) {
            $progress_class = 'cf-progress-red'; // Faible disponibilité
        } elseif ($availability_percentage < 70) {
            $progress_class = 'cf-progress-orange'; // Disponibilité moyenne
        }

        ?>
        <div class="cf-session-card <?php echo $is_full ? 'cf-session-full' : ''; ?>">
            <div class="cf-session-card-header">
                <h3 class="cf-session-card-title"><?php echo esc_html($session->session_title); ?></h3>
                <?php if ($is_full): ?>
                    <span class="cf-badge cf-badge-full"><?php _e('Complet', 'calendrier-formation'); ?></span>
                <?php elseif ($session->places_disponibles <= 3): ?>
                    <span class="cf-badge cf-badge-warning"><?php _e('Places limitées', 'calendrier-formation'); ?></span>
                <?php else: ?>
                    <span class="cf-badge cf-badge-available"><?php _e('Places disponibles', 'calendrier-formation'); ?></span>
                <?php endif; ?>
            </div>

            <div class="cf-session-card-body">
                <div class="cf-session-info-grid">
                    <div class="cf-session-info-item">
                        <span class="cf-info-icon dashicons dashicons-calendar"></span>
                        <div class="cf-info-content">
                            <div class="cf-info-label"><?php _e('Début', 'calendrier-formation'); ?></div>
                            <div class="cf-info-value"><?php echo esc_html($date_debut->format('d/m/Y')); ?></div>
                        </div>
                    </div>

                    <div class="cf-session-info-item">
                        <span class="cf-info-icon dashicons dashicons-calendar"></span>
                        <div class="cf-info-content">
                            <div class="cf-info-label"><?php _e('Fin', 'calendrier-formation'); ?></div>
                            <div class="cf-info-value"><?php echo esc_html($date_fin->format('d/m/Y')); ?></div>
                        </div>
                    </div>

                    <?php if (!empty($session->duree)): ?>
                    <div class="cf-session-info-item">
                        <span class="cf-info-icon dashicons dashicons-clock"></span>
                        <div class="cf-info-content">
                            <div class="cf-info-label"><?php _e('Durée', 'calendrier-formation'); ?></div>
                            <div class="cf-info-value"><?php echo esc_html($session->duree); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="cf-session-info-item">
                        <span class="cf-info-icon dashicons dashicons-location"></span>
                        <div class="cf-info-content">
                            <div class="cf-info-label"><?php _e('Localisation', 'calendrier-formation'); ?></div>
                            <div class="cf-info-value">
                                <?php if ($session->type_location === 'distance'): ?>
                                    <?php _e('À distance', 'calendrier-formation'); ?>
                                <?php else: ?>
                                    <?php echo esc_html($session->location_details ? $session->location_details : __('En présentiel', 'calendrier-formation')); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cf-session-places">
                    <div class="cf-places-header">
                        <span class="cf-places-label"><?php _e('Places disponibles', 'calendrier-formation'); ?></span>
                        <span class="cf-places-count">
                            <strong class="<?php echo esc_attr(str_replace('cf-progress-', 'cf-count-', $progress_class)); ?>">
                                <?php echo esc_html($session->places_disponibles); ?>
                            </strong> / <?php echo esc_html($session->places_total); ?>
                        </span>
                    </div>
                    <div class="cf-places-bar">
                        <div class="cf-places-progress <?php echo esc_attr($progress_class); ?>" style="width: <?php echo esc_attr($places_percentage); ?>%;"></div>
                    </div>
                </div>
            </div>

            <div class="cf-session-card-footer">
                <?php if ($is_full): ?>
                    <button class="cf-btn cf-btn-disabled" disabled>
                        <?php _e('Session complète', 'calendrier-formation'); ?>
                    </button>
                <?php else: ?>
                    <a href="<?php echo esc_url($booking_url); ?>" class="cf-btn cf-btn-primary">
                        <?php echo esc_html(CF_Settings::get_setting('text_button_reserve', __('Réserver ma place', 'calendrier-formation'))); ?>
                        <span class="dashicons dashicons-arrow-right-alt"></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Génère l'URL de réservation avec les paramètres
     */
    private function generate_booking_url($session, $form_url) {
        // Si form_url est vide, utiliser l'ID de page d'inscription
        if (empty($form_url)) {
            $settings = get_option('cf_settings', array());
            $inscription_page_id = isset($settings['inscription_page_id']) ? intval($settings['inscription_page_id']) : 0;

            // Si pas d'ID ou page inexistante, créer la page maintenant
            if (!$inscription_page_id || !get_post($inscription_page_id)) {
                $inscription_page_id = $this->create_inscription_page();

                // Sauvegarder l'ID dans les settings
                $settings['inscription_page_id'] = $inscription_page_id;
                update_option('cf_settings', $settings);
            }

            $form_url = get_permalink($inscription_page_id);

            if (!$form_url) {
                // Fallback: retourner l'URL de base avec message
                return home_url('?cf_error=no_booking_page');
            }
        }

        // Paramètre minimum : uniquement session_id
        // Le reste sera récupéré depuis la BDD par le formulaire
        $params = array(
            'session_id' => $session->id
        );

        // Construire l'URL (beaucoup plus courte maintenant)
        $url = add_query_arg($params, $form_url);

        return $url;
    }

    /**
     * Génère une clé unique pour la réservation
     */
    private function generate_booking_key($session) {
        return md5($session->id . $session->post_id . time() . wp_rand());
    }

    /**
     * Crée la page d'inscription si elle n'existe pas
     */
    private function create_inscription_page() {
        $inscription_page = array(
            'post_title'    => __('Inscription Formation', 'calendrier-formation'),
            'post_content'  => '[formulaire_reservation]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => get_current_user_id(),
            'comment_status' => 'closed',
            'ping_status'   => 'closed'
        );

        return wp_insert_post($inscription_page);
    }
}
