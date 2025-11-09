<?php
/**
 * Template Admin: Gestion des templates d'emails
 * Variables: $templates, $edit_template
 */

if (!defined('ABSPATH')) exit;
?>

<div class="wrap cf-email-templates-page">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-email"></span>
        <?php _e('Templates d\'emails', 'calendrier-formation'); ?>
    </h1>

    <?php if ($edit_template): ?>
        <!-- Formulaire d'édition -->
        <div class="cf-template-editor">
            <h2>Éditer: <?php echo esc_html($edit_template->template_name); ?></h2>
            
            <form method="post" action="">
                <?php wp_nonce_field('cf_save_template'); ?>
                <input type="hidden" name="template_id" value="<?php echo $edit_template->id; ?>">
                <input type="hidden" name="cf_save_template" value="1">

                <table class="form-table">
                    <tr>
                        <th><label for="subject">Sujet de l'email</label></th>
                        <td>
                            <input type="text" name="subject" id="subject" value="<?php echo esc_attr($edit_template->subject); ?>" class="large-text">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="body">Corps de l'email</label></th>
                        <td>
                            <textarea name="body" id="body" rows="15" class="large-text code"><?php echo esc_textarea($edit_template->body); ?></textarea>
                            <p class="description">
                                <strong>Variables disponibles :</strong><br>
                                <?php 
                                $vars = explode(',', $edit_template->variables);
                                foreach ($vars as $var) {
                                    echo '<code>{{' . trim($var) . '}}</code> ';
                                }
                                ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="is_active">Actif</label></th>
                        <td>
                            <input type="checkbox" name="is_active" id="is_active" value="1" <?php checked($edit_template->is_active, 1); ?>>
                            <label for="is_active">Template actif</label>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <button type="submit" class="button button-primary">
                        <span class="dashicons dashicons-yes"></span> Enregistrer
                    </button>
                    <a href="?page=cf-email-templates" class="button">Retour</a>
                    <button type="button" class="button cf-test-email" data-template="<?php echo esc_attr($edit_template->template_key); ?>">
                        <span class="dashicons dashicons-email-alt"></span> Envoyer un test
                    </button>
                </p>
            </form>
        </div>

    <?php else: ?>
        <!-- Liste des templates -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Nom du template</th>
                    <th>Sujet</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($templates as $template): ?>
                <tr>
                    <td><?php echo $template->id; ?></td>
                    <td>
                        <strong><?php echo esc_html($template->template_name); ?></strong><br>
                        <small><code><?php echo esc_html($template->template_key); ?></code></small>
                    </td>
                    <td><?php echo esc_html($template->subject); ?></td>
                    <td>
                        <?php if ($template->is_active): ?>
                            <span class="cf-badge cf-badge-active">Actif</span>
                        <?php else: ?>
                            <span class="cf-badge cf-badge-inactive">Inactif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?page=cf-email-templates&edit=<?php echo $template->id; ?>" class="button button-small">Éditer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cf-help-box">
            <h3><span class="dashicons dashicons-info"></span> Aide sur les templates</h3>
            <p>Les variables entre accolades (ex: <code>{{prenom}}</code>) sont automatiquement remplacées par les données réelles lors de l'envoi.</p>
            <p><strong>Types de templates :</strong></p>
            <ul>
                <li><strong>booking_confirmation_client</strong> : Email envoyé au client après sa demande</li>
                <li><strong>booking_notification_admin</strong> : Email envoyé à l'admin lors d'une nouvelle demande</li>
                <li><strong>booking_confirmed</strong> : Email envoyé au client quand vous confirmez son inscription</li>
            </ul>
        </div>
    <?php endif; ?>
</div>

<style>
.cf-email-templates-page { max-width: 1200px; }
.cf-template-editor { background: #fff; padding: 20px; margin-top: 20px; border-radius: 8px; }
.cf-badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
.cf-badge-active { background: #d4edda; color: #155724; }
.cf-badge-inactive { background: #f8d7da; color: #721c24; }
.cf-help-box { background: #e7f3ff; border-left: 4px solid #2271b1; padding: 20px; margin-top: 20px; }
.cf-help-box h3 { margin-top: 0; display: flex; align-items: center; gap: 8px; }
.cf-help-box ul { margin-left: 20px; }
</style>

<script>
jQuery(document).ready(function($) {
    $('.cf-test-email').on('click', function() {
        const templateKey = $(this).data('template');
        const email = prompt('Entrez l\'adresse email pour le test:');
        
        if (email) {
            $.post(ajaxurl, {
                action: 'cf_send_test_email',
                template_key: templateKey,
                email: email,
                nonce: '<?php echo wp_create_nonce("cf_test_email"); ?>'
            }, function(response) {
                if (response.success) {
                    alert('✓ Email de test envoyé à ' + email);
                } else {
                    alert('✗ Erreur: ' + response.data.message);
                }
            });
        }
    });
});
</script>
