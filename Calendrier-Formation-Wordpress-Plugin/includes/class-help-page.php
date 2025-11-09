<?php
/**
 * Page d'aide et documentation des shortcodes
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Help_Page {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Constructor vide, le menu sera ajouté par CF_Agenda_Menu
    }

    /**
     * Affiche la page d'aide
     */
    public function render_help_page() {
        ?>
        <div class="wrap cf-help-page">
            <h1 class="cf-help-title">
                <span class="dashicons dashicons-book"></span>
                <?php _e('Documentation - Calendrier Formation', 'calendrier-formation'); ?>
            </h1>

            <div class="cf-help-container">

                <!-- Section: Introduction -->
                <div class="cf-help-section">
                    <h2><span class="dashicons dashicons-welcome-learn-more"></span> <?php _e('Bienvenue !', 'calendrier-formation'); ?></h2>
                    <p><?php _e('Ce plugin vous permet de gérer facilement vos sessions de formation et les réservations. Voici comment l\'utiliser :', 'calendrier-formation'); ?></p>
                </div>

                <!-- Section: Shortcodes disponibles -->
                <div class="cf-help-section">
                    <h2><span class="dashicons dashicons-shortcode"></span> <?php _e('Shortcodes disponibles', 'calendrier-formation'); ?></h2>

                    <div class="cf-shortcode-block">
                        <h3><code>[calendrier_formation]</code></h3>
                        <p><?php _e('Affiche les sessions de formation disponibles pour la page actuelle.', 'calendrier-formation'); ?></p>

                        <h4><?php _e('Paramètres :', 'calendrier-formation'); ?></h4>
                        <table class="cf-params-table">
                            <thead>
                                <tr>
                                    <th><?php _e('Paramètre', 'calendrier-formation'); ?></th>
                                    <th><?php _e('Description', 'calendrier-formation'); ?></th>
                                    <th><?php _e('Valeur par défaut', 'calendrier-formation'); ?></th>
                                    <th><?php _e('Exemple', 'calendrier-formation'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>post_id</code></td>
                                    <td><?php _e('ID de la formation à afficher', 'calendrier-formation'); ?></td>
                                    <td><?php _e('Page actuelle', 'calendrier-formation'); ?></td>
                                    <td><code>post_id="123"</code></td>
                                </tr>
                                <tr>
                                    <td><code>limit</code></td>
                                    <td><?php _e('Nombre maximum de sessions à afficher', 'calendrier-formation'); ?></td>
                                    <td>0 (<?php _e('toutes', 'calendrier-formation'); ?>)</td>
                                    <td><code>limit="5"</code></td>
                                </tr>
                                <tr>
                                    <td><code>show_past</code></td>
                                    <td><?php _e('Afficher les sessions passées', 'calendrier-formation'); ?></td>
                                    <td>non</td>
                                    <td><code>show_past="oui"</code></td>
                                </tr>
                                <tr>
                                    <td><code>display</code></td>
                                    <td><?php _e('Mode d\'affichage', 'calendrier-formation'); ?></td>
                                    <td>cards</td>
                                    <td><code>display="table"</code></td>
                                </tr>
                                <tr>
                                    <td><code>debug</code></td>
                                    <td><?php _e('Mode debug (admin uniquement)', 'calendrier-formation'); ?></td>
                                    <td>non</td>
                                    <td><code>debug="oui"</code></td>
                                </tr>
                            </tbody>
                        </table>

                        <h4><?php _e('Exemples d\'utilisation :', 'calendrier-formation'); ?></h4>
                        <div class="cf-examples">
                            <div class="cf-example-item">
                                <strong><?php _e('Affichage simple :', 'calendrier-formation'); ?></strong>
                                <pre><code>[calendrier_formation]</code></pre>
                            </div>

                            <div class="cf-example-item">
                                <strong><?php _e('Affichage en mode tableau :', 'calendrier-formation'); ?></strong>
                                <pre><code>[calendrier_formation display="table"]</code></pre>
                            </div>

                            <div class="cf-example-item">
                                <strong><?php _e('Limiter à 3 sessions :', 'calendrier-formation'); ?></strong>
                                <pre><code>[calendrier_formation limit="3"]</code></pre>
                            </div>

                            <div class="cf-example-item">
                                <strong><?php _e('Afficher les sessions passées :', 'calendrier-formation'); ?></strong>
                                <pre><code>[calendrier_formation show_past="oui"]</code></pre>
                            </div>

                            <div class="cf-example-item">
                                <strong><?php _e('Mode debug (administrateurs) :', 'calendrier-formation'); ?></strong>
                                <pre><code>[calendrier_formation debug="oui"]</code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="cf-shortcode-block">
                        <h3><code>[formulaire_reservation]</code></h3>
                        <p><?php _e('Affiche le formulaire de réservation pour une session.', 'calendrier-formation'); ?></p>
                        <p><?php _e('Ce shortcode est automatiquement ajouté à la page d\'inscription lors de l\'activation du plugin.', 'calendrier-formation'); ?></p>

                        <h4><?php _e('Exemple d\'utilisation :', 'calendrier-formation'); ?></h4>
                        <div class="cf-examples">
                            <div class="cf-example-item">
                                <pre><code>[formulaire_reservation]</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Guide rapide -->
                <div class="cf-help-section">
                    <h2><span class="dashicons dashicons-list-view"></span> <?php _e('Guide rapide', 'calendrier-formation'); ?></h2>

                    <div class="cf-steps">
                        <div class="cf-step">
                            <div class="cf-step-number">1</div>
                            <div class="cf-step-content">
                                <h3><?php _e('Créer vos formations', 'calendrier-formation'); ?></h3>
                                <p><?php _e('Créez des pages de formation en tant qu\'enfants de votre page "Formations" principale.', 'calendrier-formation'); ?></p>
                            </div>
                        </div>

                        <div class="cf-step">
                            <div class="cf-step-number">2</div>
                            <div class="cf-step-content">
                                <h3><?php _e('Ajouter le shortcode', 'calendrier-formation'); ?></h3>
                                <p><?php _e('Ajoutez le shortcode [calendrier_formation] dans le contenu de votre page de formation.', 'calendrier-formation'); ?></p>
                            </div>
                        </div>

                        <div class="cf-step">
                            <div class="cf-step-number">3</div>
                            <div class="cf-step-content">
                                <h3><?php _e('Créer des sessions', 'calendrier-formation'); ?></h3>
                                <p><?php _e('Allez dans "Agenda > Sessions" ou "Agenda > Calendrier" pour créer vos sessions de formation.', 'calendrier-formation'); ?></p>
                            </div>
                        </div>

                        <div class="cf-step">
                            <div class="cf-step-number">4</div>
                            <div class="cf-step-content">
                                <h3><?php _e('Gérer les réservations', 'calendrier-formation'); ?></h3>
                                <p><?php _e('Les réservations apparaîtront dans "Agenda > Réservations". Vous recevrez un email pour chaque nouvelle demande.', 'calendrier-formation'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Menu Admin -->
                <div class="cf-help-section">
                    <h2><span class="dashicons dashicons-menu"></span> <?php _e('Menu d\'administration', 'calendrier-formation'); ?></h2>

                    <table class="cf-menu-table">
                        <thead>
                            <tr>
                                <th><?php _e('Menu', 'calendrier-formation'); ?></th>
                                <th><?php _e('Description', 'calendrier-formation'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong><?php _e('Tableau de bord', 'calendrier-formation'); ?></strong></td>
                                <td><?php _e('Vue d\'ensemble de vos formations, sessions et réservations', 'calendrier-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Calendrier', 'calendrier-formation'); ?></strong></td>
                                <td><?php _e('Vue calendrier interactive de toutes vos sessions', 'calendrier-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Sessions', 'calendrier-formation'); ?></strong></td>
                                <td><?php _e('Liste et gestion de toutes vos sessions de formation', 'calendrier-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Réservations', 'calendrier-formation'); ?></strong></td>
                                <td><?php _e('Gestion des demandes de réservation', 'calendrier-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Templates emails', 'calendrier-formation'); ?></strong></td>
                                <td><?php _e('Personnalisation des emails envoyés aux participants', 'calendrier-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Aide', 'calendrier-formation'); ?></strong></td>
                                <td><?php _e('Cette page de documentation', 'calendrier-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Aperçu', 'calendrier-formation'); ?></strong></td>
                                <td><?php _e('Prévisualiser les shortcodes avec vos données', 'calendrier-formation'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Paramètres', 'calendrier-formation'); ?></strong></td>
                                <td><?php _e('Configuration générale du plugin', 'calendrier-formation'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Section: Support -->
                <div class="cf-help-section cf-help-support">
                    <h2><span class="dashicons dashicons-sos"></span> <?php _e('Besoin d\'aide ?', 'calendrier-formation'); ?></h2>
                    <p><?php _e('Si vous rencontrez des difficultés, vous pouvez :', 'calendrier-formation'); ?></p>
                    <ul>
                        <li><?php _e('Tester vos shortcodes dans la page "Aperçu"', 'calendrier-formation'); ?></li>
                        <li><?php _e('Utiliser le mode debug avec <code>debug="oui"</code>', 'calendrier-formation'); ?></li>
                        <li><?php _e('Vérifier les paramètres dans "Agenda > Paramètres"', 'calendrier-formation'); ?></li>
                        <li><?php _e('Consulter le diagnostic dans "Agenda > Diagnostic 404"', 'calendrier-formation'); ?></li>
                    </ul>
                </div>

            </div>
        </div>

        <style>
            .cf-help-page {
                background: #f9f9f9;
            }

            .cf-help-title {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 20px 0;
                border-bottom: 2px solid #0073aa;
                margin-bottom: 30px;
            }

            .cf-help-title .dashicons {
                font-size: 32px;
                width: 32px;
                height: 32px;
                color: #0073aa;
            }

            .cf-help-container {
                max-width: 1200px;
            }

            .cf-help-section {
                background: white;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 25px;
                margin-bottom: 25px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .cf-help-section h2 {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 0;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 2px solid #f0f0f0;
                font-size: 22px;
                color: #333;
            }

            .cf-help-section h2 .dashicons {
                color: #0073aa;
                font-size: 26px;
                width: 26px;
                height: 26px;
            }

            .cf-shortcode-block {
                background: #f7f7f7;
                border-left: 4px solid #0073aa;
                padding: 20px;
                margin-bottom: 25px;
                border-radius: 4px;
            }

            .cf-shortcode-block h3 {
                margin-top: 0;
                color: #0073aa;
                font-size: 18px;
            }

            .cf-shortcode-block code {
                background: #2271b1;
                color: white;
                padding: 4px 8px;
                border-radius: 3px;
                font-size: 14px;
            }

            .cf-params-table,
            .cf-menu-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }

            .cf-params-table th,
            .cf-menu-table th,
            .cf-params-table td,
            .cf-menu-table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #e0e0e0;
            }

            .cf-params-table th,
            .cf-menu-table th {
                background: #f0f0f0;
                font-weight: 600;
                color: #333;
            }

            .cf-params-table code,
            .cf-menu-table code {
                background: #e7f3ff;
                color: #0073aa;
                padding: 2px 6px;
                border-radius: 3px;
                font-size: 13px;
            }

            .cf-examples {
                margin-top: 15px;
            }

            .cf-example-item {
                background: white;
                border: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 10px;
                border-radius: 4px;
            }

            .cf-example-item strong {
                display: block;
                margin-bottom: 8px;
                color: #333;
            }

            .cf-example-item pre {
                background: #282c34;
                color: #abb2bf;
                padding: 12px;
                border-radius: 4px;
                overflow-x: auto;
                margin: 0;
            }

            .cf-example-item pre code {
                background: transparent;
                color: #abb2bf;
                padding: 0;
            }

            .cf-steps {
                display: grid;
                gap: 20px;
            }

            .cf-step {
                display: flex;
                gap: 20px;
                align-items: flex-start;
            }

            .cf-step-number {
                flex-shrink: 0;
                width: 40px;
                height: 40px;
                background: #0073aa;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 18px;
            }

            .cf-step-content {
                flex: 1;
            }

            .cf-step-content h3 {
                margin: 0 0 10px 0;
                color: #333;
                font-size: 16px;
            }

            .cf-step-content p {
                margin: 0;
                color: #666;
                line-height: 1.6;
            }

            .cf-help-support {
                background: #e7f3ff;
                border-left: 4px solid #0073aa;
            }

            .cf-help-support ul {
                margin: 15px 0;
                padding-left: 25px;
            }

            .cf-help-support li {
                margin-bottom: 10px;
                line-height: 1.6;
            }
        </style>
        <?php
    }
}
