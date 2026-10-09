# Ultimate POS — aaPanel Deployment Checklist

Step-by-step guide to deploy this project on an aaPanel (Linux) server.

---

## 1. Server requirements (aaPanel → App Store)

| Software | Version |
|----------|---------|
| Nginx (or Apache) | latest |
| PHP | 8.1 or 8.2 |
| MySQL | 5.7+ / 8.0 |

**Required PHP extensions** (PHP → Install extensions):
`pdo_mysql`, `mbstring`, `openssl`, `curl`, `zip`, `gd`, `bcmath`, `xml`, `intl`, `fileinfo`

---

## 2. Upload the project

1. Zip the project locally (exclude `vendor/` if you prefer — then run `composer install` on the server).
2. aaPanel → **Files** → upload to `/www/wwwroot/ultimatepos` → extract.
3. If `vendor/` was excluded, run in aaPanel **Terminal**:
   ```bash
   cd /www/wwwroot/ultimatepos
   composer install --optimize-autoloader --no-dev
   ```

---

## 3. Create the database

1. aaPanel → **Database** → Add database:
   - Name: `ultimatepos`
   - User: `posuser` (dedicated user — never root in production)
   - Password: strong password
2. To import your local data: aaPanel → Database → phpMyAdmin → Import.
   Or for a fresh install, run migrations (step 6).

---

## 4. Create the website

aaPanel → **Website** → **Add site**:

- Domain: `pos.yourdomain.com`
- PHP version: 8.1 / 8.2
- Database: skip (already created)

**⚠️ CRITICAL:** Site Settings → **Website directory** → set **Running directory to `/public`**.
Laravel serves from `public/`. If the site root points at the project folder, your `.env`
file becomes downloadable by anyone — a critical security hole.

**SSL:** Site Settings → SSL → Let's Encrypt → apply → enable **Force HTTPS**.

---

## 5. Configure the environment

```bash
cd /www/wwwroot/ultimatepos
cp .env.production .env
nano .env    # fill in DB_*, APP_URL, MAIL_*
```

- If importing your local DB, copy the `APP_KEY` from your local `.env` (otherwise encrypted
  session/cookie data breaks).
- For a fresh install, generate a new key instead:
  ```bash
  php artisan key:generate
  ```

---

## 6. Run migrations (fresh install only)

Skip this if you imported your local database dump.

```bash
php artisan migrate --force
php artisan db:seed --force
```

> Note: the default `DatabaseSeeder` does NOT create users. To create the demo business +
> users run `php artisan db:seed --class=OldDummyBusinessSeeder --force`, or register your
> real business at `https://yourdomain.com/business/register`.

---

## 7. Set permissions & storage link

```bash
php artisan storage:link
chown -R www:www storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

If artisan commands fail with permission errors, check aaPanel's `open_basedir` restriction
for the site (Website → Settings → Website directory) and adjust it to include the project path.

---

## 8. Enable caches (performance)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> After any future `.env` change, re-run `php artisan config:cache`.

---

## 9. Cron job (WooCommerce auto-sync)

aaPanel → **Cron** → Add task:

- Type: Shell script
- Cycle: N minutes → 1 minute
- Command:
  ```bash
  php /www/wwwroot/ultimatepos/artisan schedule:run >> /dev/null 2>&1
  ```

---

## 10. Post-deployment security

- [ ] Log in (`admin` / `123456`) and **change the admin password immediately**
- [ ] Delete or disable demo users (`cashier`, `demo-admin`, `superadmin`, …)
- [ ] Set `ALLOW_REGISTRATION=false` in `.env` (already set in the template)
- [ ] Verify `https://yourdomain.com/.env` returns 404 (running directory is `/public`)
- [ ] Update your real business details in Settings → Business Settings
- [ ] Enable the modules you use in Settings → Modules (unchecked modules get disabled on save)
- [ ] Configure WooCommerce API settings if using the sync module
- [ ] Set up regular backups: aaPanel → Cron → `php artisan backup:run` (spatie/laravel-backup)

---

## 11. Troubleshooting

| Symptom | Fix |
|---------|-----|
| 500 error, blank page | Check `storage/logs/laravel.log`; ensure `storage/` writable by `www` |
| CSS/JS not loading | Run `php artisan storage:link`; check asset URLs use your domain |
| 419 Page Expired | `APP_URL` must match the actual domain (affects CSRF/cookies) |
| Routes 404 | Nginx needs the Laravel rewrite — aaPanel's "Laravel 5" rewrite template covers it |
| Email not sending | Verify `MAIL_*` values; use port 587 + TLS for most providers |
| WooCommerce sync fails | Check API URL/keys in Woocommerce → API Settings; server must allow outbound HTTPS |

---

## Quick command reference

```bash
cd /www/wwwroot/ultimatepos

# maintenance mode during updates
php artisan down
php artisan up

# clear caches after code updates
php artisan config:cache && php artisan route:cache && php artisan view:cache

# check for errors
tail -f storage/logs/laravel-$(date +%F).log
```
