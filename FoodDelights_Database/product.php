<?php
require_once 'functions.php';
$products = $pdo->query('SELECT * FROM products WHERE active=1 ORDER BY name')->fetchAll();
include 'header.php';
?>
<main>
  <h2>Our Desserts</h2>
  <p>Everything is baked fresh daily. Pick your favorites and add them to your cart.</p>
  <section class="grid">
    <?php foreach ($products as $product): ?>
      <div class="card">
        <?php if (!empty($product['image']) && file_exists(__DIR__ . '/' . $product['image'])): ?>
          <img src="<?= h($product['image']) ?>" alt="<?= h($product['name']) ?>">
        <?php else: ?><div class="emoji"><?= h($product['emoji']) ?></div><?php endif; ?>
        <h3><?= h($product['name']) ?></h3>
        <p><?= h($product['description']) ?></p>
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