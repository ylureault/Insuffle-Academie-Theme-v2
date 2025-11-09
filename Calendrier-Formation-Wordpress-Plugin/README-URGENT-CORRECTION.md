# ⚠️ CORRECTION URGENTE - Système de Réservation

## 🚨 PROBLÈME ACTUEL

Le bouton "Réserver ma place" ne fonctionne pas correctement. Cette correction va tout réparer.

---

## ✅ SOLUTION EN 5 ÉTAPES

### ÉTAPE 1: Uploadez le fichier de réparation

1. **Téléchargez** le fichier `fix-urgent.php` depuis votre dépôt Git
2. **Uploadez-le** à la RACINE de votre site WordPress (même dossier que wp-config.php)
3. **Accédez** à l'URL : `http://votresite.com/fix-urgent.php`
4. **Lisez** le rapport complet qui s'affiche
5. **Supprimez** le fichier `fix-urgent.php` après l'exécution

**Ce script va automatiquement:**
- Créer la page "Inscription Formation" si elle n'existe pas
- Vérifier que toutes les tables existent
- Créer les templates d'emails par défaut
- Nettoyer les caches
- Vous donner un rapport complet

---

### ÉTAPE 2: Si les tables n'existent pas

**SI le script dit "Tables BDD manquantes":**

1. Allez dans **Plugins**
2. **Désactivez** le plugin "Calendrier Formation"
3. **Réactivez** le plugin "Calendrier Formation"
4. Relancez `fix-urgent.php` pour vérifier

---

### ÉTAPE 3: Créez une session de test

1. Allez dans **Agenda → Agenda**
2. Cliquez sur **Nouvelle session**
3. Remplissez:
   - **Formation:** Choisissez une formation
   - **Titre de la session:** "Session Test Janvier 2026"
   - **Date de début:** Une date FUTURE (ex: 15/01/2026)
   - **Date de fin:** Une date après le début (ex: 17/01/2026)
   - **Durée:** "3 jours"
   - **Type de localisation:** À distance ou En présentiel
   - **Places totales:** 20
   - **Places disponibles:** 20
   - **Statut:** Actif
4. Cliquez sur **Créer la session**

---

### ÉTAPE 4: Testez le shortcode

1. Allez sur une **page de formation** (page enfant de votre page "Formations")
2. Vérifiez que le shortcode `[calendrier_formation]` est présent
3. **Rafraîchissez** la page (Ctrl+F5 pour vider le cache)
4. Vous devriez voir votre session apparaître
5. Cliquez sur **"Réserver ma place"**
6. Vous devriez être redirigé vers la page "Inscription Formation"

**Si ça ne fonctionne PAS:**
- Ouvrez la console JavaScript (F12 → Console)
- Cliquez sur "Réserver ma place"
- Regardez s'il y a des erreurs
- **Envoyez-moi la capture d'écran des erreurs**

---

### ÉTAPE 5: Configurez les emails

1. Allez dans **Agenda → Templates emails**
2. Cliquez sur **Éditer** pour chaque template
3. Personnalisez le sujet et le contenu
4. Cliquez sur **Envoyer un test** pour tester
5. **IMPORTANT:** Installez un plugin SMTP pour garantir la livraison des emails

**Plugins SMTP recommandés:**
- **WP Mail SMTP** (le meilleur)
- **Easy WP SMTP**
- **Post SMTP**

Sans plugin SMTP, vos emails risquent d'aller dans les spams ou de ne pas partir.

---

## 🔍 DIAGNOSTIC DES PROBLÈMES COURANTS

### Problème: "Aucune session programmée"

**Causes possibles:**
- Aucune session n'existe
- Les sessions sont dans le passé
- Les sessions sont inactives
- La page n'est pas une page enfant de "Formations"

**Solutions:**
1. Créez des sessions avec des **dates futures**
2. Vérifiez que le statut est **Actif**
3. Vérifiez dans **Agenda → Réglages** que l'ID de la page parent Formations est correct

---

### Problème: Bouton "Réserver ma place" ne fait rien

**Causes possibles:**
- JavaScript bloqué par un autre plugin
- Alerte JavaScript encore présente
- Page d'inscription n'existe pas
- Cache non vidé

**Solutions:**
1. Exécutez `fix-urgent.php`
2. Videz TOUS les caches:
   - Cache WordPress (si plugin installé)
   - Cache navigateur (Ctrl+Shift+Del)
   - Cache hébergeur (Cloudflare, etc.)
3. Désactivez temporairement les autres plugins pour identifier un conflit
4. Ouvrez la console JavaScript (F12) et regardez les erreurs

---

### Problème: Erreur 404 après clic sur Réserver

**Cause:** La page "Inscription Formation" n'existe pas

**Solution:**
1. Exécutez `fix-urgent.php` (il va la créer automatiquement)
2. OU créez-la manuellement:
   - Pages → Ajouter
   - Titre: "Inscription Formation"
   - Contenu: `[formulaire_reservation]`
   - Publiez
   - Allez dans Agenda → Réglages
   - Mettez l'ID de cette page dans "ID page inscription"

---

### Problème: Formulaire ne s'affiche pas

**Causes possibles:**
- Shortcode mal écrit
- Session ID manquant dans l'URL
- Assets CSS/JS non chargés

**Solutions:**
1. Vérifiez que le shortcode est bien `[formulaire_reservation]` (sans espace)
2. Vérifiez que l'URL contient `?session_id=X`
3. Vérifiez dans le code source de la page que les fichiers CSS/JS sont chargés:
   - `booking-form.css`
   - `booking-form.js`

---

### Problème: Les emails ne partent pas

**Causes possibles:**
- Fonction PHP mail() désactivée
- Emails marqués comme spam
- Email expéditeur invalide

**Solutions:**
1. **INSTALLEZ un plugin SMTP** (critiques!)
2. Configurez avec Gmail, SendGrid, Amazon SES, etc.
3. Vérifiez dans **Agenda → Réglages** que l'email admin est valide
4. Utilisez "Envoyer un test" dans Templates emails pour diagnostiquer

---

## 📋 CHECKLIST COMPLÈTE

Cochez au fur et à mesure:

**Installation:**
- [ ] Script `fix-urgent.php` exécuté avec succès
- [ ] Toutes les tables BDD existent
- [ ] Page "Inscription Formation" créée et publiée
- [ ] Templates d'emails créés (3 templates)

**Configuration:**
- [ ] ID page parent Formations configuré dans Réglages
- [ ] ID page inscription configuré dans Réglages
- [ ] Email admin configuré dans Réglages
- [ ] Plugin SMTP installé et configuré

**Contenu:**
- [ ] Au moins 1 session créée avec date future
- [ ] Session avec statut "Actif"
- [ ] Shortcode `[calendrier_formation]` ajouté sur page de formation
- [ ] Session visible sur la page frontend

**Tests:**
- [ ] Clic sur "Réserver ma place" redirige vers formulaire
- [ ] Formulaire s'affiche correctement
- [ ] Remplissage et soumission du formulaire fonctionne
- [ ] Message de succès affiché après soumission
- [ ] Email reçu par le client
- [ ] Email reçu par l'admin
- [ ] Réservation visible dans Agenda → Réservations

---

## 🆘 SI ÇA NE FONCTIONNE TOUJOURS PAS

Envoyez-moi les informations suivantes:

1. **URL de votre site**
2. **Capture d'écran** de la console JavaScript (F12 → Console) après clic sur Réserver
3. **Résultat** complet du script `fix-urgent.php`
4. **Capture d'écran** de Agenda → Réglages
5. **Liste des plugins** installés (au cas où conflit)
6. **Thème** utilisé

---

## 📚 DOCUMENTATION COMPLÈTE

Une fois le système fonctionnel, consultez:

- **GUIDE-CONFIGURATION-EMAILS.md** : Configuration détaillée des emails
- **GUIDE-UTILISATION-SHORTCODES.md** : Utilisation avancée des shortcodes
- **CHANGELOG-v2.0.0.md** : Liste complète des fonctionnalités
- **TEST-CHECKLIST.md** : Checklist de tests avant production

---

## ✅ CE QUI A ÉTÉ CORRIGÉ

Dans cette version, les corrections suivantes ont été apportées:

### Correction 1: Alerte JavaScript supprimée
**Fichier:** `assets/js/frontend.js`
**Problème:** Un `confirm()` bloquait la navigation
**Solution:** Code supprimé complètement

### Correction 2: Création automatique page inscription
**Fichier:** `calendrier-formation.php` (fonction activate)
**Problème:** Page inscription n'existait pas
**Solution:** Création automatique lors de l'activation

### Correction 3: Fallback création page
**Fichier:** `includes/class-shortcode.php`
**Problème:** Si page supprimée, erreur 404
**Solution:** Création automatique si page manquante

### Correction 4: Script de diagnostic
**Fichier:** `fix-urgent.php` (nouveau)
**Problème:** Difficile de diagnostiquer les problèmes
**Solution:** Script tout-en-un qui vérifie et répare

### Correction 5: Documentation complète
**Fichiers:** Guides multiples créés
**Problème:** Manque de documentation
**Solution:** 3 guides complets créés

---

## 🎯 PROCHAINES ÉTAPES APRÈS CORRECTION

1. **Créez vos vraies sessions** de formation
2. **Personnalisez les templates** d'emails
3. **Configurez SMTP** pour garantir livraison
4. **Testez** une réservation complète de bout en bout
5. **Formez** vos utilisateurs sur le système

---

## ⚡ RAPPEL IMPORTANT

**SUPPRIMEZ `fix-urgent.php`** après utilisation pour des raisons de sécurité !

---

**Le système devrait maintenant fonctionner à 100% ! 🚀**
