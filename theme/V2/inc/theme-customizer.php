<?php
/**
 * Personnalisateur de thème - Options CTA Formations
 *
 * Permet de configurer le Call-to-Action générique affiché en bas
 * de toutes les pages de formations
 */

if (!defined('ABSPATH')) exit;

/**
 * Ajouter les options au Customizer
 */
function insuffle_customize_register($wp_customize) {

    // ========================================
    // SECTION : CTA FORMATIONS
    // ========================================

    $wp_customize->add_section('insuffle_formation_cta', array(
        'title'       => 'CTA Formations',
        'description' => 'Configurez le Call-to-Action affiché en bas de toutes les pages de formations',
        'priority'    => 30,
    ));

    // ----------------
    // Activer/Désactiver le CTA
    // ----------------

    $wp_customize->add_setting('insuffle_formation_cta_enable', array(
        'default'           => true,
        'sanitize_callback' => 'insuffle_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('insuffle_formation_cta_enable', array(
        'label'    => 'Afficher le CTA sur les formations',
        'section'  => 'insuffle_formation_cta',
        'type'     => 'checkbox',
        'priority' => 10,
    ));

    // ----------------
    // Titre du CTA
    // ----------------

    $wp_customize->add_setting('insuffle_formation_cta_title', array(
        'default'           => 'Prêt à transformer votre pratique professionnelle ?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('insuffle_formation_cta_title', array(
        'label'       => 'Titre du CTA',
        'description' => 'Le titre principal affiché en grand',
        'section'     => 'insuffle_formation_cta',
        'type'        => 'text',
        'priority'    => 20,
    ));

    // ----------------
    // Sous-titre / Description
    // ----------------

    $wp_customize->add_setting('insuffle_formation_cta_subtitle', array(
        'default'           => 'Contactez notre équipe pour en savoir plus sur nos formations et obtenir un devis personnalisé',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('insuffle_formation_cta_subtitle', array(
        'label'       => 'Sous-titre / Description',
        'description' => 'Texte de description sous le titre',
        'section'     => 'insuffle_formation_cta',
        'type'        => 'textarea',
        'priority'    => 30,
    ));

    // ----------------
    // Bouton Principal
    // ----------------

    $wp_customize->add_setting('insuffle_formation_cta_button1_text', array(
        'default'           => 'Demander un devis',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('insuffle_formation_cta_button1_text', array(
        'label'       => 'Bouton 1 - Texte',
        'description' => 'Texte du bouton principal (jaune)',
        'section'     => 'insuffle_formation_cta',
        'type'        => 'text',
        'priority'    => 40,
    ));

    $wp_customize->add_setting('insuffle_formation_cta_button1_url', array(
        'default'           => '/#contact',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('insuffle_formation_cta_button1_url', array(
        'label'       => 'Bouton 1 - Lien',
        'description' => 'URL du bouton principal (ex: /#contact ou /contact/)',
        'section'     => 'insuffle_formation_cta',
        'type'        => 'url',
        'priority'    => 50,
    ));

    // ----------------
    // Bouton Secondaire
    // ----------------

    $wp_customize->add_setting('insuffle_formation_cta_button2_enable', array(
        'default'           => true,
        'sanitize_callback' => 'insuffle_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('insuffle_formation_cta_button2_enable', array(
        'label'    => 'Afficher le bouton 2',
        'section'  => 'insuffle_formation_cta',
        'type'     => 'checkbox',
        'priority' => 60,
    ));

    $wp_customize->add_setting('insuffle_formation_cta_button2_text', array(
        'default'           => 'Nous appeler',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('insuffle_formation_cta_button2_text', array(
        'label'       => 'Bouton 2 - Texte',
        'description' => 'Texte du bouton secondaire (bordure blanche)',
        'section'     => 'insuffle_formation_cta',
        'type'        => 'text',
        'priority'    => 70,
    ));

    $wp_customize->add_setting('insuffle_formation_cta_button2_url', array(
        'default'           => 'tel:+33980808962',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('insuffle_formation_cta_button2_url', array(
        'label'       => 'Bouton 2 - Lien',
        'description' => 'URL du bouton secondaire (ex: tel:+33123456789 ou mailto:contact@email.com)',
        'section'     => 'insuffle_formation_cta',
        'type'        => 'url',
        'priority'    => 80,
    ));

    // ----------------
    // Informations supplémentaires
    // ----------------

    $wp_customize->add_setting('insuffle_formation_cta_info', array(
        'default'           => '✅ Certification Qualiopi • 💰 Financement OPCO • 📞 Réponse sous 24h',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('insuffle_formation_cta_info', array(
        'label'       => 'Informations complémentaires',
        'description' => 'Petite ligne d\'info sous les boutons (optionnel)',
        'section'     => 'insuffle_formation_cta',
        'type'        => 'text',
        'priority'    => 90,
    ));

    // ----------------
    // Style du CTA
    // ----------------

    $wp_customize->add_setting('insuffle_formation_cta_style', array(
        'default'           => 'violet',
        'sanitize_callback' => 'insuffle_sanitize_cta_style',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('insuffle_formation_cta_style', array(
        'label'       => 'Style du CTA',
        'description' => 'Couleur de fond du CTA',
        'section'     => 'insuffle_formation_cta',
        'type'        => 'select',
        'choices'     => array(
            'violet'    => 'Violet (par défaut)',
            'gradient'  => 'Dégradé violet-rose',
            'white'     => 'Blanc',
        ),
        'priority'    => 100,
    ));
}
add_action('customize_register', 'insuffle_customize_register');

/**
 * Fonction de sanitization pour les checkboxes
 */
function insuffle_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Fonction de sanitization pour le style du CTA
 */
function insuffle_sanitize_cta_style($style) {
    $valid_styles = array('violet', 'gradient', 'white');
    if (in_array($style, $valid_styles)) {
        return $style;
    }
    return 'violet';
}

/**
 * Afficher le CTA Formations
 *
 * Cette fonction génère le HTML du CTA basé sur les paramètres du Customizer
 */
function insuffle_display_formation_cta() {
    // Vérifier si le CTA est activé
    if (!get_theme_mod('insuffle_formation_cta_enable', true)) {
        return;
    }

    // Récupérer les paramètres
    $title = get_theme_mod('insuffle_formation_cta_title', 'Prêt à transformer votre pratique professionnelle ?');
    $subtitle = get_theme_mod('insuffle_formation_cta_subtitle', 'Contactez notre équipe pour en savoir plus sur nos formations et obtenir un devis personnalisé');
    $button1_text = get_theme_mod('insuffle_formation_cta_button1_text', 'Demander un devis');
    $button1_url = get_theme_mod('insuffle_formation_cta_button1_url', '/#contact');
    $button2_enable = get_theme_mod('insuffle_formation_cta_button2_enable', true);
    $button2_text = get_theme_mod('insuffle_formation_cta_button2_text', 'Nous appeler');
    $button2_url = get_theme_mod('insuffle_formation_cta_button2_url', 'tel:+33980808962');
    $info = get_theme_mod('insuffle_formation_cta_info', '✅ Certification Qualiopi • 💰 Financement OPCO • 📞 Réponse sous 24h');
    $style = get_theme_mod('insuffle_formation_cta_style', 'violet');

    // Déterminer la classe de style
    $style_class = 'formation-cta-' . $style;

    ?>
    <section class="formation-cta <?php echo esc_attr($style_class); ?>">
        <div class="container">
            <div class="formation-cta-content">

                <?php if ($title) : ?>
                    <h2 class="formation-cta-title">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <p class="formation-cta-subtitle">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <div class="formation-cta-buttons">
                    <?php if ($button1_text && $button1_url) : ?>
                        <a href="<?php echo esc_url($button1_url); ?>" class="formation-cta-btn formation-cta-btn-primary">
                            <?php echo esc_html($button1_text); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($button2_enable && $button2_text && $button2_url) : ?>
                        <a href="<?php echo esc_url($button2_url); ?>" class="formation-cta-btn formation-cta-btn-secondary">
                            <?php echo esc_html($button2_text); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if ($info) : ?>
                    <p class="formation-cta-info">
                        <?php echo esc_html($info); ?>
                    </p>
                <?php endif; ?>

            </div>
        </div>
    </section>
    <?php
}

/**
 * Support pour l'aperçu en direct dans le Customizer
 */
function insuffle_customizer_live_preview() {
    wp_enqueue_script(
        'insuffle-customizer',
        get_template_directory_uri() . '/js/customizer.js',
        array('jquery', 'customize-preview'),
        INSUFFLE_VERSION,
        true
    );
}
add_action('customize_preview_init', 'insuffle_customizer_live_preview');
