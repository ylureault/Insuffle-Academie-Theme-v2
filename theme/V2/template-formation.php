<?php
/**
 * Template Name: Page Formation
 * Description: Template pour créer une page de formation
 */

get_header(); 

while (have_posts()) : the_post();
?>

<style>
:root {
    --primary: #8E2183;
    --secondary: #FFD466;
    --accent: #FFC0CB;
    --light: #FFFFFF;
    --dark: #333333;
    --grey: #F5F5F5;
}

/* Hero Formation */
.formation-hero {
    background: linear-gradient(135deg, #8E2183 0%, #6d1a66 100%);
    color: white;
    padding: 100px 0 150px;
    position: relative;
    overflow: hidden;
}

.formation-hero::before {
    content: '';
    position: absolute;
    top: -20%;
    right: -10%;
    width: 800px;
    height: 800px;
    background: radial-gradient(circle, rgba(255,212,102,0.2) 0%, transparent 70%);
    border-radius: 50%;
    z-index: 1;
}

.formation-hero::after {
    content: '';
    position: absolute;
    bottom: -15%;
    left: -5%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(255,192,203,0.15) 0%, transparent 70%);
    border-radius: 50%;
    z-index: 1;
}

.hero-content {
    display: flex;
    align-items: center;
    gap: 60px;
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.hero-text {
    flex: 1;
}

.hero-subtitle {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: #FFD466;
    font-weight: 600;
}

.formation-hero h1 {
    font-size: 4.5rem;
    font-weight: 800;
    margin-bottom: 30px;
    line-height: 1.1;
    color: white;
}

.hero-description {
    font-size: 1.2rem;
    margin-bottom: 40px;
    max-width: 600px;
    color: white;
    opacity: 1;
    line-height: 1.7;
}

.hero-image {
    flex: 1;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.hero-image-placeholder {
    width: 100%;
    max-width: 500px;
    height: 400px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    position: relative;
}

.hero-image-placeholder img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
}

.hero-stats {
    display: flex;
    gap: 40px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.hero-stat {
    text-align: left;
}

.hero-stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: #FFD466;
    line-height: 1;
}

.hero-stat-label {
    font-size: 1rem;
    color: white;
    opacity: 0.95;
    margin-top: 5px;
}

/* Info Bar */
.info-bar-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.info-bar {
    background-color: white;
    margin: -60px auto 0;
    max-width: 1000px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    position: relative;
    z-index: 10;
    padding: 30px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    text-align: center;
}

.info-item {
    padding: 15px;
}

.info-icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
    display: block;
}

.info-label {
    font-size: 0.9rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.info-value {
    font-size: 1.4rem;
    font-weight: 800;
    color: #8E2183;
}

.info-detail {
    font-size: 0.95rem;
    color: #777;
    margin-top: 5px;
}

/* Contenu de la formation */
.formation-content-wrapper {
    background: white;
    padding: 80px 0;
}

.formation-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Styles pour les blocs WordPress/Gutenberg */
.formation-container .wp-block-heading {
    color: var(--primary);
    font-weight: 700;
    margin-top: 50px;
    margin-bottom: 25px;
}

.formation-container h1,
.formation-container .wp-block-heading.has-huge-font-size {
    font-size: 2.5rem;
    border-bottom: 3px solid var(--secondary);
    padding-bottom: 15px;
    margin-top: 0;
}

.formation-container h2 {
    font-size: 2rem;
    position: relative;
    padding-left: 25px;
}

.formation-container h2::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 5px;
    height: 35px;
    background: var(--secondary);
    border-radius: 3px;
}

.formation-container h3 {
    font-size: 1.5rem;
    margin-top: 35px;
}

.formation-container h4 {
    font-size: 1.3rem;
    color: var(--dark);
    margin-top: 30px;
}

.formation-container p {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 20px;
    color: #555;
}

.formation-container ul,
.formation-container ol {
    margin: 20px 0;
    padding-left: 0;
}

.formation-container li {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 15px;
    color: #555;
}

.formation-container .wp-block-list:not(.has-background) li {
    position: relative;
    list-style: none;
    padding-left: 35px;
    margin-bottom: 12px;
}

.formation-container .wp-block-list:not(.has-background) li::before {
    content: '✓';
    position: absolute;
    left: 0;
    top: 2px;
    color: var(--primary);
    font-weight: bold;
    font-size: 1.2rem;
}

/* Blocs Cover (Hero des formations individuelles) */
.formation-container .wp-block-cover {
    margin: 0 0 40px 0;
    border-radius: 15px;
    overflow: hidden;
}

/* Blocs Colonnes */
.formation-container .wp-block-columns {
    margin: 40px 0;
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.formation-container .wp-block-column {
    background: var(--grey);
    padding: 30px;
    border-radius: 15px;
    flex: 1;
    min-width: 280px;
}

.formation-container .wp-block-columns.section-primary .wp-block-column,
.formation-container .section-primary .wp-block-column {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

/* Blocs Quote */
.formation-container blockquote,
.formation-container .wp-block-quote {
    background: linear-gradient(135deg, var(--grey) 0%, #fff 100%);
    border-left: 5px solid var(--primary);
    padding: 30px 35px;
    margin: 40px 0;
    border-radius: 15px;
    font-style: italic;
    font-size: 1.2rem;
    color: #666;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.formation-container .wp-block-quote.is-style-large {
    font-size: 1.3rem;
    padding: 35px 40px;
}

.formation-container .wp-block-quote p {
    color: var(--primary);
    font-weight: 500;
    margin-bottom: 20px;
}

.formation-container .wp-block-quote cite {
    color: var(--dark);
    font-weight: 600;
    font-style: normal;
    display: block;
    margin-top: 15px;
    font-size: 1rem;
}

.formation-container .wp-block-quote cite::before {
    content: '— ';
    color: var(--primary);
}

/* Blocs Groupe avec classes personnalisées */
.formation-container .section-grey {
    background: var(--grey);
    padding: 50px;
    border-radius: 20px;
    margin: 50px 0;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.formation-container .section-primary {
    background: linear-gradient(135deg, var(--primary) 0%, #9e3193 100%);
    color: white;
    padding: 50px;
    border-radius: 20px;
    margin: 50px 0;
    box-shadow: 0 10px 30px rgba(142, 33, 131, 0.3);
}

.formation-container .section-primary h2,
.formation-container .section-primary h3,
.formation-container .section-primary h4 {
    color: white;
}

.formation-container .section-primary h2::before {
    background: var(--secondary);
}

.formation-container .section-primary p {
    color: white;
    opacity: 0.95;
}

.formation-container .section-primary .wp-block-list li {
    color: white;
}

.formation-container .section-primary .wp-block-list li::before {
    color: var(--secondary);
}

/* Boutons */
.formation-container .wp-block-button {
    margin: 20px 10px;
}

.formation-container .wp-block-button__link {
    background: var(--secondary);
    color: var(--primary);
    padding: 15px 40px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: 2px solid var(--secondary);
}

.formation-container .wp-block-button__link:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.formation-container .wp-block-button.is-style-outline .wp-block-button__link {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.formation-container .wp-block-button.is-style-outline .wp-block-button__link:hover {
    background: var(--primary);
    color: white;
}

.formation-container .wp-block-buttons {
    margin: 30px 0;
}

.formation-container .wp-block-buttons.is-content-justification-center {
    justify-content: center;
    display: flex;
    flex-wrap: wrap;
}

/* Images */
.formation-container .wp-block-image {
    margin: 30px 0;
}

.formation-container .wp-block-image img {
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Spacer */
.formation-container .wp-block-spacer {
    display: block;
}

/* Tableaux */
.formation-container table,
.formation-container .wp-block-table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border-radius: 10px;
    overflow: hidden;
}

.formation-container th {
    background: var(--primary);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.formation-container td {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.formation-container tr:hover {
    background: var(--grey);
}

/* Classes utilitaires */
.formation-container .text-center,
.formation-container .has-text-align-center {
    text-align: center;
}

.formation-container .p-3 {
    padding: 30px;
}

/* Responsive */
@media (max-width: 992px) {
    .formation-hero h1 {
        font-size: 2.5rem;
    }

    .formation-container .wp-block-columns {
        flex-direction: column;
    }

    .formation-container .wp-block-column {
        min-width: 100%;
    }

    .formation-container .section-grey,
    .formation-container .section-primary {
        padding: 40px 30px;
    }
}

@media (max-width: 768px) {
    .formation-hero {
        padding: 80px 0 120px;
    }

    .formation-hero h1 {
        font-size: 2.5rem;
    }

    .hero-subtitle {
        font-size: 1.3rem;
    }

    .hero-content {
        flex-direction: column;
        gap: 40px;
    }

    .hero-image {
        order: -1;
        width: 100%;
    }

    .hero-image-placeholder {
        height: 300px;
    }

    .hero-stats {
        flex-wrap: wrap;
        gap: 20px;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .formation-content-wrapper {
        padding: 60px 0;
    }

    .formation-container h1 {
        font-size: 2rem;
    }

    .formation-container h2 {
        font-size: 1.6rem;
    }

    .formation-container h3 {
        font-size: 1.3rem;
    }

    .formation-container .wp-block-button__link {
        padding: 12px 30px;
        font-size: 1rem;
    }

    .formation-container .section-grey,
    .formation-container .section-primary {
        padding: 30px 20px;
        margin: 30px 0;
    }

    .formation-container .wp-block-quote {
        padding: 25px 20px;
        font-size: 1.1rem;
    }
}

/* Styles pour améliorer le rendu des sections */
.formation-container > *:first-child {
    margin-top: 0;
}

.formation-container > *:last-child {
    margin-bottom: 0;
}
</style>

<!-- Hero de la page -->
<?php
// Récupérer les champs personnalisés du hero
$hero_subtitle = get_post_meta(get_the_ID(), '_page_hero_subtitle', true);
$hero_description = get_post_meta(get_the_ID(), '_page_hero_description', true);
$hero_image = get_post_meta(get_the_ID(), '_page_hero_image', true);
$hero_stat1_number = get_post_meta(get_the_ID(), '_page_hero_stat1_number', true);
$hero_stat1_label = get_post_meta(get_the_ID(), '_page_hero_stat1_label', true);
$hero_stat2_number = get_post_meta(get_the_ID(), '_page_hero_stat2_number', true);
$hero_stat2_label = get_post_meta(get_the_ID(), '_page_hero_stat2_label', true);
$hero_stat3_number = get_post_meta(get_the_ID(), '_page_hero_stat3_number', true);
$hero_stat3_label = get_post_meta(get_the_ID(), '_page_hero_stat3_label', true);
$info_bar_item1_icon = get_post_meta(get_the_ID(), '_page_info_bar_item1_icon', true);
$info_bar_item1_label = get_post_meta(get_the_ID(), '_page_info_bar_item1_label', true);
$info_bar_item1_value = get_post_meta(get_the_ID(), '_page_info_bar_item1_value', true);
$info_bar_item1_detail = get_post_meta(get_the_ID(), '_page_info_bar_item1_detail', true);
$info_bar_item2_icon = get_post_meta(get_the_ID(), '_page_info_bar_item2_icon', true);
$info_bar_item2_label = get_post_meta(get_the_ID(), '_page_info_bar_item2_label', true);
$info_bar_item2_value = get_post_meta(get_the_ID(), '_page_info_bar_item2_value', true);
$info_bar_item2_detail = get_post_meta(get_the_ID(), '_page_info_bar_item2_detail', true);
$info_bar_item3_icon = get_post_meta(get_the_ID(), '_page_info_bar_item3_icon', true);
$info_bar_item3_label = get_post_meta(get_the_ID(), '_page_info_bar_item3_label', true);
$info_bar_item3_value = get_post_meta(get_the_ID(), '_page_info_bar_item3_value', true);
$info_bar_item3_detail = get_post_meta(get_the_ID(), '_page_info_bar_item3_detail', true);
$info_bar_item4_icon = get_post_meta(get_the_ID(), '_page_info_bar_item4_icon', true);
$info_bar_item4_label = get_post_meta(get_the_ID(), '_page_info_bar_item4_label', true);
$info_bar_item4_value = get_post_meta(get_the_ID(), '_page_info_bar_item4_value', true);
$info_bar_item4_detail = get_post_meta(get_the_ID(), '_page_info_bar_item4_detail', true);
?>

<section class="formation-hero">
    <div class="hero-content">
        <div class="hero-text">
            <?php if ($hero_subtitle) : ?>
                <div class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></div>
            <?php endif; ?>

            <h1><?php the_title(); ?></h1>

            <?php if ($hero_description) : ?>
                <p class="hero-description"><?php echo esc_html($hero_description); ?></p>
            <?php elseif (has_excerpt()) : ?>
                <p class="hero-description"><?php the_excerpt(); ?></p>
            <?php endif; ?>

            <?php if ($hero_stat1_number || $hero_stat2_number || $hero_stat3_number) : ?>
            <div class="hero-stats">
                <?php if ($hero_stat1_number) : ?>
                <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo esc_html($hero_stat1_number); ?></div>
                    <div class="hero-stat-label"><?php echo esc_html($hero_stat1_label); ?></div>
                </div>
                <?php endif; ?>

                <?php if ($hero_stat2_number) : ?>
                <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo esc_html($hero_stat2_number); ?></div>
                    <div class="hero-stat-label"><?php echo esc_html($hero_stat2_label); ?></div>
                </div>
                <?php endif; ?>

                <?php if ($hero_stat3_number) : ?>
                <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo esc_html($hero_stat3_number); ?></div>
                    <div class="hero-stat-label"><?php echo esc_html($hero_stat3_label); ?></div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($hero_image) :
            $hero_image_url = wp_get_attachment_image_url($hero_image, 'large');
        ?>
        <div class="hero-image">
            <div class="hero-image-placeholder">
                <img src="<?php echo esc_url($hero_image_url); ?>" alt="<?php the_title(); ?>">
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Info Bar -->
<?php if ($info_bar_item1_value || $info_bar_item2_value || $info_bar_item3_value || $info_bar_item4_value) : ?>
<div class="info-bar-container">
    <div class="info-bar">
        <div class="info-grid">
            <?php if ($info_bar_item1_value) : ?>
            <div class="info-item">
                <?php if ($info_bar_item1_icon) : ?>
                    <span class="info-icon"><?php echo esc_html($info_bar_item1_icon); ?></span>
                <?php endif; ?>
                <?php if ($info_bar_item1_label) : ?>
                    <div class="info-label"><?php echo esc_html($info_bar_item1_label); ?></div>
                <?php endif; ?>
                <div class="info-value"><?php echo esc_html($info_bar_item1_value); ?></div>
                <?php if ($info_bar_item1_detail) : ?>
                    <div class="info-detail"><?php echo esc_html($info_bar_item1_detail); ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($info_bar_item2_value) : ?>
            <div class="info-item">
                <?php if ($info_bar_item2_icon) : ?>
                    <span class="info-icon"><?php echo esc_html($info_bar_item2_icon); ?></span>
                <?php endif; ?>
                <?php if ($info_bar_item2_label) : ?>
                    <div class="info-label"><?php echo esc_html($info_bar_item2_label); ?></div>
                <?php endif; ?>
                <div class="info-value"><?php echo esc_html($info_bar_item2_value); ?></div>
                <?php if ($info_bar_item2_detail) : ?>
                    <div class="info-detail"><?php echo esc_html($info_bar_item2_detail); ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($info_bar_item3_value) : ?>
            <div class="info-item">
                <?php if ($info_bar_item3_icon) : ?>
                    <span class="info-icon"><?php echo esc_html($info_bar_item3_icon); ?></span>
                <?php endif; ?>
                <?php if ($info_bar_item3_label) : ?>
                    <div class="info-label"><?php echo esc_html($info_bar_item3_label); ?></div>
                <?php endif; ?>
                <div class="info-value"><?php echo esc_html($info_bar_item3_value); ?></div>
                <?php if ($info_bar_item3_detail) : ?>
                    <div class="info-detail"><?php echo esc_html($info_bar_item3_detail); ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($info_bar_item4_value) : ?>
            <div class="info-item">
                <?php if ($info_bar_item4_icon) : ?>
                    <span class="info-icon"><?php echo esc_html($info_bar_item4_icon); ?></span>
                <?php endif; ?>
                <?php if ($info_bar_item4_label) : ?>
                    <div class="info-label"><?php echo esc_html($info_bar_item4_label); ?></div>
                <?php endif; ?>
                <div class="info-value"><?php echo esc_html($info_bar_item4_value); ?></div>
                <?php if ($info_bar_item4_detail) : ?>
                    <div class="info-detail"><?php echo esc_html($info_bar_item4_detail); ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Contenu de la page -->
<section class="formation-content-wrapper">
    <div class="formation-container">
        <?php the_content(); ?>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>