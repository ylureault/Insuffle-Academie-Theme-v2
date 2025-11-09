<?php
/**
 * Gestion des modules de formation
 */

if (!defined('ABSPATH')) {
    exit;
}

class PFM_Modules_Manager {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_modules'), 10, 2);
    }

    /**
     * Ajoute les metaboxes aux pages et posts
     */
    public function add_meta_boxes() {
        $post_types = array('page', 'post');

        foreach ($post_types as $post_type) {
            add_meta_box(
                'pfm_modules_metabox',
                __('Programme de Formation - Modules', 'programme-formation'),
                array($this, 'render_metabox'),
                $post_type,
                'normal',
                'high'
            );
        }
    }

    /**
     * Affiche la metabox
     */
    public function render_metabox($post) {
        // Nonce pour la sécurité
        wp_nonce_field('pfm_save_modules', 'pfm_modules_nonce');

        // Récupérer les modules existants
        $modules = get_post_meta($post->ID, '_pfm_modules', true);
        if (empty($modules)) {
            $modules = array();
        }

        // Inclure le template
        include PFM_PLUGIN_DIR . 'templates/admin-metabox.php';
    }

    /**
     * Sauvegarde les modules
     */
    public function save_modules($post_id, $post) {
        // Vérifications de sécurité
        if (!isset($_POST['pfm_modules_nonce']) || !wp_verify_nonce($_POST['pfm_modules_nonce'], 'pfm_save_modules')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Récupérer et nettoyer les données
        $modules = array();

        if (isset($_POST['pfm_modules']) && is_array($_POST['pfm_modules'])) {
            foreach ($_POST['pfm_modules'] as $module_data) {
                $modules[] = array(
                    'number' => sanitize_text_field($module_data['number'] ?? ''),
                    'title' => sanitize_text_field($module_data['title'] ?? ''),
                    'content' => wp_kses_post($module_data['content'] ?? ''),
                );
            }
        }

        // Sauvegarder
        update_post_meta($post_id, '_pfm_modules', $modules);
    }

    /**
     * Récupère les modules d'un post
     */
    public static function get_modules($post_id) {
        $modules = get_post_meta($post_id, '_pfm_modules', true);

        if (empty($modules) || !is_array($modules)) {
            return array();
        }

        return $modules;
    }
}
