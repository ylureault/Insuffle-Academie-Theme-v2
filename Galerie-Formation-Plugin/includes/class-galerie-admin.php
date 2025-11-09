<?php
/**
 * Gestion du menu Galerie dans l'admin WordPress
 */

if (!defined('ABSPATH')) {
    exit;
}

class GFM_Galerie_Admin {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    /**
     * Ajoute le menu Galerie dans l'admin
     */
    public function add_menu() {
        // Menu principal
        add_menu_page(
            __('Galeries Formation', 'galerie-formation'),
            __('Galeries', 'galerie-formation'),
            'edit_pages',
            'galerie-formation',
            array($this, 'render_galeries_list'),
            'dashicons-images-alt2',
            26
        );

        // Sous-menu : Gérer les galeries
        add_submenu_page(
            'galerie-formation',
            __('Gérer les Galeries', 'galerie-formation'),
            __('Gérer les Galeries', 'galerie-formation'),
            'edit_pages',
            'galerie-formation',
            array($this, 'render_galeries_list')
        );

        // Sous-menu : Éditer une galerie (caché)
        add_submenu_page(
            null, // Pas dans le menu
            __('Éditer la Galerie', 'galerie-formation'),
            __('Éditer la Galerie', 'galerie-formation'),
            'edit_pages',
            'gfm-edit-galerie',
            array($this, 'render_edit_galerie')
        );
    }

    /**
     * Charge les scripts admin
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'galerie-formation') === false && strpos($hook, 'gfm-') === false) {
            return;
        }

        // Charger la médiathèque WordPress
        wp_enqueue_media();

        wp_enqueue_style('gfm-admin', GFM_PLUGIN_URL . 'assets/css/admin.css', array(), GFM_VERSION);
        wp_enqueue_script('gfm-admin', GFM_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'jquery-ui-sortable'), GFM_VERSION, true);

        wp_localize_script('gfm-admin', 'gfmAdmin', array(
            'confirmDelete' => __('Êtes-vous sûr de vouloir supprimer cette image ?', 'galerie-formation'),
            'uploadTitle' => __('Choisir une ou plusieurs images', 'galerie-formation'),
            'uploadButton' => __('Ajouter à la galerie', 'galerie-formation'),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gfm_admin_nonce'),
        ));
    }

    /**
     * Affiche la liste des galeries
     */
    public function render_galeries_list() {
        // Scanner les pages formations
        $formations = GFM_Formations_Scanner::get_formations();

        include GFM_PLUGIN_DIR . 'templates/admin-galeries-list.php';
    }

    /**
     * Affiche l'interface d'édition d'une galerie
     */
    public function render_edit_galerie() {
        $formation_id = isset($_GET['formation_id']) ? intval($_GET['formation_id']) : 0;

        if (!$formation_id) {
            wp_die(__('ID de formation invalide.', 'galerie-formation'));
        }

        $formation = get_post($formation_id);
        if (!$formation) {
            wp_die(__('Formation introuvable.', 'galerie-formation'));
        }

        // Récupérer les images de la galerie
        $images = GFM_Gallery_Manager::get_images($formation_id);

        include GFM_PLUGIN_DIR . 'templates/admin-edit-galerie.php';
    }
}
