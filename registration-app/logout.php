<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isValidCsrfToken($_POST['csrf_token'] ?? null)) {
    http_response_code(400);
    exit('Invalid sign-out request. Return to the tire price page and try again.');
}

$_SESSION = [];
session_regenerate_id(true);
rotateCsrfToken();

header('Location: index.php');
exit;
