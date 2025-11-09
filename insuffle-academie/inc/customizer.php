<?php
function insuffle_customize_register($wp_customize) {
    $wp_customize->add_section('insuffle_colors', array(
        'title' => 'Couleurs du thème',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('primary_color', array(
        'default' => '#8E2183',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => 'Couleur primaire',
        'section' => 'insuffle_colors',
    )));
}
add_action('customize_register', 'insuffle_customize_register');