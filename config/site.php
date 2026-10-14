<?php
declare(strict_types=1);

/**
 * Site-wide settings. Keep anything secret (DB passwords, mail credentials)
 * out of this file — put those in config/*.local.php, which is git-ignored.
 */
return [
    'name'        => 'Tri-Core Financial Group',
    'short_name'  => 'Tri-Core',
    'url'         => 'https://tricorefin.co.za',
    'tagline'     => 'Audit, Accounting & Advisory',
    'description' => 'Tri-Core Financial Group — audit, accounting and advisory support built around clarity, precision and confident decision-making.',
    'emails'      => [
        'admin'   => 'admin@tricorefin.co.za',
        'ricardo' => 'ricardo@tricorefin.co.za',
    ],
    'asset_version' => '2026.10.14',
];
