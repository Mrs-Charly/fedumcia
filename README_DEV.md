# Fedumcia — README DEV (handoff IA)

## 1) Contexte projet

**Fedumcia** est une agence locale (Vesoul / Haute-Saône 70) spécialisée en :

- **Attractivité visuelle** (photos / vidéos, contenus réseaux sociaux)
- **Confiance client** (gestion e-réputation : avis Google / Facebook, réponses aux avis, stratégie de collecte)

### Objectifs du site

- Présenter l’offre et les packs
- Générer des prises de rendez-vous
- Permettre la création de comptes clients
- Gestion admin : RDV + demandes de pack (workflow de validation)

### Stack technique

- **Laravel 12.x** — PHP 8.3
- **MySQL**
- Front : Blade + Tailwind (Breeze) / composants Laravel
- Environnement local : Laragon

---

## 2) Fonctionnalités implémentées (état actuel)

### Public

- Page **Home** (hero, concept, packs, formulaire RDV, avis, partenaires)
- Page **Packs** (liste + détail)
- Page **À propos** (présentation / portfolio) — contenu basique (à enrichir)

### Auth / Comptes

- Auth Breeze : inscription / connexion / reset password
- Création d’un compte possible **sans RDV**
- Lors de la **confirmation RDV par email** :
  - si l’utilisateur n’existe pas : création du user + email vérifié
  - envoi automatique d’un lien pour définir le mot de passe

### RDV (sans créneaux)

- Formulaire RDV sur la home :
  - `first_name`, `last_name`, `email`, `phone`, `company_name`
  - `scheduled_at`, `desired_pack_id`, `consent`
- Anti-double réservation : **un RDV par datetime**
- Confirmation par email via token :
  - status `pending` → `confirmed`
  - association à un user

### Packs (workflow sécurisé)

- Un user ne change **jamais directement** son pack
- Il crée une **demande de changement** (`PackChangeRequest`)
- Statut initial : `pending`
- Action admin :
  - **approve** → met à jour `users.pack_id`
  - **reject** → refuse la demande

✅ Si un pack est sélectionné lors du RDV,  
une `PackChangeRequest (pending)` est créée automatiquement à la confirmation.

### Admin

Routes sous `/admin` protégées par le middleware `admin` :

- Dashboard admin
- Liste des RDV + détails + annulation
- Liste des demandes de pack (approve / reject)

### Navigation

- Navbar dynamique :
  - utilisateur : **Mon pack**, **Mon compte**
  - admin : **Administration**
- Vérifier l’existence des routes avec `Route::has()`

---

## 3) Modèles / Tables

### users

- `is_admin` (bool)
- `pack_id` (nullable, FK packs)

### packs

- `name`, `slug`, `price_eur`, `tagline`
- `is_active`, `sort_order`

### appointments

- Identité + contact + entreprise
- `scheduled_at` (datetime)
- `desired_pack_id` (nullable)
- `status` : `pending | confirmed | cancelled`
- `confirmation_token` (UUID)
- RGPD :
  - `consent`
  - `consent_at`
  - `consent_ip`
  - `consent_user_agent`
- `user_id` (nullable)
- `confirmed_at`

### pack_change_requests

- `user_id`
- `current_pack_id` (nullable)
- `requested_pack_id`
- `status` : `pending | approved | rejected`
- `message`
- `processed_by`
- `approved_at` / `rejected_at`

---

## 4) Routes clés

### Public

- `GET /`
- `GET /packs`
- `GET /packs/{slug}`
- `GET /a-propos`

### RDV

- `POST /rendezvous`
- `GET /rendezvous/merci`
- `GET /rendezvous/confirm/{token}`

### User

- `GET /compte`
- `GET /mon-pack`
- `POST /mon-pack` (crée une demande)

### Admin

- `GET /admin`
- `GET /admin/appointments`
- `GET /admin/appointments/{appointment}`
- `POST /admin/appointments/{appointment}/cancel`
- `GET /admin/pack-requests`
- `POST /admin/pack-requests/{id}/approve`
- `POST /admin/pack-requests/{id}/reject`

---

## 5) Emails

- Confirmation de RDV (MAIL_MAILER=log en dev)
- Lien de création de mot de passe après confirmation RDV
- Aucun email marketing sans consentement explicite

---

## 6) RGPD / conformité

- Consentement obligatoire lors du RDV
- Stockage minimal :
  - date
  - IP
  - user-agent
- Finalité :
  - gestion du RDV
  - gestion du compte
- À prévoir :
  - mentions légales
  - politique de confidentialité
  - gestion cookies (si analytics)

---

## 7) Commandes utiles

### Installation

```bash
composer install
npm install
npm run dev
```

### Configuration environnement

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

### Nettoyage cache

```bash
php artisan optimize:clear
```

### Lister les routes

```bash
php artisan route:list
```

---

## 8) Données de test

Seeders existants :

- `AdminUserSeeder`
- `PackSeeder`
- `DatabaseSeeder`

---

## 9) TODO priorisé

### P1 — UX / stabilité

- Validation des créneaux RDV (futur uniquement, 00 / 30)
- Limitation horaires (9h–18h, lundi–vendredi)
- Affichage erreurs validation sous les champs

### P1 — Admin

- Vue agenda
- Journalisation annulations

### P2 — Contenus

- Portfolio détaillé
- CRUD avis / partenaires

### P2 — Légal

- Mentions légales
- Politique de confidentialité
- CGU / CGV si nécessaire

### P3 — Sécurité

- Rate limiting RDV
- Honeypot
- Logs / monitoring

---

## 10) Règles pour génération IA

- Respecter Laravel 12 + Blade / Tailwind
- Ne pas introduire de paiement en ligne
- Conserver le workflow de demande de pack
- Respecter le RGPD
- Proposer des migrations si nécessaire
- Grouper les routes `/admin`

---

### Améliorations optionnelles

- Section **Accès admin** (email du compte seed)
- Section **Arborescence du projet**

---

## 11) Arborescence (repères importants)

> Cette section décrit uniquement les dossiers/fichiers clés du projet pour
> permettre à une IA ou un développeur de comprendre rapidement l’organisation.

### app/
- **Http/Controllers/**
  - `HomeController` → page d’accueil (home)
  - `AboutController` → page à propos
  - `AppointmentController` → prise de RDV + confirmation email
  - `AccountController` → espace compte utilisateur
  - `UserPackController` → consultation pack + demande de changement
  - `Auth/AuthenticatedSessionController` → login + redirection admin/user
  - `Admin/`
    - `AppointmentAdminController` → gestion RDV côté admin
    - `PackChangeRequestAdminController` → approve / reject demandes de pack

- **Models/**
  - `User` → utilisateurs (admin / client)
  - `Pack` → offres commerciales
  - `Appointment` → rendez-vous
  - `PackChangeRequest` → workflow sécurisé de changement de pack

- **Mail/**
  - `AppointmentConfirmationMail` → email de confirmation RDV

- **Http/Middleware/**
  - `Admin` → protège les routes `/admin`

---

### resources/views/
- **layouts/**
  - `public.blade.php` → layout pages publiques
  - `app.blade.php` → layout authentifié
  - `navigation.blade.php` → navbar utilisateurs/admin
- **partials/**
  - `public-nav.blade.php` → navigation publique
- **home.blade.php** → page d’accueil
- **packs/**
  - `index.blade.php` → liste packs
  - `show.blade.php` → détail pack
- **appointments/**
  - `thanks.blade.php`
  - `confirmed.blade.php`
- **account/**
  - `dashboard.blade.php`
- **admin/**
  - `dashboard.blade.php`
  - `appointments.blade.php`
  - `pack-requests.blade.php`
- **auth/**
  - vues Breeze (login, register, forgot-password…)

---

### routes/
- `web.php` → routes publiques, user et admin (groupes protégés)

---

### database/
- **migrations/**
  - users, packs, appointments, pack_change_requests
- **seeders/**
  - `AdminUserSeeder`
  - `PackSeeder`
  - `DatabaseSeeder`

---

### config / divers
- `.env` → **NE JAMAIS VERSIONNER**
- `tailwind.config.js` → styles
- `vite.config.js` → build front
