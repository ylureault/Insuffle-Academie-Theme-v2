<?php
/**
 * Gestion du Custom Post Type Formateur
 */

if (!defined('ABSPATH')) {
    exit;
}

class Formateur_CPT {

    /**
     * Instance unique (Singleton)
     */
    private static $instance = null;

    /**
     * Retourne l'instance unique
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
        add_action('init', array($this, 'register_post_type'));
        add_filter('manage_formateur_posts_columns', array($this, 'custom_columns'));
        add_action('manage_formateur_posts_custom_column', array($this, 'custom_column_content'), 10, 2);
    }

    /**
     * Enregistre le custom post type Formateur
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => __('Formateurs', 'plugin-formateur'),
            'singular_name'         => __('Formateur', 'plugin-formateur'),
            'menu_name'             => __('Formateurs', 'plugin-formateur'),
            'add_new'               => __('Ajouter un formateur', 'plugin-formateur'),
            'add_new_item'          => __('Ajouter un nouveau formateur', 'plugin-formateur'),
            'edit_item'             => __('Modifier le formateur', 'plugin-formateur'),
            'new_item'              => __('Nouveau formateur', 'plugin-formateur'),
            'view_item'             => __('Voir le formateur', 'plugin-formateur'),
            'search_items'          => __('Rechercher un formateur', 'plugin-formateur'),
            'not_found'             => __('Aucun formateur trouvé', 'plugin-formateur'),
            'not_found_in_trash'    => __('Aucun formateur dans la corbeille', 'plugin-formateur'),
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'has_archive'           => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'formateur'),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => 6,
            'menu_icon'             => 'dashicons-businessperson',
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'          => true,
        );

        register_post_type('formateur', $args);
    }

    /**
     * Ajoute des colonnes personnalisées dans l'admin
     */
    public function custom_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['thumbnail'] = __('Photo', 'plugin-formateur');
        $new_columns['title'] = $columns['title'];
        $new_columns['titre'] = __('Titre/Fonction', 'plugin-formateur');
        $new_columns['contact'] = __('Contact', 'plugin-formateur');
        $new_columns['ordre'] = __('Ordre', 'plugin-formateur');
        $new_columns['date'] = $columns['date'];
        return $new_columns;
    }

    /**
     * Contenu des colonnes personnalisées
     */
    public function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'thumbnail':
                if (has_post_thumbnail($post_id)) {
                    echo get_the_post_thumbnail($post_id, array(50, 50), array('style' => 'border-radius: 50%;'));
                } else {
                    echo '<span class="dashicons dashicons-businessperson" style="font-size: 40px; color: #ccc;"></span>';
                }
                break;

            case 'titre':
                $titre = get_post_meta($post_id, '_formateur_titre', true);
                echo $titre ? esc_html($titre) : '—';
                break;

            case 'contact':
                $email = get_post_meta($post_id, '_formateur_email', true);
                $telephone = get_post_meta($post_id, '_formateur_telephone', true);
                if ($email) {
                    echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a><br>';
                }
                if ($telephone) {
                    echo '<a href="tel:' . esc_attr($telephone) . '">' . esc_html($telephone) . '</a>';
                }
                if (!$email && !$telephone) {
                    echo '—';
                }
                break;

            case 'ordre':
                $ordre = get_post_meta($post_id, '_formateur_ordre', true);
                echo $ordre ? esc_html($ordre) : '—';
                break;
        }
    }
}
