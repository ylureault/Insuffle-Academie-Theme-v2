<?php
/**
 * Gestion du shortcode pour afficher les formateurs
 */

if (!defined('ABSPATH')) {
    exit;
}

class Formateur_Shortcode {

    /**
     * Instance unique (Singleton)
     */
    private static $instance = null;

    /**
     * Retourne l'instance unique
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur
     */
    private function __construct() {
        add_shortcode('formateur', array($this, 'render_shortcode'));
        add_shortcode('formateurs', array($this, 'render_shortcode_multiple'));
    }

    /**
     * Rendu du shortcode pour un seul formateur
     *
     * Usage:
     * [formateur] - Affiche Yoan Lureault par défaut
     * [formateur id="123"] - Affiche un formateur spécifique
     * [formateur nom="Yoan Lureault"] - Affiche un formateur par son nom
     */
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => '',
            'nom' => 'Yoan Lureault', // Par défaut Yoan Lureault
        ), $atts);

        // Récupérer le formateur
        if (!empty($atts['id'])) {
            $formateur = get_post($atts['id']);
        } else {
            // Rechercher par nom
            $formateurs = get_posts(array(
                'post_type' => 'formateur',
                'title' => $atts['nom'],
                'posts_per_page' => 1,
                'post_status' => 'publish'
            ));

            $formateur = !empty($formateurs) ? $formateurs[0] : null;
        }

        if (!$formateur) {
            return '<p class="formateur-error">' . __('Formateur non trouvé.', 'plugin-formateur') . '</p>';
        }

        return $this->render_formateur_card($formateur);
    }

    /**
     * Rendu du shortcode pour plusieurs formateurs
     *
     * Usage:
     * [formateurs] - Affiche tous les formateurs
     * [formateurs nombre="3"] - Affiche 3 formateurs
     * [formateurs ids="1,2,3"] - Affiche des formateurs spécifiques
     */
    public function render_shortcode_multiple($atts) {
        $atts = shortcode_atts(array(
            'nombre' => -1,
            'ids' => '',
            'ordre' => 'ASC'
        ), $atts);

        $args = array(
            'post_type' => 'formateur',
            'posts_per_page' => intval($atts['nombre']),
            'post_status' => 'publish',
            'meta_key' => '_formateur_ordre',
            'orderby' => 'meta_value_num',
            'order' => $atts['ordre']
        );

        // Si des IDs spécifiques sont fournis
        if (!empty($atts['ids'])) {
            $ids = array_map('intval', explode(',', $atts['ids']));
            $args['post__in'] = $ids;
        }

        $formateurs = get_posts($args);

        if (empty($formateurs)) {
            return '<p class="formateur-error">' . __('Aucun formateur trouvé.', 'plugin-formateur') . '</p>';
        }

        ob_start();
        echo '<div class="formateurs-liste">';
        foreach ($formateurs as $formateur) {
            echo $this->render_formateur_card($formateur);
        }
        echo '</div>';
        return ob_get_clean();
    }

    /**
     * Rendu d'une carte formateur (basé sur le design du HTML)
     */
    private function render_formateur_card($formateur) {
        // Récupérer les meta données
        $titre = get_post_meta($formateur->ID, '_formateur_titre', true);
        $citation = get_post_meta($formateur->ID, '_formateur_citation', true);
        $specialites = get_post_meta($formateur->ID, '_formateur_specialites', true);
        $certifications = get_post_meta($formateur->ID, '_formateur_certifications', true);
        $experience = get_post_meta($formateur->ID, '_formateur_experience', true);
        $email = get_post_meta($formateur->ID, '_formateur_email', true);
        $telephone = get_post_meta($formateur->ID, '_formateur_telephone', true);
        $linkedin = get_post_meta($formateur->ID, '_formateur_linkedin', true);
        $twitter = get_post_meta($formateur->ID, '_formateur_twitter', true);
        $site_web = get_post_meta($formateur->ID, '_formateur_site_web', true);

        // Paramètres d'affichage
        $afficher_citation = get_post_meta($formateur->ID, '_formateur_afficher_citation', true);
        $afficher_specialites = get_post_meta($formateur->ID, '_formateur_afficher_specialites', true);
        $afficher_contact = get_post_meta($formateur->ID, '_formateur_afficher_contact', true);

        // Valeurs par défaut
        $afficher_citation = $afficher_citation !== '' ? $afficher_citation : '1';
        $afficher_specialites = $afficher_specialites !== '' ? $afficher_specialites : '1';
        $afficher_contact = $afficher_contact !== '' ? $afficher_contact : '1';

        // Biographie
        $biographie = get_the_content(null, false, $formateur);
        $biographie = apply_filters('the_content', $biographie);

        ob_start();
        ?>
        <section id="formateur-<?php echo esc_attr($formateur->ID); ?>" class="formateur-section">
            <div class="formateur-container">
                <div class="formateur-subtitle"><?php _e('L\'équipe pédagogique', 'plugin-formateur'); ?></div>
                <h2 class="formateur-section-title"><?php _e('Votre formateur', 'plugin-formateur'); ?></h2>

                <div class="formateur-highlight-box">
                    <?php if (has_post_thumbnail($formateur->ID)) : ?>
                        <div class="formateur-photo">
                            <?php echo get_the_post_thumbnail($formateur->ID, 'medium', array('class' => 'formateur-photo-img')); ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="formateur-nom"><?php echo esc_html($formateur->post_title); ?></h3>

                    <?php if ($titre) : ?>
                        <p class="formateur-titre"><strong><?php echo esc_html($titre); ?></strong></p>
                    <?php endif; ?>

                    <?php if ($afficher_citation == '1' && $citation) : ?>
                        <div class="formateur-quote-block">
                            "<?php echo esc_html($citation); ?>"
                        </div>
                    <?php endif; ?>

                    <?php if ($biographie) : ?>
                        <div class="formateur-biographie">
                            <?php echo $biographie; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($experience) : ?>
                        <div class="formateur-experience">
                            <strong><?php echo esc_html($experience); ?></strong> <?php _e('années d\'expérience', 'plugin-formateur'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($afficher_specialites == '1' && $specialites) : ?>
                        <div class="formateur-specialites">
                            <h4><?php _e('Spécialités', 'plugin-formateur'); ?></h4>
                            <ul>
                                <?php
                                $specialites_array = explode("\n", $specialites);
                                foreach ($specialites_array as $specialite) {
                                    $specialite = trim($specialite);
                                    if (!empty($specialite)) {
                                        echo '<li>' . esc_html($specialite) . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($certifications) : ?>
                        <div class="formateur-certifications">
                            <h4><?php _e('Certifications', 'plugin-formateur'); ?></h4>
                            <ul>
                                <?php
                                $certifications_array = explode("\n", $certifications);
                                foreach ($certifications_array as $certification) {
                                    $certification = trim($certification);
                                    if (!empty($certification)) {
                                        echo '<li>' . esc_html($certification) . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($afficher_contact == '1' && ($email || $telephone || $linkedin || $twitter || $site_web)) : ?>
                        <div class="formateur-contact">
                            <h4><?php _e('Contact', 'plugin-formateur'); ?></h4>
                            <div class="formateur-contact-links">
                                <?php if ($email) : ?>
                                    <a href="mailto:<?php echo esc_attr($email); ?>" class="formateur-contact-link">
                                        <span class="dashicons dashicons-email"></span>
                                        <?php echo esc_html($email); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($telephone) : ?>
                                    <a href="tel:<?php echo esc_attr($telephone); ?>" class="formateur-contact-link">
                                        <span class="dashicons dashicons-phone"></span>
                                        <?php echo esc_html($telephone); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($linkedin) : ?>
                                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" class="formateur-contact-link">
                                        <span class="dashicons dashicons-linkedin"></span>
                                        LinkedIn
                                    </a>
                                <?php endif; ?>

                                <?php if ($twitter) : ?>
                                    <a href="<?php echo esc_url($twitter); ?>" target="_blank" class="formateur-contact-link">
                                        <span class="dashicons dashicons-twitter"></span>
                                        Twitter/X
                                    </a>
                                <?php endif; ?>

                                <?php if ($site_web) : ?>
                                    <a href="<?php echo esc_url($site_web); ?>" target="_blank" class="formateur-contact-link">
                                        <span class="dashicons dashicons-admin-site"></span>
                                        Site web
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }
}

/**
 * Fonctions helper
 */

/**
 * Affiche un formateur
 */
function afficher_formateur($nom = 'Yoan Lureault') {
    echo do_shortcode('[formateur nom="' . esc_attr($nom) . '"]');
}

/**
 * Affiche tous les formateurs
 */
function afficher_formateurs($nombre = -1) {
    echo do_shortcode('[formateurs nombre="' . intval($nombre) . '"]');
}
