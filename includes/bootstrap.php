<?php
declare(strict_types=1);

/**
 * Loaded first by every page and API endpoint.
 * Defines the TRICORE guard, loads helpers, session tools and site config.
 */
define('TRICORE', true);

require __DIR__ . '/helpers.php';
require __DIR__ . '/session.php';

$site = require dirname(__DIR__) . '/config/site.php';

$localConfig = dirname(__DIR__) . '/config/site.local.php';
if (is_file($localConfig)) {
    $site = array_replace_recursive($site, (array) require $localConfig);
}

date_default_timezone_set($site['timezone']);
