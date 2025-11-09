<?php
$formations = new WP_Query(array(
    'post_type' => 'formation',
    'posts_per_page' => 6,
));
?>
<section class="formations" id="formations">
    <div class="container">
        <h2>Nos formations</h2>
        <?php if ($formations->have_posts()) : ?>
            <div class="formations-cards">
                <?php while ($formations->have_posts()) : $formations->the_post(); ?>
                    <article class="formation-card">
                        <h3><?php the_title(); ?></h3>
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="btn">Découvrir</a>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php endif; wp_reset_postdata(); ?>
    </div>
</section>