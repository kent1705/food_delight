<?php
require_once 'functions.php';
if (empty($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'checkout.php';
    header('Location: login.php?required=1');
    exit;
}
[$items, $total] = getCartDetails($pdo);
if (!$items) {
    header('Location: cart.php');
    exit;
}
$userStmt = $pdo->prepare('SELECT full_name,email,phone,address FROM users WHERE id=?');
$userStmt->execute([$_SESSION['user_id']]);
$currentUser = $userStmt->fetch();
if (!$currentUser) {
    header('Location: logout.php');
    exit;
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $currentUser['full_name'];
    $email = $currentUser['email'];
    $phone = trim($_POST['customer_phone'] ?? $currentUser['phone'] ?? '');
    $address = trim($_POST['delivery_address'] ?? $currentUser['address'] ?? '');
    if ($address === '') {
        $error = 'Please enter your delivery address.';
    } else {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO orders (user_id,customer_name,customer_email,customer_phone,delivery_address,total) VALUES (?,?,?,?,?,?)');
            $stmt->execute([$_SESSION['user_id'], $name, $email, $phone, $address, $total]);
            $orderId = (int)$pdo->lastInsertId();
            $insert = $pdo->prepare('INSERT INTO order_items (order_id,product_id,product_name,unit_price,quantity,subtotal) VALUES (?,?,?,?,?,?)');
            foreach ($items as $item) {
                $insert->execute([$orderId, $item['id'], $item['name'], $item['price'], $item['quantity'], $item['subtotal']]);
            }
            $pdo->commit();
            unset($_SESSION['cart']);
            header('Location: order_success.php?id=' . $orderId);
            exit;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $error = 'Unable to save your order. Please try again.';
        }
    }
}
include 'header.php';
?>
<main>
    <h2>Checkout</h2>
    <p>Order total: <strong>$<?= number_format($total, 2) ?></strong></p>
    <?php if ($error): ?><p class="form-error"><?= h($error) ?></p><?php endif; ?>
    <form method="post">
        <label>Name</label><input value="<?= h($currentUser['full_name']) ?>" disabled>
        <label>Email</label><input type="email" value="<?= h($currentUser['email']) ?>" disabled>
        <label>Phone</label><input name="customer_phone" value="<?= h($currentUser['phone'] ?? '') ?>">
        <label>Delivery Address</label><textarea name="delivery_address" required rows="4"><?= h($currentUser['address'] ?? '') ?></textarea>
        <button class="button" type="submit">Place Order</button>
    </form>
</main>
<?php include 'footer.php'; ?>