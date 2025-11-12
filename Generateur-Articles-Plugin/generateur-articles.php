<?php
/**
 * Plugin Name: Générateur d'Articles Insufflé Académie
 * Description: Générateur de 100 idées d'articles SEO-optimisés sur la facilitation et l'intelligence collective
 * Version: 1.0.0
 * Author: Insufflé Académie
 * Text Domain: generateur-articles
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('GAR_VERSION', '1.0.0');
define('GAR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GAR_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Classe principale du plugin
 */
class Generateur_Articles_IA {

    private static $instance = null;
    private $table_name;

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
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'gar_article_ideas';

        $this->init();
    }

    /**
     * Initialisation
     */
    private function init() {
        // Ajouter le menu admin
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Enregistrer les scripts et styles admin
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));

        // AJAX handlers
        add_action('wp_ajax_gar_validate_article', array($this, 'ajax_validate_article'));
        add_action('wp_ajax_gar_delete_idea', array($this, 'ajax_delete_idea'));
        add_action('wp_ajax_gar_regenerate_ideas', array($this, 'ajax_regenerate_ideas'));
    }

    /**
     * Créer la table lors de l'activation
     */
    public static function activate() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'gar_article_ideas';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            slug varchar(255) NOT NULL,
            content longtext NOT NULL,
            excerpt text NOT NULL,
            meta_description text NOT NULL,
            meta_keywords varchar(500) NOT NULL,
            category varchar(100) NOT NULL,
            word_count int(11) NOT NULL,
            status varchar(20) DEFAULT 'pending',
            post_id bigint(20) DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            validated_at datetime DEFAULT NULL,
            PRIMARY KEY  (id),
            KEY status (status)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Générer les 100 idées d'articles
        self::generate_article_ideas();
    }

    /**
     * Supprimer la table lors de la désactivation
     */
    public static function deactivate() {
        // On garde la table pour ne pas perdre les données
        // global $wpdb;
        // $table_name = $wpdb->prefix . 'gar_article_ideas';
        // $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    /**
     * Générer les 100 idées d'articles
     */
    public static function generate_article_ideas() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'gar_article_ideas';

        // Vérifier si des idées existent déjà
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        if ($count > 0) {
            return; // Les idées existent déjà
        }

        // Charger le fichier d'idées
        require_once GAR_PLUGIN_DIR . 'includes/article-ideas.php';

        // Insérer chaque idée
        foreach ($gar_article_ideas as $idea) {
            $wpdb->insert(
                $table_name,
                array(
                    'title' => $idea['title'],
                    'slug' => sanitize_title($idea['title']),
                    'content' => $idea['content'],
                    'excerpt' => $idea['excerpt'],
                    'meta_description' => $idea['meta_description'],
                    'meta_keywords' => $idea['meta_keywords'],
                    'category' => $idea['category'],
                    'word_count' => str_word_count(strip_tags($idea['content'])),
                    'status' => 'pending'
                ),
                array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s')
            );
        }
    }

    /**
     * Ajouter le menu admin
     */
    public function add_admin_menu() {
        add_menu_page(
            'Générateur d\'Articles',
            'Générateur Articles',
            'manage_options',
            'generateur-articles',
            array($this, 'render_admin_page'),
            'dashicons-edit-large',
            30
        );
    }

    /**
     * Charger les scripts et styles admin
     */
    public function admin_enqueue_scripts($hook) {
        if ($hook !== 'toplevel_page_generateur-articles') {
            return;
        }

        wp_enqueue_style('gar-admin', GAR_PLUGIN_URL . 'assets/css/admin.css', array(), GAR_VERSION);
        wp_enqueue_script('gar-admin', GAR_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), GAR_VERSION, true);

        wp_localize_script('gar-admin', 'garAdmin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gar_nonce'),
        ));
    }

    /**
     * Rendu de la page admin
     */
    public function render_admin_page() {
        global $wpdb;

        // Récupérer les statistiques
        $total = $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_name}");
        $pending = $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'pending'");
        $published = $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'published'");

        // Récupérer le filtre
        $filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'all';
        $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

        // Construire la requête
        $where = array();
        if ($filter === 'pending') {
            $where[] = "status = 'pending'";
        } elseif ($filter === 'published') {
            $where[] = "status = 'published'";
        }
        if (!empty($search)) {
            $where[] = $wpdb->prepare("(title LIKE %s OR content LIKE %s)", '%' . $wpdb->esc_like($search) . '%', '%' . $wpdb->esc_like($search) . '%');
        }

        $where_sql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        $ideas = $wpdb->get_results("SELECT * FROM {$this->table_name} $where_sql ORDER BY id ASC");

        include GAR_PLUGIN_DIR . 'includes/admin-page.php';
    }

    /**
     * AJAX: Valider une idée et créer l'article
     */
    public function ajax_validate_article() {
        check_ajax_referer('gar_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission refusée');
        }

        $idea_id = intval($_POST['idea_id']);

        global $wpdb;
        $idea = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE id = %d",
            $idea_id
        ));

        if (!$idea) {
            wp_send_json_error('Idée introuvable');
        }

        if ($idea->status === 'published') {
            wp_send_json_error('Article déjà publié');
        }

        // Créer l'article WordPress
        $post_data = array(
            'post_title' => $idea->title,
            'post_content' => $idea->content,
            'post_excerpt' => $idea->excerpt,
            'post_status' => 'draft', // Brouillon par défaut
            'post_type' => 'post',
            'post_name' => $idea->slug,
        );

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            wp_send_json_error('Erreur lors de la création de l\'article');
        }

        // Ajouter les meta descriptions (si Yoast SEO est installé)
        update_post_meta($post_id, '_yoast_wpseo_metadesc', $idea->meta_description);
        update_post_meta($post_id, '_yoast_wpseo_focuskw', $idea->meta_keywords);

        // Ajouter la catégorie
        $category = get_category_by_slug($idea->category);
        if ($category) {
            wp_set_post_categories($post_id, array($category->term_id));
        }

        // Mettre à jour le statut de l'idée
        $wpdb->update(
            $this->table_name,
            array(
                'status' => 'published',
                'post_id' => $post_id,
                'validated_at' => current_time('mysql')
            ),
            array('id' => $idea_id),
            array('%s', '%d', '%s'),
            array('%d')
        );

        wp_send_json_success(array(
            'post_id' => $post_id,
            'edit_url' => admin_url('post.php?post=' . $post_id . '&action=edit')
        ));
    }

    /**
     * AJAX: Supprimer une idée
     */
    public function ajax_delete_idea() {
        check_ajax_referer('gar_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission refusée');
        }

        $idea_id = intval($_POST['idea_id']);

        global $wpdb;
        $deleted = $wpdb->delete($this->table_name, array('id' => $idea_id), array('%d'));

        if ($deleted) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Erreur lors de la suppression');
        }
    }

    /**
     * AJAX: Régénérer toutes les idées
     */
    public function ajax_regenerate_ideas() {
        check_ajax_referer('gar_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission refusée');
        }

        global $wpdb;

        // Supprimer les idées non publiées
        $wpdb->delete($this->table_name, array('status' => 'pending'), array('%s'));

        // Régénérer
        self::generate_article_ideas();

        wp_send_json_success();
    }
}

// Initialiser le plugin
Generateur_Articles_IA::get_instance();

// Hooks d'activation/désactivation
register_activation_hook(__FILE__, array('Generateur_Articles_IA', 'activate'));
register_deactivation_hook(__FILE__, array('Generateur_Articles_IA', 'deactivate'));
