<div class="wfm-code-container">
    <h4>🔗 URL du widget</h4>
    <input
        type="text"
        readonly
        value="<?php echo esc_url($widget_url); ?>"
        class="wfm-code-input"
        onclick="this.select()"
    >

    <h4>📦 Code iframe (recommandé)</h4>
    <p class="description">Le plus simple à intégrer. Fond transparent.</p>
    <textarea
        readonly
        rows="4"
        class="wfm-code-textarea"
        onclick="this.select()"
    ><iframe src="<?php echo esc_url($widget_url); ?>" width="100%" height="auto" frameborder="0" scrolling="no" style="min-height: 400px; background: transparent;" allowtransparency="true"></iframe></textarea>
    <button type="button" class="button wfm-copy-btn" data-clipboard-target=".wfm-code-textarea">
        📋 Copier le code
    </button>

    <h4>⚡ Code JavaScript</h4>
    <p class="description">Pour plus de flexibilité (auto-redimensionnement).</p>
    <textarea
        readonly
        rows="5"
        class="wfm-code-textarea-js"
        onclick="this.select()"
    ><div id="insuffle-widget-<?php echo $post->ID; ?>"></div>
<script>
(function(){var iframe=document.createElement('iframe');iframe.src='<?php echo esc_url($widget_url); ?>';iframe.style.width='100%';iframe.style.border='none';iframe.style.minHeight='400px';iframe.setAttribute('allowtransparency','true');document.getElementById('insuffle-widget-<?php echo $post->ID; ?>').appendChild(iframe);})();
</script></textarea>
    <button type="button" class="button wfm-copy-btn-js" data-clipboard-target=".wfm-code-textarea-js">
        📋 Copier le code JS
    </button>

    <div class="wfm-preview-section">
        <h4>👁️ Aperçu</h4>
        <a href="<?php echo esc_url($widget_url); ?>" target="_blank" class="button button-secondary">
            Voir le widget en plein écran
        </a>
    </div>
</div>

<style>
.wfm-code-container {
    padding: 15px;
}

.wfm-code-container h4 {
    margin-top: 15px;
    margin-bottom: 5px;
    font-size: 13px;
    font-weight: 600;
}

.wfm-code-container .description {
    margin-bottom: 8px;
    font-size: 12px;
    color: #666;
}

.wfm-code-input,
.wfm-code-textarea,
.wfm-code-textarea-js {
    width: 100%;
    font-family: monospace;
    font-size: 11px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    padding: 8px;
    border-radius: 3px;
    margin-bottom: 8px;
}

.wfm-code-textarea,
.wfm-code-textarea-js {
    resize: vertical;
}

.wfm-copy-btn,
.wfm-copy-btn-js {
    margin-bottom: 15px;
}

.wfm-preview-section {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #ddd;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Copier dans le presse-papiers
    $('.wfm-copy-btn, .wfm-copy-btn-js').on('click', function() {
        var target = $(this).attr('data-clipboard-target');
        var $textarea = $(target);
        $textarea.select();
        document.execCommand('copy');

        var $btn = $(this);
        var originalText = $btn.text();
        $btn.text('✅ Copié !');
        setTimeout(function() {
            $btn.text(originalText);
        }, 2000);
    });
});
</script>
