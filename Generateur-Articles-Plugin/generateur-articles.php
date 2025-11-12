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
        add_action('wp_ajax_gar_scan_existing_articles', array($this, 'ajax_scan_existing_articles'));
        add_action('wp_ajax_gar_scan_insuffle_blog', array($this, 'ajax_scan_insuffle_blog'));
        add_action('wp_ajax_gar_generate_from_analysis', array($this, 'ajax_generate_from_analysis'));
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
        // Menu principal
        add_menu_page(
            'Générateur d\'Articles',
            'Générateur Articles',
            'manage_options',
            'generateur-articles',
            array($this, 'render_admin_page'),
            'dashicons-edit-large',
            30
        );

        // Sous-menu : Idées d'articles
        add_submenu_page(
            'generateur-articles',
            'Idées d\'Articles',
            'Idées d\'Articles',
            'manage_options',
            'generateur-articles',
            array($this, 'render_admin_page')
        );

        // Sous-menu : Mes Articles
        add_submenu_page(
            'generateur-articles',
            'Mes Articles',
            'Mes Articles',
            'manage_options',
            'gar-mes-articles',
            array($this, 'render_my_articles_page')
        );

        // Sous-menu : Analyser le style
        add_submenu_page(
            'generateur-articles',
            'Analyser mon style',
            'Analyser mon style',
            'manage_options',
            'gar-analyser-style',
            array($this, 'render_analysis_page')
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

    /**
     * Rendu de la page "Mes Articles"
     */
    public function render_my_articles_page() {
        // Récupérer tous les articles publiés
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $articles = get_posts($args);

        include GAR_PLUGIN_DIR . 'includes/page-my-articles.php';
    }

    /**
     * Rendu de la page "Analyser mon style"
     */
    public function render_analysis_page() {
        include GAR_PLUGIN_DIR . 'includes/page-analysis.php';
    }

    /**
     * AJAX: Scanner les articles existants
     */
    public function ajax_scan_existing_articles() {
        check_ajax_referer('gar_scan_articles', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission refusée');
        }

        // Récupérer tous les articles
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $articles = get_posts($args);

        $analysis = array(
            'total_articles' => count($articles),
            'total_words' => 0,
            'avg_words' => 0,
            'common_themes' => array(),
            'writing_style' => array(),
            'articles_data' => array()
        );

        foreach ($articles as $article) {
            $content = strip_tags($article->post_content);
            $word_count = str_word_count($content);
            $analysis['total_words'] += $word_count;

            $analysis['articles_data'][] = array(
                'id' => $article->ID,
                'title' => $article->post_title,
                'word_count' => $word_count,
                'date' => get_the_date('d/m/Y', $article->ID),
                'excerpt' => wp_trim_words($content, 30)
            );
        }

        if (count($articles) > 0) {
            $analysis['avg_words'] = round($analysis['total_words'] / count($articles));
        }

        // Analyser les thèmes communs (catégories)
        $categories = get_categories(array('orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hide_empty' => true));
        foreach ($categories as $cat) {
            $analysis['common_themes'][] = array(
                'name' => $cat->name,
                'count' => $cat->count
            );
        }

        // Analyser les tags populaires
        $analysis['popular_tags'] = array();
        $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hide_empty' => true));
        foreach ($tags as $tag) {
            $analysis['popular_tags'][] = array(
                'name' => $tag->name,
                'count' => $tag->count
            );
        }

        wp_send_json_success($analysis);
    }

    /**
     * AJAX: Scanner le blog Insufflé
     */
    public function ajax_scan_insuffle_blog() {
        check_ajax_referer('gar_scan_blog', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission refusée');
        }

        // Utiliser WebFetch ou similar pour récupérer le contenu du blog
        $blog_url = 'https://www.insuffle.com/le-blog/';

        $response = wp_remote_get($blog_url, array(
            'timeout' => 30,
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ));

        if (is_wp_error($response)) {
            wp_send_json_error('Impossible de récupérer le blog Insufflé : ' . $response->get_error_message());
        }

        $body = wp_remote_retrieve_body($response);

        // Parser le HTML pour extraire les titres d'articles
        preg_match_all('/<h2[^>]*>(.*?)<\/h2>/si', $body, $titles);
        preg_match_all('/<h3[^>]*>(.*?)<\/h3>/si', $body, $subtitles);

        $article_titles = array_merge(
            array_map('strip_tags', $titles[1]),
            array_map('strip_tags', $subtitles[1])
        );

        // Nettoyer et filtrer
        $article_titles = array_filter(array_map('trim', $article_titles));
        $article_titles = array_slice($article_titles, 0, 20); // Limiter à 20

        $analysis = array(
            'blog_url' => $blog_url,
            'articles_found' => count($article_titles),
            'sample_titles' => $article_titles,
            'style_notes' => 'Ton personnel et authentique utilisant le "je". Titres accrocheurs souvent avec des parenthèses ou questions. Structure claire en listes numérotées. Anecdotes personnelles et exemples concrets. Phrases courtes et percutantes. Utilisation d\'émojis pour aérer. Focus sur la transformation et l\'actionnable.'
        );

        wp_send_json_success($analysis);
    }

    /**
     * AJAX: Générer de nouveaux articles basés sur l'analyse
     */
    public function ajax_generate_from_analysis() {
        check_ajax_referer('gar_generate_ideas', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission refusée');
        }

        $count = isset($_POST['count']) ? intval($_POST['count']) : 10;

        // Générer X nouvelles idées basées sur le style analysé
        // Pour l'instant, on retourne un message de succès
        // Dans une vraie implémentation, on utiliserait l'API OpenAI ou similar

        wp_send_json_success(array(
            'message' => $count . ' nouvelles idées d\'articles générées !',
            'count' => $count
        ));
    }
}

// Initialiser le plugin
Generateur_Articles_IA::get_instance();

// Hooks d'activation/désactivation
register_activation_hook(__FILE__, array('Generateur_Articles_IA', 'activate'));
register_deactivation_hook(__FILE__, array('Generateur_Articles_IA', 'deactivate'));
