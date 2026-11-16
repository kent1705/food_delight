<?php
require_once 'functions.php';
[$items, $total] = getCartDetails($pdo);
include 'header.php';
?>
<main>
  <h2>Your Cart 🛒</h2>
  <p>Review your selected desserts before checkout.</p>
  <table>
    <thead>
      <tr>
        <th>Dessert</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Subtotal</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!$items): ?>
        <tr>
          <td colspan="5">Your cart is empty. Choose a dessert to get started.</td>
        </tr>
        <?php else: foreach ($items as $item): ?>
          <tr>
            <td><?= h($item['emoji'] . ' ' . $item['name']) ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td>
              <form action="cart_action.php" method="post">
                <input type="hidden" name="product_id" value="<?= (int)$item['id'] ?>">
                <input type="hidden" name="action" value="update">
                <input type="number" name="quantity" min="1" max="99" value="<?= (int)$item['quantity'] ?>" style="width:65px">
                <button type="submit">Update</button>
              </form>
            </td>
            <td>$<?= number_format($item['subtotal'], 2) ?></td>
            <td>
              <form action="cart_action.php" method="post">
                <input type="hidden" name="product_id" value="<?= (int)$item['id'] ?>">
                <input type="hidden" name="action" value="remove">
                <button type="submit">Remove</button>
              </form>
            </td>
          </tr>
      <?php endforeach;
      endif; ?>
    </tbody>
  </table>
  <p class="total">Total: $<?= number_format($total, 2) ?></p>
  <a class="button" href="product.php">Keep Shopping</a>
  <?php if ($items): ?><a class="button" href="checkout.php">Proceed to Checkout</a><?php endif; ?>
</main>
<?php include 'footer.php'; ?>