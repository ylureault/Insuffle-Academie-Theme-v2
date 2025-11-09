<?php
/**
 * Template pour les pages standards
 * Design cohérent avec la charte Insuffle Académie
 * Sidebar personnalisable avec widgets dynamiques
 */

get_header(); 

while (have_posts()) : the_post();

// Récupérer les métadonnées de la page pour personnalisation
$hide_sidebar = get_post_meta(get_the_ID(), '_hide_sidebar', true);
$sidebar_style = get_post_meta(get_the_ID(), '_sidebar_style', true) ?: 'default';
$hide_cta = get_post_meta(get_the_ID(), '_hide_cta', true);
?>

<style>
/* Hero de page */
.page-hero {
    background: linear-gradient(135deg, #8E2183 0%, #9e3193 100%);
    color: white !important;
    padding: 100px 0 120px;
    position: relative;
    overflow: hidden;
}

.page-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 600px;
    height: 600px;
    background: rgba(255, 212, 102, 0.1);
    border-radius: 50%;
}

.page-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: rgba(255, 192, 203, 0.05);
    border-radius: 50%;
}

.page-hero-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 30px;
    font-size: 0.95rem;
}

.breadcrumb a {
    color: #FFD466;
    text-decoration: none;
    transition: opacity 0.3s;
}

.breadcrumb a:hover {
    opacity: 0.8;
}

.breadcrumb-separator {
    color: rgba(255, 255, 255, 0.5);
}

.breadcrumb-current {
    color: rgba(255, 255, 255, 0.9);
}

.page-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.1;
    animation: fadeInUp 0.6s ease;
    color: #FFFFFF !important;
}

/* FORCE LE TITRE EN BLANC - PRIORITÉ ABSOLUE */
.page-hero .page-title,
.page-hero h1,
.page-hero-content .page-title,
.page-hero-content h1,
h1.page-title {
    color: #FFFFFF !important;
}

.page-intro {
    font-size: 1.3rem;
    line-height: 1.6;
    max-width: 800px;
    opacity: 0.95;
    animation: fadeInUp 0.6s ease 0.2s;
    animation-fill-mode: backwards;
    color: #FFFFFF !important;
}

.page-intro p {
    color: #FFFFFF !important;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Contenu principal */
.page-content-wrapper {
    padding: 80px 0;
    background: #f8f9fa;
    min-height: 60vh;
}

.page-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 40px;
}

.page-container.full-width {
    grid-template-columns: 1fr;
    max-width: 900px;
}

.page-main {
    background: white;
    border-radius: 15px;
    padding: 50px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* Styles du contenu WordPress */
.page-main h1 {
    color: #8E2183;
    font-size: 2.5rem;
    font-weight: 800;
    margin: 40px 0 20px;
    padding-bottom: 15px;
    border-bottom: 3px solid #FFD466;
}

.page-main h2 {
    color: #8E2183;
    font-size: 2rem;
    font-weight: 700;
    margin: 35px 0 20px;
    position: relative;
    padding-left: 20px;
}

.page-main h2::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 30px;
    background: #FFD466;
}

.page-main h3 {
    color: #333;
    font-size: 1.5rem;
    font-weight: 600;
    margin: 30px 0 15px;
}

.page-main p {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 20px;
    color: #555;
}

.page-main ul, .page-main ol {
    margin: 20px 0;
    padding-left: 30px;
}

.page-main li {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 10px;
    color: #555;
}

.page-main ul li {
    position: relative;
    list-style: none;
    padding-left: 25px;
}

.page-main ul li::before {
    content: '→';
    position: absolute;
    left: 0;
    color: #8E2183;
    font-weight: bold;
}

.page-main blockquote {
    background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
    border-left: 4px solid #8E2183;
    padding: 25px 30px;
    margin: 30px 0;
    border-radius: 10px;
    font-style: italic;
    font-size: 1.2rem;
    color: #666;
}

.page-main img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 30px 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.page-main table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border-radius: 10px;
    overflow: hidden;
}

.page-main th {
    background: #8E2183;
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.page-main td {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.page-main tr:hover {
    background: #f8f9fa;
}

/* Sidebar */
.page-sidebar {
    height: fit-content;
    position: sticky;
    top: 100px;
}

.sidebar-widget {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
}

.sidebar-widget:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.sidebar-widget h3 {
    color: #8E2183;
    font-size: 1.3rem;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #FFD466;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar-widget h3::before {
    content: '◆';
    color: #FFD466;
    font-size: 0.8rem;
}

/* Widget Navigation */
.sidebar-nav {
    list-style: none;
    padding: 0;
}

.sidebar-nav li {
    margin-bottom: 12px;
}

.sidebar-nav a {
    color: #666;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s;
    font-size: 0.95rem;
}

.sidebar-nav a:hover,
.sidebar-nav a.current-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
    color: #8E2183;
    transform: translateX(5px);
    box-shadow: 0 2px 10px rgba(142, 33, 131, 0.1);
}

.sidebar-nav a::before {
    content: '▸';
    margin-right: 10px;
    color: #FFD466;
    transition: transform 0.3s;
}

.sidebar-nav a:hover::before {
    transform: translateX(3px);
}

/* Widget CTA */
.sidebar-cta {
    background: linear-gradient(135deg, #8E2183 0%, #9e3193 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
}

.sidebar-cta h4 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    font-weight: 700;
}

.sidebar-cta p {
    margin-bottom: 20px;
    opacity: 0.95;
    line-height: 1.6;
}

.btn-sidebar {
    background: #FFD466;
    color: #8E2183;
    padding: 12px 30px;
    border-radius: 50px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-sidebar:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    background: #ffd966;
}

/* Widget Info Box */
.sidebar-info-box {
    background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
    border-left: 4px solid #8E2183;
    padding: 20px;
    border-radius: 10px;
}

.sidebar-info-box .info-icon {
    font-size: 2rem;
    color: #8E2183;
    margin-bottom: 10px;
}

.sidebar-info-box h4 {
    color: #8E2183;
    font-size: 1.1rem;
    margin-bottom: 10px;
    font-weight: 600;
}

.sidebar-info-box p {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.6;
    margin: 0;
}

/* Widget Liste avec icônes */
.sidebar-icon-list {
    list-style: none;
    padding: 0;
}

.sidebar-icon-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 8px;
    transition: background 0.3s;
}

.sidebar-icon-list li:hover {
    background: #f8f9fa;
}

.sidebar-icon-list .icon {
    color: #8E2183;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.sidebar-icon-list .text {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.5;
}

/* Widget Contact rapide */
.sidebar-contact {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s;
}

.contact-item:hover {
    background: #8E2183;
    color: white;
    transform: translateX(5px);
}

.contact-item .icon {
    color: #FFD466;
    font-size: 1.3rem;
}

.contact-item a {
    color: inherit;
    text-decoration: none;
    font-size: 0.95rem;
}

/* Widget Téléchargements */
.sidebar-downloads {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.download-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    background: #f8f9fa;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s;
}

.download-item:hover {
    background: #8E2183;
    color: white;
    transform: translateX(5px);
}

.download-item .icon {
    color: #FFD466;
    font-size: 1.5rem;
}

.download-item .text {
    flex: 1;
}

.download-item .title {
    font-weight: 600;
    font-size: 0.95rem;
    display: block;
    margin-bottom: 3px;
}

.download-item .size {
    font-size: 0.85rem;
    opacity: 0.7;
}

/* Widget Stats */
.sidebar-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.stat-item {
    text-align: center;
    padding: 15px;
    background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
    border-radius: 10px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: #8E2183;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.85rem;
    color: #666;
}

/* Call to Action en bas de page */
.page-cta {
    background: #8E2183;
    padding: 60px 0;
    text-align: center;
}

.page-cta-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 20px;
}

.page-cta h2 {
    color: white;
    font-size: 2.5rem;
    margin-bottom: 20px;
}

.page-cta p {
    color: white;
    font-size: 1.2rem;
    margin-bottom: 30px;
    opacity: 0.9;
}

.btn-cta {
    background: #FFD466;
    color: #8E2183;
    padding: 15px 40px;
    border-radius: 50px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s;
}

.btn-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

/* Responsive */
@media (max-width: 992px) {
    .page-container {
        grid-template-columns: 1fr;
    }
    
    .page-sidebar {
        position: static;
        margin-top: 40px;
    }
    
    .page-title {
        font-size: 2.5rem;
    }
    
    .page-main {
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .page-main h1 {
        font-size: 1.8rem;
    }
    
    .page-main h2 {
        font-size: 1.5rem;
    }
    
    .sidebar-stats {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Hero Section -->
<section class="page-hero">
    <div class="page-hero-content">
        <!-- Fil d'Ariane -->
        <nav class="breadcrumb">
            <a href="<?php echo home_url(); ?>">Accueil</a>
            <span class="breadcrumb-separator">›</span>
            <?php
            // Afficher le parent si existe
            $parent_id = wp_get_post_parent_id(get_the_ID());
            if ($parent_id) :
            ?>
                <a href="<?php echo get_permalink($parent_id); ?>"><?php echo get_the_title($parent_id); ?></a>
                <span class="breadcrumb-separator">›</span>
            <?php endif; ?>
            <span class="breadcrumb-current"><?php the_title(); ?></span>
        </nav>
        
        <!-- Titre de la page -->
        <h1 class="page-title"><?php the_title(); ?></h1>
        
        <!-- Introduction si excerpt disponible -->
        <?php if (has_excerpt()) : ?>
            <div class="page-intro">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Contenu principal -->
<section class="page-content-wrapper">
    <div class="page-container <?php echo ($hide_sidebar || !is_active_sidebar('page-sidebar')) ? 'full-width' : ''; ?>">
        
        <!-- Contenu de la page -->
        <article class="page-main">
            <?php the_content(); ?>
            
            <?php
            // Pagination pour les pages divisées
            wp_link_pages(array(
                'before' => '<div class="page-links"><span>Pages :</span>',
                'after' => '</div>',
                'link_before' => '<span>',
                'link_after' => '</span>',
            ));
            ?>
        </article>
        
        <!-- Sidebar (si activé) -->
        <?php if (!$hide_sidebar && is_active_sidebar('page-sidebar')) : ?>
        <aside class="page-sidebar">
            
            <!-- Widget Navigation contextuelle -->
            <?php
            $current_page_id = get_the_ID();
            $parent_id = wp_get_post_parent_id($current_page_id);
            
            // Construire la liste de pages
            if ($parent_id) {
                // Si la page a un parent, afficher les pages sœurs
                $pages = wp_list_pages(array(
                    'child_of' => $parent_id,
                    'title_li' => '',
                    'echo' => false,
                    'sort_column' => 'menu_order',
                ));
            } else {
                // Sinon afficher les pages enfants
                $pages = wp_list_pages(array(
                    'child_of' => $current_page_id,
                    'title_li' => '',
                    'echo' => false,
                    'sort_column' => 'menu_order',
                ));
            }
            
            if ($pages) :
            ?>
            <div class="sidebar-widget">
                <h3>Navigation</h3>
                <ul class="sidebar-nav">
                    <?php echo $pages; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <!-- Widget Info Box personnalisé -->
            <?php
            $info_title = get_post_meta(get_the_ID(), '_sidebar_info_title', true);
            $info_content = get_post_meta(get_the_ID(), '_sidebar_info_content', true);
            if ($info_title || $info_content) :
            ?>
            <div class="sidebar-widget">
                <div class="sidebar-info-box">
                    <div class="info-icon">ℹ️</div>
                    <?php if ($info_title) : ?>
                        <h4><?php echo esc_html($info_title); ?></h4>
                    <?php endif; ?>
                    <?php if ($info_content) : ?>
                        <p><?php echo wp_kses_post($info_content); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Widget Contact rapide -->
            <div class="sidebar-widget">
                <h3>Contact rapide</h3>
                <div class="sidebar-contact">
                    <div class="contact-item">
                        <span class="icon">📞</span>
                        <a href="tel:+33123456789">01 23 45 67 89</a>
                    </div>
                    <div class="contact-item">
                        <span class="icon">✉️</span>
                        <a href="mailto:contact@insuffle-academie.com">contact@insuffle-academie.com</a>
                    </div>
                    <div class="contact-item">
                        <span class="icon">📍</span>
                        <span>Deauville, Normandie</span>
                    </div>
                </div>
            </div>
            
            <!-- Widget CTA -->
            <div class="sidebar-widget">
                <div class="sidebar-cta">
                    <h4>Besoin d'informations ?</h4>
                    <p>Notre équipe est là pour répondre à vos questions et vous accompagner</p>
                    <a href="<?php echo home_url('/contact'); ?>" class="btn-sidebar">Nous contacter</a>
                </div>
            </div>
            
            <!-- Widget Stats -->
            <div class="sidebar-widget">
                <h3>Nos chiffres clés</h3>
                <div class="sidebar-stats">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Professionnels formés</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Satisfaction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">5</div>
                        <div class="stat-label">Formations</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Ans d'expérience</div>
                    </div>
                </div>
            </div>
            
            <!-- Widgets dynamiques -->
            <?php dynamic_sidebar('page-sidebar'); ?>
            
        </aside>
        <?php endif; ?>
        
    </div>
</section>

<!-- Call to Action -->
<?php
// Déterminer si c'est une page de formation
$is_formation_page = false;
$parent_id = wp_get_post_parent_id(get_the_ID());

// Vérifier si le parent est "Formations"
if ($parent_id) {
    $parent_slug = get_post_field('post_name', $parent_id);
    if (stripos($parent_slug, 'formation') !== false) {
        $is_formation_page = true;
    }
}

// Ou si le slug de la page contient "formation"
if (stripos($post->post_name, 'formation') !== false) {
    $is_formation_page = true;
}

// Ne pas afficher le CTA sur certaines pages ou si désactivé
$exclude_cta_pages = array('mentions-legales', 'conditions-generales', 'accessibilite', 'contact', 'formations');

if (!$hide_cta && !in_array($post->post_name, $exclude_cta_pages)) :

    if ($is_formation_page) {
        // CTA paramétrable pour les formations
        insuffle_display_formation_cta();
    } else {
        // CTA par défaut pour les autres pages
        ?>
        <section class="page-cta">
            <div class="page-cta-content">
                <h2>Prêt à transformer votre organisation ?</h2>
                <p>Découvrez nos formations en facilitation et intelligence collective</p>
                <a href="<?php echo home_url('/formations'); ?>" class="btn-cta">Voir nos formations</a>
            </div>
        </section>
        <?php
    }

endif;
?>

<?php endwhile; ?>

<?php get_footer(); ?>
