<?php
/**
 * Insuffle Académie Theme Functions
 * Thème basé sur Gutenberg avec gestion des formations par pages
 */

if (!defined('ABSPATH')) exit;

define('INSUFFLE_VERSION', '3.3');
define('INSUFFLE_DIR', get_template_directory());
define('INSUFFLE_URI', get_template_directory_uri());

// =======================
// CHARGEMENT DES FICHIERS INC
// =======================

// Theme Customizer (CTA Formations paramétrable)
require_once INSUFFLE_DIR . '/inc/theme-customizer.php';

// Block Patterns (Compositions prêtes à l'emploi)
require_once INSUFFLE_DIR . '/inc/block-patterns.php';

// Page Meta boxes (Hero configurable pour template-formation.php)
require_once INSUFFLE_DIR . '/inc/page-metaboxes.php';

// =======================
// SETUP DU THÈME
// =======================

function insuffle_theme_setup() {
    // Support des fonctionnalités
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Support Gutenberg complet
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-line-height');
    add_theme_support('custom-spacing');
    add_theme_support('custom-units');
    
    // Tailles d'images
    add_image_size('formation-card', 400, 250, true);
    add_image_size('formation-hero', 1200, 600, true);
    
    // Menus
    register_nav_menus(array(
        'primary' => 'Menu Principal',
        'footer' => 'Menu Footer'
    ));
}
add_action('after_setup_theme', 'insuffle_theme_setup');

// =======================
// ENQUEUE STYLES & SCRIPTS
// =======================

function insuffle_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap', array(), null);
    
    // Style principal
    wp_enqueue_style('insuffle-style', get_stylesheet_uri(), array(), INSUFFLE_VERSION);
    
    // Scripts
    if (!is_admin()) {
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'insuffle_enqueue_assets');

// Styles pour l'éditeur Gutenberg
function insuffle_editor_assets() {
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'insuffle_editor_assets');

// =======================
// CLASSES CSS PERSONNALISÉES POUR GUTENBERG
// =======================

function insuffle_custom_block_classes() {
    ?>
    <style>
        /* Classes personnalisées pour l'éditeur */
        .editor-styles-wrapper .formation-card {
            background: #f5f5f5;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
        }
        
        .editor-styles-wrapper .btn {
            display: inline-block;
            background: #FFD466;
            color: #8E2183;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
    <?php
}
add_action('admin_head', 'insuffle_custom_block_classes');

// =======================
// SIDEBAR & WIDGETS
// =======================

function insuffle_widgets_init() {
    // Sidebar Pages
    register_sidebar(array(
        'name'          => 'Sidebar Pages',
        'id'            => 'page-sidebar',
        'description'   => 'Zone de widgets pour les pages',
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    // Footer - Colonne 1
    register_sidebar(array(
        'name'          => 'Footer - Colonne 1',
        'id'            => 'footer-1',
        'description'   => 'Première colonne du footer (À propos)',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    // Footer - Colonne 2
    register_sidebar(array(
        'name'          => 'Footer - Colonne 2',
        'id'            => 'footer-2',
        'description'   => 'Deuxième colonne du footer (Navigation)',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    // Footer - Colonne 3
    register_sidebar(array(
        'name'          => 'Footer - Colonne 3',
        'id'            => 'footer-3',
        'description'   => 'Troisième colonne du footer (Formations)',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    // Footer - Colonne 4
    register_sidebar(array(
        'name'          => 'Footer - Colonne 4',
        'id'            => 'footer-4',
        'description'   => 'Quatrième colonne du footer (Contact)',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'insuffle_widgets_init');

// =======================
// CRÉATION DU CONTENU PAR DÉFAUT
// =======================

function insuffle_create_default_pages() {
    if (get_option('insuffle_pages_created')) {
        return;
    }
    
    // Page d'accueil
    $homepage_id = wp_insert_post(array(
        'post_title'    => 'Accueil',
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'page_template' => 'front-page.php'
    ));
    
    // Définir comme page d'accueil
    update_option('page_on_front', $homepage_id);
    update_option('show_on_front', 'page');
    
    // Page Formations (parent)
    $formations_parent_id = wp_insert_post(array(
        'post_title'   => 'Formations',
        'post_content' => '<!-- wp:heading --><h2>Nos formations</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Découvrez toutes nos formations en facilitation et intelligence collective.</p><!-- /wp:paragraph -->',
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ));
    
    // Formations (pages enfants)
    $formations = array(
        array(
            'title' => 'Facilitation Bootcamp',
            'excerpt' => '3 jours | Présentiel ou distanciel',
            'content' => '<!-- wp:heading --><h2>Une immersion complète dans la facilitation</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Une immersion de 3 jours pour maîtriser l\'art de libérer l\'intelligence collective. Adoptez la posture du facilitateur et découvrez les outils qui transforment les groupes en forces créatives.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Programme</h3><!-- /wp:heading --><!-- wp:list --><ul><li>Jour 1 : Les fondamentaux de la facilitation</li><li>Jour 2 : Outils et techniques avancées</li><li>Jour 3 : Mise en pratique et certification</li></ul><!-- /wp:list -->'
        ),
        array(
            'title' => 'Manager Facilitateur',
            'excerpt' => '2 jours | Présentiel ou distanciel',
            'content' => '<!-- wp:heading --><h2>Leadership collaboratif</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Apprenez à incarner un leadership collaboratif qui engage, développe et aligne vos équipes. Découvrez comment la facilitation peut transformer votre pratique managériale au quotidien.</p><!-- /wp:paragraph -->'
        ),
        array(
            'title' => 'Sketchnote',
            'excerpt' => '2 jours | Présentiel ou distanciel',
            'content' => '<!-- wp:heading --><h2>Pensée visuelle</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Structurez vos pensées visuellement et facilitez la mémorisation grâce au sketchnoting. Une approche pratique pour capturer, organiser et partager efficacement les idées.</p><!-- /wp:paragraph -->'
        ),
        array(
            'title' => 'Les fondamentaux de la facilitation',
            'excerpt' => '1 jour | Présentiel ou distanciel',
            'content' => '<!-- wp:heading --><h2>Initiation à la facilitation</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Initiez-vous aux principes essentiels de la facilitation en une journée. Découvrez comment transformer vos réunions en temps collectifs productifs et engageants.</p><!-- /wp:paragraph -->'
        ),
        array(
            'title' => 'Facilitation et intelligence collective',
            'excerpt' => '3 jours | Présentiel ou distanciel',
            'content' => '<!-- wp:heading --><h2>Formation complète</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Développez un ensemble complet de compétences en facilitation à travers une formation approfondie aux postures, techniques et outils de l\'intelligence collective.</p><!-- /wp:paragraph -->'
        ),
    );
    
    foreach ($formations as $formation) {
        wp_insert_post(array(
            'post_title'   => $formation['title'],
            'post_excerpt' => $formation['excerpt'],
            'post_content' => $formation['content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_parent'  => $formations_parent_id,
        ));
    }
    
    // Page Contact
    wp_insert_post(array(
        'post_title'   => 'Contact',
        'post_content' => '<!-- wp:heading --><h2>Contactez-nous</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Une question sur nos formations ? Contactez notre équipe.</p><!-- /wp:paragraph -->',
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ));
    
    update_option('insuffle_pages_created', true);
}
add_action('after_switch_theme', 'insuffle_create_default_pages');

// =======================
// FONCTION HELPER : RÉCUPÉRER LES FORMATIONS
// =======================

function insuffle_get_formations($args = array()) {
    // Trouver la page parent "Formations"
    $formations_page = get_page_by_path('formations');
    
    if (!$formations_page) {
        return array();
    }
    
    $defaults = array(
        'post_type'      => 'page',
        'post_parent'    => $formations_page->ID,
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );
    
    $args = wp_parse_args($args, $defaults);
    
    return get_posts($args);
}

// =======================
// BLOC GUTENBERG : LISTE DES FORMATIONS
// =======================

function insuffle_register_formations_block() {
    // Enregistrer le bloc
    register_block_type('insuffle/formations-list', array(
        'render_callback' => 'insuffle_render_formations_block',
        'attributes' => array(
            'columns' => array(
                'type' => 'number',
                'default' => 3,
            ),
            'limit' => array(
                'type' => 'number',
                'default' => -1,
            ),
            'showExcerpt' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'showButton' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'showDownload' => array(
                'type' => 'boolean',
                'default' => true,
            ),
        ),
    ));
}
add_action('init', 'insuffle_register_formations_block');

// Fonction de rendu du bloc
function insuffle_render_formations_block($attributes) {
    $columns = isset($attributes['columns']) ? $attributes['columns'] : 3;
    $limit = isset($attributes['limit']) ? $attributes['limit'] : -1;
    $show_excerpt = isset($attributes['showExcerpt']) ? $attributes['showExcerpt'] : true;
    $show_button = isset($attributes['showButton']) ? $attributes['showButton'] : true;
    $show_download = isset($attributes['showDownload']) ? $attributes['showDownload'] : true;
    
    // Récupérer les formations
    $formations = insuffle_get_formations(array(
        'posts_per_page' => $limit,
    ));
    
    if (!$formations) {
        return '<p style="text-align: center; padding: 40px; background: #f5f5f5; border-radius: 10px;">Aucune formation disponible pour le moment.</p>';
    }
    
    // Générer le HTML
    ob_start();
    ?>
    <style>
    .insuffle-formations-block {
        margin: 40px 0;
    }
    
    .insuffle-formations-grid {
        display: grid;
        grid-template-columns: repeat(<?php echo $columns; ?>, 1fr);
        gap: 30px;
        margin-top: 30px;
    }
    
    .insuffle-formation-card {
        background-color: #FFFFFF;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .insuffle-formation-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    
    .insuffle-formation-image {
        overflow: hidden;
        height: 200px;
        background: linear-gradient(135deg, #8E2183, #FFD466);
        position: relative;
    }
    
    .insuffle-formation-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .insuffle-formation-content {
        padding: 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .insuffle-formation-content h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #8E2183;
        line-height: 1.3;
    }
    
    .insuffle-formation-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }
    
    .insuffle-formation-excerpt {
        color: #555;
        line-height: 1.6;
        margin-bottom: 20px;
        flex: 1;
    }
    
    .insuffle-formation-links {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: auto;
    }
    
    .insuffle-formation-btn {
        display: inline-block;
        background-color: #FFD466;
        color: #8E2183;
        padding: 12px 30px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .insuffle-formation-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        color: #8E2183;
        text-decoration: none;
    }
    
    .insuffle-download-link {
        display: inline-block;
        color: #8E2183;
        font-size: 0.95rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
        padding: 8px 0;
    }
    
    .insuffle-download-link:hover {
        color: #FFD466;
        text-decoration: underline;
    }
    
    .insuffle-download-link::before {
        content: "📄 ";
        margin-right: 5px;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .insuffle-formations-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .insuffle-formations-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
    
    <div class="insuffle-formations-block">
        <div class="insuffle-formations-grid">
            <?php foreach ($formations as $formation) : 
                setup_postdata($formation);
                $plaquette_url = get_post_meta($formation->ID, 'plaquette_url', true);
            ?>
                <div class="insuffle-formation-card">
                    <?php if (has_post_thumbnail($formation->ID)) : ?>
                        <div class="insuffle-formation-image">
                            <?php echo get_the_post_thumbnail($formation->ID, 'formation-card'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="insuffle-formation-content">
                        <h3><?php echo get_the_title($formation->ID); ?></h3>
                        
                        <?php if ($show_excerpt && $formation->post_excerpt) : ?>
                            <div class="insuffle-formation-meta">
                                <span><?php echo esc_html($formation->post_excerpt); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="insuffle-formation-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt($formation->ID), 20); ?>
                        </div>
                        
                        <div class="insuffle-formation-links">
                            <?php if ($show_button) : ?>
                                <a href="<?php echo get_permalink($formation->ID); ?>" class="insuffle-formation-btn">
                                    Voir le programme
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($show_download && $plaquette_url) : ?>
                                <a href="<?php echo esc_url($plaquette_url); ?>" class="insuffle-download-link" target="_blank" rel="noopener">
                                    Télécharger la plaquette
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>
    <?php
    
    return ob_get_clean();
}

// Enregistrer la catégorie de bloc
function insuffle_register_block_category($categories) {
    return array_merge(
        array(
            array(
                'slug'  => 'insuffle',
                'title' => 'Insuffle Académie',
                'icon'  => 'graduation-cap',
            ),
        ),
        $categories
    );
}
add_filter('block_categories_all', 'insuffle_register_block_category', 10, 1);

// Ajouter le bloc dans l'éditeur Gutenberg avec JS
function insuffle_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'insuffle-formations-block',
        get_template_directory_uri() . '/js/formations-block.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components'),
        INSUFFLE_VERSION,
        true
    );
}
add_action('enqueue_block_editor_assets', 'insuffle_enqueue_block_editor_assets');

// Shortcode alternatif pour utiliser le bloc n'importe où
function insuffle_formations_shortcode($atts) {
    $atts = shortcode_atts(array(
        'columns' => 3,
        'limit' => -1,
        'excerpt' => 'true',
        'button' => 'true',
        'download' => 'true',
    ), $atts);
    
    $attributes = array(
        'columns' => intval($atts['columns']),
        'limit' => intval($atts['limit']),
        'showExcerpt' => $atts['excerpt'] === 'true',
        'showButton' => $atts['button'] === 'true',
        'showDownload' => $atts['download'] === 'true',
    );
    
    return insuffle_render_formations_block($attributes);
}
add_shortcode('insuffle-formations', 'insuffle_formations_shortcode');

// =======================
// CUSTOM MENU WALKER - Pour le bouton CTA
// =======================

class Insuffle_Menu_Walker extends Walker_Nav_Menu {
    /**
     * Ajoute la classe 'nav-cta' aux éléments de menu avec la classe CSS 'cta'
     */
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Vérifier si l'élément a la classe 'cta'
        $is_cta = in_array('cta', $classes);

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = ! empty($item->target) ? $item->target : '';
        $atts['rel']    = ! empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = ! empty($item->url) ? $item->url : '';

        // Ajouter la classe 'nav-cta' aux liens CTA
        if ($is_cta) {
            $atts['class'] = 'nav-cta';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (! empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Menu de secours si aucun menu n'est configuré
 */
function insuffle_fallback_menu() {
    ?>
    <ul class="nav-menu">
        <li><a href="<?php echo home_url('/'); ?>">Accueil</a></li>
        <li><a href="<?php echo home_url('/#about'); ?>">Notre approche</a></li>
        <li><a href="<?php echo home_url('/#formations'); ?>">Formations</a></li>
        <li><a href="<?php echo home_url('/blog/'); ?>">Blog</a></li>
        <li><a href="<?php echo home_url('/#contact'); ?>">Contact</a></li>
        <li><a href="<?php echo home_url('/#contact'); ?>" class="nav-cta">Demande de devis</a></li>
    </ul>
    <?php
}

/**
 * Menu de secours pour le footer
 */
function insuffle_fallback_footer_menu() {
    ?>
    <ul class="footer-links">
        <li><a href="<?php echo home_url('/'); ?>">Accueil</a></li>
        <li><a href="<?php echo home_url('/#about'); ?>">Notre approche</a></li>
        <li><a href="<?php echo home_url('/#formations'); ?>">Nos formations</a></li>
        <li><a href="<?php echo home_url('/blog/'); ?>">Blog</a></li>
        <li><a href="<?php echo home_url('/#contact'); ?>">Contact</a></li>
    </ul>
    <?php
}

// =======================
// MASQUER LE MENU FORMATION DE L'ADMIN
// =======================

/**
 * Masque l'onglet "Formations" du menu admin
 * Note: Les formations sont gérées comme des pages, pas comme custom post type
 */
function insuffle_hide_formation_menu() {
    remove_menu_page('edit.php?post_type=formation');
}
add_action('admin_menu', 'insuffle_hide_formation_menu', 999);

// =======================
// NETTOYAGE DU HEAD
// =======================

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

// =======================
// SÉCURITÉ
// =======================

// Désactiver l'édition de fichiers depuis l'admin
define('DISALLOW_FILE_EDIT', true);