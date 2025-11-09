<?php
function insuffle_register_pattern_categories() {
    register_block_pattern_category(
        'insuffle-sections',
        array('label' => 'Sections Insuffle')
    );
}
add_action('init', 'insuffle_register_pattern_categories');

function insuffle_register_patterns() {
    // Les patterns seront enregistrés ici
}
add_action('init', 'insuffle_register_patterns');