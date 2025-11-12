<?php
/**
 * Plugin Name: Widget Formation Insufflé Académie
 * Description: Génère des widgets iframe/JS pour intégrer les formations sur d'autres sites
 * Version: 1.0.0
 * Author: Insufflé Académie
 * Text Domain: widget-formation
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('WFM_VERSION', '1.0.0');
define('WFM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WFM_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Classe principale du plugin
 */
class Widget_Formation_Manager {

    private static $instance = null;

    /**
     * Singleton
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur
     */
    private function __construct() {
        $this->init();
    }

    /**
     * Initialisation
     */
    private function init() {
        // Enregistrer le custom post type
        add_action('init', array($this, 'register_post_type'));

        // Ajouter la meta box
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_widget_formation', array($this, 'save_widget_meta'));

        // Enregistrer l'endpoint pour afficher le widget
        add_action('init', array($this, 'add_widget_endpoint'));
        add_action('template_redirect', array($this, 'widget_template_redirect'));

        // Enregistrer les scripts pour l'admin
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));

        // AJAX pour récupérer les données des formations
        add_action('wp_ajax_wfm_get_formation_data', array($this, 'ajax_get_formation_data'));
    }

    /**
     * Enregistrer le custom post type
     */
    public function register_post_type() {
        $labels = array(
            'name' => 'Widgets Formation',
            'singular_name' => 'Widget Formation',
            'add_new' => 'Ajouter un widget',
            'add_new_item' => 'Ajouter un nouveau widget',
            'edit_item' => 'Modifier le widget',
            'new_item' => 'Nouveau widget',
            'view_item' => 'Voir le widget',
            'search_items' => 'Rechercher des widgets',
            'not_found' => 'Aucun widget trouvé',
            'not_found_in_trash' => 'Aucun widget dans la corbeille',
            'menu_name' => 'Widgets Formation',
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-embed-generic',
            'supports' => array('title'),
            'has_archive' => false,
            'rewrite' => false,
        );

        register_post_type('widget_formation', $args);
    }

    /**
     * Ajouter les meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'wfm_widget_config',
            'Configuration du Widget',
            array($this, 'render_meta_box'),
            'widget_formation',
            'normal',
            'high'
        );

        add_meta_box(
            'wfm_widget_code',
            'Code d\'intégration',
            array($this, 'render_code_meta_box'),
            'widget_formation',
            'side',
            'default'
        );
    }

    /**
     * Rendu de la meta box de configuration
     */
    public function render_meta_box($post) {
        wp_nonce_field('wfm_save_widget', 'wfm_widget_nonce');

        // Media uploader
        wp_enqueue_media();

        // Récupérer les données existantes
        $formations = get_post_meta($post->ID, '_wfm_formations', true);

        if (empty($formations)) {
            $formations = array();
        }

        // Récupérer toutes les formations (pages enfants de la page 51)
        $all_formations = get_pages(array(
            'child_of' => 51,
            'sort_column' => 'post_title',
            'sort_order' => 'ASC',
        ));

        // Récupérer les options d'affichage
        $display_options = get_post_meta($post->ID, '_wfm_display_options', true);
        if (empty($display_options) || !is_array($display_options)) {
            $display_options = array(
                'show_excerpt' => '1',
                'show_formateur' => '1',
                'show_duree' => '1',
                'show_prix' => '1',
                'show_modules_count' => '1',
                'card_style' => 'insuffle', // insuffle, modern, minimal
                'bg_color' => '#FFFFFF',
                'text_color' => '#333333',
                'accent_color' => '#8E2183',
            );
        }

        // Récupérer les options CTA
        $cta_options = get_post_meta($post->ID, '_wfm_cta_options', true);
        if (empty($cta_options) || !is_array($cta_options)) {
            $cta_options = array(
                'text' => 'Découvrir la formation',
                'style' => 'solid', // solid, outline, gradient
                'bg_color' => '#8E2183',
                'text_color' => '#FFFFFF',
                'hover_bg_color' => '#6B1762',
                'target' => '_blank',
            );
        }

        // Récupérer les logos
        $logo_options = get_post_meta($post->ID, '_wfm_logo_options', true);
        if (empty($logo_options) || !is_array($logo_options)) {
            $logo_options = array(
                'show_logo_ia' => '1',
                'logo_ia_id' => '',
                'show_logo_qualiopi' => '1',
                'logo_qualiopi_id' => '',
                'show_logo_custom' => '0',
                'logo_custom_id' => '',
                'logos_position' => 'bottom', // top, bottom, both
            );
        }

        include WFM_PLUGIN_DIR . 'templates/meta-box-config-pro.php';
    }

    /**
     * Rendu de la meta box du code d'intégration
     */
    public function render_code_meta_box($post) {
        if ($post->post_status === 'publish') {
            $widget_url = home_url('/widget-formation/' . $post->ID);
            include WFM_PLUGIN_DIR . 'templates/meta-box-code.php';
        } else {
            echo '<p>Publiez d\'abord ce widget pour obtenir le code d\'intégration.</p>';
        }
    }

    /**
     * Sauvegarder les métadonnées du widget
     */
    public function save_widget_meta($post_id) {
        // Vérifications de sécurité
        if (!isset($_POST['wfm_widget_nonce']) || !wp_verify_nonce($_POST['wfm_widget_nonce'], 'wfm_save_widget')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Sauvegarder les formations sélectionnées
        $formations = isset($_POST['wfm_formations']) && is_array($_POST['wfm_formations'])
            ? array_map('intval', $_POST['wfm_formations'])
            : array();
        update_post_meta($post_id, '_wfm_formations', $formations);

        // Sauvegarder les options d'affichage
        $display_options = array(
            'show_excerpt' => isset($_POST['wfm_show_excerpt']) ? '1' : '0',
            'show_formateur' => isset($_POST['wfm_show_formateur']) ? '1' : '0',
            'show_duree' => isset($_POST['wfm_show_duree']) ? '1' : '0',
            'show_prix' => isset($_POST['wfm_show_prix']) ? '1' : '0',
            'show_modules_count' => isset($_POST['wfm_show_modules_count']) ? '1' : '0',
            'card_style' => sanitize_text_field($_POST['wfm_card_style'] ?? 'insuffle'),
            'bg_color' => sanitize_hex_color($_POST['wfm_bg_color'] ?? '#FFFFFF'),
            'text_color' => sanitize_hex_color($_POST['wfm_text_color'] ?? '#333333'),
            'accent_color' => sanitize_hex_color($_POST['wfm_accent_color'] ?? '#8E2183'),
        );
        update_post_meta($post_id, '_wfm_display_options', $display_options);

        // Sauvegarder les options CTA
        $cta_options = array(
            'text' => sanitize_text_field($_POST['wfm_cta_text'] ?? 'Découvrir la formation'),
            'style' => sanitize_text_field($_POST['wfm_cta_style'] ?? 'solid'),
            'bg_color' => sanitize_hex_color($_POST['wfm_cta_bg_color'] ?? '#8E2183'),
            'text_color' => sanitize_hex_color($_POST['wfm_cta_text_color'] ?? '#FFFFFF'),
            'hover_bg_color' => sanitize_hex_color($_POST['wfm_cta_hover_bg_color'] ?? '#6B1762'),
            'target' => sanitize_text_field($_POST['wfm_cta_target'] ?? '_blank'),
        );
        update_post_meta($post_id, '_wfm_cta_options', $cta_options);

        // Sauvegarder les options de logos
        $logo_options = array(
            'show_logo_ia' => isset($_POST['wfm_show_logo_ia']) ? '1' : '0',
            'logo_ia_id' => isset($_POST['wfm_logo_ia_id']) ? intval($_POST['wfm_logo_ia_id']) : '',
            'show_logo_qualiopi' => isset($_POST['wfm_show_logo_qualiopi']) ? '1' : '0',
            'logo_qualiopi_id' => isset($_POST['wfm_logo_qualiopi_id']) ? intval($_POST['wfm_logo_qualiopi_id']) : '',
            'show_logo_custom' => isset($_POST['wfm_show_logo_custom']) ? '1' : '0',
            'logo_custom_id' => isset($_POST['wfm_logo_custom_id']) ? intval($_POST['wfm_logo_custom_id']) : '',
            'logos_position' => sanitize_text_field($_POST['wfm_logos_position'] ?? 'bottom'),
        );
        update_post_meta($post_id, '_wfm_logo_options', $logo_options);
    }

    /**
     * Ajouter l'endpoint pour les widgets
     */
    public function add_widget_endpoint() {
        add_rewrite_rule(
            '^widget-formation/([0-9]+)/?$',
            'index.php?widget_formation_id=$matches[1]',
            'top'
        );

        add_rewrite_tag('%widget_formation_id%', '([0-9]+)');
    }

    /**
     * Redirection du template pour les widgets
     */
    public function widget_template_redirect() {
        $widget_id = get_query_var('widget_formation_id');

        if ($widget_id) {
            include WFM_PLUGIN_DIR . 'templates/widget-display.php';
            exit;
        }
    }

    /**
     * Charger les scripts admin
     */
    public function admin_enqueue_scripts($hook) {
        global $post_type;

        if (($hook === 'post.php' || $hook === 'post-new.php') && $post_type === 'widget_formation') {
            wp_enqueue_style('wfm-admin', WFM_PLUGIN_URL . 'assets/css/admin.css', array(), WFM_VERSION);
            wp_enqueue_script('wfm-admin', WFM_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), WFM_VERSION, true);

            // Passer les données AJAX
            wp_localize_script('wfm-admin', 'wfmAjax', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wfm_get_formation_data')
            ));
        }
    }

    /**
     * AJAX: Récupérer les données d'une formation
     */
    public function ajax_get_formation_data() {
        check_ajax_referer('wfm_get_formation_data', 'nonce');

        $formation_id = isset($_POST['formation_id']) ? intval($_POST['formation_id']) : 0;

        if (!$formation_id) {
            wp_send_json_error('ID de formation invalide');
        }

        $formation = get_post($formation_id);

        if (!$formation) {
            wp_send_json_error('Formation introuvable');
        }

        // Récupérer les données de base
        $data = array(
            'id' => $formation->ID,
            'title' => $formation->post_title,
            'excerpt' => $formation->post_excerpt ? $formation->post_excerpt : wp_trim_words($formation->post_content, 30),
            'url' => get_permalink($formation->ID),
            'featured_image' => get_the_post_thumbnail_url($formation->ID, 'medium'),
        );

        // Récupérer les données du programme (si plugin Programme Formation est actif)
        if (class_exists('PFM_Modules_Manager')) {
            $pfm_infos = get_post_meta($formation->ID, '_pfm_infos_pratiques', true);
            $pfm_modules = get_post_meta($formation->ID, '_pfm_modules', true);

            $data['duree'] = isset($pfm_infos['duree']) ? $pfm_infos['duree'] : '';
            $data['prix'] = isset($pfm_infos['prix']) ? $pfm_infos['prix'] : '';
            $data['modules_count'] = is_array($pfm_modules) ? count($pfm_modules) : 0;
        }

        // Récupérer les données du formateur (si plugin Formateur est actif)
        if (class_exists('FFM_Formateur_Manager')) {
            // Chercher le formateur lié à cette formation
            $formateur_id = get_post_meta($formation->ID, '_wfm_formateur_id', true);

            if ($formateur_id) {
                $formateur_data = get_post_meta($formateur_id, '_ffm_formateur_data', true);

                if ($formateur_data) {
                    $data['formateur'] = array(
                        'id' => $formateur_id,
                        'nom' => isset($formateur_data['nom']) ? $formateur_data['nom'] : '',
                        'tagline' => isset($formateur_data['tagline']) ? $formateur_data['tagline'] : '',
                        'photo' => isset($formateur_data['photo_id']) ? wp_get_attachment_image_url($formateur_data['photo_id'], 'thumbnail') : '',
                        'badge' => isset($formateur_data['badge']) ? $formateur_data['badge'] : '',
                    );
                }
            }
        }

        wp_send_json_success($data);
    }
}

// Initialiser le plugin
Widget_Formation_Manager::get_instance();

// Activation du plugin : flush rewrite rules
register_activation_hook(__FILE__, function() {
    Widget_Formation_Manager::get_instance()->register_post_type();
    Widget_Formation_Manager::get_instance()->add_widget_endpoint();
    flush_rewrite_rules();
});

// Désactivation : flush rewrite rules
register_deactivation_hook(__FILE__, function() {
    flush_rewrite_rules();
});
