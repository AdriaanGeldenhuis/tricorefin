<?php
declare(strict_types=1);

defined('TRICORE') || exit;

/**
 * Start a hardened session: strict mode, cookie-only, HttpOnly, SameSite=Lax and Secure on HTTPS.
 * On HTTPS the cookie uses the __Host- prefix, which browsers only accept for secure,
 * host-only cookies on path "/".
 */
function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $secure = is_https();

    // Cookie-only sessions without URL IDs are PHP's defaults; strict mode rejects
    // session IDs the server did not create (prevents session fixation).
    ini_set('session.use_strict_mode', '1');

    session_name($secure ? '__Host-tricore' : 'tricore');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

/** The session's CSRF token (created on first use). */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/** Constant-time check of a submitted CSRF token against the session's token. */
function csrf_verify(mixed $token): bool
{
    return is_string($token)
        && $token !== ''
        && isset($_SESSION['csrf_token'])
        && is_string($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}
