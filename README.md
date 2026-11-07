# AI SQUARE HUB — Render deployment
1. Push this folder to a GitHub repo.
2. Render Dashboard → New → Blueprint → select repo (uses `render.yaml`; creates web service + free PostgreSQL).
3. After deploy, open Environment tab, copy `SETUP_KEY`, visit `https://<app>.onrender.com/setup.php?key=<SETUP_KEY>` once (creates tables + demo accounts).
4. Log in, change demo passwords, then delete the `SETUP_KEY` env var.
Notes: Render's filesystem is ephemeral — uploaded files (logos, photos, test media) vanish on redeploy; use external media URLs or add a persistent disk (paid) at `/var/www/html/uploads`. Free Render Postgres expires after 30 days; upgrade for production.
Built so far: gateway + 3 portal logins, CSRF/RBAC/bcrypt/audit log, light/dark theme, admin dashboard + employee management, employee check-in/out + evaluation chart, candidate assignment list. Also built: announcements, evaluation entry, feedback (anonymous supported), change password, admin password reset. Not yet: payroll, leave, bulk import, test runner, SMTP.
