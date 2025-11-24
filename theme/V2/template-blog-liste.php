<?php
/**
 * Template Name: Blog > Liste Articles
 * Description: Template pour créer une page blog personnalisée avec tous les articles
 */

get_header(); ?>

<div id="primary" class="content-area page-blog">
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

    <!-- Contenu de la page (si du contenu est ajouté) -->
    <?php if (get_the_content()) : ?>
        <section class="page-intro-content">
            <div class="container">
                <div class="intro-text">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php endwhile; // Fin du loop de la page ?>

    <!-- Grille d'articles de blog -->
    <section class="blog-section">
        <div class="container">
            <?php
            // Récupérer tous les articles
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $blog_query = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 9,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC'
            ));

            if ($blog_query->have_posts()) : ?>
                <div class="blog-grid">
                    <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="blog-card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    </a>
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) :
                                        $category = $categories[0];
                                    ?>
                                        <span class="blog-card-category"><?php echo esc_html($category->name); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="blog-card-content">
                                <div class="blog-card-meta">
                                    <span class="blog-date">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <span class="blog-author">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <?php the_author(); ?>
                                    </span>
                                </div>

                                <h2 class="blog-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="blog-card-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="blog-card-link">
                                    Lire la suite
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="blog-pagination">
                    <?php
                    $total_pages = $blog_query->max_num_pages;
                    if ($total_pages > 1) {
                        echo paginate_links(array(
                            'total' => $total_pages,
                            'current' => $paged,
                            'prev_text' => '&laquo; Précédent',
                            'next_text' => 'Suivant &raquo;',
                        ));
                    }
                    ?>
                </div>

            <?php else : ?>
                <div class="no-posts">
                    <p>Aucun article n'a été publié pour le moment.</p>
                </div>
            <?php endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <!-- CTA Formations -->
    <?php insuffle_display_formation_cta(); ?>
</div>

<style>
.page-intro-content {
    padding: 60px 0;
    background: #f9f9f9;
}

.intro-text {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    line-height: 1.8;
}

.no-posts {
    text-align: center;
    padding: 80px 20px;
    background: #f5f5f5;
    border-radius: 15px;
}

.no-posts p {
    font-size: 1.2rem;
    color: #666;
}
</style>

<?php get_footer(); ?>
