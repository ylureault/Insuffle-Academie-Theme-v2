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
            // Metabox modules
            add_meta_box(
                'pfm_modules_metabox',
                __('Programme de Formation - Modules', 'programme-formation'),
                array($this, 'render_metabox'),
                $post_type,
                'normal',
                'high'
            );

            // Metabox infos pratiques
            add_meta_box(
                'pfm_infos_metabox',
                __('Programme de Formation - Informations Pratiques', 'programme-formation'),
                array($this, 'render_infos_metabox'),
                $post_type,
                'normal',
                'default'
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
     * Affiche la metabox des infos pratiques
     */
    public function render_infos_metabox($post) {
        // Nonce pour la sécurité
        wp_nonce_field('pfm_save_infos', 'pfm_infos_nonce');

        // Récupérer les données existantes
        $infos = get_post_meta($post->ID, '_pfm_infos_pratiques', true);
        if (empty($infos) || !is_array($infos)) {
            $infos = array(
                'methodes' => '',
                'moyens' => '',
                'evaluation' => ''
            );
        }

        // Inclure le template
        include PFM_PLUGIN_DIR . 'templates/admin-infos-metabox.php';
    }

    /**
     * Sauvegarde les modules
     */
    public function save_modules($post_id, $post) {
        // Vérifications de sécurité modules
        if (isset($_POST['pfm_modules_nonce']) && wp_verify_nonce($_POST['pfm_modules_nonce'], 'pfm_save_modules')) {
            if (!defined('DOING_AUTOSAVE') || !DOING_AUTOSAVE) {
                if (current_user_can('edit_post', $post_id)) {
                    // Récupérer et nettoyer les données
                    $modules = array();

                    if (isset($_POST['pfm_modules']) && is_array($_POST['pfm_modules'])) {
                        foreach ($_POST['pfm_modules'] as $module_data) {
                            $modules[] = array(
                                'number' => sanitize_text_field($module_data['number'] ?? ''),
                                'title' => sanitize_text_field($module_data['title'] ?? ''),
                                'duree' => sanitize_text_field($module_data['duree'] ?? ''),
                                'objectif' => wp_kses_post($module_data['objectif'] ?? ''),
                                'content' => wp_kses_post($module_data['content'] ?? ''),
                                'evaluation' => sanitize_text_field($module_data['evaluation'] ?? ''),
                            );
                        }
                    }

                    // Sauvegarder
                    update_post_meta($post_id, '_pfm_modules', $modules);
                }
            }
        }

        // Vérifications de sécurité infos pratiques
        if (isset($_POST['pfm_infos_nonce']) && wp_verify_nonce($_POST['pfm_infos_nonce'], 'pfm_save_infos')) {
            if (!defined('DOING_AUTOSAVE') || !DOING_AUTOSAVE) {
                if (current_user_can('edit_post', $post_id)) {
                    $infos = array(
                        'methodes' => wp_kses_post($_POST['pfm_methodes'] ?? ''),
                        'moyens' => wp_kses_post($_POST['pfm_moyens'] ?? ''),
                        'evaluation' => wp_kses_post($_POST['pfm_evaluation'] ?? ''),
                    );

                    update_post_meta($post_id, '_pfm_infos_pratiques', $infos);
                }
            }
        }
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

    /**
     * Récupère les infos pratiques d'un post
     */
    public static function get_infos_pratiques($post_id) {
        $infos = get_post_meta($post_id, '_pfm_infos_pratiques', true);

        if (empty($infos) || !is_array($infos)) {
            return array(
                'methodes' => '',
                'moyens' => '',
                'evaluation' => ''
            );
        }

        return $infos;
    }
}
