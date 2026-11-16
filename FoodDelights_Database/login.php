<?php
require_once 'config.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: user.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id,full_name,password_hash FROM users WHERE email=? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $target = $_SESSION['redirect_after_login'] ?? 'user.php';
        unset($_SESSION['redirect_after_login']);
        header('Location: ' . $target);
        exit;
    }
    $error = 'Incorrect email or password.';
}
include 'header.php';
?>
<main class="auth-page">
    <section class="auth-card">
        <h2>Welcome Back!</h2>
        <p>Log in to your Food Delights account.</p>
        <?php if (isset($_GET['required'])): ?><p class="form-note">Please log in before checking out.</p><?php endif; ?>
        <?php if ($error): ?><p class="form-error"><?= h($error) ?></p><?php endif; ?>
        <form method="post" autocomplete="on">
            <label for="email">Email Address</label><input id="email" type="email" name="email" required autocomplete="email" value="<?= h($_POST['email'] ?? '') ?>">
            <label for="password">Password</label><input id="password" type="password" name="password" required autocomplete="current-password">
            <button class="button" type="submit">Log In</button>
        </form>
        <p class="auth-switch">Don't have an account? <a href="register.php">Sign up here</a>.</p>
    </section>
</main><?php include 'footer.php'; ?>