/**
 * Bloc Gutenberg : Liste des Formations
 * Affiche toutes les formations disponibles
 */

(function(blocks, element, blockEditor, components) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var RangeControl = components.RangeControl;
    var ToggleControl = components.ToggleControl;
    var ServerSideRender = wp.serverSideRender;

    blocks.registerBlockType('insuffle/formations-list', {
        title: 'Liste des Formations',
        description: 'Affiche la liste de toutes vos formations avec leurs détails',
        icon: 'welcome-learn-more',
        category: 'insuffle',
        keywords: ['formations', 'formation', 'insuffle', 'liste'],
        
        attributes: {
            columns: {
                type: 'number',
                default: 3
            },
            limit: {
                type: 'number',
                default: -1
            },
            showExcerpt: {
                type: 'boolean',
                default: true
            },
            showButton: {
                type: 'boolean',
                default: true
            },
            showDownload: {
                type: 'boolean',
                default: true
            }
        },

        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            return el('div', {},
                // Panneau de configuration (sidebar)
                el(InspectorControls, {},
                    el(PanelBody, {
                        title: 'Paramètres d\'affichage',
                        initialOpen: true
                    },
                        // Nombre de colonnes
                        el(RangeControl, {
                            label: 'Nombre de colonnes',
                            value: attributes.columns,
                            onChange: function(value) {
                                setAttributes({ columns: value });
                            },
                            min: 1,
                            max: 4
                        }),
                        
                        // Limite de formations
                        el(RangeControl, {
                            label: 'Nombre de formations à afficher (-1 = toutes)',
                            value: attributes.limit,
                            onChange: function(value) {
                                setAttributes({ limit: value });
                            },
                            min: -1,
                            max: 20
                        }),
                        
                        // Afficher l'extrait
                        el(ToggleControl, {
                            label: 'Afficher la durée/type',
                            checked: attributes.showExcerpt,
                            onChange: function(value) {
                                setAttributes({ showExcerpt: value });
                            }
                        }),
                        
                        // Afficher le bouton
                        el(ToggleControl, {
                            label: 'Afficher le bouton "Voir le programme"',
                            checked: attributes.showButton,
                            onChange: function(value) {
                                setAttributes({ showButton: value });
                            }
                        }),
                        
                        // Afficher le lien de téléchargement
                        el(ToggleControl, {
                            label: 'Afficher le lien de téléchargement',
                            checked: attributes.showDownload,
                            onChange: function(value) {
                                setAttributes({ showDownload: value });
                            }
                        })
                    )
                ),
                
                // Prévisualisation du bloc
                el('div', {
                    className: 'insuffle-block-preview',
                    style: {
                        padding: '20px',
                        backgroundColor: '#f5f5f5',
                        borderRadius: '10px',
                        textAlign: 'center'
                    }
                },
                    el('div', {
                        style: {
                            fontSize: '48px',
                            marginBottom: '10px'
                        }
                    }, '🎓'),
                    el('h3', {
                        style: {
                            color: '#8E2183',
                            marginBottom: '10px'
                        }
                    }, 'Liste des Formations'),
                    el('p', {
                        style: {
                            color: '#555',
                            marginBottom: '15px'
                        }
                    }, 
                        'Affichage : ' + attributes.columns + ' colonne(s)' +
                        (attributes.limit > 0 ? ' | Limite : ' + attributes.limit : ' | Toutes les formations')
                    ),
                    el('div', {
                        style: {
                            fontSize: '12px',
                            color: '#999',
                            marginTop: '20px',
                            padding: '10px',
                            backgroundColor: '#fff',
                            borderRadius: '5px'
                        }
                    }, '⚠️ Prévisualisation non disponible en édition. Sauvegardez pour voir le résultat.')
                )
            );
        },

        save: function() {
            // Bloc rendu côté serveur, pas besoin de save
            return null;
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);
