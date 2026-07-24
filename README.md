# 🚗 CoRide

## Projet réalisé par

- **Soukaina EN-NAOUR**
- **Taha Mouaddine**

---

# Présentation

CoRide est une application web de covoiturage développée pour **MobiliTech**, une startup spécialisée dans les solutions de mobilité durable en entreprise.

L'objectif est de permettre aux employés d'une même entreprise de partager leurs trajets domicile-travail tout en utilisant une intelligence artificielle pour évaluer la compatibilité entre un conducteur et un passager.

---

# Technologies utilisées

- Laravel 13
- PHP 8.3
- MySQL
- Blade
- Laravel Breeze
- Laravel AI
- Eloquent ORM

---

# Architecture du projet

Le projet suit l'architecture **MVC (Model – View – Controller)** de Laravel.

## Models

Les modèles représentent les entités principales :

- Entreprise
- Employe
- Trajet
- Reservation

Ils contiennent les relations Eloquent ainsi que les règles métier.

---

## Controllers

Les contrôleurs gèrent les interactions entre les vues et les modèles.

Principaux contrôleurs :

- TrajetController
- ReservationController
- DashboardController

---

## Form Requests

Les Form Requests assurent la validation des données saisies avant leur traitement.

Exemples :

- création d'un trajet
- modification d'un trajet
- réservation d'une place

---

## Policies

Les Policies assurent la sécurité de l'application en contrôlant les autorisations des utilisateurs.

Exemples :

- suppression d'un trajet
- modification d'une réservation

---

## Enums

Les Enums permettent de représenter des valeurs métier.

- RoleEmploye
- StatutReservation

---

## Services

Les Services regroupent la logique métier complexe afin d'alléger les contrôleurs.

Exemple :

- CompatibiliteIAService

---

## Value Objects et Casts

Le projet utilise un Value Object ainsi qu'un Cast personnalisé afin de manipuler les résultats de l'IA de manière propre.

- CompatibiliteIA
- CompatibiliteIACast

---

# Structure du projet

```
app/
 ├── Ai/
 ├── Casts/
 ├── Enums/
 ├── Http/
 │    ├── Controllers/
 │    └── Requests/
 ├── Models/
 ├── Policies/
 ├── Providers/
 ├── Services/
 └── ValueObjects/

database/
 ├── migrations/
 ├── factories/
 ├── seeders/

resources/
 └── views/

routes/
 └── web.php
```

---

# Brique Intelligence Artificielle

Le projet intègre Laravel AI afin de calculer un score de compatibilité entre un conducteur et un passager.

## Fonctionnement

1. Le passager consulte un trajet.
2. Le contrôleur vérifie que l'utilisateur est bien un passager.
3. Le contrôleur appelle le **CompatibiliteIAService**.
4. Le service communique avec **CompatibiliteAgent**.
5. L'agent retourne une réponse structurée.
6. Cette réponse est convertie grâce au **CompatibiliteIACast**.
7. Les données sont stockées dans le **Value Object CompatibiliteIA**.
8. Le score est affiché dans la vue.

L'IA est utilisée uniquement pour les passagers et jamais pour le conducteur du trajet.

---

# Principales règles métier

- Un employé possède un email professionnel unique.
- Un employé appartient à une seule entreprise.
- Une réservation est unique par passager et par trajet.
- Les transitions de statut sont contrôlées.
- Un trajet confirmé ne peut pas être supprimé.
- Le nombre de réservations confirmées ne peut pas dépasser le nombre de places disponibles.
- Les Policies protègent les opérations sensibles.
- L'intégrité référentielle est assurée grâce aux clés étrangères.

---

# Répartition des tâches

## 👨‍💻 Taha Mouaddine

- Modèles Eloquent
- Relations entre les entités
- Migrations
- Factories
- Seeders
- Service IA
- Agent IA
- Routes principales
- Contrôleurs de consultation

---

## 👩‍💻 Soukaina EN-NAOUR

- Gestion des statuts des réservations
- Validation des formulaires
- Policies et sécurité
- CRUD des trajets
- Dashboard conducteur
- Structured Output de Laravel AI
- Vues Blade
- Tests de l'intelligence artificielle

---

# Installation

```bash
composer install
```

```bash
cp .env.example .env
```

Configurer la base de données dans le fichier `.env`.

```bash
php artisan key:generate
```

```bash
php artisan migrate:fresh --seed
```

```bash
npm install
```

```bash
npm run dev
```

```bash
php artisan serve
```

---

# Fonctionnalités

- Authentification avec Laravel Breeze
- Gestion des entreprises
- Gestion des employés
- Gestion des trajets
- Réservation de places
- Tableau de bord conducteur
- Validation des formulaires
- Gestion des autorisations
- Calcul IA de compatibilité
- Affichage des résultats IA
- Base de données alimentée par Seeders

---

# Auteur

Projet réalisé dans le cadre de la formation Simplon.

Développé par :

- **Soukaina EN-NAOUR**
- **Taha Mouaddine**