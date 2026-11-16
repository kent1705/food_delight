<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: product.php');
    exit;
}
$productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare('SELECT id FROM products WHERE id=? AND active=1');
$stmt->execute([$productId]);
if ($productId && $stmt->fetch()) {
    $_SESSION['cart'][$productId] = min(99, (int)($_SESSION['cart'][$productId] ?? 0) + 1);
}
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'product.php'));
exit;
