<?php
/**
 * Plugin Name: Plugin Formateur
 * Plugin URI: https://github.com/ylureault/Plugin-Formateur
 * Description: Gestion des formateurs avec shortcode d'affichage stylé. Design basé sur les templates Insuffle Académie.
 * Version: 1.0.0
 * Author: Insuffle Académie
 * Author URI: https://insuffle-academie.com
 * License: GPL v2 or later
 * Text Domain: plugin-formateur
 * Domain Path: /languages
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('FORMATEUR_VERSION', '1.0.0');
define('FORMATEUR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FORMATEUR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FORMATEUR_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Classe principale du plugin Formateur
 */
class Plugin_Formateur {

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
        require_once FORMATEUR_PLUGIN_DIR . 'includes/class-formateur-cpt.php';
        require_once FORMATEUR_PLUGIN_DIR . 'includes/class-formateur-metabox.php';
        require_once FORMATEUR_PLUGIN_DIR . 'includes/class-formateur-shortcode.php';
    }

    /**
     * Initialise les hooks
     */
    private function init_hooks() {
        // Activation
        register_activation_hook(__FILE__, array($this, 'activate'));

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
        load_plugin_textdomain('plugin-formateur', false, dirname(FORMATEUR_PLUGIN_BASENAME) . '/languages');

        // Initialiser les composants
        Formateur_CPT::get_instance();
        Formateur_Metabox::get_instance();
        Formateur_Shortcode::get_instance();
    }

    /**
     * Activation du plugin
     */
    public function activate() {
        // Créer Yoan Lureault par défaut
        $this->create_default_formateur();

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Crée le formateur par défaut (Yoan Lureault)
     */
    private function create_default_formateur() {
        // Vérifier si Yoan Lureault existe déjà
        $existing = get_posts(array(
            'post_type' => 'formateur',
            'title' => 'Yoan Lureault',
            'posts_per_page' => 1,
            'post_status' => 'any'
        ));

        if (!empty($existing)) {
            return; // Yoan existe déjà
        }

        // Créer le formateur
        $formateur_id = wp_insert_post(array(
            'post_title' => 'Yoan Lureault',
            'post_type' => 'formateur',
            'post_status' => 'publish',
            'post_content' => 'Formateur-facilitateur expérimenté, certifié par Insuffle Académie, Yoan accompagne les organisations dans leur transformation par l\'intelligence collective depuis plusieurs années.'
        ));

        if ($formateur_id && !is_wp_error($formateur_id)) {
            // Ajouter les meta données
            update_post_meta($formateur_id, '_formateur_titre', 'Responsable pédagogique — Insuffle Académie');
            update_post_meta($formateur_id, '_formateur_citation', 'On ne forme pas à faire des ateliers. On forme à voir, écouter, tenir et transformer le collectif.');
            update_post_meta($formateur_id, '_formateur_email', 'yoan@insuffle-academie.com');
            update_post_meta($formateur_id, '_formateur_telephone', '09 80 80 89 62');
            update_post_meta($formateur_id, '_formateur_linkedin', '');
            update_post_meta($formateur_id, '_formateur_ordre', 1);
        }
    }

    /**
     * Enregistre les assets frontend
     */
    public function enqueue_frontend_assets() {
        // CSS
        wp_enqueue_style(
            'formateur-frontend',
            FORMATEUR_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            FORMATEUR_VERSION
        );

        // JavaScript (si nécessaire)
        wp_enqueue_script(
            'formateur-frontend',
            FORMATEUR_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            FORMATEUR_VERSION,
            true
        );
    }

    /**
     * Enregistre les assets admin
     */
    public function enqueue_admin_assets($hook) {
        global $post;

        // Charger uniquement sur les pages d'édition de formateur
        if (!in_array($hook, array('post.php', 'post-new.php'))) {
            return;
        }

        if (empty($post) || $post->post_type !== 'formateur') {
            return;
        }

        // CSS Admin
        wp_enqueue_style(
            'formateur-admin',
            FORMATEUR_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            FORMATEUR_VERSION
        );

        // WordPress Media Uploader
        wp_enqueue_media();
    }
}

/**
 * Fonction principale pour accéder à l'instance du plugin
 */
function plugin_formateur() {
    return Plugin_Formateur::get_instance();
}

// Lancer le plugin
plugin_formateur();
