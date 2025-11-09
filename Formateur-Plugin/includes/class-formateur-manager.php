<?php
/**
 * Gestion des données des formateurs
 */

if (!defined('ABSPATH')) {
    exit;
}

class FFM_Formateur_Manager {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Hook pour sauvegarder depuis l'admin
        add_action('admin_init', array($this, 'handle_save'));
    }

    /**
     * Gère la sauvegarde depuis le formulaire admin
     */
    public function handle_save() {
        if (!isset($_POST['ffm_save_fiche'])) {
            return;
        }

        $formateur_id = isset($_POST['formateur_id']) ? intval($_POST['formateur_id']) : 0;

        if (!$formateur_id) {
            return;
        }

        // Vérifier le nonce
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'ffm_save_fiche_' . $formateur_id)) {
            return;
        }

        // Vérifier les permissions
        if (!current_user_can('edit_post', $formateur_id)) {
            return;
        }

        // Sauvegarder les données
        $data = array(
            'photo_id' => isset($_POST['ffm_photo_id']) ? intval($_POST['ffm_photo_id']) : 0,
            'badge' => sanitize_text_field($_POST['ffm_badge'] ?? ''),
            'nom' => sanitize_text_field($_POST['ffm_nom'] ?? ''),
            'tagline' => sanitize_text_field($_POST['ffm_tagline'] ?? ''),
            'description' => wp_kses_post($_POST['ffm_description'] ?? ''),
            'citation_texte' => wp_kses_post($_POST['ffm_citation_texte'] ?? ''),
            'citation_auteur' => sanitize_text_field($_POST['ffm_citation_auteur'] ?? ''),
        );

        // Sauvegarder les stats
        $stats = array();
        if (isset($_POST['ffm_stats']) && is_array($_POST['ffm_stats'])) {
            foreach ($_POST['ffm_stats'] as $stat) {
                $stats[] = array(
                    'number' => sanitize_text_field($stat['number'] ?? ''),
                    'label' => sanitize_text_field($stat['label'] ?? ''),
                );
            }
        }
        $data['stats'] = $stats;

        // Sauvegarder dans post_meta
        update_post_meta($formateur_id, '_ffm_formateur_data', $data);

        // Rediriger avec message de succès
        wp_redirect(add_query_arg(
            array(
                'page' => 'ffm-edit-fiche',
                'formateur_id' => $formateur_id,
                'message' => 'saved'
            ),
            admin_url('admin.php')
        ));
        exit;
    }

    /**
     * Récupère les données d'un formateur
     */
    public static function get_formateur_data($post_id) {
        $data = get_post_meta($post_id, '_ffm_formateur_data', true);

        if (empty($data) || !is_array($data)) {
            $data = array(
                'photo_id' => 0,
                'badge' => '',
                'nom' => '',
                'tagline' => '',
                'description' => '',
                'stats' => array(),
                'citation_texte' => '',
                'citation_auteur' => '',
            );
        }

        // S'assurer que stats est un tableau
        if (!isset($data['stats']) || !is_array($data['stats'])) {
            $data['stats'] = array();
        }

        return $data;
    }
}
