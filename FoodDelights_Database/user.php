<?php
require_once 'functions.php';
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$stmt = $pdo->prepare('SELECT id,full_name,email,phone,address,created_at FROM users WHERE id=?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
if (!$user) {
    header('Location: logout.php');
    exit;
}
$notice = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['form_action'] ?? '') === 'update_profile') {
    $name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    if ($name === '') $error = 'Your name is required.';
    else {
        $update = $pdo->prepare('UPDATE users SET full_name=?,phone=?,address=? WHERE id=?');
        $update->execute([$name, $phone, $address, $_SESSION['user_id']]);
        $_SESSION['user_name'] = $name;
        header('Location: user.php?updated=1');
        exit;
    }
}
if (isset($_GET['updated'])) $notice = 'Your profile has been updated.';
$ordersStmt = $pdo->prepare('SELECT id,total,status,created_at FROM orders WHERE user_id=? ORDER BY created_at DESC');
$ordersStmt->execute([$_SESSION['user_id']]);
$orders = $ordersStmt->fetchAll();
include 'header.php';
?>
<main>
    <h2>My Account</h2>
    <p>Welcome, <?= h($user['full_name']) ?>! Manage your account and view your orders here.</p>
    <?php if ($notice): ?><p class="form-note"><?= h($notice) ?></p><?php endif; ?>
    <?php if ($error): ?><p class="form-error"><?= h($error) ?></p><?php endif; ?>
    <div class="user-layout">
        <section class="user-panel">
            <h3>My Profile</h3>
            <form method="post">
                <input type="hidden" name="form_action" value="update_profile">
                <label for="full_name">Full Name</label><input id="full_name" name="full_name" required value="<?= h($user['full_name']) ?>">
                <label>Email Address</label><input value="<?= h($user['email']) ?>" disabled>
                <label for="phone">Phone Number</label><input id="phone" name="phone" value="<?= h($user['phone'] ?? '') ?>">
                <label for="address">Delivery Address</label><textarea id="address" name="address" rows="3"><?= h($user['address'] ?? '') ?></textarea>
                <button class="button" type="submit">Save Profile</button>
            </form>
        </section>
        <section class="user-panel">
            <h3>My Orders</h3>
            <?php if (!$orders): ?><p>You have not placed any orders yet.</p><a class="button" href="product.php">Browse Desserts</a>
            <?php else: ?><div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?><tr>
                                    <td>#<?= (int)$order['id'] ?></td>
                                    <td><?= h(date('M d, Y', strtotime($order['created_at']))) ?></td>
                                    <td>$<?= number_format($order['total'], 2) ?></td>
                                    <td><?= h($order['status']) ?></td>
                                </tr><?php endforeach; ?>
                        </tbody>
                    </table>
                </div><?php endif; ?>
        </section>
    </div>
</main>
<?php include 'footer.php'; ?>