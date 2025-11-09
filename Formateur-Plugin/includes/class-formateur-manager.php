<?php
/**
 * Gestion des fiches formateurs
 */

// Sécurité
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
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_formateur'), 10, 2);
    }

    /**
     * Ajoute la metabox
     */
    public function add_metabox() {
        add_meta_box(
            'ffm_formateur_metabox',
            __('Fiche Formateur - Informations', 'fiche-formateur'),
            array($this, 'render_metabox'),
            array('post', 'page'),
            'normal',
            'high'
        );
    }

    /**
     * Affiche la metabox
     */
    public function render_metabox($post) {
        // Récupérer les données existantes
        $formateur_data = get_post_meta($post->ID, '_ffm_formateur_data', true);

        if (!is_array($formateur_data)) {
            $formateur_data = array(
                'photo_id' => '',
                'badge' => '',
                'nom' => '',
                'tagline' => '',
                'description' => '',
                'stats' => array(),
                'citation_texte' => '',
                'citation_auteur' => ''
            );
        }

        // Nonce pour la sécurité
        wp_nonce_field('ffm_save_formateur', 'ffm_formateur_nonce');

        // Charger le template
        include FFM_PLUGIN_DIR . 'templates/admin-metabox.php';
    }

    /**
     * Sauvegarde les données du formateur
     */
    public function save_formateur($post_id, $post) {
        // Vérifications de sécurité
        if (!isset($_POST['ffm_formateur_nonce']) ||
            !wp_verify_nonce($_POST['ffm_formateur_nonce'], 'ffm_save_formateur')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Préparer les données
        $formateur_data = array(
            'photo_id' => isset($_POST['ffm_photo_id']) ? intval($_POST['ffm_photo_id']) : '',
            'badge' => isset($_POST['ffm_badge']) ? sanitize_text_field($_POST['ffm_badge']) : '',
            'nom' => isset($_POST['ffm_nom']) ? sanitize_text_field($_POST['ffm_nom']) : '',
            'tagline' => isset($_POST['ffm_tagline']) ? sanitize_text_field($_POST['ffm_tagline']) : '',
            'description' => isset($_POST['ffm_description']) ? wp_kses_post($_POST['ffm_description']) : '',
            'citation_texte' => isset($_POST['ffm_citation_texte']) ? wp_kses_post($_POST['ffm_citation_texte']) : '',
            'citation_auteur' => isset($_POST['ffm_citation_auteur']) ? sanitize_text_field($_POST['ffm_citation_auteur']) : '',
            'stats' => array()
        );

        // Traiter les stats
        if (isset($_POST['ffm_stats']) && is_array($_POST['ffm_stats'])) {
            foreach ($_POST['ffm_stats'] as $stat_data) {
                if (!empty($stat_data['number']) || !empty($stat_data['label'])) {
                    $formateur_data['stats'][] = array(
                        'number' => sanitize_text_field($stat_data['number'] ?? ''),
                        'label' => sanitize_text_field($stat_data['label'] ?? '')
                    );
                }
            }
        }

        // Sauvegarder
        update_post_meta($post_id, '_ffm_formateur_data', $formateur_data);
    }

    /**
     * Récupère les données d'un formateur
     */
    public static function get_formateur_data($post_id) {
        $data = get_post_meta($post_id, '_ffm_formateur_data', true);

        if (!is_array($data)) {
            return array(
                'photo_id' => '',
                'badge' => '',
                'nom' => '',
                'tagline' => '',
                'description' => '',
                'stats' => array(),
                'citation_texte' => '',
                'citation_auteur' => ''
            );
        }

        return $data;
    }
}
