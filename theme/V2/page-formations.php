<?php
/**
 * Template Name: Page Formations Liste
 * Description: Template pour afficher la liste de toutes les formations
 */

get_header(); ?>

<style>
:root {
    --primary: #8E2183;
    --secondary: #FFD466;
    --accent: #FFC0CB;
    --light: #FFFFFF;
    --dark: #333333;
    --grey: #F5F5F5;
}

/* Hero Page Formations */
.formations-hero {
    background: linear-gradient(135deg, var(--primary) 0%, #9e3193 100%);
    color: white;
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
    text-align: center;
}

.formations-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 600px;
    height: 600px;
    background: rgba(255, 212, 102, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.formations-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: rgba(255, 192, 203, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.formations-hero-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 3;
}

.formations-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.formations-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.1;
    color: white !important;
}

.formations-hero-description {
    font-size: 1.3rem;
    opacity: 0.95;
    max-width: 800px;
    margin: 0 auto 30px;
    line-height: 1.6;
}

.formations-stats {
    display: flex;
    justify-content: center;
    gap: 60px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: var(--secondary);
    display: block;
    line-height: 1;
}

.stat-label {
    font-size: 1rem;
    margin-top: 10px;
    opacity: 0.9;
    color: white;
}

/* Contenu */
.formations-content-wrapper {
    background: white;
    padding: 80px 0;
}

.formations-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-intro {
    text-align: center;
    margin-bottom: 60px;
}

.section-intro h2 {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 20px;
}

.section-intro p {
    font-size: 1.2rem;
    color: #555;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
}

/* Grille des formations - utilise le style du bloc */
.insuffle-formations-block {
    margin: 40px 0;
}

.insuffle-formations-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 30px;
}

.insuffle-formation-card {
    background-color: #FFFFFF;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.insuffle-formation-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.insuffle-formation-image {
    overflow: hidden;
    height: 200px;
    background: linear-gradient(135deg, #8E2183, #FFD466);
    position: relative;
}

.insuffle-formation-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.insuffle-formation-content {
    padding: 30px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.insuffle-formation-content h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: #8E2183;
    line-height: 1.3;
}

.insuffle-formation-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
}

.insuffle-formation-excerpt {
    color: #555;
    line-height: 1.6;
    margin-bottom: 20px;
    flex: 1;
}

.insuffle-formation-links {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: auto;
}

.insuffle-formation-btn {
    display: inline-block;
    background-color: #FFD466;
    color: #8E2183;
    padding: 12px 30px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.3s ease;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.insuffle-formation-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    color: #8E2183;
    text-decoration: none;
}

.insuffle-download-link {
    display: inline-block;
    color: #8E2183;
    font-size: 0.95rem;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s;
    padding: 8px 0;
}

.insuffle-download-link:hover {
    color: #FFD466;
    text-decoration: underline;
}

.insuffle-download-link::before {
    content: "📄 ";
    margin-right: 5px;
}

/* Section CTA */
.formations-cta {
    background: linear-gradient(135deg, var(--grey) 0%, #fff 100%);
    border-radius: 20px;
    padding: 60px 40px;
    margin-top: 80px;
    text-align: center;
}

.formations-cta h2 {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 20px;
}

.formations-cta p {
    font-size: 1.2rem;
    color: #555;
    margin-bottom: 30px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.formations-cta .btn {
    display: inline-block;
    background-color: var(--secondary);
    color: var(--primary);
    padding: 15px 40px;
    font-size: 1.2rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.formations-cta .btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}

/* Message si aucune formation */
.no-formations {
    text-align: center;
    padding: 80px 20px;
    background: var(--grey);
    border-radius: 20px;
}

.no-formations-icon {
    font-size: 5rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.no-formations h2 {
    color: var(--primary);
    font-size: 2rem;
    margin-bottom: 20px;
}

.no-formations p {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 30px;
}

/* Responsive */
@media (max-width: 992px) {
    .formations-hero h1 {
        font-size: 2.5rem;
    }
    
    .insuffle-formations-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .formations-stats {
        gap: 30px;
    }
}

@media (max-width: 768px) {
    .formations-hero {
        padding: 80px 0 60px;
    }
    
    .formations-hero h1 {
        font-size: 2rem;
    }
    
    .formations-hero-description {
        font-size: 1.1rem;
    }
    
    .insuffle-formations-grid {
        grid-template-columns: 1fr;
    }
    
    .formations-content-wrapper {
        padding: 60px 0;
    }
    
    .section-intro h2 {
        font-size: 2rem;
    }
    
    .formations-stats {
        flex-direction: column;
        gap: 20px;
    }
}
</style>

<!-- Hero -->
<section class="formations-hero">
    <div class="formations-hero-content">
        <div class="formations-icon">🎓</div>
        <h1><?php the_title(); ?></h1>
        
        <?php if (has_excerpt()) : ?>
            <div class="formations-hero-description">
                <?php the_excerpt(); ?>
            </div>
        <?php else : ?>
            <div class="formations-hero-description">
                Découvrez nos programmes de formation en facilitation et intelligence collective. 
                Développez vos compétences pour transformer la manière dont votre organisation collabore et innove.
            </div>
        <?php endif; ?>
        
        <?php
        // Compter les formations
        $formations = insuffle_get_formations();
        $nb_formations = count($formations);
        ?>
        
        <div class="formations-stats">
            <div class="stat-item">
                <span class="stat-number"><?php echo $nb_formations; ?></span>
                <span class="stat-label">Formations disponibles</span>
            </div>
          <!--  <div class="stat-item">
                <span class="stat-number">100%</span>
                <span class="stat-label">Satisfaction client</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">15+</span>
                <span class="stat-label">Années d'expérience</span>
            </div>-->
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="formations-content-wrapper">
    <div class="formations-container">
        
        <?php
        // Afficher le contenu de la page si présent
        if (have_posts()) :
            while (have_posts()) : the_post();
                if (get_the_content()) :
                    ?>
                    <div class="section-intro">
                        <?php the_content(); ?>
                    </div>
                    <?php
                endif;
            endwhile;
        endif;
        ?>
        
        <?php
        // Récupérer et afficher les formations
        $formations = insuffle_get_formations();
        
        if ($formations) :
        ?>
            <div class="insuffle-formations-block">
                <div class="insuffle-formations-grid">
                    <?php foreach ($formations as $formation) : 
                        setup_postdata($formation);
                        $plaquette_url = get_post_meta($formation->ID, 'plaquette_url', true);
                    ?>
                        <div class="insuffle-formation-card">
                            <?php if (has_post_thumbnail($formation->ID)) : ?>
                                <div class="insuffle-formation-image">
                                    <?php echo get_the_post_thumbnail($formation->ID, 'formation-card'); ?>
                                </div>
                            <?php else : ?>
                                <div class="insuffle-formation-image"></div>
                            <?php endif; ?>
                            
                            <div class="insuffle-formation-content">
                                <h3><?php echo get_the_title($formation->ID); ?></h3>
                                
                                <?php if ($formation->post_excerpt) : ?>
                                    <div class="insuffle-formation-meta">
                                        <span><?php echo esc_html($formation->post_excerpt); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="insuffle-formation-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt($formation->ID), 20); ?>
                                </div>
                                
                                <div class="insuffle-formation-links">
                                    <a href="<?php echo get_permalink($formation->ID); ?>" class="insuffle-formation-btn">
                                        Voir le programme
                                    </a>
                                    
                                    <?php if ($plaquette_url) : ?>
                                        <a href="<?php echo esc_url($plaquette_url); ?>" class="insuffle-download-link" target="_blank" rel="noopener">
                                            Télécharger la plaquette
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php else : ?>
            <!-- Message si aucune formation -->
            <div class="no-formations">
                <div class="no-formations-icon">📚</div>
                <h2>Aucune formation disponible</h2>
                <p>Nos formations sont en cours de mise à jour. Revenez bientôt pour découvrir nos nouveaux programmes !</p>
                <a href="<?php echo home_url('/#contact'); ?>" class="btn">Nous contacter</a>
            </div>
        <?php endif; ?>
        
        <!-- CTA -->
        <div class="formations-cta">
            <h2>Une question sur nos formations ?</h2>
            <p>Notre équipe est à votre disposition pour vous conseiller et vous aider à choisir la formation la plus adaptée à vos besoins.</p>
            <a href="<?php echo home_url('/#contact'); ?>" class="btn">Nous contacter</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>