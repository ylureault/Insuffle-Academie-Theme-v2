# 🚀 Démarrage Rapide - Widget Formation

## Installation (5 minutes)

### 1. Activer le plugin

```
WordPress Admin → Extensions → Plugins installés → Widget Formation → Activer
```

### 2. Flush les permaliens (IMPORTANT !)

```
WordPress Admin → Réglages → Permaliens → Enregistrer
```

⚠️ **Cette étape est OBLIGATOIRE** pour que les URLs `/widget-formation/ID` fonctionnent !

---

## Créer votre premier widget (2 minutes)

### Étape 1 : Nouveau widget

1. Aller dans **Widgets Formation** > **Ajouter un widget**
2. Titre : `Formation Sketchnote` (par exemple)

### Étape 2 : Sélectionner les formations

1. Cocher les formations à afficher (ex: Formation Facilitation Visuelle)
2. Le compteur affiche le nombre de formations sélectionnées

### Étape 3 : Options d'affichage

- ✅ Afficher le logo Insufflé Académie
- ✅ Afficher le logo Qualiopi

### Étape 4 : Publier

1. Cliquer sur **Publier**
2. Le code d'intégration apparaît dans la sidebar droite

---

## Intégrer le widget (1 minute)

### Code iframe (recommandé)

Dans la sidebar droite, copier le code iframe :

```html
<iframe
    src="https://insuffle-academie.com/widget-formation/123"
    width="100%"
    height="auto"
    frameborder="0"
    scrolling="no"
    style="min-height: 400px; background: transparent;"
    allowtransparency="true">
</iframe>
```

### Où coller ce code ?

**Option A : Dans WordPress (via Elementor, Gutenberg, etc.)**
- Bloc HTML personnalisé
- Coller le code iframe

**Option B : Sur un site externe**
- N'importe quelle page HTML
- Coller le code iframe dans le HTML

**Option C : Dans le code source**
- Fichier PHP/HTML
- Coller le code iframe

---

## Test rapide

### Vérifier l'affichage

1. Ouvrir l'URL du widget : `https://insuffle-academie.com/widget-formation/123`
2. Vérifier que le widget s'affiche avec :
   - Dégradé violet
   - Logo(s) si activé(s)
   - Formations en cards blanches

### Vérifier le clic

1. Cliquer sur une formation
2. Vérifie que ça ouvre une nouvelle page vers la formation

---

## Cas d'usage : Site Insufflé → Insufflé Académie

**Objectif :** Promouvoir la formation Sketchnote d'Insufflé Académie sur le site Insufflé

### Setup (5 minutes)

1. **Créer le widget**
   - Titre : "Formation Sketchnote Insufflé Académie"
   - Formations : Cocher "Facilitation Visuelle - Sketchnote"
   - Logos : Activer les 2
   - Publier

2. **Récupérer le code**
   - Copier le code iframe depuis la sidebar

3. **Intégrer sur Insufflé**
   - Aller sur le site Insufflé
   - Page "Formation Sketchnote"
   - Ajouter un bloc HTML
   - Coller le code iframe
   - Publier

4. **Tester**
   - Visiter la page sketchnote sur Insufflé
   - Le widget s'affiche
   - Cliquer sur la formation
   - Nouvelle page vers insuffle-academie.com ✅

---

## Personnalisation rapide

### Changer les formations affichées

1. Modifier le widget
2. Cocher/décocher les formations
3. Enregistrer
4. Le widget se met à jour automatiquement (pas besoin de rechanger le code)

### Désactiver un logo

1. Modifier le widget
2. Décocher "Afficher le logo X"
3. Enregistrer

### Créer plusieurs widgets

Tu peux créer autant de widgets que tu veux :
- Widget "Formations Management" (3 formations management)
- Widget "Formation Sketchnote" (1 formation)
- Widget "Toutes nos formations" (toutes les formations)

Chaque widget a son propre code d'intégration.

---

## Dépannage express

### ❌ URL widget retourne 404

**Solution :** Aller dans Réglages > Permaliens > Enregistrer

### ❌ Logo Insufflé Académie ne s'affiche pas

**Solutions :**
1. Vérifier que le thème a un logo personnalisé défini
2. Sinon, le plugin utilise le logo par défaut en ligne

### ❌ Formations ne s'affichent pas

**Vérifier :**
- Les formations sont publiées (pas en brouillon)
- Les formations sont cochées dans le widget
- Le widget est publié

### ❌ Clic sur formation ne fait rien

**Vérifier :**
- La formation a une URL de permalien valide
- Le navigateur ne bloque pas les popups

---

## Support

**Documentation complète :** Voir `README.md`

**Checklist de test :** Voir `CHECKLIST-TEST.md`

**Exemple d'intégration :** Voir `exemple-integration.html`

---

## Résumé : 3 étapes pour commencer

```
1. Activer le plugin + Flush permaliens
2. Créer un widget + Sélectionner formations
3. Copier le code iframe + Coller sur ton site
```

**C'est tout ! 🎉**
