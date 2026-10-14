<?php
declare(strict_types=1);

/** Escape a value for safe HTML output. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Append a cache-busting version to a local asset path. */
function asset(string $path, array $site): string
{
    return e($path . '?v=' . $site['asset_version']);
}
