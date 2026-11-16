<?php
require_once 'functions.php';
$stmt = $pdo->query('SELECT * FROM products WHERE active=1 ORDER BY id DESC LIMIT 3');
$products = $stmt->fetchAll();
include 'header.php';
?>
<main>
  <section class="hero">
    <h2>Life is short. Eat dessert first.</h2>
    <p>Freshly baked cakes, cookies and sweet treats, made with love every morning.</p>
    <a class="button" href="product.php">Shop Desserts</a>
  </section>
  <h2>Customer Favorites</h2>
  <section class="grid">
    <?php foreach ($products as $product): ?>
      <div class="card">
        <?php if (!empty($product['image']) && file_exists(__DIR__ . '/' . $product['image'])): ?>
          <img src="<?= h($product['image']) ?>" alt="<?= h($product['name']) ?>">
        <?php else: ?><div class="emoji"><?= h($product['emoji']) ?></div><?php endif; ?>
        <h3><?= h($product['name']) ?></h3>
        <p class="price">$<?= number_format($product['price'], 2) ?></p>
        <form action="add_to_cart.php" method="post">
          <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
          <button class="button" type="submit">Add to Cart</button>
        </form>
      </div>
    <?php endforeach; ?>
  </section>
</main>
<?php include 'footer.php'; ?>