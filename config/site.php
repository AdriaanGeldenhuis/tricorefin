<?php
declare(strict_types=1);

/**
 * Site-wide settings.
 *
 * Anything secret or server-specific goes in config/site.local.php (git-ignored, never deployed
 * from GitHub). It returns an array with the same keys and overrides the values below, e.g.:
 *
 *   <?php return ['enquiry' => ['to' => 'someone@tricorefin.co.za']];
 */
return [
    'name'        => 'Tri-Core Financial Group',
    'short_name'  => 'Tri-Core',
    'url'         => 'https://tricorefin.co.za',
    'tagline'     => 'Audit, Accounting & Advisory',
    'description' => 'Tri-Core Financial Group — audit, accounting and advisory support built around clarity, precision and confident decision-making.',
    'timezone'    => 'Africa/Johannesburg',
    'emails'      => [
        'admin'   => 'admin@tricorefin.co.za',
        'ricardo' => 'ricardo@tricorefin.co.za',
    ],

    // Contact form (api/enquiry.php)
    'enquiry' => [
        'to'           => 'admin@tricorefin.co.za',
        // Must be a real mailbox on this domain: Xneelo only relays mail from addresses it hosts.
        'from'         => 'admin@tricorefin.co.za',
        'from_name'    => 'Tri-Core Website',
        'max_per_hour' => 5,   // submissions per visitor IP per hour
        'min_seconds'  => 3,   // a form completed faster than this is a bot
        'services'     => ['Audit & Assurance', 'Accounting & Tax', 'Advisory', 'General enquiry'],
    ],

    // Private writable folder for rate-limit data. Sits next to public_html, outside the web root.
    // Can be overridden with a TRICORE_STORAGE environment variable (or SetEnv in Apache).
    'storage_path' => getenv('TRICORE_STORAGE') ?: ($_SERVER['TRICORE_STORAGE'] ?? dirname(__DIR__, 2) . '/tricore-data'),
];
