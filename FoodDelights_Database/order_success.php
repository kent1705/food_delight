<?php
require_once 'functions.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare('SELECT id,customer_name,total,status,created_at FROM orders WHERE id=?');
$stmt->execute([$id]);
$order = $stmt->fetch();
include 'header.php';
?>
<main>
  <?php if ($order): ?>
    <h2>Thank you for your order, <?= h($order['customer_name']) ?>!</h2>
    <p>Your order number is <strong>#<?= (int)$order['id'] ?></strong>.</p>
    <p>Total: $<?= number_format($order['total'], 2) ?></p>
    <p>Status: <?= h($order['status']) ?></p>
  <?php else: ?><h2>Order not found.</h2><?php endif; ?>
  <a class="button" href="product.php">Continue Shopping</a>
</main>
<?php include 'footer.php'; ?>