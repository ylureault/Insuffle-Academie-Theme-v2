<?php
/**
 * Gestion des migrations de base de données
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Database_Migration {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('plugins_loaded', array($this, 'check_migrations'));
    }

    /**
     * Vérifie et exécute les migrations nécessaires
     */
    public function check_migrations() {
        $current_version = get_option('cf_db_version', '0.0.0');

        // Ajouter le champ reservation_url si nécessaire
        if (version_compare($current_version, '2.1.0', '<')) {
            $this->add_reservation_url_field();
            update_option('cf_db_version', '2.1.0');
        }
    }

    /**
     * Ajoute le champ reservation_url à la table des sessions
     */
    private function add_reservation_url_field() {
        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        // Vérifier si la colonne existe déjà
        $column_exists = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = %s
                AND TABLE_NAME = %s
                AND COLUMN_NAME = 'reservation_url'",
                DB_NAME,
                $table_sessions
            )
        );

        if (empty($column_exists)) {
            // Ajouter la colonne
            $sql = "ALTER TABLE $table_sessions ADD COLUMN reservation_url VARCHAR(500) DEFAULT '' AFTER status";
            $wpdb->query($sql);
        }
    }
}
