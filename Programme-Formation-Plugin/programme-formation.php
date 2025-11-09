<?php
/**
 * Plugin Name: Programme Formation
 * Plugin URI: https://github.com/ylureault/Programme-Formation-Plugin
 * Description: Gestionnaire de programme de formation avec système de modules dynamiques. Interface complète pour créer, éditer et afficher les modules de vos formations.
 * Version: 1.0.0
 * Author: Yoan Lureault
 * Author URI: https://github.com/ylureault
 * License: GPL v2 or later
 * Text Domain: programme-formation
 * Domain Path: /languages
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('PFM_VERSION', '1.0.0');
define('PFM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PFM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PFM_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Classe principale du plugin
 */
class Programme_Formation {

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
        require_once PFM_PLUGIN_DIR . 'includes/class-modules-manager.php';
        require_once PFM_PLUGIN_DIR . 'includes/class-shortcode.php';
        require_once PFM_PLUGIN_DIR . 'includes/class-admin-interface.php';
    }

    /**
     * Initialise les hooks
     */
    private function init_hooks() {
        // Initialisation
        add_action('init', array($this, 'init'));

        // Scripts et styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Initialisation du plugin
     */
    public function init() {
        // Charger la traduction
        load_plugin_textdomain('programme-formation', false, dirname(PFM_PLUGIN_BASENAME) . '/languages');

        // Initialiser les composants
        PFM_Modules_Manager::get_instance();
        PFM_Shortcode::get_instance();
        PFM_Admin_Interface::get_instance();
    }

    /**
     * Enregistre les assets frontend
     */
    public function enqueue_frontend_assets() {
        // Styles frontend
        wp_enqueue_style(
            'pfm-frontend',
            PFM_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            PFM_VERSION
        );

        // Scripts frontend
        wp_enqueue_script(
            'pfm-frontend',
            PFM_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            PFM_VERSION,
            true
        );
    }

    /**
     * Enregistre les assets admin
     */
    public function enqueue_admin_assets($hook) {
        // Charger uniquement sur les pages de posts/pages
        global $post_type;
        if (!in_array($hook, array('post.php', 'post-new.php'))) {
            return;
        }

        // Styles admin
        wp_enqueue_style(
            'pfm-admin',
            PFM_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            PFM_VERSION
        );

        // Scripts admin
        wp_enqueue_script(
            'pfm-admin',
            PFM_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'jquery-ui-sortable'),
            PFM_VERSION,
            true
        );

        // Localisation
        wp_localize_script('pfm-admin', 'pfmAdmin', array(
            'confirmDelete' => __('Êtes-vous sûr de vouloir supprimer ce module ?', 'programme-formation'),
            'addModule' => __('Ajouter un module', 'programme-formation'),
        ));
    }
}

/**
 * Fonction principale pour accéder à l'instance du plugin
 */
function programme_formation() {
    return Programme_Formation::get_instance();
}

// Lancer le plugin
programme_formation();
