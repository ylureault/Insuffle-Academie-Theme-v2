<?php
/**
 * Gestion du menu Programme dans l'admin WordPress
 */

if (!defined('ABSPATH')) {
    exit;
}

class PFM_Programme_Admin {

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
     * Ajoute le menu Programme dans l'admin
     */
    public function add_menu() {
        // Menu principal
        add_menu_page(
            __('Programmes Formation', 'programme-formation'),
            __('Programme', 'programme-formation'),
            'edit_pages',
            'programme-formation',
            array($this, 'render_programmes_list'),
            'dashicons-list-view',
            26
        );

        // Sous-menu : Gérer les programmes
        add_submenu_page(
            'programme-formation',
            __('Gérer les Programmes', 'programme-formation'),
            __('Gérer les Programmes', 'programme-formation'),
            'edit_pages',
            'programme-formation',
            array($this, 'render_programmes_list')
        );

        // Sous-menu : Éditer un programme (caché)
        add_submenu_page(
            null, // Pas dans le menu
            __('Éditer le Programme', 'programme-formation'),
            __('Éditer le Programme', 'programme-formation'),
            'edit_pages',
            'pfm-edit-programme',
            array($this, 'render_edit_programme')
        );

        // Sous-menu : Documentation
        add_submenu_page(
            'programme-formation',
            __('Documentation', 'programme-formation'),
            '<span class="dashicons dashicons-book-alt"></span> ' . __('Documentation', 'programme-formation'),
            'edit_pages',
            'pfm-documentation',
            array($this, 'render_documentation')
        );
    }

    /**
     * Charge les scripts admin
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'programme-formation') === false && strpos($hook, 'pfm-') === false) {
            return;
        }

        wp_enqueue_style('pfm-admin-programmes', PFM_PLUGIN_URL . 'assets/css/admin-programmes.css', array(), PFM_VERSION);
        wp_enqueue_script('pfm-admin-programmes', PFM_PLUGIN_URL . 'assets/js/admin-programmes.js', array('jquery', 'jquery-ui-sortable'), PFM_VERSION, true);

        wp_localize_script('pfm-admin-programmes', 'pfmAdmin', array(
            'confirmDelete' => __('Êtes-vous sûr de vouloir supprimer ce module ?', 'programme-formation'),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pfm_admin_nonce'),
        ));
    }

    /**
     * Affiche la liste des programmes
     */
    public function render_programmes_list() {
        // Scanner les pages enfants de Formations
        $formations = PFM_Formations_Scanner::get_formations();

        include PFM_PLUGIN_DIR . 'templates/admin-programmes-list.php';
    }

    /**
     * Affiche l'interface d'édition d'un programme
     */
    public function render_edit_programme() {
        $formation_id = isset($_GET['formation_id']) ? intval($_GET['formation_id']) : 0;

        if (!$formation_id) {
            wp_die(__('ID de formation invalide.', 'programme-formation'));
        }

        $formation = get_post($formation_id);
        if (!$formation) {
            wp_die(__('Formation introuvable.', 'programme-formation'));
        }

        // Récupérer les données du programme
        $modules = PFM_Modules_Manager::get_modules($formation_id);
        $infos = PFM_Modules_Manager::get_infos_pratiques($formation_id);

        include PFM_PLUGIN_DIR . 'templates/admin-edit-programme.php';
    }

    /**
     * Affiche la documentation
     */
    public function render_documentation() {
        include PFM_PLUGIN_DIR . 'templates/admin-documentation.php';
    }
}
