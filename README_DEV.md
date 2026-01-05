# Fedumcia — README DEV (handoff IA)

## 1) Contexte projet
**Fedumcia** est une agence locale (Vesoul / Haute-Saône 70) spécialisée en :
- **Attractivité visuelle** (photos/vidéos, contenus réseaux sociaux)
- **Confiance client** (gestion e-réputation : avis Google/Facebook, réponse aux avis, stratégie collecte)

Objectifs du site :
- Présenter l’offre et les packs
- Générer des prises de rendez-vous
- Permettre la création de comptes clients
- Gestion admin : RDV + demandes de pack (workflow de validation)

Stack :
- **Laravel 12.x**, PHP 8.3
- **MySQL**
- Front : Blade + Tailwind (Breeze) / composants Laravel
- Dev local : Laragon

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
  - si l’utilisateur n’existe pas : création user + email vérifié
  - envoi automatique d’un lien “définir son mot de passe” (reset link)

### RDV (sans créneaux)
- Formulaire RDV sur la home :
  - `first_name`, `last_name`, `email`, `phone`, `company_name`, `scheduled_at`, `desired_pack_id`, `consent`
- Anti-double réservation : **un RDV par datetime** (contrôle applicatif)
- Confirmation par email via token :
  - status `pending` → `confirmed`
  - association à un user

### Packs (workflow sécurisé)
- Un user ne “change pas” directement son pack.
- Il fait une **demande** (PackChangeRequest) : `pending`
- L’admin approuve/refuse :
  - **approve** : met à jour `users.pack_id` et marque la demande approuvée
  - **reject** : marque la demande refusée

✅ Ajout récent : si un pack souhaité est sélectionné au moment du RDV,
une **PackChangeRequest pending est créée automatiquement** lors de la confirmation du RDV.

### Admin
Routes sous `/admin` protégées par middleware `admin` :
- Dashboard admin (vue simple)
- Liste RDV + détails + annulation (si implémentée)
- Liste demandes de pack + approve/reject

### Navigation
- Navbar adaptée :
  - utilisateur : “Mon pack”, “Mon compte”
  - admin : “Administration”
- Certaines routes “profile” peuvent être absentes selon la config ; éviter de hardcoder sans vérifier `Route::has()`.

---

## 3) Modèles / Tables (résumé)

### users
- `is_admin` bool
- `pack_id` nullable FK packs

### packs
- `name`, `slug`, `price_eur`, `tagline`, etc.
- `is_active`, `sort_order`

### appointments
- identité + contact + entreprise
- `scheduled_at` datetime
- `desired_pack_id` nullable FK packs
- `status` : pending|confirmed|cancelled
- `confirmation_token` (uuid)
- RGPD : `consent`, `consent_at`, `consent_ip`, `consent_user_agent`
- `user_id` nullable, `confirmed_at`

### pack_change_requests
- `user_id`
- `current_pack_id` nullable
- `requested_pack_id`
- `status` : pending|approved|rejected
- `message` (motif)
- `processed_by` (admin id) + `approved_at` / `rejected_at`

---

## 4) Routes clés (résumé)

Public :
- `GET /` → home
- `GET /packs` → packs index
- `GET /packs/{slug}` → pack detail
- `GET /a-propos` → about

RDV :
- `POST /rendezvous` → appointments.store
- `GET /rendezvous/merci` → appointments.thanks
- `GET /rendezvous/confirm/{token}` → appointments.confirm

User :
- `GET /compte` → account.dashboard
- `GET /mon-pack` → pack.edit
- `POST /mon-pack` → pack.update (crée une demande, pas update direct)

Admin :
- `GET /admin` → admin.dashboard
- `GET /admin/appointments` → admin appointments index
- `GET /admin/appointments/{appointment}` → show
- `POST /admin/appointments/{appointment}/cancel` → cancel
- `GET /admin/pack-requests` → list
- `POST /admin/pack-requests/{id}/approve` → approve
- `POST /admin/pack-requests/{id}/reject` → reject

---

## 5) Emails
- Confirmation RDV (MAIL_MAILER=log en dev)
- Reset link pour définir le mot de passe après confirmation RDV
- ⚠️ Aucun email marketing sans consentement explicite (non implémenté)

---

## 6) RGPD / conformité (principes appliqués)
- Case consentement obligatoire sur RDV (`consent` accepted)
- Stockage d’un log minimal : date, IP, user-agent (troncation 512)
- Finalité : gestion du RDV + création/gestion du compte
- À prévoir : page Politique de confidentialité + mentions légales + gestion cookies (si analytics un jour)

---

## 7) Commandes utiles

Installer dépendances :
```bash
composer install
npm install
npm run dev
