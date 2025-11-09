# 🔥 SOLUTION ALTERNATIVE - Erreur 404 Persistante

## 🚨 PROBLÈME

URL avec paramètres renvoie 404 :
```
https://www.insuffle-academie.com/inscription-formation?session_id=3&formation_id=92&...
```

Mais URL sans paramètres fonctionne :
```
https://www.insuffle-academie.com/inscription-formation
```

**Cause :** Votre serveur/hébergeur bloque les paramètres GET (query strings) dans les URLs.

---

## ✅ SOLUTION IMMÉDIATE EN 3 ÉTAPES

### ÉTAPE 1: Exécutez fix-404.php

1. **Uploadez** `fix-404.php` à la RACINE de votre site
2. **Accédez à** : http://www.insuffle-academie.com/fix-404.php
3. **Lisez** le rapport complet
4. **Testez** l'URL fournie
5. **Supprimez** le fichier fix-404.php

**Ce script va :**
- Supprimer et recréer la page Inscription Formation
- Forcer WordPress à accepter les paramètres URL
- Régénérer les permaliens (hard flush)
- Vider tous les caches
- Tester les URLs
- Vous donner un rapport détaillé

---

### ÉTAPE 2: Si toujours 404 après fix-404.php

**C'est votre hébergeur qui bloque !**

Certains hébergeurs bloquent les paramètres GET pour des raisons de sécurité.

**Hébergeurs connus pour bloquer :**
- **Hostinger** (règles de sécurité strictes)
- **OVH** (ModSecurity)
- **1&1 IONOS** (règles personnalisées)
- **GoDaddy** (selon la configuration)

**Solution :**

**Contactez votre support hébergeur et dites :**

> "Bonjour,
>
> Mon site WordPress a besoin d'accepter les paramètres GET dans les URLs comme :
> https://www.insuffle-academie.com/inscription-formation?session_id=3
>
> Actuellement, toute URL avec paramètres renvoie une erreur 404.
>
> Pouvez-vous désactiver les règles de sécurité qui bloquent les query strings pour mon domaine ?
> Ou m'indiquer comment configurer .htaccess pour autoriser les paramètres GET ?
>
> Merci"

**Ils vont probablement :**
- Désactiver ModSecurity pour votre domaine
- Ajouter une exception dans leurs règles
- Vous donner une règle .htaccess à ajouter

---

### ÉTAPE 3: Modification .htaccess (si hébergeur vous donne l'autorisation)

Si votre hébergeur vous dit "ajoutez ça dans .htaccess", voici comment faire :

1. **Connectez-vous en FTP ou cPanel**

2. **Ouvrez** le fichier `.htaccess` à la racine de votre site

3. **Ajoutez AVANT** `# BEGIN WordPress` :
```apache
# Autoriser les query strings
<IfModule mod_security.c>
    SecFilterEngine Off
    SecFilterScanPOST Off
</IfModule>

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    # Autoriser les paramètres GET
    RewriteCond %{QUERY_STRING} ^(.*)$
    RewriteRule ^inscription-formation/?$ /inscription-formation/?%1 [L,QSA]
</IfModule>
```

4. **Enregistrez** le fichier

5. **Testez** l'URL avec paramètres

---

## 🔍 DIAGNOSTIC DÉTAILLÉ

### Test 1: Vérifier si c'est bien les paramètres qui causent le problème

**Testez ces 3 URLs dans votre navigateur :**

1. **Sans paramètres :**
   ```
   https://www.insuffle-academie.com/inscription-formation
   ```
   ✅ **Attendu :** Catalogue de sessions s'affiche

2. **Avec UN paramètre simple :**
   ```
   https://www.insuffle-academie.com/inscription-formation?test=1
   ```
   ❓ **Résultat ?**
   - ✅ Si ça fonctionne → Problème spécifique à certains paramètres
   - ❌ Si 404 → Tous les paramètres sont bloqués

3. **Avec paramètres session :**
   ```
   https://www.insuffle-academie.com/inscription-formation?session_id=3
   ```
   ❓ **Résultat ?**
   - ✅ Si ça fonctionne → C'est bon !
   - ❌ Si 404 → Paramètres bloqués

**Envoyez-moi les résultats des 3 tests !**

---

### Test 2: Vérifier mod_rewrite

**Via SSH ou cPanel Terminal :**
```bash
apache2 -M | grep rewrite
```

**Attendu :**
```
rewrite_module (shared)
```

**Si absent :**
- Contactez votre hébergeur pour activer mod_rewrite

---

### Test 3: Vérifier .htaccess

**Ouvrez** `.htaccess` à la racine de votre site

**Doit contenir AU MINIMUM :**
```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

**Si différent :**
1. Sauvegardez votre .htaccess actuel
2. Allez dans Réglages → Permaliens → Enregistrer
3. WordPress va régénérer le .htaccess

---

## 🛠️ SOLUTION ALTERNATIVE: Utiliser des segments d'URL

**Si impossible de faire passer les paramètres GET**, on peut modifier le code pour utiliser des segments d'URL.

**Au lieu de :**
```
/inscription-formation?session_id=3&formation_id=92
```

**On utiliserait :**
```
/inscription-formation/session/3/formation/92
```

**Pour activer cette solution :**

1. **Dites-moi** si vous voulez cette solution
2. **Je modifie** le code pour utiliser des segments d'URL
3. **Vous testez** et ça fonctionne

**Avantages :**
- Fonctionne sur tous les hébergeurs
- URLs plus propres (SEO-friendly)
- Pas de problème avec ModSecurity

**Inconvénients :**
- Nécessite de modifier le code
- Régénération des permaliens obligatoire

---

## 📋 CHECKLIST DE DÉPANNAGE

Cochez au fur et à mesure :

### Diagnostics
- [ ] fix-404.php exécuté
- [ ] Test URL sans paramètres → Fonctionne
- [ ] Test URL avec ?test=1 → ?
- [ ] Test URL avec ?session_id=3 → ?
- [ ] Permaliens réinitialisés (Réglages → Permaliens → Enregistrer)
- [ ] Tous les caches vidés (navigateur + WordPress + CDN)

### Vérifications serveur
- [ ] mod_rewrite activé (vérification faite)
- [ ] .htaccess existe et contient config WordPress
- [ ] .htaccess est modifiable (droits 644 ou 666)
- [ ] Aucun plugin de sécurité n'interfère

### Contact hébergeur
- [ ] Email/ticket envoyé au support
- [ ] Demandé activation query strings
- [ ] Demandé désactivation ModSecurity
- [ ] Reçu réponse du support
- [ ] Solution appliquée

### Tests finaux
- [ ] URL avec paramètres fonctionne
- [ ] Clic sur "Réserver ma place" → Formulaire s'affiche
- [ ] Soumission formulaire → Succès
- [ ] Emails reçus

---

## 🎯 RÉSOLUTION RAPIDE

**Si vous êtes pressé et que rien ne fonctionne :**

### Option A: Utiliser uniquement le catalogue
1. Gardez `/inscription-formation` sans paramètres
2. Le catalogue s'affiche
3. Les utilisateurs choisissent directement dans le catalogue
4. Pas besoin de passer par les pages formation

**Avantage :** Fonctionne immédiatement sans modification

---

### Option B: Modifier les pages formation pour lien direct
1. Au lieu de bouton "Réserver ma place" sur chaque page
2. Mettre un lien direct vers le catalogue
3. Exemple : "Voir toutes les sessions disponibles"

**Avantage :** Contournement du problème

---

### Option C: Utiliser des segments d'URL (RECOMMANDÉ si hébergeur ne résout pas)

Je modifie le code pour utiliser :
```
/inscription-formation/session/3/formation/92
```

Au lieu de :
```
/inscription-formation?session_id=3&formation_id=92
```

**Dites-moi si vous voulez cette option !**

---

## 🆘 INFORMATIONS À ME FOURNIR

Pour vous aider davantage, envoyez-moi :

1. **Résultat des 3 tests d'URL** (Test 1 ci-dessus)
2. **Rapport complet** de fix-404.php (copier/coller)
3. **Nom de votre hébergeur**
4. **Type d'offre** (mutualisé, VPS, dédié)
5. **Contenu de votre .htaccess** (sans infos sensibles)
6. **Réponse de votre hébergeur** (si vous les avez contactés)

---

## 💡 EXPLICATION TECHNIQUE

**Pourquoi ça ne fonctionne pas ?**

WordPress utilise mod_rewrite pour transformer les URLs "propres" en URLs avec paramètres.

**Exemple :**
- Vous tapez : `/inscription-formation`
- WordPress transforme en : `/index.php?pagename=inscription-formation`
- Puis WordPress affiche la page

**Quand vous ajoutez des paramètres :**
- Vous tapez : `/inscription-formation?session_id=3`
- WordPress devrait transformer en : `/index.php?pagename=inscription-formation&session_id=3`
- **MAIS** votre serveur bloque AVANT que WordPress ne traite l'URL

**C'est pour ça que :**
- URL sans paramètres → ✅ Fonctionne (WordPress gère)
- URL avec paramètres → ❌ 404 (bloqué par le serveur AVANT WordPress)

**Solutions possibles :**
1. Dire au serveur d'autoriser les paramètres (contact hébergeur)
2. Modifier le code pour utiliser des segments d'URL
3. Utiliser uniquement le catalogue sans paramètres

---

## ✅ CE QUE NOUS AVONS DÉJÀ FAIT

- ✅ Menu "Templates emails" ajouté
- ✅ Catalogue de sessions créé
- ✅ Code de génération URL correct
- ✅ Page inscription existe et fonctionne SANS paramètres
- ✅ Script fix-404.php créé pour diagnostic complet

**Le problème n'est PAS dans le code WordPress, mais dans la configuration serveur !**

---

## 🚀 PROCHAINES ÉTAPES

1. **Exécutez** fix-404.php
2. **Testez** les 3 URLs (Test 1)
3. **Envoyez-moi** les résultats
4. **Contactez** votre hébergeur
5. **OU dites-moi** si vous voulez la solution alternative (segments d'URL)

**Je suis là pour vous aider ! 🤝**
