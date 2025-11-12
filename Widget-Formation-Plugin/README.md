# Widget Formation Insufflé Académie

## Description

Ce plugin permet de créer des widgets d'intégration pour afficher vos formations Insufflé Académie sur d'autres sites internet. Les widgets sont générés sous forme d'iframe ou de code JavaScript et peuvent être intégrés n'importe où.

## Fonctionnalités

✅ **Création de widgets personnalisés** : Créez autant de widgets que vous voulez
✅ **Sélection des formations** : Choisissez 1 ou plusieurs formations à afficher
✅ **Logos personnalisables** : Affichez les logos Insufflé Académie et Qualiopi
✅ **Design professionnel** : Widget aux couleurs de la marque avec fond transparent
✅ **2 types d'intégration** : iframe (simple) ou JavaScript (auto-redimensionnement)
✅ **Responsive** : S'adapte à toutes les tailles d'écran
✅ **Clic vers formation** : Redirige vers la page formation sur Insufflé Académie

## Installation

1. Téléverser le dossier `Widget-Formation-Plugin` dans `/wp-content/plugins/`
2. Activer le plugin dans WordPress
3. Un nouveau menu "Widgets Formation" apparaît dans l'admin

## Utilisation

### 1. Créer un widget

1. Aller dans **Widgets Formation** > **Ajouter un widget**
2. Donner un titre au widget (ex: "Formation Sketchnote")
3. Cocher les formations à afficher dans le widget
4. Choisir d'afficher ou non les logos Insufflé Académie et Qualiopi
5. Cliquer sur **Publier**

### 2. Récupérer le code d'intégration

Une fois publié, le code d'intégration apparaît dans la sidebar droite :

**Option 1 : iframe (recommandé)**
```html
<iframe src="https://insuffle-academie.com/widget-formation/123" width="100%" height="auto" frameborder="0" scrolling="no" style="min-height: 400px; background: transparent;" allowtransparency="true"></iframe>
```

**Option 2 : JavaScript**
```html
<div id="insuffle-widget-123"></div>
<script>
(function(){var iframe=document.createElement('iframe');iframe.src='https://insuffle-academie.com/widget-formation/123';iframe.style.width='100%';iframe.style.border='none';iframe.style.minHeight='400px';iframe.setAttribute('allowtransparency','true');document.getElementById('insuffle-widget-123').appendChild(iframe);})();
</script>
```

### 3. Intégrer le widget sur un autre site

- Copiez le code
- Collez-le dans n'importe quelle page HTML
- Le widget s'affiche avec les formations sélectionnées
- Quand on clique sur une formation, ça ouvre la page formation sur Insufflé Académie

## Cas d'usage exemple

**Scénario :**
Vous avez un site Insufflé (sketchnote) et vous voulez promouvoir votre formation Sketchnote d'Insufflé Académie.

**Solution :**
1. Créer un widget "Formation Sketchnote Insufflé Académie"
2. Sélectionner la formation "Facilitation Visuelle - Sketchnote"
3. Copier le code iframe
4. L'intégrer dans la page sketchnote du site Insufflé
5. Les visiteurs cliquent sur le widget → nouvelle page vers la formation sur Insufflé Académie

## Design du widget

Le widget utilise :
- **Fond** : Dégradé violet (#8E2183 → #a52a9a) avec 95% d'opacité
- **Police** : Montserrat (comme le reste du site)
- **Cards** : Blanches avec ombre portée et effet hover
- **Logos** : Insufflé Académie (60px) + Qualiopi (80px)
- **Responsive** : Grille adaptative 1-3 colonnes selon l'écran

## Structure des fichiers

```
Widget-Formation-Plugin/
├── widget-formation.php           # Fichier principal
├── includes/                      # Classes PHP (vide pour l'instant)
├── templates/
│   ├── meta-box-config.php       # Configuration du widget
│   ├── meta-box-code.php         # Code d'intégration
│   └── widget-display.php        # Affichage du widget
├── assets/
│   ├── css/
│   │   └── admin.css             # Styles admin
│   └── js/
│       └── admin.js              # Scripts admin
└── README.md                     # Ce fichier
```

## Technique

### Endpoints personnalisés

Le plugin crée un endpoint `/widget-formation/{id}` qui affiche le widget sans header/footer WordPress.

### Rewrite rules

Les URLs sont propres : `https://insuffle-academie.com/widget-formation/123`

### Auto-redimensionnement

Le widget envoie sa hauteur à l'iframe parent via `postMessage` pour un redimensionnement automatique.

### Sécurité

- Vérification des nonces pour les sauvegardes
- Sanitisation de toutes les données
- Vérification des permissions utilisateur
- Échappement des sorties HTML

## Personnalisation

### Modifier le design du widget

Éditer le fichier `templates/widget-display.php` et modifier les styles CSS dans la balise `<style>`.

### Changer les couleurs

Rechercher `#8E2183` (violet Insufflé) et remplacer par votre couleur.

### Ajouter des champs personnalisés

1. Ajouter les champs dans `templates/meta-box-config.php`
2. Sauvegarder dans `save_widget_meta()` du fichier principal
3. Utiliser dans `templates/widget-display.php`

## FAQ

**Q : Peut-on intégrer le widget sur n'importe quel site ?**
R : Oui, même sur des sites non-WordPress. Il suffit de copier/coller le code HTML.

**Q : Le widget fonctionne-t-il avec HTTPS ?**
R : Oui, le widget fonctionne en HTTP et HTTPS.

**Q : Combien de formations peut-on afficher ?**
R : Autant que vous voulez, mais pour l'UX on recommande 1-4 formations max.

**Q : Peut-on personnaliser les couleurs du widget ?**
R : Oui, en modifiant le CSS dans `templates/widget-display.php`.

**Q : Le widget est-il responsive ?**
R : Oui, il s'adapte automatiquement aux mobiles, tablettes et desktop.

**Q : Que se passe-t-il quand on clique sur une formation ?**
R : Ça ouvre une nouvelle page (target="_blank") vers la formation sur Insufflé Académie.

## Support

Pour toute question ou problème, contactez l'équipe technique Insufflé Académie.

## Changelog

### Version 1.0.0
- Création initiale du plugin
- Support iframe et JavaScript
- Logos Insufflé Académie et Qualiopi
- Design responsive avec Montserrat
- Auto-redimensionnement de l'iframe
