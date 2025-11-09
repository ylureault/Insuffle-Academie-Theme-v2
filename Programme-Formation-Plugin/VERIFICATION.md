# ✅ Guide de Vérification - Programme Formation Plugin

## 📋 Checklist d'installation

### Étape 1 : Activation
- [ ] Plugin activé dans WordPress
- [ ] Aucune erreur PHP affichée
- [ ] Menu "Programme" visible dans l'admin

### Étape 2 : Interface Admin
- [ ] Metabox "Programme de Formation - Modules" visible sur les pages
- [ ] Metabox "Programme de Formation - Modules" visible sur les articles
- [ ] Bouton "Ajouter un module" fonctionne
- [ ] Les modules peuvent être réorganisés par glisser-déposer
- [ ] Les modules peuvent être repliés/dépliés
- [ ] Les modules peuvent être supprimés
- [ ] La prévisualisation du titre se met à jour en temps réel
- [ ] La prévisualisation du numéro se met à jour en temps réel

### Étape 3 : Sauvegarde
- [ ] Les modules sont sauvegardés correctement
- [ ] Les modules sont rechargés après sauvegarde
- [ ] L'ordre des modules est conservé
- [ ] Le HTML dans le contenu est conservé

### Étape 4 : Shortcode
- [ ] Le shortcode `[programme_formation]` fonctionne
- [ ] Les modules s'affichent correctement
- [ ] Les styles sont appliqués
- [ ] Le design est identique au HTML de référence

### Étape 5 : Styles
- [ ] Les couleurs sont correctes (violet, jaune)
- [ ] Les cercles de numéros s'affichent
- [ ] Les encadrés `.pfm-quote-block` fonctionnent
- [ ] Le design est responsive

## 🧪 Tests à effectuer

### Test 1 : Créer un module simple

1. Créez/éditez une page
2. Dans la metabox, cliquez sur "Ajouter un module"
3. Remplissez :
   - Numéro : `1`
   - Titre : `Test Module`
   - Contenu : `<p>Ceci est un test</p>`
4. Enregistrez la page
5. Ajoutez `[programme_formation]` dans le contenu
6. Visualisez la page

**Résultat attendu :**
- Module affiché avec cercle violet "1"
- Titre "Test Module" en violet
- Contenu "Ceci est un test"

### Test 2 : Créer plusieurs modules

1. Ajoutez 3 modules avec différents numéros et titres
2. Réorganisez-les par glisser-déposer
3. Enregistrez
4. Vérifiez l'affichage frontend

**Résultat attendu :**
- 3 modules affichés dans le bon ordre
- Chaque module a son numéro et titre

### Test 3 : HTML riche

Ajoutez ce contenu dans un module :

```html
<h4>📖 Contenu du module :</h4>
<ul>
    <li>✔︎ Point 1</li>
    <li>✔︎ Point 2</li>
    <li>✔︎ Point 3</li>
</ul>

<div class="pfm-quote-block">
    <strong>Important :</strong> Ceci est un encadré stylisé.
</div>
```

**Résultat attendu :**
- Liste à puces affichée
- Encadré avec fond dégradé et bordure violette
- Texte en italique dans l'encadré

### Test 4 : Champs optionnels

1. Créez un module sans numéro
2. Créez un module sans titre
3. Créez un module sans contenu
4. Enregistrez et affichez

**Résultat attendu :**
- Les modules s'affichent correctement même avec des champs vides
- Pas de "-" ou de texte vide visible

### Test 5 : Responsive

1. Créez une page avec plusieurs modules
2. Testez sur mobile (ou DevTools)
3. Vérifiez que le design s'adapte

**Résultat attendu :**
- Les modules sont lisibles sur mobile
- Les cercles de numéros sont plus petits
- Les textes sont adaptés

## 🎨 Vérification du design

### Couleurs attendues

- **Violet principal** : `#8E2183`
- **Jaune secondaire** : `#FFD466`
- **Rose accent** : `#FFC0CB`

### Éléments à vérifier

- [ ] Cercle de numéro : Fond violet avec dégradé
- [ ] Titre : Couleur violette
- [ ] Encadré quote : Fond dégradé subtil, bordure gauche violette
- [ ] Ombre des modules : Visible et douce
- [ ] Bordure gauche des modules : 6px violette

## 🔧 Dépannage

### La metabox ne s'affiche pas

**Solutions :**
1. Vérifiez que le plugin est activé
2. Videz le cache
3. Vérifiez les permissions utilisateur
4. Consultez la console pour les erreurs

### Les styles ne s'appliquent pas

**Solutions :**
1. Videz le cache navigateur (Ctrl+F5)
2. Vérifiez dans l'inspecteur que `frontend.css` est chargé
3. Vérifiez les conflits CSS avec votre thème
4. Vérifiez la console pour les erreurs

### Le glisser-déposer ne fonctionne pas

**Solutions :**
1. Vérifiez que jQuery UI Sortable est chargé
2. Vérifiez la console JavaScript
3. Désactivez les autres plugins pour tester les conflits

### Les modules ne se sauvegardent pas

**Solutions :**
1. Vérifiez les permissions PHP en écriture
2. Vérifiez la console pour les erreurs
3. Vérifiez que le nonce est valide
4. Augmentez `max_input_vars` dans php.ini si beaucoup de modules

## 📱 Tests cross-browser

- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

## 📊 Performance

- [ ] Temps de chargement < 3 secondes
- [ ] Pas d'erreurs dans la console
- [ ] CSS et JS minifiés (si production)

## ✨ Résultat final attendu

Après tous les tests, vous devriez avoir :

1. ✅ Un plugin fonctionnel et stable
2. ✅ Une interface admin intuitive
3. ✅ Un design identique au HTML de référence
4. ✅ Un système de modules flexible
5. ✅ Aucun champ obligatoire
6. ✅ Support HTML complet
7. ✅ Responsive design parfait

## 📸 Captures d'écran de référence

Comparez votre affichage avec le fichier :
`/Templates-html/formation-sketchnote.html`

Section "Programme détaillé" (lignes 982-1096)

---

**Date de vérification :** 2025-11-09
**Version du plugin :** 1.0.0
**Statut :** ✅ Prêt pour utilisation
