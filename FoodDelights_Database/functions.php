<?php
require_once __DIR__ . '/config.php';

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function getCartDetails(PDO $pdo)
{
    $cart = $_SESSION['cart'] ?? [];
    $items = [];
    $total = 0;

    foreach ($cart as $productId => $quantity) {
        $stmt = $pdo->prepare('SELECT id,name,price,emoji,image FROM products WHERE id = ? AND active = 1');
        $stmt->execute([(int)$productId]);
        $product = $stmt->fetch();
        if (!$product) continue;

        $quantity = max(1, min(99, (int)$quantity));
        $product['quantity'] = $quantity;
        $product['subtotal'] = (float)$product['price'] * $quantity;
        $total += $product['subtotal'];
        $items[] = $product;
    }
    return [$items, $total];
}
