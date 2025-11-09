<?php
/**
 * Scanner de formations existantes
 * Détecte automatiquement les pages enfants de la page Formations
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Formations_Scanner {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Rien pour le moment, tout est statique
    }

    /**
     * Scanne et retourne toutes les formations (pages enfants de la page Formations)
     */
    public static function get_all_formations() {
        $settings = get_option('cf_settings', array());
        $parent_id = isset($settings['formations_parent_id']) ? $settings['formations_parent_id'] : 51;

        $formations = get_pages(array(
            'child_of' => $parent_id,
            'parent' => $parent_id, // Uniquement les enfants directs
            'sort_column' => 'post_title',
            'sort_order' => 'ASC',
        ));

        return $formations;
    }

    /**
     * Retourne une formation par ID
     */
    public static function get_formation($formation_id) {
        $formation = get_post($formation_id);

        if (!$formation || $formation->post_type !== 'page') {
            return null;
        }

        // Vérifier que c'est bien une page enfant de Formations
        $settings = get_option('cf_settings', array());
        $parent_id = isset($settings['formations_parent_id']) ? $settings['formations_parent_id'] : 51;

        if ($formation->post_parent != $parent_id) {
            return null;
        }

        return $formation;
    }

    /**
     * Retourne les formations sous forme de tableau pour les sélecteurs
     */
    public static function get_formations_for_select() {
        $formations = self::get_all_formations();
        $options = array();

        foreach ($formations as $formation) {
            $options[$formation->ID] = $formation->post_title;
        }

        return $options;
    }

    /**
     * Compte le nombre de formations
     */
    public static function count_formations() {
        return count(self::get_all_formations());
    }

    /**
     * Retourne les statistiques par formation
     */
    public static function get_formations_with_stats() {
        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        $formations = self::get_all_formations();
        $formations_with_stats = array();

        foreach ($formations as $formation) {
            // Compter les sessions
            $total_sessions = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $table_sessions WHERE post_id = %d AND status = 'active'",
                $formation->ID
            ));

            // Compter les sessions à venir
            $upcoming_sessions = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $table_sessions WHERE post_id = %d AND status = 'active' AND date_debut >= NOW()",
                $formation->ID
            ));

            // Prochaine session
            $next_session = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table_sessions
                 WHERE post_id = %d AND status = 'active' AND date_debut >= NOW()
                 ORDER BY date_debut ASC LIMIT 1",
                $formation->ID
            ));

            $formations_with_stats[] = array(
                'id' => $formation->ID,
                'title' => $formation->post_title,
                'slug' => $formation->post_name,
                'url' => get_permalink($formation->ID),
                'edit_url' => get_edit_post_link($formation->ID),
                'total_sessions' => (int) $total_sessions,
                'upcoming_sessions' => (int) $upcoming_sessions,
                'next_session' => $next_session,
            );
        }

        return $formations_with_stats;
    }
}
