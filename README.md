# Nyika Safaris — Kenya Tour & Travel Website

Premium booking-focused tour and travel site for Kenya safaris, beach holidays, and private transport. Built for **XAMPP (PHP)** with **Supabase (Postgres)** as the database.

## Contact

| Channel | Value |
|--------|--------|
| Phone / display | `0712 136002` or `+254 712 136002` |
| WhatsApp (`wa.me`) | `254712136002` |
| Email | `gmegichuru@gmail.com` |

## Quick start (XAMPP + Supabase)

### 1. Create a Supabase project

1. Go to [https://supabase.com](https://supabase.com) and create a project.
2. Save the **database password** when prompted.
3. Open **Project Settings → API** and copy:
   - Project URL → `SUPABASE_URL`
   - `anon` public key → `SUPABASE_ANON_KEY`
   - `service_role` key → `SUPABASE_SERVICE_ROLE_KEY` (server-only; optional while using PDO)
4. Open **Project Settings → Database** and note:
   - Host: `db.<project-ref>.supabase.co`
   - Port: `5432`
   - Database: `postgres`
   - User: `postgres`
   - Password: (the one you set)

### 2. Run SQL in Supabase

In **SQL Editor**:

1. Paste and run `database/supabase_schema.sql`
2. Paste and run `database/supabase_seed.sql`

### 3. Configure the PHP site

1. Folder: `C:\xampp\htdocs\tour and travel website`
2. Copy `.env.example` → `.env` and fill in real Supabase values (or edit `includes/config.php` defaults).
3. Start **Apache** in XAMPP (MySQL is no longer required).
4. Confirm PHP has **pdo_pgsql** (this XAMPP build includes it). In `php.ini`: `extension=pdo_pgsql` and `extension=pgsql` if needed, then restart Apache.
5. Visit the setup helper once:
   [http://localhost/tour%20and%20travel%20website/install.php](http://localhost/tour%20and%20travel%20website/install.php)
6. Open the site:
   [http://localhost/tour%20and%20travel%20website/](http://localhost/tour%20and%20travel%20website/)
7. Admin login:
   [http://localhost/tour%20and%20travel%20website/admin/login.php](http://localhost/tour%20and%20travel%20website/admin/login.php)
   - Email: `gmegichuru@gmail.com`
   - Password: `admin123`
8. **Delete or protect `install.php`** after setup.

## How the database is connected

**Approach: PDO `pgsql` to Supabase Postgres (with SSL).**

- Existing admin CRUD and booking code already use SQL prepared statements; PDO keeps that path with minimal change.
- Typical XAMPP installs often lack `pdo_pgsql`; **this environment has it**. If yours does not, enable the extension or contact the maintainer to add a PostgREST/curl client later.
- `SUPABASE_URL` / anon / service_role keys are configured for future REST use; the live app reads/writes via the Postgres connection (`DB_*`).

Public pages still fall back to built-in content in `includes/content.php` when the database is unreachable or credentials are still placeholders.

## Configuration

Prefer `.env` (see `.env.example`). Key settings:

| Setting | Purpose |
|--------|---------|
| `WHATSAPP_NUMBER` | E.164 without `+` for wa.me (`254712136002`) |
| `CONTACT_EMAIL` / `CONTACT_PHONE` | Public contact details |
| `DB_HOST` / `DB_PORT` / `DB_NAME` / `DB_USER` / `DB_PASS` | Supabase Postgres |
| `DB_SSLMODE` | Use `require` for Supabase |
| `SUPABASE_*` | Project URL + API keys (optional for PDO path) |
| `ADMIN_EMAIL` | Seeded / install admin account |
| `EMAIL_NOTIFICATIONS_ENABLED` | Flip to `true` when PHP `mail`/SMTP works |
| `MPESA_*` | Daraja placeholders for a future live integration |

## What’s included

### Public site
- Home: full-bleed hero, trip search → book form, featured destinations, popular packages, why us, reviews, WhatsApp CTA
- Tours & packages (filterable categories)
- Destinations (Kenya + Zanzibar / regional)
- Vehicles & transport
- About
- Contact / Book Now form (writes inquiry + customer + booking)

### Admin
Login-protected CRUD / management for packages, destinations, vehicles, bookings (status + driver assignment), customers, payments (M-Pesa fields), drivers, tour schedules, expenses/profit summary, inquiries.

### Deferred / placeholders
- Live M-Pesa STK Push (schema + admin recording ready; no Daraja calls)
- Outbound Email/WhatsApp APIs (logged to `notification_logs` + PHP error log)

## Folder structure

```
├── index.php, tours.php, destinations.php, vehicles.php, about.php, contact.php
├── install.php          (verifies Supabase + resets admin password)
├── api/book.php
├── assets/css/style.css
├── assets/js/main.js
├── includes/            (config, db, functions, content, header, footer)
├── admin/               (dashboard + CRUD modules)
├── database/
│   ├── supabase_schema.sql   ← use this in Supabase
│   ├── supabase_seed.sql
│   ├── schema.sql            (legacy MySQL reference)
│   └── seed.sql              (legacy MySQL reference)
├── .env.example
└── README.md
```

## Brand & design decisions

- **Brand:** Nyika Safaris (*nyika* ≈ wilderness / bush country)
- **Palette:** deep forest green `#0f3d2e` + sun gold `#c4a35a` on photographic imagery
- **Fonts:** Fraunces (display) + Sora (UI)
- **WhatsApp:** `+254 712 136002` (`254712136002`)
- **Email:** `gmegichuru@gmail.com`
- Public pages degrade to built-in Kenya content if Supabase is offline
