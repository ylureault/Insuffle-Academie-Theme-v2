<?php
/**
 * Gestion du shortcode pour afficher le programme
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
            return '<div class="pfm-notice">' . __('Aucun module défini pour cette formation.', 'programme-formation') . '</div>';
        }

        // Générer le HTML
        ob_start();
        $this->render_modules($modules);
        return ob_get_clean();
    }

    /**
     * Affiche les modules
     */
    private function render_modules($modules) {
        ?>
        <div class="pfm-programme-container">
            <?php foreach ($modules as $index => $module): ?>
                <article class="pfm-module">
                    <div class="pfm-module-header">
                        <?php if (!empty($module['number'])): ?>
                            <div class="pfm-module-number"><?php echo esc_html($module['number']); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($module['title'])): ?>
                            <div class="pfm-module-title">
                                <h3><?php echo esc_html($module['title']); ?></h3>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($module['content'])): ?>
                        <div class="pfm-module-content">
                            <?php echo wpautop($module['content']); ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
