<?php
/**
 * Gestion du shortcode pour afficher le programme
 * Design basé sur programme-sketchnote.html
 */

if (!defined('ABSPATH')) {
    exit;
}

class PFM_Shortcode {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_shortcode('programme_formation', array($this, 'render_shortcode'));
    }

    /**
     * Rendu du shortcode
     */
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'post_id' => get_the_ID(),
        ), $atts, 'programme_formation');

        $post_id = intval($atts['post_id']);

        // Récupérer les modules
        $modules = PFM_Modules_Manager::get_modules($post_id);

        if (empty($modules)) {
            return '';
        }

        // Récupérer les infos pratiques
        $infos = PFM_Modules_Manager::get_infos_pratiques($post_id);

        // Générer le HTML
        ob_start();
        ?>

        <div class="pfm-programme-wrapper">
            <div class="pfm-fil-conducteur"></div>

            <div class="pfm-module-container">
                <?php foreach ($modules as $index => $module): ?>
                    <?php $this->render_module($module, $index); ?>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!empty($infos['methodes']) || !empty($infos['moyens']) || !empty($infos['evaluation'])): ?>
            <div class="pfm-infos-pratiques">
                <div class="pfm-infos-grid">
                    <?php if (!empty($infos['methodes'])): ?>
                        <div class="pfm-info-card">
                            <h3>
                                <span class="pfm-info-icon">🎯</span>
                                <span><?php _e('Méthodes pédagogiques', 'programme-formation'); ?></span>
                            </h3>
                            <div class="pfm-info-content">
                                <?php echo wpautop(wp_kses_post($infos['methodes'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($infos['moyens'])): ?>
                        <div class="pfm-info-card">
                            <h3>
                                <span class="pfm-info-icon">🛠️</span>
                                <span><?php _e('Moyens techniques', 'programme-formation'); ?></span>
                            </h3>
                            <div class="pfm-info-content">
                                <?php echo wp_kses_post($infos['moyens']); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($infos['evaluation'])): ?>
                        <div class="pfm-info-card">
                            <h3>
                                <span class="pfm-info-icon">✅</span>
                                <span><?php _e('Modalités d\'évaluation', 'programme-formation'); ?></span>
                            </h3>
                            <div class="pfm-info-content">
                                <?php echo wpautop(wp_kses_post($infos['evaluation'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php
        return ob_get_clean();
    }

    /**
     * Affiche un module
     */
    private function render_module($module, $index) {
        ?>
        <div class="pfm-module-item">
            <div class="pfm-module-card">
                <?php if (!empty($module['duree'])): ?>
                    <div class="pfm-duration-badge">
                        <span>⏱️</span>
                        <span><?php echo esc_html($module['duree']); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($module['title'])): ?>
                    <h2 class="pfm-module-title"><?php echo esc_html($module['title']); ?></h2>
                <?php endif; ?>

                <?php if (!empty($module['objectif'])): ?>
                    <div class="pfm-objectif-box">
                        <div class="pfm-objectif-label">
                            <span>🎯</span>
                            <span><?php _e('Objectif', 'programme-formation'); ?></span>
                        </div>
                        <p><?php echo wp_kses_post($module['objectif']); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($module['content'])): ?>
                    <div class="pfm-contenu-section">
                        <div class="pfm-contenu-title">
                            <span>📚</span>
                            <span><?php _e('Contenu', 'programme-formation'); ?></span>
                        </div>
                        <ul class="pfm-contenu-liste">
                            <?php
                            $lines = explode("\n", trim($module['content']));
                            foreach ($lines as $line) {
                                $line = trim($line);
                                if (!empty($line)) {
                                    echo '<li>' . esc_html($line) . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($module['evaluation'])): ?>
                    <div class="pfm-eval-badge">
                        <span>📋</span>
                        <span><?php echo esc_html($module['evaluation']); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="pfm-module-dot">
                <?php echo esc_html($module['number'] ?? ($index + 1)); ?>
            </div>

            <div class="pfm-module-empty"></div>
        </div>
        <?php
    }
}
