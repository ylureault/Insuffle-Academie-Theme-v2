<?php
/**
 * Plugin Name: Formation Gallery
 * Plugin URI: https://github.com/ylureault/Formation-Gallery-Plugin
 * Description: Gestion avancée de galeries photos pour les formations avec lightbox, réorganisation et options d'affichage
 * Version: 1.0.0
 * Author: Insuffle Académie
 * Author URI: https://github.com/ylureault
 * License: GPL v2 or later
 * Text Domain: formation-gallery
 * Domain Path: /languages
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('FG_VERSION', '1.0.0');
define('FG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FG_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Classe principale du plugin Formation Gallery
 */
class Formation_Gallery {

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
        require_once FG_PLUGIN_DIR . 'includes/class-gallery-metabox.php';
        require_once FG_PLUGIN_DIR . 'includes/class-gallery-shortcode.php';
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
        load_plugin_textdomain('formation-gallery', false, dirname(FG_PLUGIN_BASENAME) . '/languages');

        // Initialiser les composants
        FG_Gallery_Metabox::get_instance();
        FG_Gallery_Shortcode::get_instance();
    }

    /**
     * Activation du plugin
     */
    public function activate() {
        // Créer les options par défaut
        $existing_settings = get_option('fg_settings');
        if (!$existing_settings) {
            add_option('fg_settings', array(
                'gallery_columns' => 3,
                'thumbnail_size' => 'medium',
                'enable_lightbox' => true,
                'enable_captions' => true,
                'gallery_style' => 'grid'
            ));
        }
    }

    /**
     * Enregistre les assets frontend
     */
    public function enqueue_frontend_assets() {
        // CSS
        wp_enqueue_style(
            'fg-frontend',
            FG_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            FG_VERSION
        );

        // Lightbox CSS (GLightbox - lightweight et moderne)
        wp_enqueue_style(
            'glightbox',
            'https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css',
            array(),
            '3.2.0'
        );

        // JavaScript
        wp_enqueue_script(
            'glightbox',
            'https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/js/glightbox.min.js',
            array(),
            '3.2.0',
            true
        );

        wp_enqueue_script(
            'fg-frontend',
            FG_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery', 'glightbox'),
            FG_VERSION,
            true
        );

        // Localisation
        wp_localize_script('fg-frontend', 'fgFrontend', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('fg_frontend_nonce')
        ));
    }

    /**
     * Enregistre les assets admin
     */
    public function enqueue_admin_assets($hook) {
        global $post;

        // Charger uniquement sur les pages d'édition de formation
        if (!in_array($hook, array('post.php', 'post-new.php'))) {
            return;
        }

        if (empty($post) || $post->post_type !== 'formation') {
            return;
        }

        // CSS Admin
        wp_enqueue_style(
            'fg-admin',
            FG_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            FG_VERSION
        );

        // Sortable JS pour réorganiser les images
        wp_enqueue_script('jquery-ui-sortable');

        // WordPress Media Uploader
        wp_enqueue_media();

        // JavaScript Admin
        wp_enqueue_script(
            'fg-admin',
            FG_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'jquery-ui-sortable'),
            FG_VERSION,
            true
        );

        // Localisation
        wp_localize_script('fg-admin', 'fgAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('fg_admin_nonce'),
            'strings' => array(
                'selectImages' => __('Sélectionner des images', 'formation-gallery'),
                'addToGallery' => __('Ajouter à la galerie', 'formation-gallery'),
                'removeImage' => __('Êtes-vous sûr de vouloir retirer cette image ?', 'formation-gallery'),
            )
        ));
    }
}

/**
 * Fonction principale pour accéder à l'instance du plugin
 */
function formation_gallery() {
    return Formation_Gallery::get_instance();
}

// Lancer le plugin
formation_gallery();
