# ✅ Checklist de test - Widget Formation

## 📋 Tests à effectuer avant mise en production

### 1. Installation du plugin

- [ ] Activer le plugin dans WordPress (Extensions > Plugins installés > Activer)
- [ ] Vérifier qu'aucune erreur PHP n'apparaît
- [ ] Vérifier que le menu "Widgets Formation" apparaît dans l'admin
- [ ] **IMPORTANT** : Aller dans Réglages > Permaliens et cliquer sur "Enregistrer" pour flush les rewrite rules

### 2. Création d'un widget

- [ ] Cliquer sur "Widgets Formation" > "Ajouter un widget"
- [ ] Donner un titre : "Test Formation Sketchnote"
- [ ] Vérifier que la liste des formations s'affiche
- [ ] Cocher au moins 1 formation
- [ ] Vérifier que le compteur "X formations sélectionnées" s'affiche
- [ ] Cocher/décocher les logos Insufflé Académie et Qualiopi
- [ ] Cliquer sur "Publier"
- [ ] Vérifier qu'aucune erreur ne se produit

### 3. Code d'intégration

- [ ] Vérifier que la sidebar droite affiche "Code d'intégration"
- [ ] Vérifier que l'URL du widget est affichée (format : `https://votre-site.com/widget-formation/ID`)
- [ ] Vérifier que le code iframe est généré
- [ ] Vérifier que le code JavaScript est généré
- [ ] Tester le bouton "📋 Copier le code" - il doit afficher "✅ Copié !"
- [ ] Tester le bouton "Voir le widget en plein écran"

### 4. Affichage du widget standalone

- [ ] Ouvrir l'URL du widget dans un nouvel onglet : `https://votre-site.com/widget-formation/ID`
- [ ] Vérifier que le widget s'affiche (dégradé violet)
- [ ] Vérifier que le titre du widget s'affiche
- [ ] Vérifier que les logos s'affichent (si activés)
- [ ] Vérifier que les formations cochées s'affichent sous forme de cards
- [ ] Vérifier que la police Montserrat est bien utilisée
- [ ] Vérifier le responsive (redimensionner la fenêtre)
- [ ] Tester le hover sur les cards (effet d'élévation)
- [ ] Cliquer sur une card de formation
- [ ] Vérifier que ça ouvre une nouvelle page vers la formation sur Insufflé Académie

### 5. Intégration iframe sur un site externe

**Test avec un fichier HTML local :**

- [ ] Créer un fichier `test-widget.html` avec le code iframe
- [ ] Ouvrir le fichier dans un navigateur
- [ ] Vérifier que l'iframe s'affiche avec fond transparent
- [ ] Vérifier que le widget est visible dans l'iframe
- [ ] Vérifier que les formations sont cliquables
- [ ] Vérifier qu'au clic, ça ouvre bien la formation sur Insufflé Académie

**Code HTML de test :**
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Widget</title>
    <style>
        body { background: #f0f0f0; padding: 40px; }
    </style>
</head>
<body>
    <h1>Test d'intégration du widget</h1>
    <iframe
        src="https://VOTRE-SITE.com/widget-formation/ID"
        width="100%"
        height="auto"
        frameborder="0"
        scrolling="no"
        style="min-height: 400px; background: transparent;"
        allowtransparency="true">
    </iframe>
</body>
</html>
```

### 6. Tests de sécurité

- [ ] Essayer d'accéder à un widget non publié : `https://votre-site.com/widget-formation/ID-BROUILLON`
  - Doit afficher : "Widget non trouvé ou non publié"
- [ ] Essayer d'accéder avec un ID invalide : `https://votre-site.com/widget-formation/abc`
  - Doit afficher : "ID de widget invalide"
- [ ] Essayer d'accéder à un ID qui n'existe pas : `https://votre-site.com/widget-formation/99999`
  - Doit afficher : "Widget non trouvé ou non publié"

### 7. Tests de modification

- [ ] Modifier le widget (ajouter/retirer des formations)
- [ ] Enregistrer
- [ ] Rafraîchir l'URL du widget
- [ ] Vérifier que les modifications sont bien prises en compte

### 8. Tests avec plusieurs formations

- [ ] Créer un widget avec 3-4 formations
- [ ] Vérifier que la grille s'affiche correctement (responsive)
- [ ] Vérifier que toutes les formations sont cliquables
- [ ] Tester sur mobile (responsive)

### 9. Tests des logos

**Test avec logo IA uniquement :**
- [ ] Créer un widget avec logo IA activé, Qualiopi désactivé
- [ ] Vérifier qu'uniquement le logo IA s'affiche

**Test avec logo Qualiopi uniquement :**
- [ ] Créer un widget avec logo Qualiopi activé, IA désactivé
- [ ] Vérifier qu'uniquement le logo Qualiopi s'affiche

**Test sans logos :**
- [ ] Créer un widget avec les 2 logos désactivés
- [ ] Vérifier que la section logos ne s'affiche pas

### 10. Test cas d'usage réel

**Scénario : Site Insufflé sketchnote vers Formation Insufflé Académie**

1. [ ] Créer un widget "Formation Sketchnote"
2. [ ] Sélectionner la formation Sketchnote
3. [ ] Activer les 2 logos
4. [ ] Copier le code iframe
5. [ ] Aller sur le site Insufflé (page sketchnote)
6. [ ] Ajouter le code dans la page
7. [ ] Vérifier que le widget s'affiche
8. [ ] Cliquer sur la formation
9. [ ] Vérifier que ça ouvre la page formation sur insuffle-academie.com

---

## 🐛 Problèmes connus à tester

### Problème 1 : Rewrite rules
**Symptôme** : URL `/widget-formation/123` retourne 404
**Solution** : Aller dans Réglages > Permaliens > Enregistrer

### Problème 2 : Logo Insufflé Académie ne s'affiche pas
**Symptôme** : Logo vide ou cassé
**Solution** : Le thème doit avoir un logo personnalisé défini, sinon le plugin utilise l'URL par défaut

### Problème 3 : Formations ne s'affichent pas
**Vérifier** :
- [ ] Les formations sont bien publiées (pas en brouillon)
- [ ] Les formations sont bien cochées dans le widget
- [ ] Le widget est bien publié

---

## ✅ Validation finale

- [ ] Tous les tests ci-dessus sont passés
- [ ] Aucune erreur PHP dans les logs
- [ ] Le widget s'affiche correctement
- [ ] Les formations sont cliquables et redirigent correctement
- [ ] Le responsive fonctionne (mobile/tablette/desktop)
- [ ] L'intégration iframe fonctionne sur un site externe
- [ ] Les logos s'affichent correctement

---

## 📝 Notes additionnelles

**Date du test** : _____________

**Testeur** : _____________

**Version WordPress** : _____________

**Thème actif** : _____________

**Navigateurs testés** :
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

**Problèmes rencontrés** :
_____________________________________________
_____________________________________________
_____________________________________________

**Fonctionnalités manquantes ou améliorations suggérées** :
_____________________________________________
_____________________________________________
_____________________________________________
