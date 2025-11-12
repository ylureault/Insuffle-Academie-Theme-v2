# 📝 Générateur d'Articles Insufflé Académie

## Description

Ce plugin génère 100 idées d'articles de blog SEO-optimisés sur les thématiques de la facilitation, l'intelligence collective et le management. Chaque idée est pré-remplie et prête à être validée pour devenir un article WordPress.

## Fonctionnalités

✅ **100 idées d'articles pré-générées** (1500-3000 mots chacune)
✅ **Interface admin dédiée** pour gérer les idées
✅ **Validation en un clic** pour transformer une idée en article WordPress
✅ **SEO optimisé** : meta description, keywords, slug
✅ **Style personnel** : ton "je", structure claire, émojis
✅ **Filtrage et recherche** des idées
✅ **Statistiques** en temps réel (total, en attente, publiés)
✅ **Catégorisation** automatique (facilitation, intelligence collective, management, sketchnoting)

## Installation

1. Téléverser le dossier `Generateur-Articles-Plugin` dans `/wp-content/plugins/`
2. Activer le plugin dans WordPress
3. Un nouveau menu "Générateur Articles" apparaît dans l'admin
4. Les 100 idées sont automatiquement générées lors de l'activation

## Utilisation

### 1. Accéder au générateur

Aller dans **Générateur Articles** dans le menu admin WordPress.

### 2. Explorer les idées

- **Statistiques** : Voir le nombre total d'idées, en attente, et publiées
- **Filtres** : Afficher toutes les idées, uniquement celles en attente, ou publiées
- **Recherche** : Trouver une idée par mot-clé dans le titre ou le contenu

### 3. Consulter une idée

Chaque idée affiche :
- **Titre** optimisé pour le SEO
- **Catégorie** (facilitation, intelligence collective, etc.)
- **Nombre de mots** (1500-3000)
- **Slug** URL-friendly
- **Excerpt** (résumé court)
- **Meta description** pour le SEO
- **Meta keywords** pour le SEO
- **Contenu complet** (clic sur "Voir le contenu complet")

### 4. Valider une idée

1. Cliquer sur le bouton **"✅ Valider et créer l'article"**
2. Confirmer la création
3. L'article est créé en **brouillon** dans WordPress
4. Le statut de l'idée passe à "Publié"
5. Un lien "Modifier l'article" apparaît pour éditer l'article dans WordPress

### 5. Modifier l'article

Une fois validé, l'article est disponible dans **Articles** > **Tous les articles**.
Tu peux :
- Ajouter des images
- Ajuster le contenu
- Changer le statut de "Brouillon" à "Publié"

### 6. Supprimer une idée

Si une idée ne te plaît pas :
- Cliquer sur le bouton **"🗑️ Supprimer"**
- Confirmer la suppression
- L'idée est définitivement supprimée

### 7. Régénérer les idées

Si tu veux renouveler les idées non publiées :
- Cliquer sur **"🔄 Régénérer les idées non publiées"**
- Les idées en attente sont supprimées et remplacées par de nouvelles

## Style des articles

Les articles respectent un style cohérent avec le ton Insufflé Académie :

- **Ton personnel** : utilisation du "je"
- **Structure claire** : numérotation, sections, sous-sections
- **Phrases courtes** et percutantes
- **Émojis** pour aérer et illustrer (👉, ✅, ⚡, etc.)
- **Listes à puces** pour la lisibilité
- **Exemples concrets** et anecdotes personnelles
- **Appels à l'action** naturels
- **Focus transformation** : pas de théorie pure, mais du vécu et de l'actionnable

## Thématiques des articles

### Facilitation (35 articles)
- Techniques de facilitation
- Erreurs à éviter
- Posture du facilitateur
- Méthodes et outils

### Intelligence Collective (30 articles)
- Dynamiques de groupe
- Co-construction
- Prise de décision collective
- Collaboration efficace

### Management (20 articles)
- Management participatif
- Leadership
- Communication en équipe
- Transformation organisationnelle

### Sketchnoting (15 articles)
- Techniques de sketchnoting
- Facilitation visuelle
- Pensée visuelle
- Apprentissage par le visuel

## Structure technique

### Base de données

Le plugin crée une table `wp_gar_article_ideas` avec :
- ID
- Titre
- Slug
- Contenu complet (HTML)
- Excerpt
- Meta description
- Meta keywords
- Catégorie
- Nombre de mots
- Statut (pending/published)
- ID de l'article WordPress (si publié)
- Dates de création et validation

### Fichiers

```
Generateur-Articles-Plugin/
├── generateur-articles.php      # Plugin principal
├── includes/
│   ├── article-ideas.php        # 100 idées pré-générées
│   └── admin-page.php           # Interface admin
├── assets/
│   ├── css/
│   │   └── admin.css            # Styles admin
│   └── js/
│       └── admin.js             # Scripts admin (AJAX)
└── README.md                    # Ce fichier
```

### AJAX

Le plugin utilise AJAX pour :
- Valider une idée et créer l'article
- Supprimer une idée
- Régénérer les idées

Tous les appels AJAX sont sécurisés avec des nonces.

## SEO

Chaque article est optimisé pour le SEO :
- **Titre** : H1 optimisé avec mots-clés
- **Meta description** : 155 caractères max, incitative
- **Meta keywords** : 4-6 mots-clés pertinents
- **Slug** : URL-friendly, avec mots-clés
- **Structure H2/H3** : Hiérarchie claire
- **Contenu** : 1500-3000 mots (idéal pour SEO)
- **Mots-clés** : Densité naturelle (1-2%)

Compatible avec Yoast SEO : les meta sont automatiquement remplies.

## Personnalisation

### Ajouter des articles

Pour ajouter des idées d'articles, éditer le fichier `includes/article-ideas.php` et ajouter des entrées dans le tableau `$gar_article_ideas`.

Format :
```php
array(
    'title' => 'Titre de l\'article',
    'slug' => 'titre-de-l-article',
    'category' => 'facilitation',
    'meta_description' => 'Description SEO (155 chars max)',
    'meta_keywords' => 'mot-clé1, mot-clé2, mot-clé3',
    'excerpt' => 'Résumé court de l\'article',
    'content' => '<h2>Section 1</h2><p>Contenu...</p>'
),
```

### Modifier les catégories

Les catégories sont utilisées pour organiser les articles.
Pour que l'assignation automatique fonctionne, créer les catégories dans WordPress :
- Facilitation
- Intelligence Collective
- Management
- Sketchnoting

## Sécurité

- ✅ Vérification des permissions (manage_options)
- ✅ Nonces pour tous les appels AJAX
- ✅ Sanitisation des données entrantes
- ✅ Échappement des sorties HTML
- ✅ Protection contre les injections SQL (prepare)

## Compatibilité

- WordPress 5.0+
- PHP 7.4+
- Compatible avec tous les thèmes
- Compatible Yoast SEO
- Compatible Rank Math SEO

## Support

Pour ajouter plus d'articles ou modifier le style, éditer le fichier `includes/article-ideas.php`.

---

**Créé pour Insufflé Académie** 🎓
