<?php
function insuffle_meta_tags() {
    $description = is_front_page() ? 
        "Formation facilitation et intelligence collective à Deauville." : 
        get_bloginfo('description');
    ?>
    <meta name="description" content="<?php echo esc_attr($description); ?>">
    <meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
    <?php
}
add_action('wp_head', 'insuffle_meta_tags', 1);