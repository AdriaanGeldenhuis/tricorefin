<?php
declare(strict_types=1);

defined('TRICORE') || exit;

/**
 * Shared document head + site header.
 *
 * Expects before include:
 *   $site   array   from includes/bootstrap.php
 *   $nonce  string  CSP nonce sent by send_page_headers()
 *   $page   array   ['title', 'description', 'path', 'css' => [], 'js' => [], 'noindex' => bool]
 */
$pageTitle       = $page['title'] ?? $site['name'];
$pageDescription = $page['description'] ?? $site['description'];
$canonical       = rtrim($site['url'], '/') . ($page['path'] ?? '/');
?>
<!DOCTYPE html>
<html lang="en-ZA" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
<?php if (!empty($page['noindex'])): ?>
    <meta name="robots" content="noindex">
<?php else: ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
<?php endif; ?>
    <!-- The page ships its own dark and light themes. Declaring that stops phone browsers
         (Samsung Internet, Chrome "force dark") from re-colouring the page on top of ours. -->
    <meta name="color-scheme" content="dark light">
    <meta name="supported-color-schemes" content="dark light">
    <meta name="theme-color" content="#07111f">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e($site['name']) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e(rtrim($site['url'], '/') . '/assets/img/og-tricore.jpg') ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" type="image/png" href="/assets/img/favicon-64.png" sizes="64x64">
    <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Fonts are self-hosted (faster, and no visitor data goes to third parties). -->
    <link rel="preload" href="/assets/fonts/cormorant-garamond-latin.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/assets/fonts/manrope-latin.woff2" as="font" type="font/woff2" crossorigin>

    <script nonce="<?= e($nonce) ?>">
        // Apply the saved theme before first paint to avoid a flash. Dark is the default look;
        // visitors who switch to light keep that choice on later visits.
        (function () {
            var t = null;
            try { t = localStorage.getItem('tricore-theme'); } catch (err) {}
            if (t !== 'light' && t !== 'dark') { t = 'dark'; }
            var root = document.documentElement;
            root.setAttribute('data-theme', t);
            root.classList.add('js');
            var meta = document.querySelector('meta[name="theme-color"]');
            if (meta) { meta.setAttribute('content', t === 'dark' ? '#07111f' : '#f6f5f1'); }
        })();
    </script>

    <link rel="stylesheet" href="<?= asset('/assets/css/site.css') ?>">
<?php foreach ($page['css'] ?? [] as $css): ?>
    <link rel="stylesheet" href="<?= asset($css) ?>">
<?php endforeach; ?>

    <script type="application/ld+json" nonce="<?= e($nonce) ?>">
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
            <img class="brand-mark" src="/assets/img/tricore-emblem-112.webp" srcset="/assets/img/tricore-emblem-112.webp 112w, /assets/img/tricore-emblem-160.webp 160w" sizes="44px" width="112" height="90" alt="" fetchpriority="high">
            <span class="brand-text">
                <strong><span class="b-tri">TRI-</span><span class="b-core">CORE</span></strong>
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
            <a class="btn btn-gold nav-mobile-cta" href="/#contact"><span class="btn-label">Book a consultation</span></a>
        </nav>

        <div class="nav-actions">
            <button class="icon-btn theme-toggle" id="themeToggle" type="button" aria-label="Switch to light mode">
                <svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4.2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M12 2.5v2.2M12 19.3v2.2M2.5 12h2.2M19.3 12h2.2M5.3 5.3l1.6 1.6M17.1 17.1l1.6 1.6M5.3 18.7l1.6-1.6M17.1 6.9l1.6-1.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 14.6A8.2 8.2 0 0 1 9.4 4a8.2 8.2 0 1 0 10.6 10.6z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
            </button>
            <a class="btn btn-gold nav-cta" href="/#contact"><span class="btn-label">Book a consultation</span></a>
            <button class="icon-btn menu-toggle" id="menuToggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="primaryNav">
                <svg class="burger" width="20" height="12" viewBox="0 0 20 12" aria-hidden="true"><path class="bar-1" d="M1 2h18"/><path class="bar-2" d="M1 10h18"/></svg>
            </button>
        </div>
    </div>
</header>
