# CoRide — Code source (MobiliTech)

Structure d'app Laravel 12 (fichiers `app/`, `database/`, `routes/`,
`resources/views/`). A copier dans un projet `laravel new coride` existant
(`composer require laravel/breeze laravel/ai` puis coller ces fichiers).

## Repartition des fichiers par developpeur

### 👨‍💻 Taha — Entites, modeles, IA (moteur), seeders

| Fichier | Epic / Tache |
|---|---|
| `app/Enums/RoleEmploye.php` | Epic 2 — Identifier les entites |
| `app/Models/Entreprise.php` | Epic 3 — Modele Entreprise |
| `app/Models/Employe.php` | Epic 3 — Modele Employe + relations |
| `app/Models/Trajet.php` | Epic 3 — Modele Trajet + relations |
| `app/Models/Reservation.php` (partie relations) | Epic 3 — Modele Reservation |
| `app/Casts/CompatibiliteIACast.php` | Epic 5 — US8, Cast personnalise |
| `app/ValueObjects/CompatibiliteIA.php` | Epic 5 — support du Cast |
| `app/Ai/Agents/CompatibiliteAgent.php` | Epic 5 — Installer Laravel AI |
| `app/Services/CompatibiliteIAService.php` | Epic 5 — Service de compatibilite IA |
| `app/Http/Controllers/ReservationController.php` | Epic 3 — Contrôleur Reservation, verif places, anti-doublon |
| `app/Http/Controllers/TrajetController.php` (index/show) | Epic 4 — Liste des trajets / détail |
| `database/migrations/*` (structure) | Epic 2 — Configurer la base de données |
| `database/factories/*.php` | Epic 2 — Factories |
| `database/seeders/*.php` | Epic 2 — Seeders + import CSV |
| `routes/web.php` (squelette) | Epic 1 — Créer le Sprint / routes |

### 👩‍💻 Soukaina — Règles métier, sécurité, vues, IA (structured output)

| Fichier | Epic / Tache |
|---|---|
| `app/Enums/StatutReservation.php` | Epic 3 — Contrôler les transitions de statut |
| `app/Models/Reservation.php::changerStatut()` | Epic 3 — Gérer les statuts des réservations |
| `app/Models/Trajet.php::peutEtreSupprime()` | Epic 3 — Bloquer suppression trajet confirmé |
| `app/Http/Requests/*.php` | Epic 3 — Form Requests + validations |
| `app/Policies/TrajetPolicy.php`, `ReservationPolicy.php` | Epic 4 — Vérifier la sécurité |
| `app/Providers/AppServiceProvider.php` | Epic 4 — Enregistrement des policies |
| `app/Http/Controllers/TrajetController.php` (store/update/destroy) | Epic 3 — CRUD trajets |
| `app/Http/Controllers/DashboardController.php` | Epic 4 — Tableau de bord conducteur |
| `app/Ai/Agents/CompatibiliteAgent.php::schema()` | Epic 5 — Structured Output |
| `resources/views/**/*.blade.php` | Epic 4 — Vues Blade (liste, détail, réservations, dashboard) |
| Tests sur `database/seeders/data/*.csv` | Epic 5 — Tester les réponses IA / tests finaux |

## Regles de gestion couvertes dans le code

- Un employe = un email pro unique, une seule entreprise (`employes.email` unique, `entreprise_id` NOT NULL).
- Conducteur/passager/les deux → `RoleEmploye` + `Employe::estConducteur()/estPassager()`.
- Places vs reservations confirmees → `Trajet::placesRestantes()`, verifie dans `Reservation::changerStatut()`.
- Anti-doublon reservation → contrainte unique `(trajet_id, passager_id)` + `StoreReservationRequest`.
- Transitions de statut controlees → `StatutReservation::transitionsAutorisees()` + `Reservation::changerStatut()`.
- Suppression bloquee si reservations confirmees → `Trajet::peutEtreSupprime()` + `TrajetPolicy::delete()`.
- Score IA uniquement cote passager, jamais cote conducteur → verifie dans `TrajetController::show()`
  (`$user->estPassager() && ! $estConducteurDuTrajet`) avant tout appel au service IA.
- Integrite referentielle → `cascadeOnDelete()` sur toutes les cles etrangeres.

## Mise en route (une fois copie dans un projet Laravel)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```
