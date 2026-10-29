<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function isSignedIn(): bool
{
    return isset($_SESSION['user_id'], $_SESSION['user_name']);
}

function isValidCsrfToken(mixed $token): bool
{
    return is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

function rotateCsrfToken(): void
{
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
