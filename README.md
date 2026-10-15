# Tri-Core Financial Group — website

Live site: https://tricorefin.co.za (Xneelo web hosting, PHP 8+, Apache).

## How changes go live

1. Work happens on a branch and is merged into `main`.
2. GitHub Actions (`.github/workflows/deploy.yml`) checks PHP syntax, verifies the server's SSH
   host key, then copies the files into `public_html` over SSH.
3. Files that exist only on the server (such as `config/site.local.php`) are never touched.

Required repository secrets: `SSH_HOST`, `SSH_PORT`, `SSH_USER`, `SSH_PRIVATE_KEY`, `DEPLOY_PATH`.

## Structure

```
/index.php                 Homepage
/404.php                   "Page not found" page (wired up in .htaccess)
/api/enquiry.php           Contact form endpoint (POST, JSON for fetch, redirect without JS)
/css/home.css              Homepage styles
/js/home.js                Homepage behaviour (scroll story, form)
/assets/css/site.css       Shared styles (fonts, colour tokens, header, footer, buttons)
/assets/js/site.js         Shared behaviour (theme toggle, menus, reveal animations)
/assets/fonts/             Self-hosted fonts (Google Fonts, SIL Open Font License 1.1)
/assets/img/               Logo, icons, social-share image
/config/site.php           Site settings (emails, contact-form options)
/includes/                 bootstrap, helpers, session/CSRF, rate limiter, header, footer
/.htaccess                 HTTPS + bare-domain redirects, 404 page, caching, security headers
```

`config/` and `includes/` are blocked from the web (`Require all denied`).

## Contact form

- Sends to `enquiry.to` in `config/site.php` using PHP `mail()`; the sender (`enquiry.from`)
  must be a real mailbox on the domain.
- Protection: same-origin check, CSRF token, hidden honeypot field, 3-second time trap,
  server-side validation, and 5 sent enquiries per IP per hour.
- Rate-limit data is stored outside the web root in `../tricore-data/` (falls back to the
  system temp folder if that cannot be created).

## Server-only settings

Create `config/site.local.php` on the server to override settings without committing them:

```php
<?php
return ['enquiry' => ['to' => 'someone@tricorefin.co.za']];
```

## Local preview

```
php -S 127.0.0.1:8080
```

(`.htaccess` rules only apply under Apache.)
