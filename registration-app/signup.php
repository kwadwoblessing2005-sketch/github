<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isSignedIn()) {
    header('Location: tires.php');
    exit;
}

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isValidCsrfToken($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Your session expired. Refresh the page and try again.';
    } elseif (($_POST['action'] ?? '') !== 'sign_up') {
        $errors[] = 'This request could not be processed. Refresh the page and try again.';
    } else {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

        if ($name === '' || strlen($name) > 100) {
            $errors[] = 'Enter your name (up to 100 characters).';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
            $errors[] = 'Enter a valid email address.';
        }
        if (strlen($password) < 8 || strlen($password) > 4096) {
            $errors[] = 'Your password must be between 8 and 4096 characters long.';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'The passwords do not match.';
        }

        if ($errors === []) {
            try {
                require __DIR__ . '/db.php';

                $statement = $pdo->prepare(
                    'INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password_hash)'
                );
                $statement->execute([
                    'name' => $name,
                    'email' => $email,
                    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                ]);

                session_regenerate_id(true);
                $_SESSION['user_id'] = (int) $pdo->lastInsertId();
                $_SESSION['user_name'] = $name;
                rotateCsrfToken();
                header('Location: tires.php');
                exit;
            } catch (PDOException $exception) {
                error_log($exception->getMessage());
                if ($exception->getCode() === '23000') {
                    $errors[] = 'An account with that email address already exists.';
                } else {
                    $errors[] = 'We could not create your account. Check the database setup and try again.';
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create an account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="card">
        <p class="eyebrow">GET STARTED</p>
        <h1>Create your account</h1>
        <p class="intro">Create an account to browse our car tire prices.</p>

        <?php if ($errors !== []): ?>
            <div class="notice error" role="alert">
                <p>Please check the following:</p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="signup.php">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
            <input type="hidden" name="action" value="sign_up">

            <label for="name">Full name</label>
            <input id="name" name="name" type="text" maxlength="100" autocomplete="name"
                   value="<?= e($name) ?>" required>

            <label for="email">Email address</label>
            <input id="email" name="email" type="email" maxlength="254" autocomplete="email"
                   value="<?= e($email) ?>" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" minlength="8" maxlength="4096"
                   autocomplete="new-password" required>

            <label for="confirm_password">Confirm password</label>
            <input id="confirm_password" name="confirm_password" type="password" minlength="8"
                   maxlength="4096" autocomplete="new-password" required>

            <button type="submit">Create account</button>
        </form>
        <p class="auth-links">Already have an account? <a href="index.php">Sign in</a></p>
    </main>
</body>
</html>
