<?php
/**
 * Gestionnaire des sessions - Vue tableau
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Sessions_Manager {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Géré par le menu
    }

    /**
     * Affiche la page de gestion des sessions
     */
    public function render_sessions_page() {
        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        // Filtres
        $formation_filter = isset($_GET['formation_id']) ? intval($_GET['formation_id']) : 0;
        $status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
        $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

        // Query
        $query = "SELECT s.*, p.post_title as formation_title
                  FROM $table_sessions s
                  LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
                  WHERE 1=1";

        if ($formation_filter > 0) {
            $query .= $wpdb->prepare(" AND s.post_id = %d", $formation_filter);
        }

        if ($status_filter !== 'all') {
            $query .= $wpdb->prepare(" AND s.status = %s", $status_filter);
        }

        if (!empty($search)) {
            $query .= $wpdb->prepare(" AND (s.session_title LIKE %s OR p.post_title LIKE %s)",
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%'
            );
        }

        $query .= " ORDER BY s.date_debut DESC";

        $sessions = $wpdb->get_results($query);

        // Formations pour le filtre
        $formations = CF_Formations_Scanner::get_formations_for_select();

        include CF_PLUGIN_DIR . 'templates/sessions.php';
    }
}
