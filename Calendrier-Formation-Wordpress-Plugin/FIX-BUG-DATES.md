# Correction : Bug de modification automatique des dates

## Problème identifié

**Symptôme** : Lorsqu'on modifie une session et qu'on revient dessus, les dates changent automatiquement (ajoutent ou suppriment des jours).

**Cause** : Problème de conversion de fuseau horaire dans la fonction JavaScript `formatDateForInput()`.

## Explication technique

### Avant (code buggé)

```javascript
function formatDateForInput(dateStr) {
    const date = new Date(dateStr);
    return date.toISOString().slice(0, 10);
}
```

**Ce qui se passait** :
1. MySQL stocke la date : `2024-01-15 00:00:00`
2. JavaScript reçoit cette chaîne
3. `new Date("2024-01-15 00:00:00")` crée un objet Date dans le **fuseau horaire local**
4. Si l'utilisateur est en UTC+1, JavaScript interprète `2024-01-15 00:00:00 UTC+1`
5. `toISOString()` convertit en UTC : `2024-01-14T23:00:00.000Z`
6. On extrait la date : `2024-01-14` ❌ **La date a changé !**

### Après (code corrigé)

```javascript
function formatDateForInput(dateStr) {
    // Extraire uniquement la partie date (YYYY-MM-DD) sans conversion
    if (!dateStr) return '';
    return dateStr.substring(0, 10);
}
```

**Ce qui se passe maintenant** :
1. MySQL stocke la date : `2024-01-15 00:00:00`
2. JavaScript reçoit cette chaîne
3. On extrait directement les 10 premiers caractères : `2024-01-15`
4. Pas de conversion de fuseau horaire ✅ **La date reste identique !**

## Fichiers modifiés

- `Calendrier-Formation-Wordpress-Plugin/templates/sessions.php`
  - Ligne 406-412 : Fonction `formatDateForInput()` corrigée

## Vérification

Pour vérifier que le bug est corrigé :

1. Créez une session avec une date spécifique (ex: 15/01/2025)
2. Enregistrez
3. Cliquez sur "Modifier" pour cette session
4. Vérifiez que la date affichée dans le formulaire est bien 15/01/2025
5. Fermez et ré-ouvrez plusieurs fois
6. La date doit rester identique ✅

## Cas concernés

Ce bug affectait :
- ✅ Toutes les dates de début de session
- ✅ Toutes les dates de fin de session
- ✅ Tous les fuseaux horaires (surtout UTC+1, UTC+2, etc.)

## Pourquoi ce bug était critique

- ❌ Les sessions pouvaient être décalées d'un jour sans que l'administrateur ne s'en rende compte
- ❌ Risque de confusion pour les participants
- ❌ Problème récurrent à chaque modification
- ❌ Perte de confiance dans le système

## Solution technique détaillée

### Stockage MySQL
Les dates sont stockées au format : `YYYY-MM-DD HH:MM:SS`
- Date de début : `YYYY-MM-DD 00:00:00`
- Date de fin : `YYYY-MM-DD 23:59:59`

### Formulaire HTML
Le champ `<input type="date">` attend le format : `YYYY-MM-DD`

### Conversion JavaScript
**Méthode bugée** :
```javascript
new Date("2024-01-15 00:00:00") // Interprété avec fuseau horaire local
```

**Méthode correcte** :
```javascript
"2024-01-15 00:00:00".substring(0, 10) // Extraction directe, pas de conversion
```

## Bonnes pratiques

Pour éviter ce type de bug à l'avenir :

1. ✅ Ne jamais utiliser `new Date()` avec des dates MySQL
2. ✅ Toujours extraire directement la partie date avec `substring()` ou `split()`
3. ✅ Éviter les conversions de fuseau horaire quand on travaille uniquement avec des dates (sans heure)
4. ✅ Tester dans différents fuseaux horaires

## Tests recommandés

Après cette correction, testez avec :
- [ ] Utilisateur en UTC+0 (Londres)
- [ ] Utilisateur en UTC+1 (Paris)
- [ ] Utilisateur en UTC+2 (Helsinki)
- [ ] Utilisateur en UTC-5 (New York)

Dans tous les cas, les dates doivent rester identiques.

## Note pour les développeurs

Si vous devez manipuler des dates en JavaScript avec des heures précises, utilisez plutôt :
```javascript
// Pour une vraie date/heure avec fuseau horaire
const date = new Date(dateStr + 'Z'); // Le 'Z' indique UTC explicitement

// Pour une date seule (sans heure)
const dateParts = dateStr.split(/[-\s:]/);
const date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
```

Mais pour notre cas (juste afficher la date dans un input), la méthode `substring()` est la plus simple et la plus fiable.
