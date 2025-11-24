<?php
/**
 * Template Name: Page Contact
 * Description: Page de contact avec formulaire et informations
 */

get_header(); ?>

<div id="primary" class="content-area page-contact">
    <?php while (have_posts()) : the_post(); ?>

        <!-- Hero Section -->
        <section class="page-hero">
            <div class="page-hero-content">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <div class="page-intro"><?php the_excerpt(); ?></div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Contenu -->
        <section class="page-content-wrapper">
            <div class="container">
                <div class="contact-grid">

                    <!-- Formulaire -->
                    <div class="contact-form-section">
                        <?php the_content(); ?>
                    </div>

                    <!-- Informations de contact -->
                    <div class="contact-info-section">
                        <div class="contact-info-card">
                            <h3>📞 Téléphone</h3>
                            <p><a href="tel:+33980808962">09 80 80 89 62</a></p>
                            <p class="info-details">Du lundi au vendredi<br>9h - 18h</p>
                        </div>

                        <div class="contact-info-card">
                            <h3>✉️ Email</h3>
                            <p><a href="mailto:contact@insuffle-academie.com">contact@insuffle-academie.com</a></p>
                            <p class="info-details">Réponse sous 24h</p>
                        </div>

                        <div class="contact-info-card">
                            <h3>📍 Adresse</h3>
                            <p>Deauville, Normandie<br>France</p>
                        </div>

                        <div class="contact-info-card">
                            <h3>💼 Organisme certifié</h3>
                            <p>Certification Qualiopi<br>N° déclaration : XXXXXXXX</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    <?php endwhile; ?>
</div>

<style>
.contact-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 60px;
    margin-top: 40px;
}

.contact-info-card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

.contact-info-card h3 {
    color: var(--primary);
    font-size: 1.3rem;
    margin-bottom: 15px;
}

.contact-info-card a {
    color: var(--primary);
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
}

.info-details {
    font-size: 0.9rem;
    color: #666;
    margin-top: 10px;
}

@media (max-width: 992px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}
</style>

<?php get_footer(); ?>
