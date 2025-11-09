# Fiche Formateur Plugin

Plugin WordPress pour créer des fiches formateurs professionnelles avec photo, statistiques et citations.

## 📋 Description

Ce plugin vous permet de créer et gérer facilement les fiches de vos formateurs avec :
- ✅ Photo du formateur (circulaire avec bordure dorée)
- ✅ Badge / Titre personnalisé
- ✅ Nom et tagline
- ✅ Description / Biographie (HTML autorisé)
- ✅ Chiffres clés illimités (statistiques)
- ✅ Citation / Devise du formateur
- ✅ Design identique au HTML de référence (fiche-formateur-yoan.html)
- ✅ Classes CSS préfixées "ffm-" pour éviter les conflits
- ✅ Shortcode simple et flexible
- ✅ Tous les champs 100% optionnels

## 🚀 Installation

1. Téléchargez le dossier `Formateur-Plugin`
2. Placez-le dans `/wp-content/plugins/`
3. Activez le plugin depuis l'interface WordPress
4. Un nouveau menu "Formateurs" apparaît dans votre admin

## 💻 Utilisation

### 1. Créer une fiche formateur

Sur chaque page ou article, une metabox **"Fiche Formateur - Informations"** vous permet de gérer les informations.

**Champs disponibles (tous optionnels) :**

- **Photo** : Sélectionnez depuis la médiathèque WordPress
- **Badge** : Ex: "Fondateur Insuffle Académie"
- **Nom** : Le nom du formateur
- **Tagline** : Ex: "Expert en Transformation Collective"
- **Description** : Biographie et expertise (HTML autorisé)
- **Chiffres clés** : Ajoutez autant de statistiques que vous voulez
  - Nombre : Ex: "15+", "500+", "200+"
  - Label : Ex: "Années d'expérience", "Managers formés"
- **Citation** : Une devise ou citation du formateur
- **Auteur** : Nom de l'auteur de la citation

### 2. Gérer les chiffres clés

- ✅ **Ajouter** : Cliquez sur "Ajouter un chiffre clé"
- ✅ **Réorganiser** : Glissez-déposez les statistiques
- ✅ **Supprimer** : Cliquez sur l'icône poubelle

### 3. Afficher la fiche

Utilisez le shortcode dans votre contenu :

```
[fiche_formateur]
```

Ou pour une page spécifique :

```
[fiche_formateur post_id="123"]
```

## 📝 Shortcode

### `[fiche_formateur]`

Affiche la fiche du formateur de la page actuelle.

**Paramètres :**

| Paramètre | Description | Défaut |
|-----------|-------------|--------|
| `post_id` | ID de la page/article contenant les infos | Page actuelle |

**Exemples :**

```
[fiche_formateur]
```
Affiche la fiche de la page actuelle.

```
[fiche_formateur post_id="123"]
```
Affiche la fiche de la page ID 123.

## 📖 Exemple complet

### Remplissage de la metabox :

**Photo :** Sélectionnez une photo carrée pour un meilleur rendu circulaire

**Badge :** Fondateur Insuffle Académie

**Nom :** Yoan Lureault

**Tagline :** Expert en Transformation Collective

**Description :**
```html
Facilitateur et stratège de la transformation organisationnelle, créateur des méthodologies
<strong>Futur Désiré®</strong> et <strong>Boussole 4C®</strong>.
15 ans d'expérience terrain à accompagner PME et ETI dans leur transformation par l'intelligence collective.
```

**Chiffres clés :**
- 15+ | Années d'expérience terrain
- 500+ | Managers formés
- 200+ | Entreprises accompagnées
- 2 | Méthodes propriétaires

**Citation :**
```
Le changement ne se décrète pas, il se facilite. Mon job n'est pas de vous dire quoi faire,
mais de révéler l'intelligence qui existe déjà dans vos équipes.
```

**Auteur :** Yoan Lureault

### Résultat :

Le shortcode `[fiche_formateur]` affichera une fiche professionnelle avec :
- Header violet dégradé avec photo circulaire
- Badge jaune en haut à gauche
- Nom en gros titre blanc
- Tagline en jaune
- Description en blanc
- Section stats avec fond violet et chiffres en jaune
- Citation centrée avec guillemets

## 🎨 Styles disponibles

Le plugin inclut des styles identiques au HTML de référence avec le préfixe `ffm-` :

### Classes principales :

- `.ffm-fiche-container` : Container principal
- `.ffm-header-section` : Section header avec gradient
- `.ffm-photo-frame` : Cadre circulaire de la photo
- `.ffm-badge` : Badge/Titre
- `.ffm-nom` : Nom du formateur
- `.ffm-tagline` : Tagline/Sous-titre
- `.ffm-description` : Description/Biographie
- `.ffm-stats-section` : Section statistiques
- `.ffm-stat-number` : Chiffre de la stat
- `.ffm-stat-label` : Label de la stat
- `.ffm-quote-section` : Section citation
- `.ffm-quote-text` : Texte de la citation
- `.ffm-quote-author` : Auteur de la citation

## 🔧 Personnalisation

### Couleurs

Les couleurs sont définies en variables CSS dans `assets/css/frontend.css` :

```css
:root {
    --ffm-primary: #8E2183;    /* Violet principal */
    --ffm-secondary: #FFD466;  /* Jaune */
    --ffm-accent: #FFC0CB;     /* Rose */
    --ffm-light: #FFFFFF;      /* Blanc */
    --ffm-dark: #333333;       /* Gris foncé */
    --ffm-grey: #F5F5F5;       /* Gris clair */
}
```

Vous pouvez les surcharger dans votre thème.

### Styles personnalisés

Ajoutez vos styles dans votre thème en ciblant les classes `ffm-*` :

```css
.ffm-header-section {
    /* Vos styles personnalisés */
}

.ffm-photo-frame {
    /* Personnaliser le cadre photo */
}
```

## 📱 Responsive

Le plugin est entièrement responsive avec des breakpoints à :
- 768px (tablettes)
- 480px (mobiles)

## 🔐 Sécurité

- ✅ Nonces WordPress pour toutes les sauvegardes
- ✅ Vérifications des permissions
- ✅ Sanitization de tous les champs
- ✅ Echappement des sorties
- ✅ Protection contre l'accès direct

## 📄 Structure des fichiers

```
Formateur-Plugin/
├── formateur.php                    # Fichier principal
├── includes/
│   ├── class-formateur-manager.php  # Gestion des données
│   ├── class-shortcode.php          # Shortcode
│   └── class-admin-interface.php    # Interface admin
├── assets/
│   ├── css/
│   │   ├── frontend.css             # Styles frontend
│   │   └── admin.css                # Styles admin
│   └── js/
│       ├── frontend.js              # Scripts frontend
│       └── admin.js                 # Scripts admin (upload, stats)
├── templates/
│   └── admin-metabox.php            # Template metabox
└── README.md                        # Ce fichier
```

## 🆘 Support

### Page d'aide intégrée
Consultez **WordPress > Formateurs** pour la documentation complète.

### Problèmes courants

**La fiche ne s'affiche pas ?**
- Vérifiez que vous avez ajouté le shortcode `[fiche_formateur]`
- Vérifiez qu'au moins un champ est rempli (nom ou photo)

**Les styles ne s'appliquent pas ?**
- Videz le cache de votre navigateur
- Vérifiez qu'il n'y a pas de conflit CSS dans votre thème

**L'upload de photo ne fonctionne pas ?**
- Vérifiez que la médiathèque WordPress fonctionne
- Vérifiez la console JavaScript pour les erreurs

**Les stats ne se réorganisent pas ?**
- Vérifiez que jQuery UI Sortable est chargé
- Vérifiez la console JavaScript

## 📊 Compatibilité

- **WordPress** : 5.0+
- **PHP** : 7.0+
- **Navigateurs** : Chrome, Firefox, Safari, Edge

## 🎨 Design

Design basé sur le fichier `fiche-formateur-yoan.html` avec :
- Gradient violet (#8E2183) et jaune (#FFD466)
- Photo circulaire avec bordure jaune
- Header avec fond dégradé violet
- Section stats avec fond violet
- Citation centrée avec guillemets géants
- Typographie moderne (Montserrat ou équivalent)
- Effets subtils et professionnels

## 💡 Conseils

- Utilisez une **photo carrée** pour un meilleur rendu circulaire
- Les chiffres clés peuvent contenir du **texte** : "15+", "500+", "2", etc.
- **Réorganisez** les statistiques par glisser-déposer pour l'ordre souhaité
- **Tous les champs sont optionnels** - adaptez selon vos besoins
- Le design est **identique au template HTML** de référence
- Utilisez le **HTML** dans la description pour des mises en forme riches

## 📝 Changelog

### Version 1.0.0
- ✨ Première version
- ✨ Upload de photo via médiathèque WordPress
- ✨ Gestion de chiffres clés illimités
- ✨ Système de citation
- ✨ Shortcode [fiche_formateur]
- ✨ Design identique au HTML de référence
- ✨ Classes CSS préfixées "ffm-"
- ✨ Documentation intégrée
- ✨ Responsive design complet

## 👨‍💻 Auteur

**Yoan Lureault**
- GitHub: https://github.com/ylureault
- Site: https://www.insuffle-academie.com

## 📄 License

GPL v2 or later

---

**Merci d'utiliser Fiche Formateur !** 🎉
