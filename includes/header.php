<?php
declare(strict_types=1);

/**
 * Shared document head + site header.
 *
 * Expects before include:
 *   $site  array  from config/site.php
 *   $page  array  ['title', 'description', 'path', 'css' => [], 'js' => []]
 */
$pageTitle       = $page['title'] ?? $site['name'];
$pageDescription = $page['description'] ?? $site['description'];
$canonical       = rtrim($site['url'], '/') . ($page['path'] ?? '/');
?>
<!DOCTYPE html>
<html lang="en-ZA" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <meta name="theme-color" content="#07111f" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#f6f4ef" media="(prefers-color-scheme: light)">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e($site['name']) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e(rtrim($site['url'], '/') . '/assets/img/og-tricore.jpg') ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/png" href="/assets/img/favicon-64.png">
    <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500;600&family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500;1,600&family=Manrope:wght@400;500;600;700&display=swap">

    <script>
        // Apply the saved / OS theme before first paint to avoid a flash.
        (function () {
            var t = null;
            try { t = localStorage.getItem('tricore-theme'); } catch (err) {}
            if (t !== 'light' && t !== 'dark') {
                t = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
            }
            document.documentElement.setAttribute('data-theme', t);
            document.documentElement.classList.add('js');
        })();
    </script>

    <link rel="stylesheet" href="<?= asset('/assets/css/site.css', $site) ?>">
<?php foreach ($page['css'] ?? [] as $css): ?>
    <link rel="stylesheet" href="<?= asset($css, $site) ?>">
<?php endforeach; ?>

    <script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'AccountingService',
    'name'        => $site['name'],
    'url'         => $site['url'],
    'logo'        => rtrim($site['url'], '/') . '/assets/img/og-tricore.jpg',
    'email'       => $site['emails']['admin'],
    'description' => $site['description'],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>

    </script>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header" id="siteHeader">
    <div class="container nav">
        <a class="brand" href="/" aria-label="<?= e($site['name']) ?> — home">
            <img class="brand-mark" src="/assets/img/tricore-emblem.webp" width="300" height="240" alt="">
            <span class="brand-text">
                <strong>TRI-CORE</strong>
                <small>Financial Group</small>
            </span>
        </a>

        <nav class="primary-nav" id="primaryNav" aria-label="Main navigation">
            <ul class="nav-list">
                <li><a href="/#about">About</a></li>
                <li class="has-mega">
                    <button class="mega-trigger" type="button" aria-expanded="false" aria-controls="megaServices">
                        Services
                        <svg width="10" height="6" viewBox="0 0 10 6" aria-hidden="true"><path d="M1 1l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <div class="mega" id="megaServices">
                        <div class="mega-inner">
                            <a class="mega-col" href="/#core-01">
                                <span class="mega-no">01</span>
                                <strong>Audit &amp; Assurance</strong>
                                <span>Confidence in reporting, governance and controls.</span>
                            </a>
                            <a class="mega-col" href="/#core-02">
                                <span class="mega-no">02</span>
                                <strong>Accounting &amp; Tax</strong>
                                <span>Accurate information. Clear compliance.</span>
                            </a>
                            <a class="mega-col" href="/#core-03">
                                <span class="mega-no">03</span>
                                <strong>Advisory</strong>
                                <span>Better information for better decisions.</span>
                            </a>
                            <div class="mega-note" aria-hidden="true">
                                <span class="hand">three disciplines, one view</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="/#industries">Industries</a></li>
                <li><a href="/#approach">Approach</a></li>
                <li><a href="/#contact">Contact</a></li>
            </ul>
            <a class="btn btn-gold nav-mobile-cta" href="/#contact">Book a consultation</a>
        </nav>

        <div class="nav-actions">
            <button class="icon-btn theme-toggle" id="themeToggle" type="button" aria-label="Switch to light mode">
                <svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4.2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M12 2.5v2.2M12 19.3v2.2M2.5 12h2.2M19.3 12h2.2M5.3 5.3l1.6 1.6M17.1 17.1l1.6 1.6M5.3 18.7l1.6-1.6M17.1 6.9l1.6-1.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 14.6A8.2 8.2 0 0 1 9.4 4a8.2 8.2 0 1 0 10.6 10.6z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
            </button>
            <a class="btn btn-gold nav-cta" href="/#contact">Book a consultation</a>
            <button class="icon-btn menu-toggle" id="menuToggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="primaryNav">
                <span class="burger" aria-hidden="true"><i></i><i></i></span>
            </button>
        </div>
    </div>
</header>
