<?php
declare(strict_types=1);

defined('TRICORE') || exit;

/** Escape a value for safe HTML output. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Local asset URL with a cache-busting version taken from the file's modification time,
 * so browsers can cache CSS/JS for a year and still pick up every deploy immediately.
 */
function asset(string $path): string
{
    $file    = dirname(__DIR__) . $path;
    $version = is_file($file) ? (string) filemtime($file) : '1';

    return e($path . '?v=' . $version);
}

/** True when the current request arrived over HTTPS (directly or via a proxy). */
function is_https(): bool
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        || ((int) ($_SERVER['SERVER_PORT'] ?? 0) === 443);
}

/** Multibyte-safe string length (falls back to bytes if mbstring is missing). */
function str_length(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

/** Trim a submitted value and strip control characters (keeps line breaks when asked). */
function clean_text(mixed $value, bool $multiline = false): string
{
    if (!is_string($value)) {
        return '';
    }
    $value = str_replace(["\r\n", "\r"], "\n", $value);
    $value = $multiline
        ? preg_replace('/[^\P{C}\n\t]/u', '', $value)
        : preg_replace('/\p{C}/u', '', $value);

    return trim((string) $value);
}

/**
 * Security headers for HTML pages. The script nonce lets the small inline theme script run
 * while everything else is limited to files served from this site.
 */
function send_page_headers(string $nonce): void
{
    header('Content-Type: text/html; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Frame-Options: SAMEORIGIN');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
    header(
        "Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-{$nonce}'; "
        . "style-src 'self'; img-src 'self' data:; font-src 'self'; connect-src 'self'; "
        . "form-action 'self'; frame-ancestors 'self'; base-uri 'self'; object-src 'none'"
    );
}
