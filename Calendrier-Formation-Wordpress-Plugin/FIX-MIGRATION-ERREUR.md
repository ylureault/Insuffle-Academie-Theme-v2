# Correction : Erreur "Unknown column 'reservation_url'"

## Problème

Vous recevez l'erreur suivante dans l'administration :
```
Unknown column 'reservation_url' in 'field list'
```

Cette erreur se produit car le champ `reservation_url` n'a pas été ajouté à la table `wp_cf_sessions` lors de la mise à jour du plugin.

## Solutions (par ordre de préférence)

### Solution 1 : Désactiver/Réactiver le plugin ⭐ (RECOMMANDÉE)

La solution la plus simple et la plus sûre :

1. Allez dans **Extensions > Extensions installées**
2. Trouvez "Calendrier Formation"
3. Cliquez sur **Désactiver**
4. Attendez quelques secondes
5. Cliquez sur **Activer**

✅ Le champ sera automatiquement créé lors de la réactivation.

### Solution 2 : Utiliser le script de migration automatique

Le plugin vérifie maintenant automatiquement à chaque chargement si le champ existe :

1. Rechargez simplement n'importe quelle page de l'administration
2. Le champ devrait être créé automatiquement
3. Si ça ne fonctionne pas, passez à la solution 3

### Solution 3 : Exécuter le script de migration manuelle

1. Dans votre navigateur, accédez à :
   ```
   https://votre-site.com/wp-content/plugins/calendrier-formation/add-reservation-url-field.php
   ```

2. Le script va :
   - Vérifier si le champ existe
   - L'ajouter s'il n'existe pas
   - Afficher un message de confirmation

3. Une fois terminé, rafraîchissez votre page d'administration

### Solution 4 : Requête SQL manuelle (pour utilisateurs avancés)

Si les solutions précédentes ne fonctionnent pas, exécutez cette requête SQL dans phpMyAdmin ou votre interface de gestion de base de données :

```sql
ALTER TABLE wp_cf_sessions
ADD COLUMN reservation_url VARCHAR(500) DEFAULT ''
AFTER status;
```

⚠️ **Important** : Remplacez `wp_` par le préfixe de votre base de données WordPress si différent.

## Vérification

Pour vérifier que le problème est résolu :

1. Allez dans **Calendrier Formation > Sessions**
2. Cliquez sur "Modifier" pour une session existante
3. Vous devriez voir le nouveau champ "Lien de réservation personnalisé"
4. Plus aucune erreur ne devrait apparaître

## Pourquoi cette erreur ?

Cette erreur se produit lorsque :
- Le plugin a été mis à jour mais pas réactivé
- La migration automatique n'a pas pu s'exécuter
- Les permissions de la base de données sont restrictives

## Solutions préventives pour l'avenir

Le plugin a été mis à jour pour :
- ✅ Vérifier automatiquement l'existence du champ à chaque chargement
- ✅ Créer le champ lors de l'activation
- ✅ Créer le champ lors du premier chargement si manquant

Vous ne devriez plus rencontrer ce problème après cette mise à jour.

## Support

Si aucune de ces solutions ne fonctionne :
1. Vérifiez les logs d'erreur PHP
2. Vérifiez les permissions de votre utilisateur MySQL
3. Contactez votre hébergeur si le problème persiste

## Historique de la fonctionnalité

Le champ `reservation_url` a été ajouté pour permettre :
- Des liens de réservation personnalisés par session (ex: Digiforma)
- L'encapsulation des formulaires externes dans une iframe
- Une meilleure flexibilité dans la gestion des réservations

Voir le fichier `GUIDE-RESERVATION-PERSONNALISEE.md` pour plus de détails.
