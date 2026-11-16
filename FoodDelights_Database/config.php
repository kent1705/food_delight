<?php
// XAMPP default: username root, blank password.
// Change these values if your MySQL setup uses a password.
$host = '127.0.0.1';
$dbname = 'food_delights';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Check config.php and make sure MySQL is running.');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
