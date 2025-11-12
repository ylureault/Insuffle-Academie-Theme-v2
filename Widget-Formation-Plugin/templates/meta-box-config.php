<div class="wfm-config-container">
    <div class="wfm-section">
        <h3>🎯 Sélectionner les formations à afficher</h3>
        <p class="description">Cochez les formations que vous souhaitez afficher dans ce widget.</p>

        <div class="wfm-formations-list">
            <?php if (!empty($all_formations)): ?>
                <?php foreach ($all_formations as $formation): ?>
                    <label class="wfm-formation-item">
                        <input
                            type="checkbox"
                            name="wfm_formations[]"
                            value="<?php echo $formation->ID; ?>"
                            <?php checked(in_array($formation->ID, $formations)); ?>
                        >
                        <span class="formation-title"><?php echo esc_html($formation->post_title); ?></span>
                    </label>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune formation trouvée. <a href="<?php echo admin_url('post-new.php?post_type=programme-formation'); ?>">Créez votre première formation</a>.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="wfm-section">
        <h3>🎨 Options d'affichage</h3>

        <label class="wfm-checkbox">
            <input
                type="checkbox"
                name="wfm_show_logo_ia"
                value="1"
                <?php checked($show_logo_ia, '1'); ?>
            >
            <span>Afficher le logo Insufflé Académie</span>
        </label>

        <label class="wfm-checkbox">
            <input
                type="checkbox"
                name="wfm_show_logo_qualiopi"
                value="1"
                <?php checked($show_logo_qualiopi, '1'); ?>
            >
            <span>Afficher le logo Qualiopi</span>
        </label>
    </div>

    <div class="wfm-section wfm-info">
        <h4>ℹ️ Comment ça fonctionne ?</h4>
        <ul>
            <li>Sélectionnez une ou plusieurs formations</li>
            <li>Publiez le widget pour générer le code d'intégration</li>
            <li>Copiez le code et collez-le sur n'importe quel site</li>
            <li>Quand on clique sur une formation, ça ouvre la page formation sur Insufflé Académie</li>
        </ul>
    </div>
</div>
