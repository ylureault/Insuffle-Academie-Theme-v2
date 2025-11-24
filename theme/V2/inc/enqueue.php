<?php
function insuffle_enqueue_scripts() {
    wp_enqueue_style('insuffle-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap');
    wp_enqueue_style('insuffle-main', get_template_directory_uri() . '/assets/css/main.css', array(), '2.0.0');
    wp_enqueue_style('insuffle-style', get_stylesheet_uri(), array('insuffle-main'), '2.0.0');
    wp_enqueue_script('insuffle-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '2.0.0', true);
}
add_action('wp_enqueue_scripts', 'insuffle_enqueue_scripts');