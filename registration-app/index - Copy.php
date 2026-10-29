<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="card">
        <p class="eyebrow">WELCOME BACK</p>
        <h1>Sign in to your account</h1>
        <p class="intro">Sign in to browse our car tire prices.</p>

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

        <form method="post" action="index.php">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
            <input type="hidden" name="action" value="sign_in">

            <label for="email">Email address</label>
            <input id="email" name="email" type="email" maxlength="254" autocomplete="email"
                   value="<?= e($email) ?>" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>

            <button type="submit">Sign in</button>
        </form>
        <p class="auth-links">New here? <a href="signup.php">Create an account</a></p>
    </main>
</body>
</html>

    header('Location: tires.php');
    exit;
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isValidCsrfToken($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Your session expired. Refresh the page and try again.';
    } elseif (($_POST['action'] ?? '') !== 'sign_in') {
        $errors[] = 'This request could not be processed. Refresh the page and try again.';
    } else {
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
            $errors[] = 'Enter a valid email address.';
        }
        if ($password === '') {
            $errors[] = 'Enter your password.';
        }

        if ($errors === []) {
            try {
                require __DIR__ . '/db.php';

                $statement = $pdo->prepare(
                    'SELECT id, name, password_hash FROM users WHERE email = :email LIMIT 1'
                );
                $statement->execute(['email' => $email]);
                $user = $statement->fetch();

                if ($user !== false && password_verify($password, $user['password_hash'])) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = (int) $user['id'];
                    $_SESSION['user_name'] = (string) $user['name'];
                    rotateCsrfToken();
                    header('Location: tires.php');
                    exit;
                }

                $errors[] = 'The email address or password is incorrect.';
            } catch (PDOException $exception) {
                error_log($exception->getMessage());
                $errors[] = 'We could not sign you in. Check the database setup and try again.';
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
    <title>Sign in</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="card">
        <p class="eyebrow">WELCOME BACK</p>
        <h1>Sign in to your account</h1>
        <p class="intro">Sign in to browse our car tire prices.</p>

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

        <form method="post" action="index.php">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
            <input type="hidden" name="action" value="sign_in">

            <label for="email">Email address</label>
            <input id="email" name="email" type="email" maxlength="254" autocomplete="email"
                   value="<?= e($email) ?>" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>

            <button type="submit">Sign in</button>
        </form>
        <p class="auth-links">New here? <a href="signup.php">Create an account</a></p>
    </main>
</body>
</html>
