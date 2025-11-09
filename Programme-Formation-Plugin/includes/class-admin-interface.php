<?php
/**
 * Interface d'administration pour les modules
 */

if (!defined('ABSPATH')) {
    exit;
}

class PFM_Admin_Interface {

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
            __('Programme Formation', 'programme-formation'),
            __('Programme', 'programme-formation'),
            'edit_pages',
            'programme-formation',
            array($this, 'render_help_page'),
            'dashicons-list-view',
            30
        );
    }

    /**
     * Affiche la page d'aide
     */
    public function render_help_page() {
        ?>
        <div class="wrap pfm-help-page">
            <h1><?php _e('Programme Formation - Documentation', 'programme-formation'); ?></h1>

            <div class="pfm-help-container">
                <div class="pfm-help-section">
                    <h2><?php _e('Bienvenue !', 'programme-formation'); ?></h2>
                    <p><?php _e('Ce plugin vous permet de créer et gérer facilement le programme de vos formations avec un système de modules dynamiques.', 'programme-formation'); ?></p>
                </div>

                <div class="pfm-help-section">
                    <h2><?php _e('Comment utiliser le plugin ?', 'programme-formation'); ?></h2>

                    <h3><?php _e('1. Créer des modules', 'programme-formation'); ?></h3>
                    <p><?php _e('Sur chaque page ou article, vous trouverez une metabox "Programme de Formation - Modules" où vous pouvez ajouter autant de modules que vous le souhaitez.', 'programme-formation'); ?></p>

                    <h3><?php _e('2. Remplir les champs', 'programme-formation'); ?></h3>
                    <p><?php _e('Chaque module dispose de 3 champs (tous optionnels) :', 'programme-formation'); ?></p>
                    <ul>
                        <li><strong><?php _e('Numéro :', 'programme-formation'); ?></strong> <?php _e('Le numéro du module (ex: 1, 2, 3...)', 'programme-formation'); ?></li>
                        <li><strong><?php _e('Titre :', 'programme-formation'); ?></strong> <?php _e('Le titre du module', 'programme-formation'); ?></li>
                        <li><strong><?php _e('Contenu :', 'programme-formation'); ?></strong> <?php _e('Le contenu du module avec support HTML (listes, gras, italique...)', 'programme-formation'); ?></li>
                    </ul>

                    <h3><?php _e('3. Afficher le programme', 'programme-formation'); ?></h3>
                    <p><?php _e('Utilisez le shortcode dans votre contenu :', 'programme-formation'); ?></p>
                    <pre><code>[programme_formation]</code></pre>
                </div>

                <div class="pfm-help-section">
                    <h2><?php _e('Shortcode disponible', 'programme-formation'); ?></h2>

                    <h3><code>[programme_formation]</code></h3>
                    <p><?php _e('Affiche tous les modules de la formation.', 'programme-formation'); ?></p>

                    <h4><?php _e('Paramètres :', 'programme-formation'); ?></h4>
                    <ul>
                        <li><code>post_id</code> - <?php _e('ID du post/page (par défaut: page actuelle)', 'programme-formation'); ?></li>
                    </ul>

                    <h4><?php _e('Exemples :', 'programme-formation'); ?></h4>
                    <pre><code>[programme_formation]</code></pre>
                    <pre><code>[programme_formation post_id="123"]</code></pre>
                </div>

                <div class="pfm-help-section">
                    <h2><?php _e('Exemple de module', 'programme-formation'); ?></h2>
                    <p><?php _e('Voici un exemple de contenu pour un module :', 'programme-formation'); ?></p>

                    <div style="background: #f7f7f7; padding: 20px; border-left: 4px solid #8E2183; border-radius: 4px;">
                        <p><strong><?php _e('Numéro :', 'programme-formation'); ?></strong> 1</p>
                        <p><strong><?php _e('Titre :', 'programme-formation'); ?></strong> Le principe du Sketchnoting</p>
                        <p><strong><?php _e('Contenu :', 'programme-formation'); ?></strong></p>
                        <pre style="background: white; padding: 15px; overflow: auto;">
&lt;h4&gt;📖 Contenu du module :&lt;/h4&gt;
&lt;ul&gt;
    &lt;li&gt;✔︎ C'est quoi le Sketchnoting ?&lt;/li&gt;
    &lt;li&gt;✔︎ Découverte et test du matériel&lt;/li&gt;
    &lt;li&gt;✔︎ Bénéfices attendus et objections courantes&lt;/li&gt;
&lt;/ul&gt;

&lt;div class="pfm-quote-block"&gt;
    &lt;strong&gt;Objectif pédagogique :&lt;/strong&gt; À l'issue de la séquence...
&lt;/div&gt;</pre>
                    </div>
                </div>

                <div class="pfm-help-section" style="background: #e7f3ff; border-left: 4px solid #0073aa; padding: 20px; border-radius: 4px;">
                    <h2><?php _e('Conseils', 'programme-formation'); ?></h2>
                    <ul>
                        <li><?php _e('Vous pouvez laisser des champs vides si vous ne souhaitez pas les afficher', 'programme-formation'); ?></li>
                        <li><?php _e('Le contenu supporte le HTML pour un formatage riche', 'programme-formation'); ?></li>
                        <li><?php _e('Utilisez la classe "pfm-quote-block" pour créer des encadrés', 'programme-formation'); ?></li>
                        <li><?php _e('Les modules sont réorganisables par glisser-déposer', 'programme-formation'); ?></li>
                    </ul>
                </div>
            </div>

            <style>
                .pfm-help-page {
                    max-width: 1200px;
                }

                .pfm-help-container {
                    margin-top: 30px;
                }

                .pfm-help-section {
                    background: white;
                    padding: 30px;
                    margin-bottom: 20px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                }

                .pfm-help-section h2 {
                    margin-top: 0;
                    color: #8E2183;
                    border-bottom: 2px solid #f0f0f0;
                    padding-bottom: 15px;
                }

                .pfm-help-section h3 {
                    color: #333;
                    margin-top: 20px;
                }

                .pfm-help-section pre {
                    background: #282c34;
                    color: #abb2bf;
                    padding: 15px;
                    border-radius: 4px;
                    overflow-x: auto;
                }

                .pfm-help-section code {
                    background: #e7f3ff;
                    color: #8E2183;
                    padding: 3px 8px;
                    border-radius: 3px;
                    font-size: 13px;
                }

                .pfm-help-section pre code {
                    background: transparent;
                    color: #abb2bf;
                    padding: 0;
                }

                .pfm-help-section ul {
                    margin: 15px 0;
                    padding-left: 30px;
                }

                .pfm-help-section li {
                    margin: 10px 0;
                    line-height: 1.6;
                }
            </style>
        </div>
        <?php
    }
}
