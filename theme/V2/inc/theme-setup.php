<?php
function insuffle_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'gallery', 'caption'));
    
    register_nav_menus(array(
        'primary' => 'Menu Principal',
        'footer' => 'Menu Footer',
    ));
}
add_action('after_setup_theme', 'insuffle_theme_setup');