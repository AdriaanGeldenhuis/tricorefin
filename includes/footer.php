<?php
declare(strict_types=1);

defined('TRICORE') || exit;

/**
 * Shared site footer + scripts. Expects $site and $page (see header.php).
 */
?>
<footer class="site-footer" data-hide-cta>
    <div class="container">
        <div class="footer-top">
            <div class="footer-brand">
                <a class="brand brand-lg" href="/" aria-label="<?= e($site['name']) ?> — home">
                    <img class="brand-mark" src="/assets/img/tricore-emblem-160.webp" srcset="/assets/img/tricore-emblem-112.webp 112w, /assets/img/tricore-emblem-160.webp 160w" sizes="58px" width="160" height="128" alt="" loading="lazy">
                    <span class="brand-text">
                        <strong><span class="b-tri">TRI-</span><span class="b-core">CORE</span></strong>
                        <small>Financial Group</small>
                    </span>
                </a>
                <p>Audit, accounting and advisory support built around clarity, precision and informed decision-making.</p>
                <p class="hand footer-hand">Clarity. Precision. Confidence.</p>
            </div>

            <div class="footer-col">
                <h2>Company</h2>
                <a href="/#about">About</a>
                <a href="/#approach">Our approach</a>
                <a href="/#industries">Industries</a>
                <a href="/#contact">Contact</a>
            </div>
            <div class="footer-col">
                <h2>Services</h2>
                <a href="/#core-01">Audit &amp; Assurance</a>
                <a href="/#core-02">Accounting &amp; Tax</a>
                <a href="/#core-03">Advisory</a>
            </div>
            <div class="footer-col">
                <h2>Contact</h2>
                <a href="mailto:<?= e($site['emails']['admin']) ?>"><?= e($site['emails']['admin']) ?></a>
                <a href="mailto:<?= e($site['emails']['ricardo']) ?>"><?= e($site['emails']['ricardo']) ?></a>
                <a href="/#contact">Arrange a consultation</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= e($site['name']) ?>. All rights reserved.</p>
            <ul class="legal">
                <li>Privacy Policy</li>
                <li>POPIA</li>
                <li>PAIA</li>
                <li>Terms &amp; Conditions</li>
            </ul>
        </div>
    </div>
</footer>

<a class="mobile-cta" id="mobileCta" href="/#contact" aria-hidden="true" tabindex="-1">
    <span class="btn-label">Book a consultation</span><span class="btn-ico btn-ico-diag" aria-hidden="true"></span>
</a>

<script src="<?= asset('/assets/js/site.js') ?>" defer></script>
<?php foreach ($page['js'] ?? [] as $js): ?>
<script src="<?= asset($js) ?>" defer></script>
<?php endforeach; ?>
</body>
</html>
