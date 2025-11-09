<?php
/**
 * Gestion du Custom Post Type pour les sessions de formation
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Sessions_CPT {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_filter('manage_formation_posts_columns', array($this, 'add_custom_columns'));
        add_action('manage_formation_posts_custom_column', array($this, 'render_custom_columns'), 10, 2);
    }

    /**
     * Enregistre le Custom Post Type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => __('Formations', 'calendrier-formation'),
            'singular_name'         => __('Formation', 'calendrier-formation'),
            'menu_name'             => __('Calendrier Formations', 'calendrier-formation'),
            'name_admin_bar'        => __('Formation', 'calendrier-formation'),
            'add_new'               => __('Ajouter', 'calendrier-formation'),
            'add_new_item'          => __('Ajouter une formation', 'calendrier-formation'),
            'new_item'              => __('Nouvelle formation', 'calendrier-formation'),
            'edit_item'             => __('Modifier la formation', 'calendrier-formation'),
            'view_item'             => __('Voir la formation', 'calendrier-formation'),
            'all_items'             => __('Toutes les formations', 'calendrier-formation'),
            'search_items'          => __('Rechercher des formations', 'calendrier-formation'),
            'not_found'             => __('Aucune formation trouvée', 'calendrier-formation'),
            'not_found_in_trash'    => __('Aucune formation dans la corbeille', 'calendrier-formation'),
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'formation'),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-calendar-alt',
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'          => true,
        );

        register_post_type('formation', $args);
    }

    /**
     * Ajoute des colonnes personnalisées dans la liste admin
     */
    public function add_custom_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = $columns['title'];
        $new_columns['sessions_count'] = __('Nombre de sessions', 'calendrier-formation');
        $new_columns['next_session'] = __('Prochaine session', 'calendrier-formation');
        $new_columns['date'] = $columns['date'];
        return $new_columns;
    }

    /**
     * Affiche le contenu des colonnes personnalisées
     */
    public function render_custom_columns($column, $post_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cf_sessions';

        switch ($column) {
            case 'sessions_count':
                $count = $wpdb->get_var($wpdb->prepare(
                    "SELECT COUNT(*) FROM $table_name WHERE post_id = %d AND status = 'active'",
                    $post_id
                ));
                echo esc_html($count ? $count : '0');
                break;

            case 'next_session':
                $next_session = $wpdb->get_row($wpdb->prepare(
                    "SELECT date_debut, places_disponibles, places_total
                     FROM $table_name
                     WHERE post_id = %d
                     AND status = 'active'
                     AND date_debut >= NOW()
                     ORDER BY date_debut ASC
                     LIMIT 1",
                    $post_id
                ));

                if ($next_session) {
                    $date = new DateTime($next_session->date_debut);
                    echo esc_html($date->format('d/m/Y H:i'));
                    echo '<br><small>' . sprintf(
                        __('%d/%d places', 'calendrier-formation'),
                        $next_session->places_disponibles,
                        $next_session->places_total
                    ) . '</small>';
                } else {
                    echo '<span style="color: #999;">' . __('Aucune', 'calendrier-formation') . '</span>';
                }
                break;
        }
    }
}
