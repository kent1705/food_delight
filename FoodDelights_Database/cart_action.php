<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $action = $_POST['action'] ?? '';
    if ($id && isset($_SESSION['cart'][$id])) {
        if ($action === 'remove') unset($_SESSION['cart'][$id]);
        elseif ($action === 'update') {
            $qty = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
            if (!$qty || $qty < 1) unset($_SESSION['cart'][$id]);
            else $_SESSION['cart'][$id] = min(99, $qty);
        }
    }
}
header('Location: cart.php');
exit;
