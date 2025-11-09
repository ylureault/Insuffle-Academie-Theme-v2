<?php
/**
 * Plugin Name: Galerie Formation
 * Plugin URI: https://github.com/ylureault/Galerie-Formation-Plugin
 * Description: Gestionnaire de galerie d'images avec backoffice dédié - Uploadez, organisez et affichez vos réalisations
 * Version: 2.0.0
 * Author: Yoan Lureault
 * Author URI: https://github.com/ylureault
 * License: GPL v2 or later
 * Text Domain: galerie-formation
 * Domain Path: /languages
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('GFM_VERSION', '2.0.0');
define('GFM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GFM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GFM_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Classe principale du plugin
 */
class Galerie_Formation {

    /**
     * Instance unique du plugin (Singleton)
     */
    private static $instance = null;

    /**
     * Retourne l'instance unique du plugin
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
     * Charge les fichiers nécessaires
     */
    private function load_dependencies() {
        require_once GFM_PLUGIN_DIR . 'includes/class-formations-scanner.php';
        require_once GFM_PLUGIN_DIR . 'includes/class-gallery-manager.php';
        require_once GFM_PLUGIN_DIR . 'includes/class-galerie-admin.php';
        require_once GFM_PLUGIN_DIR . 'includes/class-shortcode.php';
    }

    /**
     * Initialise les hooks
     */
    private function init_hooks() {
        // Initialisation
        add_action('init', array($this, 'init'));

        // Scripts et styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
    }

    /**
     * Initialisation du plugin
     */
    public function init() {
        // Charger la traduction
        load_plugin_textdomain('galerie-formation', false, dirname(GFM_PLUGIN_BASENAME) . '/languages');

        // Initialiser les composants
        GFM_Formations_Scanner::get_instance();
        GFM_Gallery_Manager::get_instance();
        GFM_Galerie_Admin::get_instance();
        GFM_Shortcode::get_instance();
    }

    /**
     * Enregistre les assets frontend
     */
    public function enqueue_frontend_assets() {
        // Styles frontend
        wp_enqueue_style(
            'gfm-frontend',
            GFM_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            GFM_VERSION
        );

        // Scripts frontend
        wp_enqueue_script(
            'gfm-frontend',
            GFM_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            GFM_VERSION,
            true
        );
    }
}

/**
 * Fonction principale pour accéder à l'instance du plugin
 */
function galerie_formation() {
    return Galerie_Formation::get_instance();
}

// Lancer le plugin
galerie_formation();
