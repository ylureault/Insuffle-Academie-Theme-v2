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

        // Récupérer les données existantes
        $formations = get_post_meta($post->ID, '_wfm_formations', true);
        $show_logo_ia = get_post_meta($post->ID, '_wfm_show_logo_ia', true);
        $show_logo_qualiopi = get_post_meta($post->ID, '_wfm_show_logo_qualiopi', true);

        if (empty($formations)) {
            $formations = array();
        }
        if ($show_logo_ia === '') {
            $show_logo_ia = '1';
        }
        if ($show_logo_qualiopi === '') {
            $show_logo_qualiopi = '1';
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
                'show_prix' => '0',
                'show_cta_text' => 'En savoir plus',
                'card_style' => 'modern', // modern, minimal, classic
            );
        }

        include WFM_PLUGIN_DIR . 'templates/meta-box-config-new.php';
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

        // Sauvegarder les options d'affichage des logos
        update_post_meta($post_id, '_wfm_show_logo_ia', isset($_POST['wfm_show_logo_ia']) ? '1' : '0');
        update_post_meta($post_id, '_wfm_show_logo_qualiopi', isset($_POST['wfm_show_logo_qualiopi']) ? '1' : '0');

        // Sauvegarder les options d'affichage
        $display_options = array(
            'show_excerpt' => isset($_POST['wfm_show_excerpt']) ? '1' : '0',
            'show_formateur' => isset($_POST['wfm_show_formateur']) ? '1' : '0',
            'show_duree' => isset($_POST['wfm_show_duree']) ? '1' : '0',
            'show_prix' => isset($_POST['wfm_show_prix']) ? '1' : '0',
            'show_cta_text' => sanitize_text_field($_POST['wfm_cta_text'] ?? 'En savoir plus'),
            'card_style' => sanitize_text_field($_POST['wfm_card_style'] ?? 'modern'),
        );
        update_post_meta($post_id, '_wfm_display_options', $display_options);
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
        }
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
