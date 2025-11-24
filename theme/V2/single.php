<?php
/**
 * Template pour les pages standards
 * Design cohérent avec la charte Insuffle Académie
 */

get_header(); 

while (have_posts()) : the_post();
?>

<style>
/* Hero de page */
.page-hero {
    background: linear-gradient(135deg, #8E2183 0%, #9e3193 100%);
    color: white;
    padding: 100px 0 120px;
    position: relative;
    overflow: hidden;
}

.page-hero.has-featured-image {
    background-size: cover;
    background-position: center;
    background-blend-mode: multiply;
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
    color: white !important;
}

.page-intro {
    font-size: 1.3rem;
    line-height: 1.6;
    max-width: 800px;
    opacity: 0.95;
    animation: fadeInUp 0.6s ease 0.2s;
    animation-fill-mode: backwards;
    color: white;
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
    grid-template-columns: 1fr 300px;
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
}

.sidebar-widget h3 {
    color: #8E2183;
    font-size: 1.3rem;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #FFD466;
}

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
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s;
}

.sidebar-nav a:hover {
    background: #f8f9fa;
    color: #8E2183;
    transform: translateX(5px);
}

.sidebar-nav a::before {
    content: '▸';
    margin-right: 10px;
    color: #FFD466;
}

.sidebar-cta {
    background: linear-gradient(135deg, #8E2183 0%, #9e3193 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
}

.sidebar-cta h4 {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.sidebar-cta p {
    margin-bottom: 20px;
    opacity: 0.9;
}

.btn-sidebar {
    background: #FFD466;
    color: #8E2183;
    padding: 12px 25px;
    border-radius: 50px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    transition: transform 0.3s;
}

.btn-sidebar:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
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
}
</style>

<!-- Hero Section -->
<?php 
$featured_image_url = '';
$has_featured_image = '';
if (has_post_thumbnail()) {
    $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $has_featured_image = 'has-featured-image';
}
?>
<section class="page-hero <?php echo $has_featured_image; ?>" <?php if ($featured_image_url) : ?>style="background-image: url('<?php echo esc_url($featured_image_url); ?>');"<?php endif; ?>>
    <div class="page-hero-content">
        <!-- Fil d'Ariane -->
        <nav class="breadcrumb">
            <a href="<?php echo home_url(); ?>">Accueil</a>
            <span class="breadcrumb-separator">›</span>
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
    <div class="page-container <?php echo !is_active_sidebar('page-sidebar') ? 'full-width' : ''; ?>">
        
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
        
        <!-- Sidebar (optionnel) -->
        <?php if (is_active_sidebar('page-sidebar')) : ?>
        <aside class="page-sidebar">
            <!-- Navigation contextuelle -->
            <div class="sidebar-widget">
                <h3>Navigation</h3>
                <?php
                // Afficher les pages sœurs ou enfants
                $current_page_id = get_the_ID();
                $parent_id = wp_get_post_parent_id($current_page_id);
                
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
                <ul class="sidebar-nav">
                    <?php echo $pages; ?>
                </ul>
                <?php endif; ?>
            </div>
            
            <!-- Widget CTA -->
            <div class="sidebar-widget">
                <div class="sidebar-cta">
                    <h4>Besoin d'informations ?</h4>
                    <p>Notre équipe est là pour répondre à vos questions</p>
                    <a href="<?php echo home_url('/contact'); ?>" class="btn-sidebar">Nous contacter</a>
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
// Afficher le CTA seulement sur certaines pages
$show_cta_pages = array('mentions-legales', 'conditions-generales', 'accessibilite');
if (!in_array($post->post_name, $show_cta_pages)) : 
?>
<section class="page-cta">
    <div class="page-cta-content">
        <h2>Prêt à transformer votre organisation ?</h2>
        <p>Découvrez nos formations en facilitation et intelligence collective</p>
        <a href="<?php echo home_url('/formations'); ?>" class="btn-cta">Voir nos formations</a>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>