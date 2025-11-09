<?php
/**
 * Plugin Name: Fiche Formateur
 * Plugin URI: https://www.insuffle-academie.com
 * Description: Gestion des fiches formateurs avec backoffice dédié - Photo, stats et citation
 * Version: 2.0.0
 * Author: Yoan Lureault
 * Author URI: https://www.insuffle-academie.com
 * License: GPL v2 or later
 * Text Domain: fiche-formateur
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Définir les constantes
define('FFM_VERSION', '2.0.0');
define('FFM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FFM_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Classe principale du plugin
 */
class Fiche_Formateur {

    /**
     * Instance unique du plugin (Singleton)
     */
    private static $instance = null;

    /**
     * Récupère l'instance unique
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur privé (Singleton)
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Charge les dépendances
     */
    private function load_dependencies() {
        require_once FFM_PLUGIN_DIR . 'includes/class-formateurs-scanner.php';
        require_once FFM_PLUGIN_DIR . 'includes/class-formateur-manager.php';
        require_once FFM_PLUGIN_DIR . 'includes/class-formateur-admin.php';
        require_once FFM_PLUGIN_DIR . 'includes/class-shortcode.php';
    }

    /**
     * Initialise les hooks WordPress
     */
    private function init_hooks() {
        // Charger les assets frontend
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));

        // Initialiser les classes
        FFM_Formateurs_Scanner::get_instance();
        FFM_Formateur_Manager::get_instance();
        FFM_Formateur_Admin::get_instance();
        FFM_Shortcode::get_instance();
    }

    /**
     * Charge les assets frontend
     */
    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'ffm-frontend',
            FFM_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            FFM_VERSION
        );

        wp_enqueue_script(
            'ffm-frontend',
            FFM_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            FFM_VERSION,
            true
        );
    }
}

/**
 * Initialise le plugin
 */
function ffm_init() {
    return Fiche_Formateur::get_instance();
}

// Lance le plugin
add_action('plugins_loaded', 'ffm_init');
