# Guide : Liens de Réservation Personnalisés

## Vue d'ensemble

Cette fonctionnalité permet d'utiliser des liens de réservation externes (comme Digiforma) pour chaque session de formation. Les liens externes s'ouvrent automatiquement dans un nouvel onglet pour une meilleure expérience utilisateur.

## Comment ça fonctionne ?

### 1. Configuration d'une session avec lien personnalisé

1. Allez dans **Calendrier Formation > Sessions**
2. Créez une nouvelle session ou modifiez une session existante
3. Dans le formulaire, vous trouverez un nouveau champ : **"Lien de réservation personnalisé"**
4. Collez le lien externe (exemple : `https://app.digiforma.com/guest/1823646490/training_sessions/2649393/register`)
5. Enregistrez la session

### 2. Ce qui se passe en coulisse

Lorsqu'un visiteur clique sur "Réserver ma place" pour une session avec un lien personnalisé :

1. Le système détecte automatiquement que la session a un lien externe
2. Le lien s'ouvre dans un **nouvel onglet** (target="_blank")
3. L'attribut `rel="noopener noreferrer"` est ajouté pour la sécurité
4. Le visiteur peut revenir facilement à la page des formations

### 3. Avantages

✅ **Ouverture dans nouvel onglet** : l'utilisateur garde la page d'origine ouverte
✅ **Compatible avec tous les services** : fonctionne même si le service externe bloque les iframes
✅ **Flexibilité** : utilisez Digiforma ou tout autre outil
✅ **Pas de régression** : les sessions sans lien personnalisé fonctionnent comme avant
✅ **Sécurisé** : attributs de sécurité ajoutés automatiquement

## Architecture technique

### Nouveaux éléments ajoutés

#### 1. Migration de base de données
- Fichier : `includes/class-database-migration.php`
- Action : Ajoute le champ `reservation_url` à la table `wp_cf_sessions`
- Exécution : Automatique lors du chargement du plugin

#### 2. Modifications du plugin

**Formulaire d'administration** (`templates/sessions.php`)
- Nouveau champ pour saisir l'URL de réservation
- Validation automatique du format URL
- Texte d'aide explicatif

**AJAX Handler** (`includes/class-ajax-handler.php`)
- Sauvegarde du champ `reservation_url` lors de la création/modification de session
- Sanitization de l'URL pour la sécurité

**Shortcode** (`includes/class-shortcode.php`)
- Détection automatique des liens personnalisés
- Les liens externes s'ouvrent dans un nouvel onglet avec `target="_blank"`
- Attribut `rel="noopener noreferrer"` ajouté pour la sécurité
- Fallback sur le formulaire interne si pas de lien personnalisé

## Utilisation

### Scénario 1 : Session avec Digiforma

```
1. Créez une session dans l'admin
2. Remplissez les informations habituelles (dates, places, etc.)
3. Dans "Lien de réservation personnalisé", collez :
   https://app.digiforma.com/guest/1823646490/training_sessions/2649393/register
4. Enregistrez

→ Le bouton "Réserver ma place" pointera automatiquement vers le lien Digiforma encapsulé
```

### Scénario 2 : Session avec formulaire interne

```
1. Créez une session dans l'admin
2. Remplissez les informations habituelles
3. Laissez le champ "Lien de réservation personnalisé" vide
4. Enregistrez

→ Le bouton "Réserver ma place" utilisera le formulaire interne classique
```

### Scénario 3 : Mélange des deux

```
Vous pouvez avoir :
- Certaines sessions avec lien Digiforma
- D'autres sessions avec formulaire interne
- Le système gère automatiquement les deux cas
```

## Maintenance

### Vérifier qu'une session a un lien personnalisé

Dans l'administration :
1. Allez dans **Calendrier Formation > Sessions**
2. Cliquez sur "Modifier" pour une session
3. Regardez le champ "Lien de réservation personnalisé"

### Modifier un lien personnalisé

1. Éditez la session concernée
2. Modifiez le lien dans le champ dédié
3. Enregistrez

### Supprimer un lien personnalisé

1. Éditez la session
2. Videz le champ "Lien de réservation personnalisé"
3. Enregistrez
→ La session utilisera à nouveau le formulaire interne

## Dépannage

### Le lien ne fonctionne pas

**Vérifier :**
- Le lien est bien une URL valide (commence par `https://`)
- Le lien est accessible depuis un navigateur
- Le bouton "Réserver ma place" s'affiche bien sur la session

### Le lien ne s'ouvre pas dans un nouvel onglet

**Causes possibles :**
- Le navigateur bloque les popups
- Extension de navigateur qui interfère
- JavaScript désactivé

**Solutions :**
- Autoriser les popups pour votre site
- Tester dans un autre navigateur
- Désactiver temporairement les extensions

### La migration ne s'est pas exécutée

**Solution :**
1. Désactivez le plugin
2. Réactivez-le
3. La migration devrait s'exécuter automatiquement

Ou manuellement via SQL :
```sql
ALTER TABLE wp_cf_sessions ADD COLUMN reservation_url VARCHAR(500) DEFAULT '' AFTER status;
```

## Notes techniques

### Sécurité

- Les URLs sont sanitizées avec `esc_url_raw()`
- Attribut `rel="noopener noreferrer"` pour éviter les failles de sécurité window.opener
- Validation du format URL côté formulaire
- Échappement systématique des URLs avec `esc_url()`

### Performance

- Pas d'impact sur les sessions sans lien personnalisé
- Détection du type de lien en une seule vérification
- Pas de requêtes supplémentaires à la base de données

### Compatibilité

- WordPress 5.0+
- PHP 7.4+
- Testé avec Digiforma
- Compatible avec tous les services de réservation en ligne
- Fonctionne même si le service externe bloque les iframes (contrairement à la version précédente)

## Évolutions futures possibles

- [ ] Prévisualisation du lien avant enregistrement
- [ ] Statistiques de clics sur les liens personnalisés
- [ ] Gestion de plusieurs liens par session (fallback)
- [ ] Option pour choisir entre nouvel onglet et même fenêtre
- [ ] Tracking des conversions par lien

## Support

Pour toute question ou problème, contactez l'équipe de développement.
