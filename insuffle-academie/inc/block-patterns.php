<?php
/**
 * Block Patterns (Compositions)
 *
 * Enregistrement des compositions Gutenberg prêtes à l'emploi
 */

function insuffle_register_block_patterns() {

    // Catégorie personnalisée pour les patterns
    register_block_pattern_category('insuffle', array(
        'label' => 'Insuffle Académie'
    ));

    // Pattern: Hero avec gradient
    register_block_pattern('insuffle/hero-gradient', array(
        'title' => 'Hero avec Gradient',
        'description' => 'Section hero avec fond dégradé violet',
        'categories' => array('insuffle'),
        'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"100px","bottom":"100px"}}},"backgroundColor":"white","className":"hero-gradient"} -->
<div class="wp-block-group alignfull hero-gradient has-white-background-color has-background" style="padding-top:100px;padding-bottom:100px">
    <!-- wp:group {"layout":{"type":"constrained","contentSize":"1200px"}} -->
    <div class="wp-block-group">
        <!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"3.5rem"}}} -->
        <h1 class="has-text-align-center" style="font-size:3.5rem">Titre Accrocheur</h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.3rem"}}} -->
        <p class="has-text-align-center" style="font-size:1.3rem">Un sous-titre captivant qui explique votre proposition de valeur</p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"40px"}}}} -->
        <div class="wp-block-buttons" style="margin-top:40px">
            <!-- wp:button {"backgroundColor":"primary","className":"is-style-fill"} -->
            <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button">Découvrir nos formations</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->

<style>
.hero-gradient {
    background: linear-gradient(135deg, #8E2183 0%, #FF6B9D 100%) !important;
    color: white !important;
}
.hero-gradient h1,
.hero-gradient p {
    color: white !important;
}
</style>'
    ));

    // Pattern: Section Fonctionnalités 3 colonnes
    register_block_pattern('insuffle/features-3-columns', array(
        'title' => 'Fonctionnalités 3 Colonnes',
        'description' => 'Grille de 3 fonctionnalités avec icônes',
        'categories' => array('insuffle'),
        'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"backgroundColor":"white"} -->
<div class="wp-block-group alignfull has-white-background-color has-background" style="padding-top:80px;padding-bottom:80px">
    <!-- wp:group {"layout":{"type":"constrained","contentSize":"1200px"}} -->
    <div class="wp-block-group">
        <!-- wp:heading {"textAlign":"center"} -->
        <h2 class="has-text-align-center">Nos Atouts</h2>
        <!-- /wp:heading -->

        <!-- wp:columns {"style":{"spacing":{"margin":{"top":"60px"}}}} -->
        <div class="wp-block-columns" style="margin-top:60px">
            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"radius":"15px"}},"backgroundColor":"white","className":"feature-card"} -->
                <div class="wp-block-group feature-card has-white-background-color has-background" style="border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px">
                    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
                    <p class="has-text-align-center" style="font-size:3rem">🎯</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Expertise</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Des formateurs certifiés avec une expérience terrain</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"radius":"15px"}},"backgroundColor":"white","className":"feature-card"} -->
                <div class="wp-block-group feature-card has-white-background-color has-background" style="border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px">
                    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
                    <p class="has-text-align-center" style="font-size:3rem">⚡</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Rapidité</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Des formations intensives pour des résultats immédiats</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"radius":"15px"}},"backgroundColor":"white","className":"feature-card"} -->
                <div class="wp-block-group feature-card has-white-background-color has-background" style="border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px">
                    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
                    <p class="has-text-align-center" style="font-size:3rem">✓</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Qualité</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Certification Qualiopi garantissant la qualité</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->

<style>
.feature-card {
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}
.feature-card:hover {
    transform: translateY(-10px);
}
</style>'
    ));

    // Pattern: CTA Simple
    register_block_pattern('insuffle/cta-simple', array(
        'title' => 'CTA Simple',
        'description' => 'Call-to-action simple et efficace',
        'categories' => array('insuffle'),
        'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"backgroundColor":"primary"} -->
<div class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:80px;padding-bottom:80px">
    <!-- wp:group {"layout":{"type":"constrained","contentSize":"800px"}} -->
    <div class="wp-block-group">
        <!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"}}} -->
        <h2 class="has-text-align-center" style="color:#ffffff">Prêt à transformer votre équipe ?</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","style":{"color":{"text":"#ffffff"},"spacing":{"margin":{"top":"20px"}}}} -->
        <p class="has-text-align-center" style="color:#ffffff;margin-top:20px">Contactez-nous dès maintenant pour discuter de vos besoins en formation</p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"40px"}}}} -->
        <div class="wp-block-buttons" style="margin-top:40px">
            <!-- wp:button {"backgroundColor":"secondary","textColor":"black","className":"is-style-fill"} -->
            <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-black-color has-secondary-background-color has-text-color has-background wp-element-button">Demander un devis</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->'
    ));

    // Pattern: Témoignage
    register_block_pattern('insuffle/testimonial', array(
        'title' => 'Témoignage',
        'description' => 'Bloc témoignage avec citation',
        'categories' => array('insuffle'),
        'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"40px","right":"40px","bottom":"40px","left":"40px"}},"border":{"radius":"15px"}},"backgroundColor":"white","className":"testimonial-block"} -->
<div class="wp-block-group testimonial-block has-white-background-color has-background" style="border-radius:15px;padding-top:40px;padding-right:40px;padding-bottom:40px;padding-left:40px">
    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"2rem","lineHeight":"1"}}} -->
    <p class="has-text-align-center" style="font-size:2rem;line-height:1">⭐⭐⭐⭐⭐</p>
    <!-- /wp:paragraph -->

    <!-- wp:quote {"align":"center"} -->
    <blockquote class="wp-block-quote has-text-align-center">
        <p>"Une formation exceptionnelle qui a transformé notre façon de travailler. Les outils et méthodologies sont directement applicables."</p>
    </blockquote>
    <!-- /wp:quote -->

    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontWeight":"600"}}} -->
    <p class="has-text-align-center" style="font-weight:600">Marie Dubois</p>
    <!-- /wp:paragraph -->

    <!-- wp:paragraph {"align":"center","style":{"color":{"text":"#666666"}}} -->
    <p class="has-text-align-center" style="color:#666666">Directrice RH, Entreprise XYZ</p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<style>
.testimonial-block {
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}
.testimonial-block blockquote {
    border-left: none;
    font-style: italic;
}
</style>'
    ));

    // Pattern: Grille de services 2x2
    register_block_pattern('insuffle/services-grid', array(
        'title' => 'Grille Services 2x2',
        'description' => 'Grille de 4 services en 2x2',
        'categories' => array('insuffle'),
        'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"backgroundColor":"white"} -->
<div class="wp-block-group alignfull has-white-background-color has-background" style="padding-top:80px;padding-bottom:80px">
    <!-- wp:group {"layout":{"type":"constrained","contentSize":"1200px"}} -->
    <div class="wp-block-group">
        <!-- wp:heading {"textAlign":"center"} -->
        <h2 class="has-text-align-center">Nos Formations</h2>
        <!-- /wp:heading -->

        <!-- wp:columns {"style":{"spacing":{"margin":{"top":"60px"},"blockGap":"30px"}}} -->
        <div class="wp-block-columns" style="margin-top:60px">
            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"radius":"15px","width":"1px"}},"borderColor":"primary","className":"service-box"} -->
                <div class="wp-block-group service-box has-border-color has-primary-border-color" style="border-width:1px;border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px">
                    <!-- wp:heading {"level":3} -->
                    <h3>Leadership</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph -->
                    <p>Développez vos compétences en leadership et management d\'équipe</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:button {"width":100} -->
                    <div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button">En savoir plus</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"radius":"15px","width":"1px"}},"borderColor":"primary","className":"service-box"} -->
                <div class="wp-block-group service-box has-border-color has-primary-border-color" style="border-width:1px;border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px">
                    <!-- wp:heading {"level":3} -->
                    <h3>Innovation</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph -->
                    <p>Stimulez la créativité et l\'innovation dans votre organisation</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:button {"width":100} -->
                    <div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button">En savoir plus</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->

        <!-- wp:columns {"style":{"spacing":{"margin":{"top":"30px"},"blockGap":"30px"}}} -->
        <div class="wp-block-columns" style="margin-top:30px">
            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"radius":"15px","width":"1px"}},"borderColor":"primary","className":"service-box"} -->
                <div class="wp-block-group service-box has-border-color has-primary-border-color" style="border-width:1px;border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px">
                    <!-- wp:heading {"level":3} -->
                    <h3>Communication</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph -->
                    <p>Maîtrisez l\'art de la communication efficace</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:button {"width":100} -->
                    <div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button">En savoir plus</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"radius":"15px","width":"1px"}},"borderColor":"primary","className":"service-box"} -->
                <div class="wp-block-group service-box has-border-color has-primary-border-color" style="border-width:1px;border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px">
                    <!-- wp:heading {"level":3} -->
                    <h3>Agilité</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph -->
                    <p>Adoptez les méthodes agiles pour plus d\'efficacité</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:button {"width":100} -->
                    <div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button">En savoir plus</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->

<style>
.service-box {
    transition: all 0.3s ease;
}
.service-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(142, 33, 131, 0.2);
}
</style>'
    ));

    // Pattern: Section Stats/Chiffres
    register_block_pattern('insuffle/stats-section', array(
        'title' => 'Section Statistiques',
        'description' => 'Section avec chiffres clés',
        'categories' => array('insuffle'),
        'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"backgroundColor":"secondary"} -->
<div class="wp-block-group alignfull has-secondary-background-color has-background" style="padding-top:80px;padding-bottom:80px">
    <!-- wp:group {"layout":{"type":"constrained","contentSize":"1200px"}} -->
    <div class="wp-block-group">
        <!-- wp:columns {"verticalAlignment":"center"} -->
        <div class="wp-block-columns are-vertically-aligned-center">
            <!-- wp:column {"verticalAlignment":"center"} -->
            <div class="wp-block-column is-vertically-aligned-center">
                <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"3.5rem","fontWeight":"700"}}} -->
                <h3 class="has-text-align-center" style="font-size:3.5rem;font-weight:700">500+</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.2rem"}}} -->
                <p class="has-text-align-center" style="font-size:1.2rem">Apprenants formés</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column {"verticalAlignment":"center"} -->
            <div class="wp-block-column is-vertically-aligned-center">
                <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"3.5rem","fontWeight":"700"}}} -->
                <h3 class="has-text-align-center" style="font-size:3.5rem;font-weight:700">95%</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.2rem"}}} -->
                <p class="has-text-align-center" style="font-size:1.2rem">Taux de satisfaction</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column {"verticalAlignment":"center"} -->
            <div class="wp-block-column is-vertically-aligned-center">
                <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"3.5rem","fontWeight":"700"}}} -->
                <h3 class="has-text-align-center" style="font-size:3.5rem;font-weight:700">15</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.2rem"}}} -->
                <p class="has-text-align-center" style="font-size:1.2rem">Formations disponibles</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column {"verticalAlignment":"center"} -->
            <div class="wp-block-column is-vertically-aligned-center">
                <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"3.5rem","fontWeight":"700"}}} -->
                <h3 class="has-text-align-center" style="font-size:3.5rem;font-weight:700">10+</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.2rem"}}} -->
                <p class="has-text-align-center" style="font-size:1.2rem">Années d\'expérience</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->'
    ));

    // Pattern: Image + Texte
    register_block_pattern('insuffle/image-text', array(
        'title' => 'Image + Texte',
        'description' => 'Section image à gauche, texte à droite',
        'categories' => array('insuffle'),
        'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"backgroundColor":"white"} -->
<div class="wp-block-group alignfull has-white-background-color has-background" style="padding-top:80px;padding-bottom:80px">
    <!-- wp:group {"layout":{"type":"constrained","contentSize":"1200px"}} -->
    <div class="wp-block-group">
        <!-- wp:columns {"verticalAlignment":"center"} -->
        <div class="wp-block-columns are-vertically-aligned-center">
            <!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
            <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
                <!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"15px"}}} -->
                <figure class="wp-block-image size-large has-custom-border"><img src="" alt="" style="border-radius:15px"/></figure>
                <!-- /wp:image -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
            <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
                <!-- wp:heading -->
                <h2>Notre Approche Unique</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>Nous combinons expertise théorique et pratique terrain pour des formations qui transforment vraiment vos équipes.</p>
                <!-- /wp:paragraph -->

                <!-- wp:list -->
                <ul>
                    <li>Formateurs certifiés et expérimentés</li>
                    <li>Méthodologies éprouvées</li>
                    <li>Accompagnement personnalisé</li>
                    <li>Résultats mesurables</li>
                </ul>
                <!-- /wp:list -->

                <!-- wp:button -->
                <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Découvrir notre méthode</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->'
    ));

    // Pattern: Footer 4 colonnes
    register_block_pattern('insuffle/footer-4-columns', array(
        'title' => 'Footer 4 Colonnes',
        'description' => 'Pied de page avec 4 colonnes de contenu',
        'categories' => array('insuffle'),
        'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"60px","bottom":"30px"}}},"backgroundColor":"primary","textColor":"white"} -->
<div class="wp-block-group alignfull has-white-color has-primary-background-color has-text-color has-background" style="padding-top:60px;padding-bottom:30px">
    <!-- wp:group {"layout":{"type":"constrained","contentSize":"1200px"}} -->
    <div class="wp-block-group">
        <!-- wp:columns {"style":{"spacing":{"blockGap":"40px"}}} -->
        <div class="wp-block-columns">
            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:heading {"level":3,"style":{"color":{"text":"#ffffff"}}} -->
                <h3 class="has-text-color" style="color:#ffffff">Insuffle Académie</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"style":{"color":{"text":"#ffffff"}}} -->
                <p class="has-text-color" style="color:#ffffff">Formations professionnelles certifiantes pour développer vos compétences.</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:heading {"level":4,"style":{"color":{"text":"#ffffff"}}} -->
                <h4 class="has-text-color" style="color:#ffffff">Formations</h4>
                <!-- /wp:heading -->

                <!-- wp:list {"style":{"color":{"text":"#ffffff"}}} -->
                <ul class="has-text-color" style="color:#ffffff">
                    <li>Leadership</li>
                    <li>Management</li>
                    <li>Innovation</li>
                    <li>Communication</li>
                </ul>
                <!-- /wp:list -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:heading {"level":4,"style":{"color":{"text":"#ffffff"}}} -->
                <h4 class="has-text-color" style="color:#ffffff">Liens Utiles</h4>
                <!-- /wp:heading -->

                <!-- wp:list {"style":{"color":{"text":"#ffffff"}}} -->
                <ul class="has-text-color" style="color:#ffffff">
                    <li><a href="#">À propos</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Tarifs</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <!-- /wp:list -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:heading {"level":4,"style":{"color":{"text":"#ffffff"}}} -->
                <h4 class="has-text-color" style="color:#ffffff">Contact</h4>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"style":{"color":{"text":"#ffffff"}}} -->
                <p class="has-text-color" style="color:#ffffff">📞 09 80 80 89 62<br>✉️ contact@insuffle-academie.com<br>📍 Deauville, France</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->

        <!-- wp:separator {"style":{"spacing":{"margin":{"top":"40px","bottom":"20px"}}},"backgroundColor":"white"} -->
        <hr class="wp-block-separator has-text-color has-white-color has-alpha-channel-opacity has-white-background-color has-background" style="margin-top:40px;margin-bottom:20px"/>
        <!-- /wp:separator -->

        <!-- wp:paragraph {"align":"center","style":{"color":{"text":"#ffffff"}}} -->
        <p class="has-text-align-center has-text-color" style="color:#ffffff">© 2024 Insuffle Académie - Tous droits réservés</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->'
    ));

}
add_action('init', 'insuffle_register_block_patterns');
