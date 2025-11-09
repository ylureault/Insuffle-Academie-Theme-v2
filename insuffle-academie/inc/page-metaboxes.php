<?php
/**
 * Meta boxes pour les pages (template Formation)
 * Permet de configurer le hero header depuis l'éditeur de page
 */

if (!defined('ABSPATH')) exit;

// Ajouter les metaboxes uniquement pour les pages
function insuffle_add_page_metaboxes() {
    add_meta_box(
        'page_hero_config',
        'Configuration du Hero Header',
        'insuffle_page_hero_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'insuffle_add_page_metaboxes');

// Callback pour la configuration du hero
function insuffle_page_hero_callback($post) {
    wp_nonce_field('insuffle_page_hero_save', 'insuffle_page_hero_nonce');

    // Récupérer les valeurs existantes
    $hero_subtitle = get_post_meta($post->ID, '_page_hero_subtitle', true);
    $hero_description = get_post_meta($post->ID, '_page_hero_description', true);
    $hero_image = get_post_meta($post->ID, '_page_hero_image', true);

    // Statistiques
    $hero_stat1_number = get_post_meta($post->ID, '_page_hero_stat1_number', true);
    $hero_stat1_label = get_post_meta($post->ID, '_page_hero_stat1_label', true);
    $hero_stat2_number = get_post_meta($post->ID, '_page_hero_stat2_number', true);
    $hero_stat2_label = get_post_meta($post->ID, '_page_hero_stat2_label', true);
    $hero_stat3_number = get_post_meta($post->ID, '_page_hero_stat3_number', true);
    $hero_stat3_label = get_post_meta($post->ID, '_page_hero_stat3_label', true);

    // Info bar items
    $info_bar_item1_icon = get_post_meta($post->ID, '_page_info_bar_item1_icon', true);
    $info_bar_item1_label = get_post_meta($post->ID, '_page_info_bar_item1_label', true);
    $info_bar_item1_value = get_post_meta($post->ID, '_page_info_bar_item1_value', true);
    $info_bar_item1_detail = get_post_meta($post->ID, '_page_info_bar_item1_detail', true);

    $info_bar_item2_icon = get_post_meta($post->ID, '_page_info_bar_item2_icon', true);
    $info_bar_item2_label = get_post_meta($post->ID, '_page_info_bar_item2_label', true);
    $info_bar_item2_value = get_post_meta($post->ID, '_page_info_bar_item2_value', true);
    $info_bar_item2_detail = get_post_meta($post->ID, '_page_info_bar_item2_detail', true);

    $info_bar_item3_icon = get_post_meta($post->ID, '_page_info_bar_item3_icon', true);
    $info_bar_item3_label = get_post_meta($post->ID, '_page_info_bar_item3_label', true);
    $info_bar_item3_value = get_post_meta($post->ID, '_page_info_bar_item3_value', true);
    $info_bar_item3_detail = get_post_meta($post->ID, '_page_info_bar_item3_detail', true);

    $info_bar_item4_icon = get_post_meta($post->ID, '_page_info_bar_item4_icon', true);
    $info_bar_item4_label = get_post_meta($post->ID, '_page_info_bar_item4_label', true);
    $info_bar_item4_value = get_post_meta($post->ID, '_page_info_bar_item4_value', true);
    $info_bar_item4_detail = get_post_meta($post->ID, '_page_info_bar_item4_detail', true);
    ?>

    <style>
        .hero-config-section {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #8E2183;
        }
        .hero-config-section h4 {
            margin-top: 0;
            color: #8E2183;
        }
        .hero-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        .hero-stat-box {
            background: white;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .info-bar-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        .info-bar-item-box {
            background: white;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .info-bar-item-box input[type="text"] {
            width: 100%;
            margin-bottom: 5px;
        }
    </style>

    <div class="hero-config-section">
        <h4>🎯 Contenu du Hero</h4>
        <table class="form-table">
            <tr>
                <th><label for="page_hero_subtitle">Sous-titre</label></th>
                <td>
                    <input type="text" id="page_hero_subtitle" name="page_hero_subtitle"
                           value="<?php echo esc_attr($hero_subtitle); ?>" class="large-text"
                           placeholder="Ex: 🎨 Formation Sketchnote" />
                    <p class="description">Sous-titre affiché au-dessus du titre principal (peut inclure un emoji)</p>
                </td>
            </tr>

            <tr>
                <th><label for="page_hero_description">Description</label></th>
                <td>
                    <textarea id="page_hero_description" name="page_hero_description"
                              rows="3" class="large-text"
                              placeholder="Apprenez la prise de notes visuelles..."><?php echo esc_textarea($hero_description); ?></textarea>
                    <p class="description">Paragraphe descriptif affiché dans le hero</p>
                </td>
            </tr>

            <tr>
                <th><label for="page_hero_image">Image du Hero</label></th>
                <td>
                    <div class="hero-image-upload">
                        <input type="hidden" id="page_hero_image" name="page_hero_image" value="<?php echo esc_attr($hero_image); ?>" />
                        <button type="button" class="button hero-image-upload-btn">Choisir une image</button>
                        <button type="button" class="button hero-image-remove-btn" <?php echo empty($hero_image) ? 'style="display:none;"' : ''; ?>>Retirer l'image</button>
                        <div class="hero-image-preview" style="margin-top: 10px;">
                            <?php if ($hero_image) :
                                $image_url = wp_get_attachment_image_url($hero_image, 'medium');
                            ?>
                            <img src="<?php echo esc_url($image_url); ?>" style="max-width: 300px; height: auto; border-radius: 10px;" />
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="description">Image affichée à droite du hero (recommandé: 500x400px)</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="hero-config-section">
        <h4>📊 Statistiques du Hero</h4>
        <p class="description">3 statistiques affichées sous le texte du hero</p>

        <div class="hero-stats-grid">
            <div class="hero-stat-box">
                <label><strong>Statistique 1</strong></label>
                <input type="text" name="page_hero_stat1_number"
                       value="<?php echo esc_attr($hero_stat1_number); ?>"
                       placeholder="14h" style="width: 100%; margin-bottom: 5px;" />
                <input type="text" name="page_hero_stat1_label"
                       value="<?php echo esc_attr($hero_stat1_label); ?>"
                       placeholder="de formation" style="width: 100%;" />
            </div>

            <div class="hero-stat-box">
                <label><strong>Statistique 2</strong></label>
                <input type="text" name="page_hero_stat2_number"
                       value="<?php echo esc_attr($hero_stat2_number); ?>"
                       placeholder="2" style="width: 100%; margin-bottom: 5px;" />
                <input type="text" name="page_hero_stat2_label"
                       value="<?php echo esc_attr($hero_stat2_label); ?>"
                       placeholder="jours intensifs" style="width: 100%;" />
            </div>

            <div class="hero-stat-box">
                <label><strong>Statistique 3</strong></label>
                <input type="text" name="page_hero_stat3_number"
                       value="<?php echo esc_attr($hero_stat3_number); ?>"
                       placeholder="70%" style="width: 100%; margin-bottom: 5px;" />
                <input type="text" name="page_hero_stat3_label"
                       value="<?php echo esc_attr($hero_stat3_label); ?>"
                       placeholder="mémorisation en +" style="width: 100%;" />
            </div>
        </div>
    </div>

    <div class="hero-config-section">
        <h4>ℹ️ Barre d'informations</h4>
        <p class="description">4 items affichés dans la barre d'informations sous le hero</p>

        <div class="info-bar-grid">
            <div class="info-bar-item-box">
                <label><strong>Item 1</strong></label>
                <input type="text" name="page_info_bar_item1_icon"
                       value="<?php echo esc_attr($info_bar_item1_icon); ?>"
                       placeholder="Icône (emoji): ⏱️" />
                <input type="text" name="page_info_bar_item1_label"
                       value="<?php echo esc_attr($info_bar_item1_label); ?>"
                       placeholder="Label: Durée" />
                <input type="text" name="page_info_bar_item1_value"
                       value="<?php echo esc_attr($info_bar_item1_value); ?>"
                       placeholder="Valeur: 14 heures" />
                <input type="text" name="page_info_bar_item1_detail"
                       value="<?php echo esc_attr($info_bar_item1_detail); ?>"
                       placeholder="Détail: 2 jours de formation" />
            </div>

            <div class="info-bar-item-box">
                <label><strong>Item 2</strong></label>
                <input type="text" name="page_info_bar_item2_icon"
                       value="<?php echo esc_attr($info_bar_item2_icon); ?>"
                       placeholder="Icône (emoji): 👥" />
                <input type="text" name="page_info_bar_item2_label"
                       value="<?php echo esc_attr($info_bar_item2_label); ?>"
                       placeholder="Label: Format" />
                <input type="text" name="page_info_bar_item2_value"
                       value="<?php echo esc_attr($info_bar_item2_value); ?>"
                       placeholder="Valeur: Présentiel" />
                <input type="text" name="page_info_bar_item2_detail"
                       value="<?php echo esc_attr($info_bar_item2_detail); ?>"
                       placeholder="Détail: ou distanciel" />
            </div>

            <div class="info-bar-item-box">
                <label><strong>Item 3</strong></label>
                <input type="text" name="page_info_bar_item3_icon"
                       value="<?php echo esc_attr($info_bar_item3_icon); ?>"
                       placeholder="Icône (emoji): 🎯" />
                <input type="text" name="page_info_bar_item3_label"
                       value="<?php echo esc_attr($info_bar_item3_label); ?>"
                       placeholder="Label: Niveau" />
                <input type="text" name="page_info_bar_item3_value"
                       value="<?php echo esc_attr($info_bar_item3_value); ?>"
                       placeholder="Valeur: Débutant" />
                <input type="text" name="page_info_bar_item3_detail"
                       value="<?php echo esc_attr($info_bar_item3_detail); ?>"
                       placeholder="Détail: Aucun prérequis" />
            </div>

            <div class="info-bar-item-box">
                <label><strong>Item 4</strong></label>
                <input type="text" name="page_info_bar_item4_icon"
                       value="<?php echo esc_attr($info_bar_item4_icon); ?>"
                       placeholder="Icône (emoji): 🎨" />
                <input type="text" name="page_info_bar_item4_label"
                       value="<?php echo esc_attr($info_bar_item4_label); ?>"
                       placeholder="Label: Pratique" />
                <input type="text" name="page_info_bar_item4_value"
                       value="<?php echo esc_attr($info_bar_item4_value); ?>"
                       placeholder="Valeur: 100%" />
                <input type="text" name="page_info_bar_item4_detail"
                       value="<?php echo esc_attr($info_bar_item4_detail); ?>"
                       placeholder="Détail: Théorie + Pratique" />
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Upload image
        $('.hero-image-upload-btn').on('click', function(e) {
            e.preventDefault();
            var custom_uploader = wp.media({
                title: 'Choisir une image pour le hero',
                button: { text: 'Utiliser cette image' },
                multiple: false
            }).on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#page_hero_image').val(attachment.id);
                $('.hero-image-preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; border-radius: 10px;" />');
                $('.hero-image-remove-btn').show();
            }).open();
        });

        // Remove image
        $('.hero-image-remove-btn').on('click', function(e) {
            e.preventDefault();
            $('#page_hero_image').val('');
            $('.hero-image-preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

// Sauvegarder les métadonnées
function insuffle_save_page_hero_meta($post_id) {
    // Vérifications de sécurité
    if (!isset($_POST['insuffle_page_hero_nonce']) ||
        !wp_verify_nonce($_POST['insuffle_page_hero_nonce'], 'insuffle_page_hero_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Liste des champs à sauvegarder
    $fields = array(
        'page_hero_subtitle',
        'page_hero_description',
        'page_hero_image',
        'page_hero_stat1_number',
        'page_hero_stat1_label',
        'page_hero_stat2_number',
        'page_hero_stat2_label',
        'page_hero_stat3_number',
        'page_hero_stat3_label',
        'page_info_bar_item1_icon',
        'page_info_bar_item1_label',
        'page_info_bar_item1_value',
        'page_info_bar_item1_detail',
        'page_info_bar_item2_icon',
        'page_info_bar_item2_label',
        'page_info_bar_item2_value',
        'page_info_bar_item2_detail',
        'page_info_bar_item3_icon',
        'page_info_bar_item3_label',
        'page_info_bar_item3_value',
        'page_info_bar_item3_detail',
        'page_info_bar_item4_icon',
        'page_info_bar_item4_label',
        'page_info_bar_item4_value',
        'page_info_bar_item4_detail',
    );

    // Sauvegarder chaque champ
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_page', 'insuffle_save_page_hero_meta');
