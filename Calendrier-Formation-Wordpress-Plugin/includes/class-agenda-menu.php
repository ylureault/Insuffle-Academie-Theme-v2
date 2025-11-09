<?php
/**
 * Gestion du menu Agenda dans l'admin WordPress
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Agenda_Menu {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_menu'));
    }

    /**
     * Ajoute le menu Agenda dans l'admin
     */
    public function add_menu() {
        // Menu principal
        add_menu_page(
            __('Agenda Formation', 'calendrier-formation'),
            __('Agenda', 'calendrier-formation'),
            'edit_pages',
            'calendrier-formation',
            array($this, 'render_dashboard'),
            'dashicons-calendar-alt',
            25
        );

        // Sous-menu : Tableau de bord
        add_submenu_page(
            'calendrier-formation',
            __('Tableau de bord', 'calendrier-formation'),
            __('Tableau de bord', 'calendrier-formation'),
            'edit_pages',
            'calendrier-formation',
            array($this, 'render_dashboard')
        );

        // Sous-menu : Calendrier
        add_submenu_page(
            'calendrier-formation',
            __('Calendrier', 'calendrier-formation'),
            __('Calendrier', 'calendrier-formation'),
            'edit_pages',
            'cf-calendar',
            array(CF_Calendar_View::get_instance(), 'render_calendar_page')
        );

        // Sous-menu : Sessions
        add_submenu_page(
            'calendrier-formation',
            __('Sessions', 'calendrier-formation'),
            __('Sessions', 'calendrier-formation'),
            'edit_pages',
            'cf-sessions',
            array(CF_Sessions_Manager::get_instance(), 'render_sessions_page')
        );

        // Sous-menu : Réservations
        add_submenu_page(
            'calendrier-formation',
            __('Réservations', 'calendrier-formation'),
            __('Réservations', 'calendrier-formation'),
            'edit_pages',
            'cf-bookings',
            array(CF_Bookings_Manager::get_instance(), 'render_bookings_page')
        );

        // Sous-menu : Templates emails
        add_submenu_page(
            'calendrier-formation',
            __('Templates emails', 'calendrier-formation'),
            __('Templates emails', 'calendrier-formation'),
            'manage_options',
            'cf-email-templates',
            array(CF_Email_Manager::get_instance(), 'render_email_templates_page')
        );

        // Sous-menu : Diagnostic 404
        add_submenu_page(
            'calendrier-formation',
            __('Diagnostic 404', 'calendrier-formation'),
            __('Diagnostic 404', 'calendrier-formation'),
            'manage_options',
            'cf-diagnostic-404',
            array(CF_Diagnostic_404::get_instance(), 'render_diagnostic_page')
        );

        // Sous-menu : Paramètres
        add_submenu_page(
            'calendrier-formation',
            __('Paramètres', 'calendrier-formation'),
            __('Paramètres', 'calendrier-formation'),
            'manage_options',
            'cf-settings',
            array(CF_Settings::get_instance(), 'render_settings_page')
        );
    }

    /**
     * Affiche le tableau de bord principal
     */
    public function render_dashboard() {
        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        // Statistiques globales
        $stats = array(
            'formations' => CF_Formations_Scanner::count_formations(),
            'total_sessions' => $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active'"),
            'upcoming_sessions' => $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active' AND date_debut >= NOW()"),
            'total_bookings' => $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings"),
            'pending_bookings' => $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings WHERE status = 'pending'"),
        );

        // Prochaines sessions
        $upcoming = $wpdb->get_results("
            SELECT s.*, p.post_title as formation_title
            FROM $table_sessions s
            LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
            WHERE s.status = 'active' AND s.date_debut >= NOW()
            ORDER BY s.date_debut ASC
            LIMIT 5
        ");

        // Formations avec stats
        $formations = CF_Formations_Scanner::get_formations_with_stats();

        include CF_PLUGIN_DIR . 'templates/dashboard.php';
    }
}
