<?php
require_once 'functions.php';
$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
        $error = 'Please complete all fields using a valid email address.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO contact_messages (customer_name,customer_email,message) VALUES (?,?,?)');
        $stmt->execute([$name, $email, $message]);
        $success = true;
    }
}
include 'header.php';
?>
<main>
    <h2>Contact Us</h2>
    <p>Questions, custom cake orders or just want to say hi? Send us a message.<br>
        📍 123 Sugar Street | 📞 (555) 123-4567 | 🕗 Daily 8am to 6pm</p>
    <?php if ($success): ?><p>Thank you! Your message has been saved.</p><?php endif; ?>
    <?php if ($error): ?><p style="color:red"><?= h($error) ?></p><?php endif; ?>
    <form method="post">
        <label for="name">Name</label><input type="text" id="name" name="name" required>
        <label for="email">Email</label><input type="email" id="email" name="email" required>
        <label for="message">Message</label><textarea id="message" name="message" rows="5" required></textarea>
        <button class="button" type="submit">Send Message</button>
    </form>
</main>
<?php include 'footer.php'; ?>