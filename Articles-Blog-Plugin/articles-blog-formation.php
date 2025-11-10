<?php
/**
 * Plugin Name: Articles Blog Formation
 * Description: Affiche les articles du blog liés à une formation via un shortcode
 * Version: 1.0.0
 * Author: Insufflé Académie
 * Text Domain: articles-blog-formation
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('ABF_VERSION', '1.0.0');
define('ABF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ABF_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Classe principale du plugin
 */
class Articles_Blog_Formation {

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
        // Enregistrer les scripts et styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));

        // Enregistrer le shortcode
        add_shortcode('articles_formation', array($this, 'shortcode_articles'));

        // Ajouter le support des tags pour le CPT programme-formation
        add_action('init', array($this, 'register_taxonomy_for_formation'));
    }

    /**
     * Ajouter le support des tags pour les formations
     */
    public function register_taxonomy_for_formation() {
        register_taxonomy_for_object_type('post_tag', 'programme-formation');
    }

    /**
     * Charger les assets
     */
    public function enqueue_assets() {
        if (has_shortcode(get_post()->post_content, 'articles_formation')) {
            wp_enqueue_style(
                'abf-frontend',
                ABF_PLUGIN_URL . 'assets/css/frontend.css',
                array(),
                ABF_VERSION
            );
        }
    }

    /**
     * Shortcode pour afficher les articles
     *
     * Usage: [articles_formation limit="3" titre="Articles liés"]
     */
    public function shortcode_articles($atts) {
        $atts = shortcode_atts(array(
            'limit' => 3,
            'titre' => 'Articles du blog en lien avec cette formation',
            'formation_id' => get_the_ID(),
        ), $atts);

        // Récupérer les tags de la formation
        $formation_tags = wp_get_post_tags($atts['formation_id'], array('fields' => 'ids'));

        if (empty($formation_tags)) {
            // Si pas de tags, récupérer les derniers articles
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $atts['limit'],
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
            );
        } else {
            // Récupérer les articles avec les mêmes tags
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $atts['limit'],
                'post_status' => 'publish',
                'tag__in' => $formation_tags,
                'orderby' => 'date',
                'order' => 'DESC',
            );
        }

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            return '';
        }

        ob_start();
        ?>

        <section class="abf-articles-section">
            <div class="abf-container">
                <div class="abf-section-subtitle">Blog</div>
                <h2 class="abf-section-title"><?php echo esc_html($atts['titre']); ?></h2>

                <div class="abf-articles-grid">
                    <?php while ($query->have_posts()): $query->the_post(); ?>
                        <article class="abf-article-card">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="abf-article-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', array('class' => 'abf-img')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="abf-article-content">
                                <div class="abf-article-meta">
                                    <span class="abf-article-date">
                                        <span class="dashicons dashicons-calendar-alt"></span>
                                        <?php echo get_the_date('d/m/Y'); ?>
                                    </span>

                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)):
                                    ?>
                                        <span class="abf-article-category">
                                            <?php echo esc_html($categories[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <h3 class="abf-article-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <div class="abf-article-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="abf-article-link">
                                    Lire l'article
                                    <span class="dashicons dashicons-arrow-right-alt2"></span>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php if (!empty($formation_tags)): ?>
                    <div class="abf-view-all">
                        <a href="<?php echo esc_url(get_tag_link($formation_tags[0])); ?>" class="abf-button">
                            Voir tous les articles
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }
}

// Initialiser le plugin
Articles_Blog_Formation::get_instance();
