<?php
require_once 'config.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: user.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Enter your name and a valid email.';
    elseif (strlen($password) < 8) $error = 'Password must contain at least 8 characters.';
    elseif ($password !== $confirm) $error = 'The passwords do not match.';
    else {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (full_name,email,password_hash,phone) VALUES (?,?,?,?)');
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $phone]);
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
            header('Location: user.php?welcome=1');
            exit;
        } catch (PDOException $e) {
            $error = $e->getCode() === '23000' ? 'That email is already registered. Please log in.' : 'Could not create your account. Please try again.';
        }
    }
}
include 'header.php';
?>
<main class="auth-page">
    <section class="auth-card">
        <h2>Create Your Account</h2>
        <p>Sign up to place orders and track your purchases.</p>
        <?php if ($error): ?><p class="form-error"><?= h($error) ?></p><?php endif; ?>
        <form method="post" autocomplete="on">
            <label for="full_name">Full Name</label><input id="full_name" name="full_name" required maxlength="150" value="<?= h($_POST['full_name'] ?? '') ?>">
            <label for="email">Email Address</label><input id="email" type="email" name="email" required value="<?= h($_POST['email'] ?? '') ?>">
            <label for="phone">Phone Number</label><input id="phone" name="phone" value="<?= h($_POST['phone'] ?? '') ?>">
            <label for="password">Password (at least 8 characters)</label><input id="password" type="password" name="password" minlength="8" required>
            <label for="confirm_password">Confirm Password</label><input id="confirm_password" type="password" name="confirm_password" minlength="8" required>
            <button class="button" type="submit">Create Account</button>
        </form>
        <p class="auth-switch">Already have an account? <a href="login.php">Log in here</a>.</p>
    </section>
</main><?php include 'footer.php'; ?>