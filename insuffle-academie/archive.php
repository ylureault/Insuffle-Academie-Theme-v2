<?php
/**
 * Template pour les archives (Blog, Catégories, Tags)
 */

get_header(); ?>

<!-- Hero Section Blog -->
<div class="blog-hero">
    <div class="container">
        <h1 class="blog-hero-title">
            <?php
            if (is_category()) {
                single_cat_title('Catégorie : ');
            } elseif (is_tag()) {
                single_tag_title('Tag : ');
            } elseif (is_author()) {
                echo 'Articles de ' . get_the_author();
            } elseif (is_day()) {
                echo 'Archives du ' . get_the_date();
            } elseif (is_month()) {
                echo 'Archives de ' . get_the_date('F Y');
            } elseif (is_year()) {
                echo 'Archives de ' . get_the_date('Y');
            } else {
                echo 'Blog';
            }
            ?>
        </h1>

        <?php if (is_category() || is_tag()) : ?>
            <div class="blog-hero-description">
                <?php echo term_description(); ?>
            </div>
        <?php else : ?>
            <p class="blog-hero-description">
                Découvrez nos articles, réflexions et retours d'expérience sur la facilitation et l'intelligence collective
            </p>
        <?php endif; ?>
    </div>
</div>

<!-- Blog Grid -->
<div class="blog-container">
    <div class="container">

        <?php if (have_posts()) : ?>

            <div class="blog-grid">
                <?php
                while (have_posts()) :
                    the_post();
                ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="blog-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                                <?php
                                // Badge catégorie
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                ?>
                                    <span class="blog-card-category">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="blog-card-content">

                            <div class="blog-card-meta">
                                <span class="blog-card-date">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                    <?php echo get_the_date('d F Y'); ?>
                                </span>

                                <span class="blog-card-author">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    </svg>
                                    <?php the_author(); ?>
                                </span>

                                <?php if (get_comments_number() > 0) : ?>
                                    <span class="blog-card-comments">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                        </svg>
                                        <?php comments_number('0', '1', '%'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h2 class="blog-card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="blog-card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="blog-card-link">
                                Lire la suite
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </a>

                        </div>

                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="blog-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '← Précédent',
                    'next_text' => 'Suivant →',
                ));
                ?>
            </div>

        <?php else : ?>

            <div class="blog-no-posts">
                <div class="blog-no-posts-content">
                    <svg width="80" height="80" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                    </svg>
                    <h2>Aucun article trouvé</h2>
                    <p>Il n'y a pas encore d'articles dans cette section.</p>
                    <a href="<?php echo home_url('/'); ?>" class="btn">Retour à l'accueil</a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
