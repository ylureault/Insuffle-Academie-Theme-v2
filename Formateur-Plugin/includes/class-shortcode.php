<?php
/**
 * Gestion du shortcode [fiche_formateur]
 */

// Sécurité
if (!defined('ABSPATH')) {
    exit;
}

class FFM_Shortcode {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_shortcode('fiche_formateur', array($this, 'render_shortcode'));
    }

    /**
     * Affiche la fiche formateur
     */
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'post_id' => get_the_ID(),
        ), $atts, 'fiche_formateur');

        $post_id = intval($atts['post_id']);

        // Récupérer les données pour le post_id actuel
        $data = FFM_Formateur_Manager::get_formateur_data($post_id);

        // Si pas de données sur la page actuelle, chercher un formateur avec des données
        if (empty($data['nom']) && empty($data['photo_id']) && empty($data['stats'])) {
            $formateurs = FFM_Formateurs_Scanner::get_formateurs();

            foreach ($formateurs as $formateur) {
                $formateur_data = FFM_Formateur_Manager::get_formateur_data($formateur->ID);

                // Si on trouve un formateur avec des données, l'utiliser
                if (!empty($formateur_data['nom']) || !empty($formateur_data['photo_id']) || !empty($formateur_data['stats'])) {
                    $post_id = $formateur->ID;
                    $data = $formateur_data;
                    break;
                }
            }
        }

        // Démarrer la sortie
        ob_start();
        ?>

        <div class="ffm-fiche-container">

            <!-- Header avec photo -->
            <div class="ffm-header-section">
                <?php if (!empty($data['photo_id'])): ?>
                    <div class="ffm-photo-container">
                        <div class="ffm-photo-frame">
                            <?php echo wp_get_attachment_image($data['photo_id'], 'medium', false, array('alt' => esc_attr($data['nom']))); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="ffm-header-content">
                    <?php if (!empty($data['badge'])): ?>
                        <div class="ffm-badge"><?php echo esc_html($data['badge']); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($data['nom'])): ?>
                        <h1 class="ffm-nom"><?php echo esc_html($data['nom']); ?></h1>
                    <?php endif; ?>

                    <?php if (!empty($data['tagline'])): ?>
                        <div class="ffm-tagline"><?php echo esc_html($data['tagline']); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($data['description'])): ?>
                        <div class="ffm-description"><?php echo wp_kses_post($data['description']); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Chiffres clés -->
            <?php if (!empty($data['stats'])): ?>
                <div class="ffm-stats-section">
                    <div class="ffm-stats-grid">
                        <?php foreach ($data['stats'] as $stat): ?>
                            <?php if (!empty($stat['number']) || !empty($stat['label'])): ?>
                                <div class="ffm-stat-item">
                                    <?php if (!empty($stat['number'])): ?>
                                        <span class="ffm-stat-number"><?php echo esc_html($stat['number']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($stat['label'])): ?>
                                        <div class="ffm-stat-label"><?php echo esc_html($stat['label']); ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Citation -->
            <?php if (!empty($data['citation_texte'])): ?>
                <div class="ffm-quote-section">
                    <div class="ffm-quote-box">
                        <div class="ffm-quote-icon">"</div>
                        <p class="ffm-quote-text"><?php echo wp_kses_post($data['citation_texte']); ?></p>
                        <?php if (!empty($data['citation_auteur'])): ?>
                            <p class="ffm-quote-author">— <?php echo esc_html($data['citation_auteur']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <?php
        return ob_get_clean();
    }
}
