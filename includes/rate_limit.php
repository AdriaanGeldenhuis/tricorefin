<?php
declare(strict_types=1);

defined('TRICORE') || exit;

/**
 * Simple file-based sliding-window rate limiter (no database needed).
 *
 * Records one hit for $key in $bucket and returns false once $max hits have happened
 * within the last $window seconds. Keys are hashed, so no raw IP addresses are stored.
 * If storage cannot be written, the request is allowed (and logged) rather than blocking
 * genuine visitors because of a server problem.
 */
function rate_limit_allow(string $bucket, string $key, int $max, int $window, string $dir): bool
{
    if (!is_dir($dir) && !@mkdir($dir, 0700, true) && !is_dir($dir)) {
        $dir = rtrim(sys_get_temp_dir(), '/') . '/tricore-rate-limit';
        if (!is_dir($dir) && !@mkdir($dir, 0700, true) && !is_dir($dir)) {
            error_log('tricore: rate-limit storage is not writable');
            return true;
        }
    }

    $file   = $dir . '/' . preg_replace('/[^a-z0-9_-]/i', '', $bucket) . '-' . hash('sha256', $key) . '.json';
    $handle = @fopen($file, 'c+');
    if ($handle === false) {
        error_log('tricore: cannot open rate-limit file');
        return true;
    }

    try {
        flock($handle, LOCK_EX);

        $hits = json_decode((string) stream_get_contents($handle), true);
        $hits = is_array($hits) ? $hits : [];
        $now  = time();
        $hits = array_values(array_filter($hits, static fn ($t): bool => is_int($t) && $t > $now - $window));

        $allowed = count($hits) < $max;
        if ($allowed) {
            $hits[] = $now;
        }

        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, (string) json_encode($hits));
        fflush($handle);
        flock($handle, LOCK_UN);
    } finally {
        fclose($handle);
    }

    return $allowed;
}

/** The visitor's IP as seen by the web server (forwarded headers are not trusted). */
function client_ip(): string
{
    return (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
}
