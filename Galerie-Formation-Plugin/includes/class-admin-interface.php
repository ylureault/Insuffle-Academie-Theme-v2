<?php
/**
 * Interface d'administration
 */

if (!defined('ABSPATH')) {
    exit;
}

class GFM_Admin_Interface {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_menu'));
    }

    /**
     * Ajoute le menu d'aide
     */
    public function add_menu() {
        add_menu_page(
            __('Galerie Formation', 'galerie-formation'),
            __('Galerie', 'galerie-formation'),
            'edit_pages',
            'galerie-formation',
            array($this, 'render_help_page'),
            'dashicons-images-alt2',
            31
        );
    }

    /**
     * Affiche la page d'aide
     */
    public function render_help_page() {
        ?>
        <div class="wrap gfm-help-page">
            <h1><?php _e('Galerie Formation - Documentation', 'galerie-formation'); ?></h1>

            <div class="gfm-help-container">
                <div class="gfm-help-section">
                    <h2><?php _e('Bienvenue !', 'galerie-formation'); ?></h2>
                    <p><?php _e('Ce plugin vous permet de créer et gérer facilement des galeries d\'images pour vos formations.', 'galerie-formation'); ?></p>
                </div>

                <div class="gfm-help-section">
                    <h2><?php _e('Comment utiliser le plugin ?', 'galerie-formation'); ?></h2>

                    <h3><?php _e('1. Ajouter des images', 'galerie-formation'); ?></h3>
                    <p><?php _e('Sur chaque page ou article, vous trouverez une metabox "Galerie Formation - Images" où vous pouvez ajouter autant d\'images que vous le souhaitez.', 'galerie-formation'); ?></p>

                    <h3><?php _e('2. Remplir les champs', 'galerie-formation'); ?></h3>
                    <p><?php _e('Chaque image dispose de 4 champs (tous optionnels) :', 'galerie-formation'); ?></p>
                    <ul>
                        <li><strong><?php _e('Image :', 'galerie-formation'); ?></strong> <?php _e('L\'image à afficher', 'galerie-formation'); ?></li>
                        <li><strong><?php _e('Titre :', 'galerie-formation'); ?></strong> <?php _e('Le titre de l\'image (affiché au survol)', 'galerie-formation'); ?></li>
                        <li><strong><?php _e('Description :', 'galerie-formation'); ?></strong> <?php _e('La description (affichée au survol)', 'galerie-formation'); ?></li>
                        <li><strong><?php _e('Catégorie :', 'galerie-formation'); ?></strong> <?php _e('Pour filtrer par catégorie', 'galerie-formation'); ?></li>
                    </ul>

                    <h3><?php _e('3. Afficher la galerie', 'galerie-formation'); ?></h3>
                    <p><?php _e('Utilisez le shortcode dans votre contenu :', 'galerie-formation'); ?></p>
                    <pre><code>[galerie_formation]</code></pre>
                </div>

                <div class="gfm-help-section">
                    <h2><?php _e('Shortcode disponible', 'galerie-formation'); ?></h2>

                    <h3><code>[galerie_formation]</code></h3>
                    <p><?php _e('Affiche toutes les images de la galerie.', 'galerie-formation'); ?></p>

                    <h4><?php _e('Paramètres :', 'galerie-formation'); ?></h4>
                    <table class="gfm-params-table">
                        <thead>
                            <tr>
                                <th><?php _e('Paramètre', 'galerie-formation'); ?></th>
                                <th><?php _e('Description', 'galerie-formation'); ?></th>
                                <th><?php _e('Défaut', 'galerie-formation'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>post_id</code></td>
                                <td><?php _e('ID du post/page', 'galerie-formation'); ?></td>
                                <td><?php _e('Page actuelle', 'galerie-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><code>category</code></td>
                                <td><?php _e('Filtrer par catégorie', 'galerie-formation'); ?></td>
                                <td><?php _e('Toutes', 'galerie-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><code>columns</code></td>
                                <td><?php _e('Nombre de colonnes', 'galerie-formation'); ?></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td><code>titre</code></td>
                                <td><?php _e('Titre de la section', 'galerie-formation'); ?></td>
                                <td><?php _e('Vide', 'galerie-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><code>sous_titre</code></td>
                                <td><?php _e('Sous-titre de la section', 'galerie-formation'); ?></td>
                                <td><?php _e('Vide', 'galerie-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><code>description</code></td>
                                <td><?php _e('Description de la section', 'galerie-formation'); ?></td>
                                <td><?php _e('Vide', 'galerie-formation'); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <h4><?php _e('Exemples :', 'galerie-formation'); ?></h4>
                    <div class="gfm-examples">
                        <div class="gfm-example-item">
                            <strong><?php _e('Galerie simple :', 'galerie-formation'); ?></strong>
                            <pre><code>[galerie_formation]</code></pre>
                        </div>

                        <div class="gfm-example-item">
                            <strong><?php _e('Avec titres et textes :', 'galerie-formation'); ?></strong>
                            <pre><code>[galerie_formation titre="Nos réalisations" sous_titre="Portfolio" description="Découvrez nos exemples"]</code></pre>
                        </div>

                        <div class="gfm-example-item">
                            <strong><?php _e('4 colonnes :', 'galerie-formation'); ?></strong>
                            <pre><code>[galerie_formation columns="4"]</code></pre>
                        </div>

                        <div class="gfm-example-item">
                            <strong><?php _e('Filtrer par catégorie :', 'galerie-formation'); ?></strong>
                            <pre><code>[galerie_formation category="sketchnote"]</code></pre>
                        </div>
                    </div>
                </div>

                <div class="gfm-help-section" style="background: #e7f3ff; border-left: 4px solid #0073aa; padding: 20px; border-radius: 4px;">
                    <h2><?php _e('Conseils', 'galerie-formation'); ?></h2>
                    <ul>
                        <li><?php _e('Tous les champs sont optionnels', 'galerie-formation'); ?></li>
                        <li><?php _e('Vous pouvez réorganiser les images par glisser-déposer', 'galerie-formation'); ?></li>
                        <li><?php _e('Utilisez des catégories pour créer plusieurs galeries filtrées', 'galerie-formation'); ?></li>
                        <li><?php _e('Le titre et la description s\'affichent au survol de l\'image', 'galerie-formation'); ?></li>
                    </ul>
                </div>
            </div>

            <style>
                .gfm-help-page {
                    max-width: 1200px;
                }

                .gfm-help-container {
                    margin-top: 30px;
                }

                .gfm-help-section {
                    background: white;
                    padding: 30px;
                    margin-bottom: 20px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                }

                .gfm-help-section h2 {
                    margin-top: 0;
                    color: #8E2183;
                    border-bottom: 2px solid #f0f0f0;
                    padding-bottom: 15px;
                }

                .gfm-help-section h3 {
                    color: #333;
                    margin-top: 20px;
                }

                .gfm-help-section pre {
                    background: #282c34;
                    color: #abb2bf;
                    padding: 15px;
                    border-radius: 4px;
                    overflow-x: auto;
                }

                .gfm-help-section code {
                    background: #e7f3ff;
                    color: #8E2183;
                    padding: 3px 8px;
                    border-radius: 3px;
                    font-size: 13px;
                }

                .gfm-help-section pre code {
                    background: transparent;
                    color: #abb2bf;
                    padding: 0;
                }

                .gfm-help-section ul {
                    margin: 15px 0;
                    padding-left: 30px;
                }

                .gfm-help-section li {
                    margin: 10px 0;
                    line-height: 1.6;
                }

                .gfm-params-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }

                .gfm-params-table th,
                .gfm-params-table td {
                    padding: 12px;
                    text-align: left;
                    border-bottom: 1px solid #e0e0e0;
                }

                .gfm-params-table th {
                    background: #f0f0f0;
                    font-weight: 600;
                }

                .gfm-examples {
                    margin-top: 15px;
                }

                .gfm-example-item {
                    background: white;
                    border: 1px solid #ddd;
                    padding: 15px;
                    margin-bottom: 10px;
                    border-radius: 4px;
                }

                .gfm-example-item strong {
                    display: block;
                    margin-bottom: 8px;
                }
            </style>
        </div>
        <?php
    }
}
