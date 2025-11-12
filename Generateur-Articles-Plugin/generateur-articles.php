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

// API Gemini
define('GAR_GEMINI_API_KEY', 'AIzaSyCTGsQvbFkEmWrjc7tnbnw0TJH406NbL-Y');
define('GAR_GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent');

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
     * Helper: Appeler l'API Google Gemini
     */
    private function call_gemini_api($prompt) {
        $api_url = GAR_GEMINI_API_URL . '?key=' . GAR_GEMINI_API_KEY;

        $body = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => $prompt)
                    )
                )
            ),
            'generationConfig' => array(
                'temperature' => 0.9,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 8000,
            )
        );

        $response = wp_remote_post($api_url, array(
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($body),
            'timeout' => 60
        ));

        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }

        $response_body = wp_remote_retrieve_body($response);
        $response_code = wp_remote_retrieve_response_code($response);

        if ($response_code !== 200) {
            return array('error' => 'API Error: ' . $response_code . ' - ' . $response_body);
        }

        $data = json_decode($response_body, true);

        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return array('success' => true, 'text' => $data['candidates'][0]['content']['parts'][0]['text']);
        }

        return array('error' => 'Format de réponse inattendu');
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
        $count = max(1, min(50, $count)); // Limiter entre 1 et 50

        // Récupérer l'analyse existante
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 5,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $recent_articles = get_posts($args);

        // Construire le contexte pour Gemini
        $context = "Tu es un expert en création de contenu pour Insufflé Académie, un organisme de formation spécialisé en facilitation, intelligence collective et management.\n\n";

        $context .= "STYLE D'ÉCRITURE À RESPECTER :\n";
        $context .= "- Ton personnel utilisant le 'je'\n";
        $context .= "- Titres accrocheurs, souvent avec des questions ou parenthèses\n";
        $context .= "- Structure claire en listes numérotées\n";
        $context .= "- Anecdotes personnelles et exemples concrets\n";
        $context .= "- Phrases courtes et percutantes\n";
        $context .= "- Utilisation d'émojis pour aérer (2-3 par article)\n";
        $context .= "- Focus sur la transformation et l'actionnable\n";
        $context .= "- Longueur : 1500-3000 mots\n\n";

        if (!empty($recent_articles)) {
            $context .= "EXEMPLES DE TITRES D'ARTICLES EXISTANTS :\n";
            foreach ($recent_articles as $article) {
                $context .= "- " . $article->post_title . "\n";
            }
            $context .= "\n";
        }

        $context .= "THÉMATIQUES À COUVRIR : facilitation, intelligence collective, management, réunions efficaces, animation d'équipe, leadership collaboratif, transformation organisationnelle, agilité, soft skills.\n\n";

        $context .= "TÂCHE : Génère " . $count . " idées d'articles de blog complètes.\n\n";

        $context .= "FORMAT DE RÉPONSE (STRICT) - Pour chaque article, utilise EXACTEMENT ce format avec les balises :\n\n";
        $context .= "[ARTICLE_START]\n";
        $context .= "[TITRE]Le titre accrocheur ici[/TITRE]\n";
        $context .= "[SLUG]le-slug-optimise-seo[/SLUG]\n";
        $context .= "[CATEGORY]facilitation[/CATEGORY]\n";
        $context .= "[META_DESC]Meta description SEO optimisée (150-160 caractères)[/META_DESC]\n";
        $context .= "[KEYWORDS]mot-clé1, mot-clé2, mot-clé3[/KEYWORDS]\n";
        $context .= "[EXCERPT]Extrait court de 2-3 phrases qui donne envie de lire[/EXCERPT]\n";
        $context .= "[CONTENT]\n";
        $context .= "Le contenu complet de l'article en HTML...\n";
        $context .= "[/CONTENT]\n";
        $context .= "[ARTICLE_END]\n\n";

        $context .= "IMPORTANT :\n";
        $context .= "- Les catégories possibles : facilitation, intelligence-collective, management, leadership\n";
        $context .= "- Le contenu doit être en HTML avec des balises <h2>, <h3>, <p>, <ul>, <li>, <strong>, <em>\n";
        $context .= "- Inclure des émojis pertinents dans le contenu\n";
        $context .= "- Chaque article doit faire 1500-3000 mots\n";
        $context .= "- Respect STRICT du format avec les balises\n\n";

        $context .= "Génère maintenant " . $count . " articles complets :";

        // Appeler Gemini
        $result = $this->call_gemini_api($context);

        if (isset($result['error'])) {
            wp_send_json_error('Erreur Gemini : ' . $result['error']);
        }

        // Parser la réponse et créer les idées
        $generated_text = $result['text'];
        $created_count = $this->parse_and_save_articles($generated_text);

        if ($created_count > 0) {
            wp_send_json_success(array(
                'message' => $created_count . ' nouvelles idées d\'articles générées !',
                'count' => $created_count
            ));
        } else {
            wp_send_json_error('Aucune idée n\'a pu être générée. Veuillez réessayer.');
        }
    }

    /**
     * Parser et sauvegarder les articles générés par Gemini
     */
    private function parse_and_save_articles($text) {
        global $wpdb;
        $count = 0;

        // Extraire tous les articles avec regex
        preg_match_all('/\[ARTICLE_START\](.*?)\[ARTICLE_END\]/s', $text, $matches);

        if (empty($matches[1])) {
            return 0;
        }

        foreach ($matches[1] as $article_data) {
            // Extraire chaque champ
            $title = '';
            $slug = '';
            $category = '';
            $meta_desc = '';
            $keywords = '';
            $excerpt = '';
            $content = '';

            if (preg_match('/\[TITRE\](.*?)\[\/TITRE\]/s', $article_data, $m)) {
                $title = trim($m[1]);
            }
            if (preg_match('/\[SLUG\](.*?)\[\/SLUG\]/s', $article_data, $m)) {
                $slug = trim($m[1]);
            }
            if (preg_match('/\[CATEGORY\](.*?)\[\/CATEGORY\]/s', $article_data, $m)) {
                $category = trim($m[1]);
            }
            if (preg_match('/\[META_DESC\](.*?)\[\/META_DESC\]/s', $article_data, $m)) {
                $meta_desc = trim($m[1]);
            }
            if (preg_match('/\[KEYWORDS\](.*?)\[\/KEYWORDS\]/s', $article_data, $m)) {
                $keywords = trim($m[1]);
            }
            if (preg_match('/\[EXCERPT\](.*?)\[\/EXCERPT\]/s', $article_data, $m)) {
                $excerpt = trim($m[1]);
            }
            if (preg_match('/\[CONTENT\](.*?)\[\/CONTENT\]/s', $article_data, $m)) {
                $content = trim($m[1]);
            }

            // Valider les données minimales
            if (empty($title) || empty($content)) {
                continue;
            }

            // Générer slug si absent
            if (empty($slug)) {
                $slug = sanitize_title($title);
            }

            // Catégorie par défaut
            if (empty($category)) {
                $category = 'facilitation';
            }

            // Insérer dans la base de données
            $inserted = $wpdb->insert(
                $this->table_name,
                array(
                    'title' => $title,
                    'slug' => $slug,
                    'category' => $category,
                    'excerpt' => $excerpt,
                    'content' => $content,
                    'meta_description' => $meta_desc,
                    'meta_keywords' => $keywords,
                    'status' => 'pending',
                    'created_at' => current_time('mysql')
                ),
                array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
            );

            if ($inserted) {
                $count++;
            }
        }

        return $count;
    }
}

// Initialiser le plugin
Generateur_Articles_IA::get_instance();

// Hooks d'activation/désactivation
register_activation_hook(__FILE__, array('Generateur_Articles_IA', 'activate'));
register_deactivation_hook(__FILE__, array('Generateur_Articles_IA', 'deactivate'));
