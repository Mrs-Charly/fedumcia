# Fedumcia — Documentation technique et guide de reprise

Ce document décrit l'état réel du projet Laravel "Fedumcia" (code présent dans ce dépôt) : architecture, fonctionnalités, règles métier, sécurité RGPD, installation et priorités. Il est destiné à d'autres IA, à un développeur senior reprenant le projet, ou à un contexte d'entreprise.

Important : ce README reflète uniquement les fonctionnalités existantes dans le code (pas de propositions de refonte).

---

## 1. Présentation du projet

- **Contexte business :** Fedumcia est une offre locale d'accompagnement en e-réputation et attractivité visuelle (photos/vidéos, contenus réseaux sociaux, gestion des avis). Le site présente les packs, permet de prendre un rendez-vous et gère les demandes internes de changement de pack.
- **Objectifs du site :** présenter l'offre, permettre aux prospects/clients de prendre un rendez-vous, capter le consentement et initier le workflow commercial (création de compte automatique après confirmation du RDV), permettre aux utilisateurs de demander un changement de pack, et fournir une interface d'administration pour valider ces demandes.
- **Public cible :** commerçants, artisans et petites entreprises locales recherchant gestion d'image et e-réputation.

## 2. Stack technique

- **Framework :** Laravel 12 (code base Laravel 12 compatible dans ce dépôt).
- **PHP :** PHP 8.3 (prérequis projet).
- **Frontend :** Blade templates + Tailwind CSS (présence de `tailwind.config.js` et vues Blade). Pas d'application SPA présente.
- **Base de données :** MySQL / MariaDB / tout RDBMS supporté par Laravel (migrations présentes pour `packs`, `appointments`, `pack_change_requests`, etc.).
- **Outils de dev :** Composer, Node (npm), Vite (fichier `vite.config.js`), PHPUnit (tests présents), artisan.

## 3. Architecture du projet (dossiers clés)

Ci-dessous les dossiers importants et leur rôle, commentés en fonction du code réel.

- `app/Http/Controllers` : contrôleurs HTTP principaux :
  - `HomeController` : affiche la page d'accueil (charge les packs actifs).
  - `PackController` : liste et montre les packs (`index`, `show`).
  - `AppointmentController` : enregistre les demandes de rendez-vous, génère un token de confirmation, envoie l'email de confirmation, confirme le RDV et crée un compte utilisateur si nécessaire.
  - `UserPackController` : interface utilisateur pour demander un changement de pack (création d'une `PackChangeRequest`).
  - `ProfileController`, `AccountController` : gestion du profil / tableau de bord utilisateur.
  - `Admin/*` : contrôleurs d'administration (gestion des rendez-vous, approbation/refus des demandes de pack).

- `app/Models` : modèles principaux :
  - `Pack` : représentation des offres (`packs` table).
  - `Appointment` : rendez-vous, contient preuve de consentement RGPD (consent, consent_at, consent_ip, consent_user_agent), status, token.
  - `PackChangeRequest` : demandes de changement de pack par utilisateur (status workflow : `pending|approved|rejected|cancelled`).
  - `User` : utilisateur (relation `pack_id` possible).

- `resources/views` : templates Blade.
  - Vues publiques : `home.blade.php`, `packs/index.blade.php`, `packs/show.blade.php`, formulaire de RDV dans la page d'accueil.
  - `resources/views/admin` : vues administrateur (liste RDV, détails, liste demandes de packs).
  - `resources/views/layouts` : gabarits (`public`, `app`, `guest`).

- `app/Mail` : emails :
  - `AppointmentConfirmationMail` : email envoyé après dépôt d'un RDV contenant le lien de confirmation (route `appointments.confirm`).

- `database/migrations` : migrations observées (extraits) :
  - `create_packs_table` : schéma des packs (slug unique, price_eur, details, is_active, etc.).
  - `create_appointments_table` : schéma des rendez-vous (first_name, last_name, email, scheduled_at, status, confirmation_token, champs RGPD de preuve de consentement).
  - `create_pack_change_requests_table` : schéma des demandes de changement de pack (user_id, requested_pack_id, status, admin_note, approved_at, rejected_at, processed_by).
  - Ajouts de `pack_id` aux `users` et `desired_pack_id` aux `appointments` existent via migrations.

- `database/seeders` :
  - `PackSeeder` : seed des packs (Start / Croissance / Premium) — utilisé pour initialiser les offres.

### Rôle de chaque couche

- Routes (dans `routes/web.php` et `routes/auth.php`) mappent les actions publiques, auth et admin.
- Contrôleurs : logique HTTP, validation, envoi de mails, création/modification de modèles.
- Modèles : relations Eloquent, casts et fillable définis.
- Vues : interface utilisateur (no JavaScript spécifique visible, principalement HTML/Tailwind via Blade).

## 4. Fonctionnalités existantes (état actuel réel)

Les sections suivantes décrivent précisément ce qui est présent dans le code.

- Public
  - Page d'accueil (`/`) présentant l'offre et un formulaire de prise de rendez-vous.
  - Pages packs : liste (`/packs`) et détail (`/packs/{slug}`). Les packs affichent prix, tagline, description et détails.
  - Prise de rendez-vous via POST vers `/rendezvous` (route `appointments.store`). Le formulaire collecte nom, prénom, email, téléphone, entreprise, date/heure, pack indicatif et consentement explicite.

- Authentification
  - Routes d'inscription, login, reset password et vérification d'email gérées par `routes/auth.php` (contrôleurs sous `app/Http/Controllers/Auth` — scaffolding type Breeze/Fortify style présent).

- Rendez-vous
  - Enregistrement d'un RDV (`AppointmentController@store`) avec validation.
  - Vérification côté serveur pour éviter double réservation sur le même créneau horaire (contrainte d'unicité sur `scheduled_at` + vérification `pending|confirmed`).
  - Génération d'un `confirmation_token` et envoi d'un email de confirmation (`AppointmentConfirmationMail`).
  - Confirmation via `GET /rendezvous/confirm/{token}` : marque le RDV `confirmed`, crée un compte utilisateur si l'email n'existe pas, envoie un lien de réinitialisation de mot de passe pour permettre à l'utilisateur de définir son mot de passe (appel à Password::sendResetLink).
  - Message de remerciement/confirmation (`/rendezvous/merci`, `/rendezvous/confirm/{token}` vues existantes).

- Packs
  - `Pack` modèle et vues de présentation.
  - Les packs sont gérés via le seeder initial `PackSeeder` et la table `packs`.
  - Aucune gestion de paiement (aucune route / champ lié au paiement détecté).

- Workflow demande de pack
  - Côté utilisateur : via `GET /mon-pack` et `POST /mon-pack` (`UserPackController`) un utilisateur connecté peut envoyer une `PackChangeRequest` avec message optionnel. Le contrôleur empêche d'avoir plusieurs demandes `pending` en parallèle.
  - Côté admin : liste des demandes (`/admin/pack-requests`), approbation (`post /admin/pack-requests/{packChangeRequest}/approve`) et rejet (`.../reject`) via `PackChangeRequestAdminController`.
  - Approve : transaction DB sécurisée avec `lockForUpdate()` sur l'utilisateur, application du `pack_id` sur le `User`, et marquage de la demande (`approved_at`, `processed_by`).
  - Reject : mise à jour du statut `rejected` et `rejected_at`.
  - Règle métier importante : les changements de pack sont uniquement appliqués après validation explicite d'un admin.

- Administration
  - Préfixe `/admin`, middleware `auth` + `admin` pour les routes admin (contrôleur admin et vues admin présentes).
  - Gestion des rendez-vous : consultation / annulation (admin peut annuler un RDV en POST `/admin/appointments/{appointment}/cancel`).

## 5. Modèle de données (résumé)

- Tables principales (extrait) :
  - `users` : standard Laravel + `is_admin` (bool), `pack_id` (nullable, FK -> packs).
  - `packs` : `id`, `name`, `slug`, `price_eur`, `tagline`, `short_description`, `details`, `posts_per_month`, `review_response_hours`, `sort_order`, `is_active`, timestamps.
  - `appointments` : `id`, `user_id` (nullable), `first_name`, `last_name`, `email`, `phone`, `company_name`, `scheduled_at`, `status`, `confirmation_token`, `confirmed_at`, RGPD fields (`consent`, `consent_at`, `consent_ip`, `consent_user_agent`), `desired_pack_id` (nullable), timestamps.
  - `pack_change_requests` : `id`, `user_id`, `requested_pack_id`, `status`, `message`, `admin_note`, `approved_at`, `rejected_at`, `processed_by`, timestamps.

- Relations importantes :
  - `User` belongsTo `Pack` via `pack_id`.
  - `Pack` hasMany `User`.
  - `Appointment` belongsTo `User` et belongsTo `Pack` via `desired_pack_id`.
  - `PackChangeRequest` belongsTo `User` et belongsTo `Pack` via `requested_pack_id`.

- Champs sensibles / RGPD :
  - `appointments` contient les preuves de consentement (`consent`, `consent_at`, `consent_ip`, `consent_user_agent`) — ces champs sont explicitement remplis lors de la soumission.
  - `users.email`, `users.name`, `appointments.email`, `appointments.phone`, `company_name` : données personnelles stockées.
  - Pas de gestion de paiement ou données bancaires détectées (aucune donnée financière collectée ni stockée).

## 6. Routes importantes

Les routes sont définies dans `routes/web.php` et `routes/auth.php`.

- Publices
  - `GET /` -> `HomeController@index` (page d'accueil avec formulaire RDV).
  - `GET /a-propos` -> `AboutController@index`.
  - `GET /packs` -> `PackController@index`.
  - `GET /packs/{slug}` -> `PackController@show`.
  - `POST /rendezvous` -> `AppointmentController@store` (création RDV).
  - `GET /rendezvous/merci` -> `AppointmentController@thanks`.
  - `GET /rendezvous/confirm/{token}` -> `AppointmentController@confirm` (confirmation RDV + création de compte éventuelle).

- Utilisateur (middleware `auth`)
  - `GET /compte` -> `AccountController@dashboard`.
  - `GET|POST /mon-pack` -> `UserPackController@edit|update` (gestion demande de changement de pack côté user).
  - Profil (routes Breeze-like) : `profile` routes (edit/update/destroy).

- Admin (middleware `auth`, `admin`, prefix `admin`, name `admin.`)
  - `GET /admin` -> admin dashboard view.
  - `GET /admin/appointments` -> `AppointmentAdminController@index`.
  - `GET /admin/appointments/{appointment}` -> `AppointmentAdminController@show`.
  - `POST /admin/appointments/{appointment}/cancel` -> annulation de RDV.
  - `GET /admin/pack-requests` -> `PackChangeRequestAdminController@index`.
  - `POST /admin/pack-requests/{packChangeRequest}/approve` -> approval.
  - `POST /admin/pack-requests/{packChangeRequest}/reject` -> rejection.

- Règles de sécurité associées
  - Les routes admin utilisent le middleware `admin` (contrôle d'accès requis) en plus de `auth`.
  - Les actions sensibles (approuver pack) utilisent des transactions et `lockForUpdate()` pour éviter conditions de course.
  - Les formulaires publics valident le consentement (`consent` champ `accepted`) avant enregistrement.

## 7. Emails

- Email principal existant : `AppointmentConfirmationMail` envoyé lors de la création d'un RDV. Contient un lien de confirmation (`appointments.confirm` avec token unique).
- Reset password : après confirmation d'un RDV, si le compte n'existeait pas il est créé puis `Password::sendResetLink` est appelé pour inviter l'utilisateur à définir un mot de passe.
- Règles RGPD liées aux emails : le consentement est requis pour traiter la demande de RDV (case à cocher obligatoire dans le formulaire), et la preuve est stockée dans `appointments`.

## 8. Sécurité & conformité

- RGPD (tel que codé) :
  - Consentement explicite requis (`consent` checkbox) dans le formulaire RDV ; contrôlé par validation `accepted` dans `AppointmentController@store`.
  - Preuves de consentement stored : `consent_at`, `consent_ip`, `consent_user_agent`.
  - Minimisation : seules les données nécessaires au RDV et à la création de compte sont conservées (nom, email, téléphone, entreprise, pack indicatif).
  - Finalité : uniquement gestion de la demande de rendez-vous et workflow commercial.

- Bonnes pratiques appliquées dans le code :
  - Validation serveur stricte pour les inputs utilisateur (`->validate` dans contrôleurs).
  - Protection des actions administratives (middleware `admin`).
  - Transactions et verrouillage (`DB::transaction`, `lockForUpdate`) lors de modifications sensibles (appliquer un pack).
  - Pas de stockage d'informations de paiement (aucune donnée financière présente).

- Limitations volontaires / points à noter :
  - Les utilisateurs sont créés automatiquement après confirmation du RDV ; aucun email de bienvenu personnalisé autre que le lien de reset n'est present.
  - Le modèle de `pack_change_requests` conserve `admin_note` et `processed_by` mais n'envoie pas automatiquement de notification à l'utilisateur lors de la validation/refus (aucun mail de notification détecté).

## 9. Installation & démarrage (commandes exactes)

Exemples de commandes pour installer et lancer le projet localement (Windows). Adaptez les variables d'environnement (`.env`) selon votre configuration DB / mail.

1) Cloner et installer dépendances PHP/JS

```powershell
cd c:\laragon\www\fedumcia
composer install --no-interaction --prefer-dist
npm install
npm run build # ou npm run dev pour développement
```

2) Variables d'environnement

- Copier le fichier d'exemple si présent, sinon créer `.env` et ajuster :

```powershell
copy .env.example .env
# puis éditez .env (DB_CONNECTION, DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD, MAIL_*)
```

3) Générer la clé d'application

```powershell
php artisan key:generate
```

4) Migration & seed

```powershell
php artisan migrate --seed
```

Le seeder `PackSeeder` insère les packs Start / Croissance / Premium.

5) Créer un compte admin initial

- Le projet n'inclut pas de seeder explicite pour l'admin. Créez un utilisateur admin manuellement via Tinker :

```powershell
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('changeme'), 'is_admin' => true]);
```

6) Lancer le serveur

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Notes sur l'email : configurez `MAIL_*` dans `.env`. En développement, `log` ou `smtp` local sont acceptables.

## 10. Règles à respecter pour toute IA ou dev futur

- Ce qu'il ne faut JAMAIS faire :
  - Ne jamais automatiser l'application d'un pack sans validation explicite d'un admin. Le workflow métier impose une approbation manuelle.
  - Ne pas stocker ou traiter de données bancaires (aucune fonctionnalité de paiement présentée ni autorisée).
  - Ne pas supprimer ou altérer les preuves de consentement (`consent_at`, `consent_ip`, `consent_user_agent`) sans trace — ces champs sont la base de conformité RGPD pour les RDV.

- Conventions à respecter :
  - Respecter les validations existantes (utiliser les mêmes règles ou classes Request si créées).
  - Garder les actions critiques en transaction et utiliser `lockForUpdate()` lors de modifications concurrentes (ex. pack apply).
  - Ne pas modifier le comportement d'inscription automatique lié à la confirmation du RDV sans accord métier.

- Workflow métier à conserver :
  - Prise de RDV public → confirmation par email → création compte utilisateur (si nécessaire) → demande automatique de changement de pack (si `desired_pack_id` fourni) visible en admin → décision admin (approve/reject) → application du pack côté utilisateur si approuvé.

## 11. TODO priorisé (P1 / P2 / P3)

- P1 (sécurité / conformité / blocants) :
  - Vérifier configuration email en production (MAIL_*), s'assurer que les reset links et confirmation mails sont envoyés correctement.
  - Mettre en place un seeder ou procédure sécurisée pour créer un admin (si nécessaire automatiser dans `DatabaseSeeder` mais conserver commande manuelle recommandée en prod).

- P2 (améliorations UX / notifications) :
  - Ajouter notifications emails utilisateur lors de l'approbation/refus d'une `PackChangeRequest` (actuellement absent).
  - Ajouter tests automatisés pour le workflow RDV → confirmation → création de compte → demande de pack.

- P3 (non-urgent) :
  - Historisation / audit des actions admin (logs détaillés pour conformité).
  - UI/UX pulses : affichage clair des demandes `pending` côté utilisateur (déjà partiellement présent) et timeline.

---

Si vous voulez, je peux :
- lancer les migrations et seeders localement (si vous me le demandez explicitement),
- ajouter une note d'implémentation pour envoyer un email lors de l'approbation/rejet, ou
- générer des tests PHPUnit ciblés pour les workflows critiques.

Fichier(s) clés consultés pour ce README :
- `routes/web.php`, `routes/auth.php`
- `app/Http/Controllers/AppointmentController.php`, `UserPackController.php`, `Admin/*`
- `app/Models/*` (User, Pack, Appointment, PackChangeRequest)
- `database/migrations/*` (packs, appointments, pack_change_requests)
- `database/seeders/PackSeeder.php`

---
