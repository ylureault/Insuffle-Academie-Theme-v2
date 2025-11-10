# Articles Blog Formation - Plugin WordPress

## Description

Ce plugin permet d'afficher automatiquement les articles du blog liés à une formation via un shortcode. Les articles sont liés aux formations via les **tags WordPress** partagés.

## Fonctionnalités

✅ **Détection automatique** : Les articles sont trouvés via les tags en commun avec la formation
✅ **Affichage élégant** : Grille responsive de cards avec image, titre, extrait et catégorie
✅ **Shortcode simple** : `[articles_formation]` - c'est tout !
✅ **Personnalisable** : Options pour contrôler le nombre d'articles et le titre
✅ **Design cohérent** : Utilise les mêmes couleurs et styles que le reste du site

## Installation

1. Téléverser le dossier `Articles-Blog-Plugin` dans `/wp-content/plugins/`
2. Activer le plugin dans WordPress
3. Le plugin ajoute automatiquement le support des tags pour le post type `programme-formation`

## Utilisation

### 1. Lier des articles à une formation

Pour qu'un article soit associé à une formation, il suffit d'ajouter **les mêmes tags** aux deux :

**Exemple :**
- Formation "Facilitation et Intelligence Collective" → Tags : `facilitation`, `intelligence-collective`, `management`
- Article "10 techniques de facilitation" → Tags : `facilitation`, `techniques`

L'article sera automatiquement affiché car il partage le tag `facilitation` avec la formation.

### 2. Insérer le shortcode

Dans une page ou formation, ajoutez simplement :

```
[articles_formation]
```

### 3. Options du shortcode

```
[articles_formation limit="3" titre="Articles recommandés"]
```

**Paramètres disponibles :**

- `limit` : Nombre d'articles à afficher (défaut: 3)
- `titre` : Titre de la section (défaut: "Articles du blog en lien avec cette formation")
- `formation_id` : ID de la formation (par défaut : page actuelle)

**Exemples :**

```
[articles_formation limit="6"]
```

```
[articles_formation titre="Nos articles sur ce sujet" limit="4"]
```

```
[articles_formation formation_id="123" limit="5"]
```

## Comportement

### Avec tags en commun
Le plugin affiche les articles qui partagent au moins un tag avec la formation, triés par date (plus récents en premier).

### Sans tags
Si la formation n'a pas de tags, le plugin affiche les derniers articles du blog.

## Structure de l'affichage

Chaque article inclut :
- 📸 **Image à la une** (si disponible)
- 📅 **Date de publication**
- 🏷️ **Catégorie principale**
- 📝 **Titre** (lien vers l'article)
- ✍️ **Extrait** (20 premiers mots)
- 🔗 **Lien "Lire l'article"**

Un bouton "Voir tous les articles" est affiché en bas pour accéder à la page archive du tag.

## Design

Le plugin utilise :
- Couleur principale : **Violet #8E2183**
- Couleur secondaire : **Doré #FFD466**
- Cards blanches avec ombres portées
- Effets hover sur les cards et images
- Grille responsive (1 à 3 colonnes selon la largeur d'écran)

## Compatibilité

- ✅ WordPress 5.0+
- ✅ PHP 7.4+
- ✅ Compatible avec tous les thèmes
- ✅ Responsive (mobile, tablette, desktop)

## Support

Le plugin fonctionne automatiquement avec :
- Post type `post` (articles WordPress classiques)
- Post type `programme-formation` (créé par le plugin Programme Formation)
- Taxonomie `post_tag` (tags WordPress natifs)

## Fichiers

```
Articles-Blog-Plugin/
├── articles-blog-formation.php    # Fichier principal
├── assets/
│   └── css/
│       └── frontend.css           # Styles frontend
└── README.md                      # Ce fichier
```

## Exemples de mise en page

### Dans une page Formation

```html
<!-- Contenu de la formation -->
<h2>Programme</h2>
[programme_formation]

<h2>Informations pratiques</h2>
[calendrier_formation]

<h2>Ressources complémentaires</h2>
[articles_formation limit="3"]
```

### Dans une page personnalisée

```html
<h1>Ressources</h1>
[articles_formation formation_id="42" titre="Articles recommandés pour cette formation"]
```

## Notes importantes

⚠️ **Tags obligatoires** : Pour que les articles s'affichent automatiquement, la formation ET les articles doivent avoir des tags en commun.

💡 **Conseil** : Utilisez des tags pertinents et spécifiques pour créer des associations précises entre formations et articles.

🎨 **Style** : Le CSS utilise `!important` pour garantir que le style ne soit pas écrasé par le thème.

## À venir

Fonctionnalités possibles pour les prochaines versions :
- Filtrage par catégorie en plus des tags
- Choix manuel des articles via une meta box
- Templates personnalisables
- Widget pour la sidebar
