# Guide : Liens de Réservation Personnalisés

## Vue d'ensemble

Cette fonctionnalité permet d'utiliser des liens de réservation externes (comme Digiforma) pour chaque session de formation, tout en gardant l'expérience utilisateur intégrée au site Insuffle Académie.

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
2. Au lieu d'afficher le formulaire interne, il redirige vers une page spéciale
3. Cette page encapsule le lien externe dans une iframe élégante
4. L'expérience reste fluide : l'utilisateur a l'impression de rester sur le site Insuffle Académie

### 3. Avantages

✅ **Aucune redirection externe visible** : le visiteur reste sur votre domaine
✅ **Expérience cohérente** : design unifié avec le site
✅ **Flexibilité** : utilisez Digiforma ou tout autre outil
✅ **Pas de régression** : les sessions sans lien personnalisé fonctionnent comme avant

## Architecture technique

### Nouveaux éléments ajoutés

#### 1. Migration de base de données
- Fichier : `includes/class-database-migration.php`
- Action : Ajoute le champ `reservation_url` à la table `wp_cf_sessions`
- Exécution : Automatique lors du chargement du plugin

#### 2. Template d'encapsulation
- Fichier : `theme/V2/template-reservation-iframe.php`
- Template WordPress qui affiche le lien externe dans une iframe
- Fonctionnalités :
  - Header avec titre de la session et bouton retour
  - Iframe plein écran pour le formulaire externe
  - Indicateur de chargement
  - Design responsive

#### 3. Modifications du plugin

**Formulaire d'administration** (`templates/sessions.php`)
- Nouveau champ pour saisir l'URL de réservation
- Validation automatique du format URL
- Texte d'aide explicatif

**AJAX Handler** (`includes/class-ajax-handler.php`)
- Sauvegarde du champ `reservation_url` lors de la création/modification de session
- Sanitization de l'URL pour la sécurité

**Shortcode** (`includes/class-shortcode.php`)
- Détection automatique des liens personnalisés
- Génération de l'URL vers le template iframe
- Création automatique de la page "Réservation" si nécessaire
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
- La page "Réservation" existe bien dans WordPress (Pages > Toutes les pages)

### L'iframe ne s'affiche pas

**Causes possibles :**
- Le site externe bloque l'affichage en iframe (X-Frame-Options)
- Solutions :
  - Contacter le support de l'outil externe
  - Vérifier les paramètres de sécurité de Digiforma

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
- Les paramètres GET sont encodés avec `urlencode()`
- Validation du format URL côté formulaire

### Performance

- Pas d'impact sur les sessions sans lien personnalisé
- La page iframe est créée une seule fois et réutilisée
- Chargement asynchrone de l'iframe

### Compatibilité

- WordPress 5.0+
- PHP 7.4+
- Testé avec Digiforma
- Compatible avec tout outil acceptant l'encapsulation iframe

## Évolutions futures possibles

- [ ] Prévisualisation du lien avant enregistrement
- [ ] Statistiques de clics sur les liens personnalisés
- [ ] Gestion de plusieurs liens par session (fallback)
- [ ] Détection automatique des erreurs iframe
- [ ] Personnalisation du design de la page iframe par session

## Support

Pour toute question ou problème, contactez l'équipe de développement.
