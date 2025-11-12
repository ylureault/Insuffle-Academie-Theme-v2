<div class="wrap">
    <h1>📝 Générateur d'Articles Insufflé Académie</h1>

    <div class="gar-header">
        <div class="gar-stats">
            <div class="gar-stat-box gar-total">
                <div class="gar-stat-number"><?php echo $total; ?></div>
                <div class="gar-stat-label">Idées totales</div>
            </div>
            <div class="gar-stat-box gar-pending">
                <div class="gar-stat-number"><?php echo $pending; ?></div>
                <div class="gar-stat-label">En attente</div>
            </div>
            <div class="gar-stat-box gar-published">
                <div class="gar-stat-number"><?php echo $published; ?></div>
                <div class="gar-stat-label">Publiés</div>
            </div>
        </div>

        <div class="gar-actions">
            <button type="button" class="button button-secondary" id="gar-regenerate-ideas">
                🔄 Régénérer les idées non publiées
            </button>
        </div>
    </div>

    <div class="gar-filters">
        <ul class="subsubsub">
            <li><a href="?page=generateur-articles&filter=all" <?php echo $filter === 'all' ? 'class="current"' : ''; ?>>Toutes (<?php echo $total; ?>)</a> |</li>
            <li><a href="?page=generateur-articles&filter=pending" <?php echo $filter === 'pending' ? 'class="current"' : ''; ?>>En attente (<?php echo $pending; ?>)</a> |</li>
            <li><a href="?page=generateur-articles&filter=published" <?php echo $filter === 'published' ? 'class="current"' : ''; ?>>Publiés (<?php echo $published; ?>)</a></li>
        </ul>

        <form method="get" class="gar-search-form">
            <input type="hidden" name="page" value="generateur-articles">
            <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Rechercher une idée...">
            <button type="submit" class="button">Rechercher</button>
        </form>
    </div>

    <div class="gar-ideas-list">
        <?php if (empty($ideas)): ?>
            <div class="gar-no-results">
                <p>Aucune idée trouvée.</p>
            </div>
        <?php else: ?>
            <?php foreach ($ideas as $idea): ?>
                <div class="gar-idea-card" data-id="<?php echo $idea->id; ?>">
                    <div class="gar-idea-header">
                        <h2 class="gar-idea-title"><?php echo esc_html($idea->title); ?></h2>
                        <div class="gar-idea-status <?php echo $idea->status; ?>">
                            <?php echo $idea->status === 'published' ? '✅ Publié' : '⏳ En attente'; ?>
                        </div>
                    </div>

                    <div class="gar-idea-meta">
                        <span class="gar-meta-item">📁 <?php echo esc_html($idea->category); ?></span>
                        <span class="gar-meta-item">📊 <?php echo number_format($idea->word_count); ?> mots</span>
                        <span class="gar-meta-item">🔗 <?php echo esc_html($idea->slug); ?></span>
                    </div>

                    <div class="gar-idea-excerpt">
                        <?php echo esc_html($idea->excerpt); ?>
                    </div>

                    <div class="gar-idea-seo">
                        <div class="gar-seo-item">
                            <strong>Meta Description:</strong>
                            <p><?php echo esc_html($idea->meta_description); ?></p>
                        </div>
                        <div class="gar-seo-item">
                            <strong>Mots-clés:</strong>
                            <p><?php echo esc_html($idea->meta_keywords); ?></p>
                        </div>
                    </div>

                    <div class="gar-idea-actions">
                        <button type="button" class="button gar-toggle-content">
                            👁️ Voir le contenu complet
                        </button>

                        <?php if ($idea->status === 'pending'): ?>
                            <button type="button" class="button button-primary gar-validate-btn" data-id="<?php echo $idea->id; ?>">
                                ✅ Valider et créer l'article
                            </button>
                        <?php else: ?>
                            <a href="<?php echo admin_url('post.php?post=' . $idea->post_id . '&action=edit'); ?>" class="button button-secondary">
                                ✏️ Modifier l'article
                            </a>
                        <?php endif; ?>

                        <button type="button" class="button button-link-delete gar-delete-btn" data-id="<?php echo $idea->id; ?>">
                            🗑️ Supprimer
                        </button>
                    </div>

                    <div class="gar-idea-content" style="display: none;">
                        <div class="gar-content-preview">
                            <?php echo wpautop($idea->content); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
