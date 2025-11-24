<?php
/**
 * Template pour l'affichage détaillé d'une formation
 * Conforme aux exigences Qualiopi
 */

get_header();

while (have_posts()) : the_post();

// Récupération de toutes les métadonnées
$reference = get_post_meta(get_the_ID(), '_formation_reference', true);
$duree_heures = get_post_meta(get_the_ID(), '_formation_duree_heures', true);
$duree_jours = get_post_meta(get_the_ID(), '_formation_duree_jours', true);
$modalite = get_post_meta(get_the_ID(), '_formation_modalite', true);
$lieu = get_post_meta(get_the_ID(), '_formation_lieu', true);
$tarif_inter = get_post_meta(get_the_ID(), '_formation_tarif_inter', true);
$tarif_intra = get_post_meta(get_the_ID(), '_formation_tarif_intra', true);
$tarif_individuel = get_post_meta(get_the_ID(), '_formation_tarif_individuel', true);
$financement = get_post_meta(get_the_ID(), '_formation_financement', true);
$niveau_requis = get_post_meta(get_the_ID(), '_formation_niveau_requis', true);
$public_vise = get_post_meta(get_the_ID(), '_formation_public_vise', true);
$prerequis = get_post_meta(get_the_ID(), '_formation_prerequis', true);
$objectifs = get_post_meta(get_the_ID(), '_formation_objectifs', true);
$competences = get_post_meta(get_the_ID(), '_formation_competences', true);
$programme = get_post_meta(get_the_ID(), '_formation_programme', true);
$methodes = get_post_meta(get_the_ID(), '_formation_methodes', true);
$moyens_techniques = get_post_meta(get_the_ID(), '_formation_moyens_techniques', true);
$encadrement = get_post_meta(get_the_ID(), '_formation_encadrement', true);
$suivi = get_post_meta(get_the_ID(), '_formation_suivi', true);
$evaluation = get_post_meta(get_the_ID(), '_formation_evaluation', true);
$sanction = get_post_meta(get_the_ID(), '_formation_sanction', true);
$accessibilite = get_post_meta(get_the_ID(), '_formation_accessibilite', true);
$delai_acces = get_post_meta(get_the_ID(), '_formation_delai_acces', true);
$effectif_min = get_post_meta(get_the_ID(), '_formation_effectif_min', true);
$effectif_max = get_post_meta(get_the_ID(), '_formation_effectif_max', true);
$taux_satisfaction = get_post_meta(get_the_ID(), '_formation_taux_satisfaction', true);
$taux_reussite = get_post_meta(get_the_ID(), '_formation_taux_reussite', true);
$sessions_data = get_post_meta(get_the_ID(), '_formation_sessions_data', true);
$formateurs = get_post_meta(get_the_ID(), '_formation_formateurs', true);
$galerie = get_post_meta(get_the_ID(), '_formation_galerie', true);
$bouton1_texte = get_post_meta(get_the_ID(), '_formation_bouton1_texte', true);
$bouton1_fichier = get_post_meta(get_the_ID(), '_formation_bouton1_fichier', true);
$bouton2_texte = get_post_meta(get_the_ID(), '_formation_bouton2_texte', true);
$bouton2_fichier = get_post_meta(get_the_ID(), '_formation_bouton2_fichier', true);
$bouton3_texte = get_post_meta(get_the_ID(), '_formation_bouton3_texte', true);
$bouton3_fichier = get_post_meta(get_the_ID(), '_formation_bouton3_fichier', true);
$formulaire_code = get_post_meta(get_the_ID(), '_formation_formulaire_code', true);
?>

<style>
/* Styles spécifiques pour la page formation */
.formation-hero {
    background: linear-gradient(135deg, #8E2183 0%, #9e3193 100%);
    color: white;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.formation-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: rgba(255, 212, 102, 0.1);
    border-radius: 50%;
}

.formation-badge {
    display: inline-block;
    background: #FFD466;
    color: #8E2183;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.formation-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.2;
}

.formation-meta {
    display: flex;
    gap: 30px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
}

.meta-item svg {
    width: 24px;
    height: 24px;
    fill: #FFD466;
}

.formation-content {
    padding: 60px 0;
    background: #f8f9fa;
}

.content-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
}

.main-content {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.content-section {
    padding: 40px;
    border-bottom: 1px solid #eee;
}

.content-section:last-child {
    border-bottom: none;
}

.section-title {
    font-size: 1.8rem;
    color: #8E2183;
    margin-bottom: 20px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-icon {
    width: 30px;
    height: 30px;
    background: #FFD466;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.formation-main-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.formation-main-content p {
    margin-bottom: 15px;
}

.formation-main-content h2,
.formation-main-content h3,
.formation-main-content h4 {
    color: #8E2183;
    margin-top: 25px;
    margin-bottom: 15px;
}

.formation-main-content ul,
.formation-main-content ol {
    margin: 15px 0;
    padding-left: 25px;
}

.formation-main-content li {
    margin-bottom: 8px;
}

.objectifs-list {
    list-style: none;
    padding: 0;
}

.objectifs-list li {
    padding: 15px 0 15px 40px;
    position: relative;
    border-bottom: 1px solid #f0f0f0;
}

.objectifs-list li::before {
    content: '✓';
    position: absolute;
    left: 10px;
    color: #28a745;
    font-weight: bold;
    font-size: 1.2rem;
}

.programme-module {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.programme-module h4 {
    color: #8E2183;
    margin-bottom: 10px;
}

.sidebar {
    height: fit-content;
    position: sticky;
    top: 100px;
}

.sidebar-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

.price-box {
    background: linear-gradient(135deg, #8E2183 0%, #9e3193 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
}

.price-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 10px;
}

.price-value {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 5px;
}

.price-info {
    font-size: 0.85rem;
    opacity: 0.8;
}

.btn-primary {
    background: #FFD466;
    color: #8E2183;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    width: 100%;
    text-align: center;
    margin-top: 20px;
    transition: transform 0.3s;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.info-list {
    list-style: none;
    padding: 0;
}

.info-list li {
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
}

.info-list li:last-child {
    border-bottom: none;
}

.info-label {
    color: #666;
    font-weight: 500;
}

.info-value {
    color: #333;
    font-weight: 600;
}

.qualiopi-badge {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    margin-top: 20px;
}

.qualiopi-badge img {
    width: 120px;
    margin-bottom: 10px;
}

.formateur-card {
    display: flex;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 15px;
}

.formateur-photo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.formateur-info h4 {
    color: #8E2183;
    margin-bottom: 5px;
}

.sessions-list {
    list-style: none;
    padding: 0;
}

.session-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.session-date {
    font-weight: 600;
    color: #8E2183;
}

.session-status {
    background: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.85rem;
}

.session-status.complet {
    background: #dc3545;
}

.indicateurs {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.indicateur-item {
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.indicateur-value {
    font-size: 2rem;
    font-weight: 800;
    color: #8E2183;
}

.indicateur-label {
    font-size: 0.9rem;
    color: #666;
    margin-top: 5px;
}

.formation-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.formation-gallery img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    cursor: pointer;
    transition: transform 0.3s;
}

.formation-gallery img:hover {
    transform: scale(1.05);
}

.download-buttons {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 20px;
}

.btn-download {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #8E2183;
    color: white;
    padding: 15px 25px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-download:hover {
    background: #6f1a68;
    transform: translateX(5px);
}

.btn-download svg {
    width: 20px;
    height: 20px;
    fill: white;
}

@media (max-width: 992px) {
    .content-wrapper {
        grid-template-columns: 1fr;
    }
    
    .sidebar {
        position: static;
    }
    
    .formation-title {
        font-size: 2rem;
    }
}
</style>

<!-- Hero Section -->
<section class="formation-hero">
    <div class="container">
        <?php if ($reference) : ?>
            <span class="formation-badge">Réf. <?php echo esc_html($reference); ?></span>
        <?php endif; ?>
        
        <h1 class="formation-title"><?php the_title(); ?></h1>
        
        <div class="formation-meta">
            <?php if ($duree_jours) : ?>
            <div class="meta-item">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                <span><strong><?php echo esc_html($duree_jours); ?> jours</strong> (<?php echo esc_html($duree_heures); ?> heures)</span>
            </div>
            <?php endif; ?>
            
            <?php if ($modalite) : ?>
            <div class="meta-item">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                <span><?php echo esc_html($modalite); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($lieu) : ?>
            <div class="meta-item">
                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                <span><?php echo esc_html($lieu); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<section class="formation-content">
    <div class="content-wrapper">
        <div class="main-content">
            
            <!-- Résumé -->
            <?php if (has_excerpt()) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">📋</span>
                    En bref
                </h2>
                <p style="font-size: 1.1rem; line-height: 1.7;">
                    <?php the_excerpt(); ?>
                </p>
            </div>
            <?php endif; ?>
            
            <!-- CONTENU PRINCIPAL DE LA FORMATION - NOUVEAU -->
            <?php if (get_the_content()) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">📖</span>
                    Description complète
                </h2>
                <div class="formation-main-content">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- GALERIE PHOTOS -->
            <?php if ($galerie) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">📸</span>
                    Galerie photos
                </h2>
                <div class="formation-gallery">
                    <?php
                    $gallery_ids = explode(',', $galerie);
                    foreach ($gallery_ids as $img_id) {
                        $img_url = wp_get_attachment_image_url($img_id, 'large');
                        $img_thumb = wp_get_attachment_image_url($img_id, 'medium');
                        if ($img_url) {
                            echo '<a href="' . esc_url($img_url) . '" target="_blank">';
                            echo '<img src="' . esc_url($img_thumb) . '" alt="Photo de la formation">';
                            echo '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Public visé et prérequis -->
            <?php if ($public_vise || $prerequis || $niveau_requis) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">👥</span>
                    Public visé et prérequis
                </h2>
                
                <?php if ($public_vise) : ?>
                <div style="margin-bottom: 25px;">
                    <h3 style="color: #333; margin-bottom: 10px;">Public concerné</h3>
                    <p><?php echo nl2br(esc_html($public_vise)); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if ($prerequis) : ?>
                <div style="margin-bottom: 25px;">
                    <h3 style="color: #333; margin-bottom: 10px;">Prérequis</h3>
                    <p><?php echo nl2br(esc_html($prerequis)); ?></p>
                </div>
                <?php else : ?>
                <div style="margin-bottom: 25px;">
                    <h3 style="color: #333; margin-bottom: 10px;">Prérequis</h3>
                    <p>Cette formation ne nécessite pas de prérequis particulier.</p>
                </div>
                <?php endif; ?>
                
                <?php if ($niveau_requis) : ?>
                <div>
                    <h3 style="color: #333; margin-bottom: 10px;">Niveau requis</h3>
                    <p><?php echo esc_html($niveau_requis); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Objectifs pédagogiques -->
            <?php if ($objectifs) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">🎯</span>
                    Objectifs pédagogiques
                </h2>
                <ul class="objectifs-list">
                    <?php 
                    $objectifs_array = explode("\n", $objectifs);
                    foreach ($objectifs_array as $objectif) :
                        if (trim($objectif)) :
                    ?>
                    <li><?php echo esc_html($objectif); ?></li>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <!-- Compétences visées -->
            <?php if ($competences) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">💪</span>
                    Compétences visées
                </h2>
                <p><?php echo nl2br(esc_html($competences)); ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Programme détaillé -->
            <?php if ($programme) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">📚</span>
                    Programme détaillé
                </h2>
                <?php 
                // Découper le programme en modules si présence de "Module" ou "Jour"
                $programme_lines = explode("\n", $programme);
                $current_module = '';
                
                foreach ($programme_lines as $line) :
                    if (stripos($line, 'module') !== false || stripos($line, 'jour') !== false) :
                        if ($current_module) echo '</div>';
                ?>
                        <div class="programme-module">
                            <h4><?php echo esc_html($line); ?></h4>
                <?php
                        $current_module = $line;
                    else :
                        echo '<p>' . esc_html($line) . '</p>';
                    endif;
                endforeach;
                
                if ($current_module) echo '</div>';
                ?>
            </div>
            <?php endif; ?>
            
            <!-- Méthodes pédagogiques -->
            <?php if ($methodes) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">🎓</span>
                    Méthodes pédagogiques
                </h2>
                <p><?php echo nl2br(esc_html($methodes)); ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Moyens techniques -->
            <?php if ($moyens_techniques) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">🛠️</span>
                    Moyens techniques
                </h2>
                <p><?php echo nl2br(esc_html($moyens_techniques)); ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Encadrement -->
            <?php if ($encadrement || $formateurs) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">👨‍🏫</span>
                    Encadrement
                </h2>
                
                <?php if ($encadrement) : ?>
                <p><?php echo nl2br(esc_html($encadrement)); ?></p>
                <?php endif; ?>
                
                <?php 
                if ($formateurs) :
                    $formateurs_ids = explode(',', $formateurs);
                    foreach ($formateurs_ids as $formateur_id) :
                        $formateur = get_post($formateur_id);
                        if ($formateur) :
                            $photo = get_the_post_thumbnail_url($formateur_id, 'formateur-photo');
                            $titre = get_post_meta($formateur_id, '_formateur_titre', true);
                ?>
                <div class="formateur-card">
                    <?php if ($photo) : ?>
                    <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($formateur->post_title); ?>" class="formateur-photo">
                    <?php endif; ?>
                    <div class="formateur-info">
                        <h4><?php echo esc_html($formateur->post_title); ?></h4>
                        <p><?php echo esc_html($titre); ?></p>
                    </div>
                </div>
                <?php 
                        endif;
                    endforeach;
                endif; 
                ?>
            </div>
            <?php endif; ?>
            
            <!-- Suivi et évaluation -->
            <?php if ($suivi || $evaluation || $sanction) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">📊</span>
                    Suivi et évaluation
                </h2>
                
                <?php if ($suivi) : ?>
                <div style="margin-bottom: 25px;">
                    <h3 style="color: #333; margin-bottom: 10px;">Modalités de suivi</h3>
                    <p><?php echo nl2br(esc_html($suivi)); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if ($evaluation) : ?>
                <div style="margin-bottom: 25px;">
                    <h3 style="color: #333; margin-bottom: 10px;">Modalités d'évaluation</h3>
                    <p><?php echo nl2br(esc_html($evaluation)); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if ($sanction) : ?>
                <div>
                    <h3 style="color: #333; margin-bottom: 10px;">Sanction de la formation</h3>
                    <p><?php echo nl2br(esc_html($sanction)); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Accessibilité -->
            <?php if ($accessibilite) : ?>
            <div class="content-section">
                <h2 class="section-title">
                    <span class="section-icon">♿</span>
                    Accessibilité
                </h2>
                <p><?php echo nl2br(esc_html($accessibilite)); ?></p>
            </div>
            <?php endif; ?>
            
        </div>
        
        <!-- Sidebar -->
        <aside class="sidebar">
            
            <!-- Prix et inscription -->
            <div class="sidebar-card">
                <div class="price-box">
                    <?php if ($tarif_inter) : ?>
                    <div class="price-label">Tarif Inter-entreprises</div>
                    <div class="price-value"><?php echo esc_html($tarif_inter); ?>€</div>
                    <div class="price-info">HT par participant</div>
                    <?php elseif ($tarif_individuel) : ?>
                    <div class="price-label">Tarif individuel</div>
                    <div class="price-value"><?php echo esc_html($tarif_individuel); ?>€</div>
                    <div class="price-info">HT par participant</div>
                    <?php endif; ?>
                </div>
                
                <a href="#contact" class="btn-primary">S'inscrire à cette formation</a>
                
                <?php if ($financement) : ?>
                <p style="text-align: center; margin-top: 15px; font-size: 0.9rem; color: #666;">
                    <?php echo esc_html($financement); ?>
                </p>
                <?php endif; ?>
            </div>
            
            <!-- Informations clés -->
            <div class="sidebar-card">
                <h3 style="margin-bottom: 20px; color: #8E2183;">Informations clés</h3>
                <ul class="info-list">
                    <?php if ($duree_jours) : ?>
                    <li>
                        <span class="info-label">Durée</span>
                        <span class="info-value"><?php echo esc_html($duree_jours); ?> jours</span>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($modalite) : ?>
                    <li>
                        <span class="info-label">Format</span>
                        <span class="info-value"><?php echo esc_html($modalite); ?></span>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($effectif_max) : ?>
                    <li>
                        <span class="info-label">Participants</span>
                        <span class="info-value"><?php echo esc_html($effectif_min); ?> à <?php echo esc_html($effectif_max); ?></span>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($delai_acces) : ?>
                    <li>
                        <span class="info-label">Délai d'accès</span>
                        <span class="info-value"><?php echo esc_html($delai_acces); ?></span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Prochaines sessions -->
            <?php if (!empty($sessions_data) && is_array($sessions_data)) : ?>
            <div class="sidebar-card">
                <h3 style="margin-bottom: 20px; color: #8E2183;">Prochaines sessions</h3>
                
                <?php 
                // Trier les sessions par date de début
                usort($sessions_data, function($a, $b) {
                    return strtotime($a['date_debut']) - strtotime($b['date_debut']);
                });
                
                // Filtrer pour afficher uniquement les sessions futures
                $today = date('Y-m-d');
                $future_sessions = array_filter($sessions_data, function($session) use ($today) {
                    return $session['date_debut'] >= $today;
                });
                
                if (!empty($future_sessions)) :
                    foreach ($future_sessions as $session) :
                        // Formatage des dates
                        $date_debut_formatted = date_i18n('d/m/Y', strtotime($session['date_debut']));
                        $date_fin_formatted = date_i18n('d/m/Y', strtotime($session['date_fin']));
                        
                        // Déterminer le statut CSS
                        $statut_class = $session['statut'];
                        $statut_text = '';
                        switch($session['statut']) {
                            case 'disponible':
                                $statut_text = 'Places disponibles';
                                break;
                            case 'derniere_place':
                                $statut_text = 'Dernières places';
                                break;
                            case 'complet':
                                $statut_text = 'Complet';
                                break;
                            case 'annule':
                                $statut_text = 'Annulé';
                                break;
                        }
                ?>
                <div class="session-item">
                    <div class="session-dates">
                        <?php 
                        if ($session['date_debut'] === $session['date_fin']) {
                            echo $date_debut_formatted;
                        } else {
                            echo $date_debut_formatted . ' - ' . $date_fin_formatted;
                        }
                        ?>
                    </div>
                    
                    <div class="session-details">
                        <?php if (!empty($session['lieu'])) : ?>
                        <div class="session-detail-item">
                            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                            <span><?php echo esc_html($session['lieu']); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($session['places_dispo'])) : ?>
                        <div class="session-detail-item">
                            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                            <span><?php echo esc_html($session['places_dispo']); ?> places</span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($session['tarif_specifique'])) : ?>
                        <div class="session-tarif">
                            <?php echo number_format($session['tarif_specifique'], 0, ',', ' '); ?> € HT
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <span class="session-status <?php echo esc_attr($statut_class); ?>">
                        <?php echo esc_html($statut_text); ?>
                    </span>
                </div>
                <?php 
                    endforeach;
                else : 
                ?>
                <p style="color: #666; text-align: center; padding: 20px;">Aucune session programmée prochainement</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Indicateurs de performance -->
            <?php if ($taux_satisfaction || $taux_reussite) : ?>
            <div class="sidebar-card">
                <h3 style="margin-bottom: 20px; color: #8E2183;">Nos résultats</h3>
                <div class="indicateurs">
                    <?php if ($taux_satisfaction) : ?>
                    <div class="indicateur-item">
                        <div class="indicateur-value"><?php echo esc_html($taux_satisfaction); ?>%</div>
                        <div class="indicateur-label">Satisfaction</div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($taux_reussite) : ?>
                    <div class="indicateur-item">
                        <div class="indicateur-value"><?php echo esc_html($taux_reussite); ?>%</div>
                        <div class="indicateur-label">Réussite</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Boutons de téléchargement -->
            <?php if ($bouton1_texte || $bouton2_texte || $bouton3_texte) : ?>
            <div class="sidebar-card">
                <h3 style="margin-bottom: 20px; color: #8E2183;">Documents à télécharger</h3>
                <div class="download-buttons">
                    <?php if ($bouton1_texte && $bouton1_fichier) : 
                        $file_url = wp_get_attachment_url($bouton1_fichier);
                    ?>
                    <a href="<?php echo esc_url($file_url); ?>" class="btn-download" download>
                        <svg viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                        <?php echo esc_html($bouton1_texte); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($bouton2_texte && $bouton2_fichier) : 
                        $file_url = wp_get_attachment_url($bouton2_fichier);
                    ?>
                    <a href="<?php echo esc_url($file_url); ?>" class="btn-download" download>
                        <svg viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                        <?php echo esc_html($bouton2_texte); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($bouton3_texte && $bouton3_fichier) : 
                        $file_url = wp_get_attachment_url($bouton3_fichier);
                    ?>
                    <a href="<?php echo esc_url($file_url); ?>" class="btn-download" download>
                        <svg viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                        <?php echo esc_html($bouton3_texte); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Badge Qualiopi -->
            <div class="sidebar-card">
                <div class="qualiopi-badge">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-qualiopi.png" alt="Certification Qualiopi">
                    <p style="font-size: 0.9rem; color: #666; margin: 0;">
                        Organisme certifié Qualiopi<br>
                        pour les actions de formation
                    </p>
                </div>
            </div>
            
        </aside>
    </div>
</section>

<!-- Section Contact/Inscription -->
<section id="contact" style="background: #8E2183; padding: 80px 0;">
    <div class="container" style="max-width: 800px; margin: 0 auto; text-align: center;">
        <h2 style="color: white; font-size: 2.5rem; margin-bottom: 20px;">Inscrivez-vous à cette formation</h2>
        <p style="color: white; font-size: 1.2rem; margin-bottom: 40px;">
            Remplissez le formulaire ci-dessous pour vous inscrire ou obtenir plus d'informations
        </p>
        
        <div style="background: white; padding: 40px; border-radius: 15px;">
            <iframe data-tally-src="https://tally.so/embed/wgV2Q4?alignLeft=1&hideTitle=1&transparentBackground=1&dynamicHeight=1" 
                    loading="lazy" 
                    width="100%" 
                    height="400" 
                    frameborder="0" 
                    title="Formulaire d'inscription">
            </iframe>
            <script>
                var d=document,w="https://tally.so/widgets/embed.js",v=function(){"undefined"!=typeof Tally?Tally.loadEmbeds():d.querySelectorAll("iframe[data-tally-src]:not([src])").forEach((function(e){e.src=e.dataset.tallySrc}))};if("undefined"!=typeof Tally)v();else if(d.querySelector('script[src="'+w+'"]')==null){var s=d.createElement("script");s.src=w,s.onload=v,s.onerror=v,d.body.appendChild(s);}</script>
        </div>
    </div>
</section>

<!-- Section Formulaire prochaines dates -->
<?php if ($formulaire_code) : ?>
<section style="background: #f8f9fa; padding: 60px 0;">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="color: #8E2183; font-size: 2.5rem; margin-bottom: 20px;">Recevez les prochaines dates de formation</h2>
            <p style="font-size: 1.1rem; color: #666;">
                Inscrivez-vous pour être informé des prochaines sessions et ne manquer aucune opportunité de vous former
            </p>
        </div>
        
        <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);">
            <?php echo $formulaire_code; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>