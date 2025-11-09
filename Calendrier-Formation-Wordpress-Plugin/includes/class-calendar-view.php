<?php
/**
 * Vue Calendrier avec FullCalendar
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Calendar_View {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Les hooks sont gérés par le menu
    }

    /**
     * Affiche la page calendrier
     */
    public function render_calendar_page() {
        // Récupérer les formations pour les filtres
        $formations = CF_Formations_Scanner::get_formations_for_select();

        include CF_PLUGIN_DIR . 'templates/calendar.php';
    }

    /**
     * Retourne les événements pour FullCalendar (appelé via AJAX)
     */
    public function get_calendar_events() {
        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        $start = isset($_GET['start']) ? sanitize_text_field($_GET['start']) : null;
        $end = isset($_GET['end']) ? sanitize_text_field($_GET['end']) : null;
        $formation_id = isset($_GET['formation_id']) ? intval($_GET['formation_id']) : 0;

        $query = "SELECT s.*, p.post_title as formation_title
                  FROM $table_sessions s
                  LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
                  WHERE s.status = 'active'";

        if ($start && $end) {
            $query .= $wpdb->prepare(" AND s.date_debut BETWEEN %s AND %s", $start, $end);
        }

        if ($formation_id > 0) {
            $query .= $wpdb->prepare(" AND s.post_id = %d", $formation_id);
        }

        $query .= " ORDER BY s.date_debut ASC";

        $sessions = $wpdb->get_results($query);

        $events = array();
        foreach ($sessions as $session) {
            $is_full = $session->places_disponibles <= 0;
            $is_limited = $session->places_disponibles <= 3 && $session->places_disponibles > 0;

            // Définir la couleur selon le statut
            $color = '#46b450'; // Vert par défaut
            if ($is_full) {
                $color = '#dc3232'; // Rouge si complet
            } elseif ($is_limited) {
                $color = '#f0ad4e'; // Orange si places limitées
            }

            $events[] = array(
                'id' => $session->id,
                'title' => $session->formation_title . ' - ' . $session->session_title,
                'start' => $session->date_debut,
                'end' => $session->date_fin,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => array(
                    'session_id' => $session->id,
                    'formation_id' => $session->post_id,
                    'formation_title' => $session->formation_title,
                    'session_title' => $session->session_title,
                    'type_location' => $session->type_location,
                    'location_details' => $session->location_details,
                    'places_total' => $session->places_total,
                    'places_disponibles' => $session->places_disponibles,
                    'is_full' => $is_full,
                    'is_limited' => $is_limited,
                    'duree' => $session->duree,
                ),
            );
        }

        return $events;
    }
}
