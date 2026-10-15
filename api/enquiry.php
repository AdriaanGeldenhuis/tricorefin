<?php
declare(strict_types=1);

/**
 * POST /api/enquiry.php — contact form submission.
 *
 * Called with fetch() from js/home.js (Accept: application/json → JSON reply).
 * Without JavaScript the form posts here directly and is redirected back to /#contact
 * with ?enquiry=<status> so the page can show the result.
 *
 * Checks, in order: POST only → same-origin → CSRF token → honeypot → time trap →
 * field validation → per-IP rate limit → send mail.
 */
require dirname(__DIR__) . '/includes/bootstrap.php';
require dirname(__DIR__) . '/includes/rate_limit.php';

$config    = $site['enquiry'];
$wantsJson = str_contains((string) ($_SERVER['HTTP_ACCEPT'] ?? ''), 'application/json');

header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

/**
 * @param array<string,string> $errors field name => message
 */
function respond(bool $ok, string $status, string $message, int $httpCode = 200, array $errors = []): void
{
    global $wantsJson;

    if ($wantsJson) {
        http_response_code($httpCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(
            ['ok' => $ok, 'status' => $status, 'message' => $message, 'errors' => (object) $errors],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    } else {
        header('Location: /?enquiry=' . rawurlencode($status) . '#contact', true, 303);
    }
    exit;
}

// 1. Method
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    respond(false, 'error', 'Please use the contact form to send an enquiry.', 405);
}

// 2. Same-origin: browsers send Origin on POST; a different host means a cross-site post.
$origin = (string) ($_SERVER['HTTP_ORIGIN'] ?? '');
if ($origin !== '') {
    $originHost = (string) parse_url($origin, PHP_URL_HOST);
    $originPort = parse_url($origin, PHP_URL_PORT);
    $originHost .= $originPort ? ':' . $originPort : '';
    if (strcasecmp($originHost, (string) ($_SERVER['HTTP_HOST'] ?? '')) !== 0) {
        respond(false, 'error', 'This request was blocked for security reasons.', 403);
    }
}

// 3. CSRF
start_secure_session();
if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    respond(false, 'expired', 'Your session has expired. Please refresh the page and send your enquiry again.', 403);
}

// 4. Honeypot: a hidden field that people never fill in. Bots get a quiet "success".
if (clean_text($_POST['website'] ?? '') !== '') {
    respond(true, 'sent', 'Thank you — your enquiry has been sent.');
}

// 5. Time trap: humans need a few seconds to fill in the form.
$startedAt = (int) ($_SESSION['enquiry_started'] ?? 0);
if ($startedAt === 0 || (time() - $startedAt) < (int) $config['min_seconds']) {
    respond(false, 'error', 'That was quicker than we expected. Please wait a moment and try again.', 429);
}

// 6. Validate
$data = [
    'name'    => clean_text($_POST['name'] ?? ''),
    'company' => clean_text($_POST['company'] ?? ''),
    'email'   => clean_text($_POST['email'] ?? ''),
    'phone'   => clean_text($_POST['phone'] ?? ''),
    'service' => clean_text($_POST['service'] ?? ''),
    'message' => clean_text($_POST['message'] ?? '', true),
    'consent' => ($_POST['consent'] ?? '') === 'on',
];

$errors = [];

if ($data['name'] === '') {
    $errors['name'] = 'Please enter your name.';
} elseif (str_length($data['name']) > 120) {
    $errors['name'] = 'Please keep your name under 120 characters.';
}

if (str_length($data['company']) > 160) {
    $errors['company'] = 'Please keep the company name under 160 characters.';
}

if ($data['email'] === '') {
    $errors['email'] = 'Please enter your email address.';
} elseif (str_length($data['email']) > 160 || filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
    $errors['email'] = 'Please enter a valid email address.';
}

if ($data['phone'] !== '' && !preg_match('/^[0-9 +()\-]{7,30}$/', $data['phone'])) {
    $errors['phone'] = 'Please enter a valid telephone number.';
}

if (!in_array($data['service'], $config['services'], true)) {
    $errors['service'] = 'Please choose a service.';
}

if ($data['message'] === '') {
    $errors['message'] = 'Please tell us how we can help.';
} elseif (str_length($data['message']) < 10) {
    $errors['message'] = 'Please add a little more detail (at least 10 characters).';
} elseif (str_length($data['message']) > 3000) {
    $errors['message'] = 'Please keep your message under 3,000 characters.';
}

if (!$data['consent']) {
    $errors['consent'] = 'Please confirm that we may use your details to respond.';
}

if ($errors) {
    respond(false, 'invalid', 'Please check the highlighted fields.', 422, $errors);
}

// 7. Rate limit per IP — counts only enquiries that are about to be sent, so typos never lock anyone out.
$allowed = rate_limit_allow(
    'enquiry',
    client_ip(),
    (int) $config['max_per_hour'],
    3600,
    (string) $site['storage_path']
);
if (!$allowed) {
    respond(false, 'limit', 'You have sent several enquiries in a short time. Please try again later, or email us directly.', 429);
}

// 8. Send. Only validated values reach the headers: the visitor's address goes in Reply-To,
//    the subject comes from the fixed service list, and the sender is our own mailbox.
$subject = 'Website enquiry: ' . $data['service'];
$body = implode("\n", [
    'New enquiry from the Tri-Core website',
    str_repeat('-', 40),
    'Name:      ' . $data['name'],
    'Company:   ' . ($data['company'] !== '' ? $data['company'] : '-'),
    'Email:     ' . $data['email'],
    'Telephone: ' . ($data['phone'] !== '' ? $data['phone'] : '-'),
    'Service:   ' . $data['service'],
    'Received:  ' . date('j F Y, H:i'),
    str_repeat('-', 40),
    '',
    $data['message'],
    '',
    str_repeat('-', 40),
    'Reply to this email to answer ' . $data['name'] . ' directly.',
]);

$fromName = str_replace(['"', "\r", "\n"], '', (string) $config['from_name']);
$headers  = [
    'From'                      => sprintf('"%s" <%s>', $fromName, $config['from']),
    'Reply-To'                  => $data['email'],
    'MIME-Version'              => '1.0',
    'Content-Type'              => 'text/plain; charset=UTF-8',
    'Content-Transfer-Encoding' => '8bit',
    'X-Mailer'                  => 'Tri-Core website',
];

$encodedSubject = function_exists('mb_encode_mimeheader')
    ? mb_encode_mimeheader($subject, 'UTF-8', 'Q')
    : $subject;

$sent = @mail((string) $config['to'], $encodedSubject, $body, $headers, '-f' . $config['from']);
if (!$sent) {
    // Some hosts refuse the -f envelope option; try once more without it.
    $sent = @mail((string) $config['to'], $encodedSubject, $body, $headers);
}

if (!$sent) {
    error_log('tricore: enquiry mail() failed');
    respond(false, 'failed', 'We could not send your enquiry just now. Please email us directly.', 500);
}

respond(true, 'sent', 'Thank you — your enquiry has been sent. We will be in touch shortly.');
