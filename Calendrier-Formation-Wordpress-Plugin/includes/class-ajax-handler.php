<?php
/**
 * Gestionnaire AJAX pour toutes les opérations
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Ajax_Handler {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Événements calendrier
        add_action('wp_ajax_cf_get_calendar_events', array($this, 'get_calendar_events'));

        // CRUD Sessions
        add_action('wp_ajax_cf_create_session', array($this, 'create_session'));
        add_action('wp_ajax_cf_update_session', array($this, 'update_session'));
        add_action('wp_ajax_cf_delete_session', array($this, 'delete_session'));
        add_action('wp_ajax_cf_get_session', array($this, 'get_session'));
        add_action('wp_ajax_cf_get_sessions', array($this, 'get_sessions'));

        // Déplacement de session (drag & drop)
        add_action('wp_ajax_cf_move_session', array($this, 'move_session'));

        // Ajustement rapide des places (+/-)
        add_action('wp_ajax_cf_adjust_places', array($this, 'adjust_places'));
    }

    /**
     * Vérification de sécurité
     */
    private function verify_nonce() {
        if (!isset($_POST['nonce']) && !isset($_GET['nonce'])) {
            wp_send_json_error(array('message' => 'Nonce manquant'));
            exit;
        }

        $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : $_GET['nonce'];

        if (!wp_verify_nonce($nonce, 'cf_admin_nonce')) {
            wp_send_json_error(array('message' => 'Nonce invalide'));
            exit;
        }

        if (!current_user_can('edit_pages')) {
            wp_send_json_error(array('message' => 'Permission refusée'));
            exit;
        }

        return true;
    }

    /**
     * Récupère les événements pour le calendrier
     */
    public function get_calendar_events() {
        $this->verify_nonce();

        $calendar_view = CF_Calendar_View::get_instance();
        $events = $calendar_view->get_calendar_events();

        wp_send_json_success($events);
    }

    /**
     * Créer une session
     */
    public function create_session() {
        $this->verify_nonce();

        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        // Convertir les dates au format MySQL (juste la date, pas d'heure)
        $date_debut = isset($_POST['date_debut']) ? sanitize_text_field($_POST['date_debut']) . ' 00:00:00' : '';
        $date_fin = isset($_POST['date_fin']) ? sanitize_text_field($_POST['date_fin']) . ' 23:59:59' : '';

        // Gestion places illimitées (-1)
        $places_total = intval($_POST['places_total']);
        $places_disponibles = intval($_POST['places_disponibles']);

        $data = array(
            'post_id' => intval($_POST['formation_id']),
            'session_title' => sanitize_text_field($_POST['session_title']),
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'duree' => isset($_POST['duree']) ? sanitize_text_field($_POST['duree']) : '',
            'type_location' => isset($_POST['type_location']) ? sanitize_text_field($_POST['type_location']) : 'distance',
            'location_details' => isset($_POST['location_details']) ? sanitize_textarea_field($_POST['location_details']) : '',
            'places_total' => $places_total,
            'places_disponibles' => $places_disponibles,
            'status' => isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'active',
            'reservation_url' => isset($_POST['reservation_url']) ? esc_url_raw($_POST['reservation_url']) : '',
        );

        // Validation des données
        if (empty($data['post_id']) || empty($data['session_title']) || empty($data['date_debut']) || empty($data['date_fin'])) {
            wp_send_json_error(array('message' => __('Données manquantes ou invalides', 'calendrier-formation')));
            exit;
        }

        $result = $wpdb->insert(
            $table_sessions,
            $data,
            array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s')
        );

        if ($result) {
            $session_id = $wpdb->insert_id;
            $session = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_sessions WHERE id = %d", $session_id));

            wp_send_json_success(array(
                'message' => __('Session créée avec succès', 'calendrier-formation'),
                'session' => $session
            ));
        } else {
            $error_message = $wpdb->last_error ? $wpdb->last_error : __('Erreur lors de la création', 'calendrier-formation');
            wp_send_json_error(array('message' => $error_message));
        }
    }

    /**
     * Mettre à jour une session
     */
    public function update_session() {
        $this->verify_nonce();

        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';
        $session_id = intval($_POST['session_id']);

        if (empty($session_id)) {
            wp_send_json_error(array('message' => __('ID de session manquant', 'calendrier-formation')));
            exit;
        }

        // Convertir les dates au format MySQL (juste la date, pas d'heure)
        $date_debut = isset($_POST['date_debut']) ? sanitize_text_field($_POST['date_debut']) . ' 00:00:00' : '';
        $date_fin = isset($_POST['date_fin']) ? sanitize_text_field($_POST['date_fin']) . ' 23:59:59' : '';

        // Gestion places illimitées (-1)
        $places_total = intval($_POST['places_total']);
        $places_disponibles = intval($_POST['places_disponibles']);

        $data = array(
            'post_id' => intval($_POST['formation_id']),
            'session_title' => sanitize_text_field($_POST['session_title']),
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'duree' => isset($_POST['duree']) ? sanitize_text_field($_POST['duree']) : '',
            'type_location' => isset($_POST['type_location']) ? sanitize_text_field($_POST['type_location']) : 'distance',
            'location_details' => isset($_POST['location_details']) ? sanitize_textarea_field($_POST['location_details']) : '',
            'places_total' => $places_total,
            'places_disponibles' => $places_disponibles,
            'status' => isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'active',
            'reservation_url' => isset($_POST['reservation_url']) ? esc_url_raw($_POST['reservation_url']) : '',
        );

        $result = $wpdb->update(
            $table_sessions,
            $data,
            array('id' => $session_id),
            array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s'),
            array('%d')
        );

        if ($result !== false) {
            $session = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_sessions WHERE id = %d", $session_id));

            wp_send_json_success(array(
                'message' => __('Session mise à jour', 'calendrier-formation'),
                'session' => $session
            ));
        } else {
            $error_message = $wpdb->last_error ? $wpdb->last_error : __('Erreur lors de la mise à jour', 'calendrier-formation');
            wp_send_json_error(array('message' => $error_message));
        }
    }

    /**
     * Supprimer une session
     */
    public function delete_session() {
        $this->verify_nonce();

        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';
        $session_id = intval($_POST['session_id']);

        $result = $wpdb->delete($table_sessions, array('id' => $session_id));

        if ($result) {
            wp_send_json_success(array('message' => __('Session supprimée', 'calendrier-formation')));
        } else {
            wp_send_json_error(array('message' => __('Erreur lors de la suppression', 'calendrier-formation')));
        }
    }

    /**
     * Récupérer une session
     */
    public function get_session() {
        $this->verify_nonce();

        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';
        $session_id = intval($_GET['session_id']);

        $session = $wpdb->get_row($wpdb->prepare(
            "SELECT s.*, p.post_title as formation_title
             FROM $table_sessions s
             LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
             WHERE s.id = %d",
            $session_id
        ));

        if ($session) {
            wp_send_json_success($session);
        } else {
            wp_send_json_error(array('message' => __('Session introuvable', 'calendrier-formation')));
        }
    }

    /**
     * Récupérer toutes les sessions avec filtres
     */
    public function get_sessions() {
        $this->verify_nonce();

        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        $formation_id = isset($_GET['formation_id']) ? intval($_GET['formation_id']) : 0;
        $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
        $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

        $query = "SELECT s.*, p.post_title as formation_title
                  FROM $table_sessions s
                  LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
                  WHERE 1=1";

        if ($formation_id > 0) {
            $query .= $wpdb->prepare(" AND s.post_id = %d", $formation_id);
        }

        if ($status !== 'all') {
            $query .= $wpdb->prepare(" AND s.status = %s", $status);
        }

        if (!empty($search)) {
            $query .= $wpdb->prepare(" AND (s.session_title LIKE %s OR p.post_title LIKE %s)",
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%'
            );
        }

        $query .= " ORDER BY s.date_debut DESC";

        $sessions = $wpdb->get_results($query);

        wp_send_json_success($sessions);
    }

    /**
     * Déplacer une session (drag & drop calendrier)
     */
    public function move_session() {
        $this->verify_nonce();

        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';
        $session_id = intval($_POST['session_id']);
        $new_start = sanitize_text_field($_POST['new_start']);
        $new_end = sanitize_text_field($_POST['new_end']);

        $result = $wpdb->update(
            $table_sessions,
            array(
                'date_debut' => $new_start,
                'date_fin' => $new_end
            ),
            array('id' => $session_id)
        );

        if ($result !== false) {
            wp_send_json_success(array('message' => __('Session déplacée', 'calendrier-formation')));
        } else {
            wp_send_json_error(array('message' => __('Erreur lors du déplacement', 'calendrier-formation')));
        }
    }

    /**
     * Ajuster les places disponibles (+/-)
     */
    public function adjust_places() {
        $this->verify_nonce();

        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';
        $session_id = intval($_POST['session_id']);
        $adjustment = sanitize_text_field($_POST['adjustment']); // 'add' ou 'remove'

        if (empty($session_id)) {
            wp_send_json_error(array('message' => __('ID de session manquant', 'calendrier-formation')));
            exit;
        }

        // Récupérer la session actuelle
        $session = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_sessions WHERE id = %d",
            $session_id
        ));

        if (!$session) {
            wp_send_json_error(array('message' => __('Session introuvable', 'calendrier-formation')));
            exit;
        }

        // Calculer la nouvelle valeur
        $new_places = $session->places_disponibles;
        if ($adjustment === 'add') {
            $new_places++;
        } elseif ($adjustment === 'remove') {
            $new_places--;
        }

        // Vérifier les limites
        if ($new_places < 0) {
            wp_send_json_error(array('message' => __('Impossible de descendre en dessous de 0', 'calendrier-formation')));
            exit;
        }

        if ($new_places > $session->places_total) {
            wp_send_json_error(array('message' => __('Impossible de dépasser le nombre total de places', 'calendrier-formation')));
            exit;
        }

        // Mettre à jour
        $result = $wpdb->update(
            $table_sessions,
            array('places_disponibles' => $new_places),
            array('id' => $session_id),
            array('%d'),
            array('%d')
        );

        if ($result !== false) {
            $message = $adjustment === 'add'
                ? __('Place libérée', 'calendrier-formation')
                : __('Place réservée', 'calendrier-formation');

            wp_send_json_success(array(
                'message' => $message,
                'places_disponibles' => $new_places,
                'places_total' => $session->places_total
            ));
        } else {
            wp_send_json_error(array('message' => __('Erreur lors de la mise à jour', 'calendrier-formation')));
        }
    }
}
