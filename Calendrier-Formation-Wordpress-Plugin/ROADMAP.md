# Roadmap - Calendrier Formation Plugin

## 🎯 Fonctionnalités à Implémenter

### 🔴 Haute Priorité

#### 1. Amélioration de la jauge de places disponibles
**Problème**: Avec 2 places disponibles sur 10, la jauge reste verte et affiche 3/4 de remplissage
**Solution**:
- Revoir le calcul du pourcentage (actuellement inversé)
- Implémenter un code couleur intuitif:
  - 🟢 Vert: 70-100% de places disponibles
  - 🟠 Orange: 30-69% de places disponibles
  - 🔴 Rouge: 0-29% de places disponibles
- Afficher clairement "X/Y places disponibles"

#### 2. Boutons +/- pour gestion rapide des places
**Localisation**: Liste des sessions (templates/sessions.php)
**Fonctionnalités**:
- Bouton `+` pour ajouter une place disponible (inscription)
- Bouton `-` pour retirer une place disponible (nouvelle réservation)
- Mise à jour AJAX sans rechargement de page
- Affichage du compteur en temps réel
- Protection: ne pas descendre sous 0 places disponibles

#### 3. Badge "Edition Spéciale"
**Description**: Marquer certaines formations comme uniques/spéciales
**Implémentation**:
- Ajouter champ boolean `is_edition_speciale` dans table sessions
- Checkbox dans formulaire d'ajout/modification session
- Badge visuel très distinctif sur le frontend
- Possibilité de filtrer les éditions spéciales dans l'admin

#### 4. Version Tableau du Shortcode
**Problème**: Avec 10+ sessions, l'affichage en cartes devient illisible
**Solution**:
- Créer nouveau shortcode `[cf_sessions_table]` ou paramètre `display="table"`
- Colonnes: Date | Titre | Durée | Lieu | Places | Actions
- Responsive: passer en cartes sur mobile
- Tri par colonne (date, places, titre)
- Pagination si > 10 sessions

#### 5. Formulaire de Réservation Professionnel
**Problème**: Le formulaire actuel est vide
**Besoins**:
- **Informations Personne**:
  - Civilité (M./Mme/Autre)
  - Prénom et Nom
  - Email professionnel
  - Téléphone
  - Fonction dans l'entreprise

- **Informations Entreprise**:
  - Raison sociale
  - SIRET
  - Adresse complète
  - Secteur d'activité
  - Taille de l'entreprise

- **Détails Réservation**:
  - Session sélectionnée (pré-remplie)
  - Nombre de participants
  - Besoins spécifiques / Commentaires
  - Facturation (devis/prise en charge)

- **Aspects Pro**:
  - Design soigné et rassurant
  - Validation des champs en temps réel
  - Messages de confirmation clairs
  - Email de confirmation automatique
  - Stockage sécurisé des données (RGPD)
  - Export admin des réservations

### 🟠 Moyenne Priorité

#### 6. Harmonisation Graphique
**Problème**: Styles trop différents du thème de base
**Actions**:
- Utiliser les variables CSS du thème parent
- Adapter les couleurs aux couleurs primaires/secondaires du thème
- Revoir les espacements et typographies
- Tester avec différents thèmes WordPress populaires

#### 7. Configuration des Boutons d'Action
**Localisation**: Shortcode frontend
**Fonctionnalités**:
- Option `button_type` dans shortcode: `"reserver"` ou `"info"`
- Bouton "Réserver" → redirige vers page inscription (ID configurable dans settings)
- Bouton "+ d'infos" → redirige vers page contact
- Permettre les deux boutons simultanément
- Style différencié (primaire vs secondaire)

### 🟢 Basse Priorité

#### 8. Export des Sessions
- Export CSV/Excel des sessions
- Export PDF avec planning visuel
- Import/Export pour backup

#### 9. Notifications Email
- Email admin lors de nouvelle réservation
- Email client lors de confirmation
- Rappel automatique avant la session
- Templates personnalisables

#### 10. Statistiques Avancées
- Taux de remplissage moyen
- Sessions les plus populaires
- Évolution des réservations
- Graphiques dans le dashboard

---

## ✅ Fonctionnalités Déjà Implémentées

- ✅ Création/Modification/Suppression de sessions
- ✅ Calendrier interactif avec drag & drop
- ✅ Support places illimitées (champ vide = -1)
- ✅ Protection contre double soumission
- ✅ Affichage shortcode avec filtrage
- ✅ Dates sans horaires
- ✅ Suppression notion de couleur manuelle
- ✅ Modification depuis liste des sessions
- ✅ Dashboard avec statistiques de base
- ✅ Plugin Documents Formation (plaquettes)

---

## 📝 Notes de Développement

### Ordre Recommandé d'Implémentation

1. **Jauge de places** (impact visuel immédiat, rapide à implémenter)
2. **Boutons +/-** (améliore l'ergonomie admin)
3. **Formulaire de réservation** (fonctionnalité critique)
4. **Version tableau** (améliore la scalabilité)
5. **Badge Edition Spéciale** (valeur ajoutée marketing)
6. **Harmonisation graphique** (polish final)
7. **Configuration boutons** (flexibilité)
8. Reste selon besoins

### Considérations Techniques

- **Performance**: Avec beaucoup de sessions, optimiser les requêtes SQL
- **Sécurité**: Valider toutes les entrées utilisateur, utiliser nonces
- **RGPD**: Consentement, droit à l'oubli, export données personnelles
- **Accessibilité**: ARIA labels, navigation clavier, contraste
- **Mobile**: Tout doit être parfaitement utilisable sur smartphone

### Base de Données

Nouvelles tables potentiellement nécessaires:
- `wp_cf_reservations` (pour le formulaire de réservation)
- `wp_cf_reservation_meta` (métadonnées réservations)

Nouveaux champs dans `wp_cf_sessions`:
- `is_edition_speciale` (tinyint)

---

## 🚀 Version Cible

**v2.0.0** - Plugin complet et production-ready avec toutes les fonctionnalités critiques

**Prochaine Release**: v1.1.0 avec jauge, boutons +/-, et formulaire de réservation
