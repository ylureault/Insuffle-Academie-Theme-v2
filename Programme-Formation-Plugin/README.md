# Programme Formation Plugin

Plugin WordPress pour gérer le programme de vos formations avec un système de modules dynamiques.

## 📋 Description

Ce plugin vous permet de créer et gérer facilement le programme de vos formations avec :
- ✅ Système de modules illimité
- ✅ Tous les champs optionnels et paramétrables à 100%
- ✅ Interface d'administration intuitive avec glisser-déposer
- ✅ Design identique au HTML de référence (formation-sketchnote.html)
- ✅ Classes CSS préfixées "pfm-" pour éviter les conflits
- ✅ Shortcode simple et flexible
- ✅ Support HTML dans le contenu des modules

## 🚀 Installation

1. Téléchargez le dossier `Programme-Formation-Plugin`
2. Placez-le dans `/wp-content/plugins/`
3. Activez le plugin depuis l'interface WordPress
4. Un nouveau menu "Programme" apparaît dans votre admin

## 💻 Utilisation

### 1. Créer des modules

Sur chaque page ou article, une metabox **"Programme de Formation - Modules"** vous permet d'ajouter des modules.

Chaque module dispose de **3 champs (tous optionnels)** :
- **Numéro** : Le numéro du module (ex: 1, 2, 3...)
- **Titre** : Le titre du module
- **Contenu** : Le contenu HTML du module

### 2. Gérer les modules

- ✅ **Ajouter** : Cliquez sur "Ajouter un module"
- ✅ **Réorganiser** : Glissez-déposez les modules
- ✅ **Replier/Déplier** : Cliquez sur la flèche
- ✅ **Supprimer** : Cliquez sur "Supprimer"

### 3. Afficher le programme

Utilisez le shortcode dans votre contenu :

```
[programme_formation]
```

Ou pour un post spécifique :

```
[programme_formation post_id="123"]
```

## 📝 Exemples

### Exemple de module simple

**Numéro :** 1

**Titre :** Le principe du Sketchnoting

**Contenu :**
```html
<h4>📖 Contenu du module :</h4>
<ul>
    <li>✔︎ C'est quoi le Sketchnoting ?</li>
    <li>✔︎ Découverte et test du matériel</li>
    <li>✔︎ Bénéfices attendus et objections courantes</li>
</ul>

<div class="pfm-quote-block">
    <strong>Objectif pédagogique :</strong> À l'issue de la séquence, le stagiaire sera capable de définir ce qu'est le sketchnoting.
</div>
```

### Exemple avec HTML riche

```html
<h4>📖 Contenu du module :</h4>
<ul>
    <li>✔︎ Comprendre comment obtenir rapidement des résultats satisfaisants</li>
    <li>✔︎ La gestion de l'espace : trouver comment adapter son espace au contenu</li>
    <li>✔︎ S'entraîner et pratiquer dans un contexte de réunion</li>
</ul>

<h4>🎯 Exercices pratiques :</h4>
<ul>
    <li>Esquisse game</li>
    <li>Dessiner un visage</li>
    <li>Sketchnoting en direct</li>
</ul>

<div class="pfm-quote-block">
    <strong>Objectif pédagogique :</strong> À l'issue de la séquence, le stagiaire sera capable d'utiliser les 4 approches de base.
</div>
```

## 🎨 Styles disponibles

Le plugin inclut des styles identiques au HTML de référence avec le préfixe `pfm-` :

### Classes principales :
- `.pfm-programme-container` : Container principal
- `.pfm-module` : Module individuel
- `.pfm-module-header` : En-tête du module
- `.pfm-module-number` : Numéro du module (cercle)
- `.pfm-module-title` : Titre du module
- `.pfm-module-content` : Contenu du module
- `.pfm-quote-block` : Bloc de citation / encadré

### Classe spéciale pour les encadrés :

```html
<div class="pfm-quote-block">
    <strong>Important :</strong> Votre texte ici...
</div>
```

Cette classe crée un joli encadré avec :
- Fond dégradé subtil
- Bordure gauche colorée
- Style italique
- Padding agréable

## 📖 Documentation complète

Une page d'aide complète est disponible dans **WordPress > Programme** avec :
- Guide d'utilisation pas à pas
- Exemples de modules
- Liste des classes CSS
- Conseils et astuces

## 🎯 Fonctionnalités

### Interface Admin
- ✅ Metabox sur toutes les pages et articles
- ✅ Glisser-déposer pour réorganiser les modules
- ✅ Aperçu en temps réel du titre et numéro
- ✅ Replier/déplier les modules
- ✅ Suppression avec confirmation
- ✅ Champs optionnels (aucun n'est obligatoire)

### Frontend
- ✅ Design identique au HTML de référence
- ✅ Classes CSS préfixées "pfm-"
- ✅ Responsive design
- ✅ Support HTML complet
- ✅ Animations subtiles

### Shortcode
- ✅ Simple et flexible
- ✅ Paramètre `post_id` optionnel
- ✅ Affichage automatique des modules

## 🔧 Personnalisation

### Couleurs

Les couleurs sont définies en variables CSS dans `assets/css/frontend.css` :

```css
:root {
    --pfm-primary: #8E2183;    /* Violet principal */
    --pfm-secondary: #FFD466;  /* Jaune */
    --pfm-accent: #FFC0CB;     /* Rose */
    --pfm-light: #FFFFFF;      /* Blanc */
    --pfm-dark: #333333;       /* Gris foncé */
    --pfm-grey: #F5F5F5;       /* Gris clair */
}
```

Vous pouvez les surcharger dans votre thème.

### Styles personnalisés

Ajoutez vos styles dans votre thème en ciblant les classes `pfm-*` :

```css
.pfm-module {
    /* Vos styles personnalisés */
}

.pfm-module-number {
    /* Personnaliser le cercle de numéro */
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
Programme-Formation-Plugin/
├── programme-formation.php         # Fichier principal
├── includes/
│   ├── class-modules-manager.php   # Gestion des modules
│   ├── class-shortcode.php         # Shortcode
│   └── class-admin-interface.php   # Interface admin
├── assets/
│   ├── css/
│   │   ├── frontend.css            # Styles frontend
│   │   └── admin.css               # Styles admin
│   └── js/
│       ├── frontend.js             # Scripts frontend
│       └── admin.js                # Scripts admin (drag&drop, etc.)
├── templates/
│   └── admin-metabox.php           # Template metabox
└── README.md                       # Ce fichier
```

## 🆘 Support

### Page d'aide intégrée
Consultez **WordPress > Programme** pour la documentation complète.

### Problèmes courants

**Les modules ne s'affichent pas ?**
- Vérifiez que vous avez ajouté le shortcode `[programme_formation]`
- Vérifiez que des modules existent pour cette page

**Les styles ne s'appliquent pas ?**
- Videz le cache de votre navigateur
- Vérifiez qu'il n'y a pas de conflit CSS dans votre thème

**L'interface admin ne fonctionne pas ?**
- Vérifiez que jQuery est chargé
- Vérifiez la console pour les erreurs JavaScript

## 📊 Compatibilité

- **WordPress** : 5.0+
- **PHP** : 7.0+
- **Navigateurs** : Chrome, Firefox, Safari, Edge

## 🎨 Design

Design basé sur le fichier `formation-sketchnote.html` avec :
- Gradient violet et jaune
- Cercles numérotés
- Encadrés stylisés
- Typographie moderne
- Animations subtiles

## 📝 Changelog

### Version 1.0.0
- ✨ Première version
- ✨ Système de modules dynamiques
- ✨ Interface glisser-déposer
- ✨ Shortcode [programme_formation]
- ✨ Styles identiques au HTML de référence
- ✨ Classes CSS préfixées "pfm-"
- ✨ Documentation intégrée

## 👨‍💻 Auteur

**Yoan Lureault**
- GitHub: https://github.com/ylureault
- Site: https://www.insuffle-academie.com

## 📄 License

GPL v2 or later

---

**Merci d'utiliser Programme Formation !** 🎉
