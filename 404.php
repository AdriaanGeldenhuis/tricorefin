<?php
declare(strict_types=1);

/**
 * Custom "page not found" page. Apache serves it for unknown URLs (ErrorDocument in .htaccess).
 */
require __DIR__ . '/includes/bootstrap.php';

http_response_code(404);
$nonce = base64_encode(random_bytes(16));
send_page_headers($nonce);

$page = [
    'title'       => 'Page not found | Tri-Core Financial Group',
    'description' => 'The page you were looking for could not be found.',
    'noindex'     => true,
];

require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="simple-page" aria-labelledby="notFoundTitle">
        <div class="container">
            <p class="eyebrow">Error 404</p>
            <h1 id="notFoundTitle">This page <em>doesn't add up.</em></h1>
            <p>The page you were looking for has moved or no longer exists. Everything you need is on our homepage.</p>
            <p class="hand" aria-hidden="true">let's get you back on track</p>
            <div class="actions">
                <a class="btn btn-gold" href="/"><span class="btn-label">Back to the homepage</span></a>
                <a class="btn btn-line" href="/#contact">Contact us</a>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
