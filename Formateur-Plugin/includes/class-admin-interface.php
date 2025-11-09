<?php
/**
 * Interface admin et menu WordPress
 */

// Sécurité
if (!defined('ABSPATH')) {
    exit;
}

class FFM_Admin_Interface {

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
     * Ajoute le menu WordPress
     */
    public function add_menu() {
        add_menu_page(
            __('Formateurs', 'fiche-formateur'),
            __('Formateurs', 'fiche-formateur'),
            'edit_pages',
            'fiche-formateur',
            array($this, 'render_help_page'),
            'dashicons-businessperson',
            30
        );

        add_submenu_page(
            'fiche-formateur',
            __('Documentation', 'fiche-formateur'),
            '<span class="dashicons dashicons-book-alt"></span> ' . __('Documentation', 'fiche-formateur'),
            'edit_pages',
            'fiche-formateur',
            array($this, 'render_help_page')
        );
    }

    /**
     * Affiche la page d'aide
     */
    public function render_help_page() {
        ?>
        <div class="wrap ffm-admin-page">
            <h1><?php _e('Fiche Formateur - Documentation', 'fiche-formateur'); ?></h1>

            <div class="ffm-admin-content">

                <div class="ffm-section">
                    <h2><?php _e('📋 Guide d\'utilisation', 'fiche-formateur'); ?></h2>
                    <p><?php _e('Ce plugin vous permet de créer des fiches formateurs complètes avec photo, statistiques et citations.', 'fiche-formateur'); ?></p>

                    <h3><?php _e('Étape 1 : Créer/Éditer une page', 'fiche-formateur'); ?></h3>
                    <p><?php _e('Créez une nouvelle page ou éditez une page existante.', 'fiche-formateur'); ?></p>

                    <h3><?php _e('Étape 2 : Remplir la metabox', 'fiche-formateur'); ?></h3>
                    <p><?php _e('Dans la metabox "Fiche Formateur - Informations", remplissez les champs souhaités :', 'fiche-formateur'); ?></p>
                    <ul>
                        <li><strong><?php _e('Photo :', 'fiche-formateur'); ?></strong> <?php _e('Sélectionnez une photo depuis la médiathèque', 'fiche-formateur'); ?></li>
                        <li><strong><?php _e('Badge :', 'fiche-formateur'); ?></strong> <?php _e('Ex: "Fondateur Insuffle Académie"', 'fiche-formateur'); ?></li>
                        <li><strong><?php _e('Nom :', 'fiche-formateur'); ?></strong> <?php _e('Le nom du formateur', 'fiche-formateur'); ?></li>
                        <li><strong><?php _e('Tagline :', 'fiche-formateur'); ?></strong> <?php _e('Ex: "Expert en Transformation Collective"', 'fiche-formateur'); ?></li>
                        <li><strong><?php _e('Description :', 'fiche-formateur'); ?></strong> <?php _e('Biographie et expertise (HTML autorisé)', 'fiche-formateur'); ?></li>
                        <li><strong><?php _e('Chiffres clés :', 'fiche-formateur'); ?></strong> <?php _e('Ajoutez autant de statistiques que vous voulez', 'fiche-formateur'); ?></li>
                        <li><strong><?php _e('Citation :', 'fiche-formateur'); ?></strong> <?php _e('Une devise ou citation du formateur', 'fiche-formateur'); ?></li>
                    </ul>

                    <h3><?php _e('Étape 3 : Ajouter le shortcode', 'fiche-formateur'); ?></h3>
                    <p><?php _e('Insérez le shortcode dans le contenu de votre page :', 'fiche-formateur'); ?></p>
                    <pre><code>[fiche_formateur]</code></pre>
                </div>

                <div class="ffm-section">
                    <h2><?php _e('📝 Shortcode disponible', 'fiche-formateur'); ?></h2>

                    <h3><code>[fiche_formateur]</code></h3>
                    <p><?php _e('Affiche la fiche du formateur de la page actuelle.', 'fiche-formateur'); ?></p>

                    <h4><?php _e('Paramètres :', 'fiche-formateur'); ?></h4>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th><?php _e('Paramètre', 'fiche-formateur'); ?></th>
                                <th><?php _e('Description', 'fiche-formateur'); ?></th>
                                <th><?php _e('Défaut', 'fiche-formateur'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>post_id</code></td>
                                <td><?php _e('ID de la page/article contenant les infos du formateur', 'fiche-formateur'); ?></td>
                                <td><?php _e('Page actuelle', 'fiche-formateur'); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <h4><?php _e('Exemples :', 'fiche-formateur'); ?></h4>
                    <pre><code>[fiche_formateur]</code></pre>
                    <p><?php _e('Affiche la fiche de la page actuelle.', 'fiche-formateur'); ?></p>

                    <pre><code>[fiche_formateur post_id="123"]</code></pre>
                    <p><?php _e('Affiche la fiche de la page ID 123.', 'fiche-formateur'); ?></p>
                </div>

                <div class="ffm-section">
                    <h2><?php _e('🎨 Classes CSS disponibles', 'fiche-formateur'); ?></h2>
                    <p><?php _e('Toutes les classes CSS sont préfixées "ffm-" pour éviter les conflits :', 'fiche-formateur'); ?></p>
                    <ul>
                        <li><code>.ffm-fiche-container</code> - <?php _e('Container principal', 'fiche-formateur'); ?></li>
                        <li><code>.ffm-header-section</code> - <?php _e('Section header', 'fiche-formateur'); ?></li>
                        <li><code>.ffm-photo-frame</code> - <?php _e('Cadre de la photo', 'fiche-formateur'); ?></li>
                        <li><code>.ffm-badge</code> - <?php _e('Badge/Titre', 'fiche-formateur'); ?></li>
                        <li><code>.ffm-nom</code> - <?php _e('Nom du formateur', 'fiche-formateur'); ?></li>
                        <li><code>.ffm-tagline</code> - <?php _e('Tagline/Sous-titre', 'fiche-formateur'); ?></li>
                        <li><code>.ffm-stats-section</code> - <?php _e('Section statistiques', 'fiche-formateur'); ?></li>
                        <li><code>.ffm-stat-number</code> - <?php _e('Chiffre de la stat', 'fiche-formateur'); ?></li>
                        <li><code>.ffm-quote-section</code> - <?php _e('Section citation', 'fiche-formateur'); ?></li>
                    </ul>
                </div>

                <div class="ffm-section">
                    <h2><?php _e('💡 Conseils', 'fiche-formateur'); ?></h2>
                    <ul>
                        <li><?php _e('Utilisez une photo carrée pour un meilleur rendu circulaire', 'fiche-formateur'); ?></li>
                        <li><?php _e('Les chiffres clés peuvent contenir du texte : "15+", "200+", etc.', 'fiche-formateur'); ?></li>
                        <li><?php _e('Réorganisez les statistiques par glisser-déposer', 'fiche-formateur'); ?></li>
                        <li><?php _e('Tous les champs sont optionnels - adaptez selon vos besoins', 'fiche-formateur'); ?></li>
                        <li><?php _e('Le design est identique au template HTML de référence', 'fiche-formateur'); ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <?php
    }
}
