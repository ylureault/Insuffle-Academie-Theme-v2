<?php
/**
 * Gestion du menu Formateur dans l'admin WordPress
 */

if (!defined('ABSPATH')) {
    exit;
}

class FFM_Formateur_Admin {

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
     * Ajoute le menu Formateur dans l'admin
     */
    public function add_menu() {
        // Menu principal
        add_menu_page(
            __('Fiches Formateurs', 'fiche-formateur'),
            __('Formateurs', 'fiche-formateur'),
            'edit_pages',
            'fiche-formateur',
            array($this, 'render_formateurs_list'),
            'dashicons-groups',
            26
        );

        // Sous-menu : Gérer les fiches
        add_submenu_page(
            'fiche-formateur',
            __('Gérer les Fiches', 'fiche-formateur'),
            __('Gérer les Fiches', 'fiche-formateur'),
            'edit_pages',
            'fiche-formateur',
            array($this, 'render_formateurs_list')
        );

        // Sous-menu : Éditer une fiche (caché)
        add_submenu_page(
            null, // Pas dans le menu
            __('Éditer la Fiche Formateur', 'fiche-formateur'),
            __('Éditer la Fiche', 'fiche-formateur'),
            'edit_pages',
            'ffm-edit-fiche',
            array($this, 'render_edit_fiche')
        );
    }

    /**
     * Charge les scripts admin
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'fiche-formateur') === false && strpos($hook, 'ffm-') === false) {
            return;
        }

        // Charger la médiathèque WordPress
        wp_enqueue_media();

        wp_enqueue_style('ffm-admin', FFM_PLUGIN_URL . 'assets/css/admin.css', array(), FFM_VERSION);
        wp_enqueue_script('ffm-admin', FFM_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'jquery-ui-sortable'), FFM_VERSION, true);

        wp_localize_script('ffm-admin', 'ffmAdmin', array(
            'confirmDelete' => __('Êtes-vous sûr de vouloir supprimer cet élément ?', 'fiche-formateur'),
            'uploadTitle' => __('Choisir une photo', 'fiche-formateur'),
            'uploadButton' => __('Utiliser cette photo', 'fiche-formateur'),
            'removePhoto' => __('Retirer la photo', 'fiche-formateur'),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ffm_admin_nonce'),
        ));
    }

    /**
     * Affiche la liste des formateurs
     */
    public function render_formateurs_list() {
        // Scanner les pages formateurs
        $formateurs = FFM_Formateurs_Scanner::get_formateurs();

        include FFM_PLUGIN_DIR . 'templates/admin-formateurs-list.php';
    }

    /**
     * Affiche l'interface d'édition d'une fiche
     */
    public function render_edit_fiche() {
        $formateur_id = isset($_GET['formateur_id']) ? intval($_GET['formateur_id']) : 0;

        if (!$formateur_id) {
            wp_die(__('ID de formateur invalide.', 'fiche-formateur'));
        }

        $formateur = get_post($formateur_id);
        if (!$formateur) {
            wp_die(__('Formateur introuvable.', 'fiche-formateur'));
        }

        // Récupérer les données de la fiche
        $data = FFM_Formateur_Manager::get_formateur_data($formateur_id);

        include FFM_PLUGIN_DIR . 'templates/admin-edit-fiche.php';
    }
}
