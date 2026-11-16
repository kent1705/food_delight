<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Delights</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>🧁 Food Delights</h1>
        <nav>
            <a href="index.php">Home</a><a href="product.php">Products</a>
            <a href="cart.php">Cart (<?= array_sum($_SESSION['cart'] ?? []) ?>)</a>
            <a href="about_us.php">About Us</a><a href="contact.php">Contact Us</a>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="user.php">My Account</a><a href="logout.php">Log Out</a>
            <?php else: ?><a href="login.php">Log In</a><a href="register.php">Sign Up</a><?php endif; ?>
        </nav>
    </header>