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

        // Récupérer les objectifs pédagogiques
        $objectifs = get_post_meta($post_id, '_pfm_objectifs', true);
        if (empty($objectifs) || !is_array($objectifs)) {
            $objectifs = array(
                'introduction' => '',
                'objectifs' => '',
                'preambule_titre' => '',
                'preambule_contenu' => '',
            );
        }

        // Récupérer les informations pratiques
        $informations = get_post_meta($post_id, '_pfm_informations', true);
        if (empty($informations) || !is_array($informations)) {
            $informations = array('tableau' => array(), 'moyens_techniques' => '', 'encadrement' => '', 'suivi_post' => '');
        }

        // Récupérer les bénéfices
        $benefices = get_post_meta($post_id, '_pfm_benefices', true);
        if (empty($benefices) || !is_array($benefices)) {
            $benefices = array();
        }

        // Récupérer les tarifs
        $tarifs = get_post_meta($post_id, '_pfm_tarifs', true);
        if (empty($tarifs) || !is_array($tarifs)) {
            $tarifs = array('intra' => '', 'inter' => '', 'notes' => '');
        }

        // Générer le HTML
        ob_start();
        ?>

        <?php if (!empty($objectifs['objectifs'])): ?>
            <section class="pfm-objectifs-section">
                <div class="pfm-container">
                    <div class="pfm-section-subtitle">Compétences développées</div>
                    <h2 class="pfm-section-title">Objectifs pédagogiques de la formation</h2>

                    <?php if (!empty($objectifs['introduction'])): ?>
                        <p class="pfm-section-description"><?php echo wp_kses_post($objectifs['introduction']); ?></p>
                    <?php endif; ?>

                    <ul class="pfm-objectives-list">
                        <?php
                        $objectifs_lines = array_filter(array_map('trim', explode("\n", $objectifs['objectifs'])));
                        foreach ($objectifs_lines as $objectif):
                            // Convertir **texte** en <strong>texte</strong>
                            $objectif = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $objectif);
                        ?>
                            <li><?php echo wp_kses_post($objectif); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($objectifs['preambule_titre']) || !empty($objectifs['preambule_contenu'])): ?>
            <section class="pfm-preambule-section">
                <div class="pfm-container">
                    <div class="pfm-section-subtitle">Contenu de la formation</div>
                    <h2 class="pfm-section-title">Programme détaillé de la formation</h2>

                    <div class="pfm-highlight-box">
                        <?php if (!empty($objectifs['preambule_titre'])): ?>
                            <h3><?php echo esc_html($objectifs['preambule_titre']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($objectifs['preambule_contenu'])): ?>
                            <ul>
                                <?php
                                $preambule_lines = array_filter(array_map('trim', explode("\n", $objectifs['preambule_contenu'])));
                                foreach ($preambule_lines as $ligne):
                                ?>
                                    <li><?php echo esc_html($ligne); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

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

        <?php if (!empty($informations['tableau']) || !empty($informations['moyens_techniques']) || !empty($informations['encadrement']) || !empty($informations['suivi_post'])): ?>
            <section class="pfm-informations-section" id="pratique">
                <div class="pfm-container">
                    <div class="pfm-section-subtitle">Informations</div>
                    <h2 class="pfm-section-title">Informations pratiques</h2>

                    <?php if (!empty($informations['tableau'])): ?>
                        <table class="pfm-table">
                            <thead>
                                <tr>
                                    <th>Élément</th>
                                    <th>Détail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($informations['tableau'] as $row): ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($row['element']); ?></strong></td>
                                        <td><?php echo esc_html($row['detail']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <?php if (!empty($informations['moyens_techniques']) || !empty($informations['encadrement'])): ?>
                        <h3 style="margin-top: 50px; color: #8E2183; font-size: 1.8rem;">Moyens techniques et d'encadrement</h3>

                        <div class="pfm-cards-grid">
                            <?php if (!empty($informations['moyens_techniques'])): ?>
                                <div class="pfm-card">
                                    <h3>🏢 Moyens techniques</h3>
                                    <ul>
                                        <?php
                                        $moyens_lines = array_filter(array_map('trim', explode("\n", $informations['moyens_techniques'])));
                                        foreach ($moyens_lines as $ligne):
                                        ?>
                                            <li><?php echo esc_html($ligne); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($informations['encadrement'])): ?>
                                <div class="pfm-card">
                                    <h3>👨‍🏫 Encadrement</h3>
                                    <ul>
                                        <?php
                                        $encadrement_lines = array_filter(array_map('trim', explode("\n", $informations['encadrement'])));
                                        foreach ($encadrement_lines as $ligne):
                                        ?>
                                            <li><?php echo esc_html($ligne); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($informations['suivi_post'])): ?>
                        <h3 style="margin-top: 40px; color: #8E2183; font-size: 1.6rem;">Suivi post-formation</h3>
                        <ul style="font-size: 1.1rem; line-height: 2; max-width: 800px; margin: 30px auto;">
                            <?php
                            $suivi_lines = array_filter(array_map('trim', explode("\n", $informations['suivi_post'])));
                            foreach ($suivi_lines as $ligne):
                            ?>
                                <li><?php echo esc_html($ligne); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($benefices)): ?>
            <section class="pfm-benefices-section" id="resultats">
                <div class="pfm-container">
                    <div class="pfm-section-subtitle">Bénéfices</div>
                    <h2 class="pfm-section-title">Ce que vous allez développer</h2>

                    <div class="pfm-cards-grid">
                        <?php foreach ($benefices as $benefice): ?>
                            <div class="pfm-card">
                                <h3><?php echo esc_html($benefice['icone']); ?> <?php echo esc_html($benefice['titre']); ?></h3>
                                <p><?php echo wp_kses_post($benefice['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($tarifs['intra']) || !empty($tarifs['inter']) || !empty($tarifs['notes'])): ?>
            <section class="pfm-tarifs-section">
                <div class="pfm-container">
                    <div class="pfm-section-subtitle">Tarifs</div>
                    <h2 class="pfm-section-title">Tarifs de la formation</h2>

                    <div class="pfm-highlight-box">
                        <?php if (!empty($tarifs['intra'])): ?>
                            <p><strong>Tarif Intra-entreprise :</strong> <?php echo esc_html($tarifs['intra']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($tarifs['inter'])): ?>
                            <p><strong>Tarif Inter-entreprises :</strong> <?php echo esc_html($tarifs['inter']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($tarifs['notes'])): ?>
                            <div style="margin-top: 20px;">
                                <?php echo wpautop(wp_kses_post($tarifs['notes'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
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
