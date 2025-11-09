<?php
/**
 * Template: Tableau de bord
 * Variables disponibles: $stats, $upcoming, $formations
 */

if (!defined('ABSPATH')) exit;
?>

<div class="wrap cf-dashboard">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-calendar-alt"></span>
        <?php _e('Tableau de bord - Agenda Formation', 'calendrier-formation'); ?>
    </h1>

    <!-- Widget de bienvenue -->
    <div class="cf-welcome-panel">
        <div class="cf-welcome-content">
            <h2><?php _e('Bienvenue dans Calendrier Formation !', 'calendrier-formation'); ?></h2>
            <p class="about-description">
                <?php _e('Gérez facilement vos sessions de formation et réservations. Voici les actions rapides pour commencer :', 'calendrier-formation'); ?>
            </p>
            <div class="cf-welcome-actions">
                <a href="?page=cf-calendar" class="cf-welcome-action">
                    <span class="dashicons dashicons-calendar"></span>
                    <strong><?php _e('Voir le calendrier', 'calendrier-formation'); ?></strong>
                    <span class="cf-action-desc"><?php _e('Vue d\'ensemble des sessions', 'calendrier-formation'); ?></span>
                </a>
                <a href="?page=cf-sessions" class="cf-welcome-action">
                    <span class="dashicons dashicons-plus-alt"></span>
                    <strong><?php _e('Créer une session', 'calendrier-formation'); ?></strong>
                    <span class="cf-action-desc"><?php _e('Ajouter une nouvelle session', 'calendrier-formation'); ?></span>
                </a>
                <a href="?page=cf-help" class="cf-welcome-action">
                    <span class="dashicons dashicons-book-alt"></span>
                    <strong><?php _e('Documentation', 'calendrier-formation'); ?></strong>
                    <span class="cf-action-desc"><?php _e('Guides et shortcodes', 'calendrier-formation'); ?></span>
                </a>
                <a href="?page=cf-preview" class="cf-welcome-action">
                    <span class="dashicons dashicons-visibility"></span>
                    <strong><?php _e('Tester les shortcodes', 'calendrier-formation'); ?></strong>
                    <span class="cf-action-desc"><?php _e('Aperçu en temps réel', 'calendrier-formation'); ?></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="cf-stats-grid">
        <div class="cf-stat-card cf-stat-formations">
            <div class="cf-stat-icon">
                <span class="dashicons dashicons-book"></span>
            </div>
            <div class="cf-stat-content">
                <div class="cf-stat-value"><?php echo esc_html($stats['formations']); ?></div>
                <div class="cf-stat-label"><?php _e('Formations', 'calendrier-formation'); ?></div>
            </div>
        </div>

        <div class="cf-stat-card cf-stat-sessions">
            <div class="cf-stat-icon">
                <span class="dashicons dashicons-calendar"></span>
            </div>
            <div class="cf-stat-content">
                <div class="cf-stat-value"><?php echo esc_html($stats['total_sessions']); ?></div>
                <div class="cf-stat-label"><?php _e('Sessions totales', 'calendrier-formation'); ?></div>
            </div>
        </div>

        <div class="cf-stat-card cf-stat-upcoming">
            <div class="cf-stat-icon">
                <span class="dashicons dashicons-clock"></span>
            </div>
            <div class="cf-stat-content">
                <div class="cf-stat-value"><?php echo esc_html($stats['upcoming_sessions']); ?></div>
                <div class="cf-stat-label"><?php _e('Sessions à venir', 'calendrier-formation'); ?></div>
            </div>
        </div>

        <div class="cf-stat-card cf-stat-bookings">
            <div class="cf-stat-icon">
                <span class="dashicons dashicons-groups"></span>
            </div>
            <div class="cf-stat-content">
                <div class="cf-stat-value"><?php echo esc_html($stats['total_bookings']); ?></div>
                <div class="cf-stat-label"><?php _e('Réservations', 'calendrier-formation'); ?></div>
                <?php if ($stats['pending_bookings'] > 0): ?>
                    <div class="cf-stat-badge"><?php echo esc_html($stats['pending_bookings']); ?> en attente</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="cf-dashboard-content">
        <!-- Colonne gauche: Prochaines sessions -->
        <div class="cf-dashboard-left">
            <div class="cf-panel">
                <div class="cf-panel-header">
                    <h2><?php _e('Prochaines sessions', 'calendrier-formation'); ?></h2>
                    <a href="?page=cf-calendar" class="button button-secondary">
                        <?php _e('Voir le calendrier', 'calendrier-formation'); ?>
                    </a>
                </div>
                <div class="cf-panel-body">
                    <?php if (!empty($upcoming)): ?>
                        <div class="cf-sessions-list">
                            <?php foreach ($upcoming as $session): ?>
                                <?php
                                $date_debut = new DateTime($session->date_debut);
                                $is_full = $session->places_disponibles <= 0;
                                $is_limited = $session->places_disponibles <= 3 && !$is_full;
                                ?>
                                <div class="cf-session-item">
                                    <div class="cf-session-date">
                                        <div class="cf-session-day"><?php echo $date_debut->format('d'); ?></div>
                                        <div class="cf-session-month"><?php echo $date_debut->format('M'); ?></div>
                                    </div>
                                    <div class="cf-session-details">
                                        <div class="cf-session-title">
                                            <strong><?php echo esc_html($session->formation_title); ?></strong>
                                            <?php if ($is_full): ?>
                                                <span class="cf-badge cf-badge-full"><?php _e('Complet', 'calendrier-formation'); ?></span>
                                            <?php elseif ($is_limited): ?>
                                                <span class="cf-badge cf-badge-warning"><?php _e('Places limitées', 'calendrier-formation'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="cf-session-subtitle"><?php echo esc_html($session->session_title); ?></div>
                                        <div class="cf-session-meta">
                                            <span class="dashicons dashicons-calendar"></span>
                                            <?php echo $date_debut->format('d/m/Y'); ?>
                                            &nbsp;|&nbsp;
                                            <span class="dashicons dashicons-location"></span>
                                            <?php echo $session->type_location === 'distance' ? __('À distance', 'calendrier-formation') : __('Présentiel', 'calendrier-formation'); ?>
                                            &nbsp;|&nbsp;
                                            <span class="dashicons dashicons-groups"></span>
                                            <?php echo esc_html($session->places_disponibles . '/' . $session->places_total); ?> places
                                        </div>
                                    </div>
                                    <div class="cf-session-actions">
                                        <a href="?page=cf-sessions&session_id=<?php echo $session->id; ?>" class="button button-small">
                                            <?php _e('Modifier', 'calendrier-formation'); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="cf-empty-state">
                            <span class="dashicons dashicons-calendar"></span>
                            <p><?php _e('Aucune session à venir', 'calendrier-formation'); ?></p>
                            <a href="?page=cf-sessions" class="button button-primary"><?php _e('Créer une session', 'calendrier-formation'); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Colonne droite: Formations -->
        <div class="cf-dashboard-right">
            <div class="cf-panel">
                <div class="cf-panel-header">
                    <h2><?php _e('Vos formations', 'calendrier-formation'); ?></h2>
                </div>
                <div class="cf-panel-body">
                    <?php if (!empty($formations)): ?>
                        <div class="cf-formations-list">
                            <?php foreach ($formations as $formation): ?>
                                <div class="cf-formation-item">
                                    <div class="cf-formation-title">
                                        <strong><?php echo esc_html($formation['title']); ?></strong>
                                    </div>
                                    <div class="cf-formation-stats">
                                        <span class="cf-formation-stat">
                                            <span class="dashicons dashicons-calendar"></span>
                                            <?php echo esc_html($formation['total_sessions']); ?> sessions
                                        </span>
                                        <span class="cf-formation-stat">
                                            <span class="dashicons dashicons-clock"></span>
                                            <?php echo esc_html($formation['upcoming_sessions']); ?> à venir
                                        </span>
                                    </div>
                                    <?php if ($formation['next_session']): ?>
                                        <?php $next_date = new DateTime($formation['next_session']->date_debut); ?>
                                        <div class="cf-formation-next">
                                            <?php _e('Prochaine:', 'calendrier-formation'); ?>
                                            <?php echo $next_date->format('d/m/Y'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="cf-formation-actions">
                                        <a href="<?php echo esc_url($formation['url']); ?>" class="button button-small" target="_blank">
                                            <?php _e('Voir', 'calendrier-formation'); ?>
                                        </a>
                                        <a href="?page=cf-sessions&formation_id=<?php echo $formation['id']; ?>" class="button button-small button-primary">
                                            <?php _e('Gérer sessions', 'calendrier-formation'); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="cf-empty-state">
                            <span class="dashicons dashicons-book"></span>
                            <p><?php _e('Aucune formation détectée', 'calendrier-formation'); ?></p>
                            <p class="description">
                                <?php printf(
                                    __('Créez des pages enfants de la page "Formations" (ID: %d) pour commencer.', 'calendrier-formation'),
                                    get_option('cf_settings')['formations_parent_id'] ?? 51
                                ); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
