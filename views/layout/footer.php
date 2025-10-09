<footer class="site-footer">
  <div class="footer-logos">
    <?php $footer->showAll(); ?>
  </div>

  <?php [$q1, $q2] = $footer->getQuotes(); ?>
  <?php if ($q1 || $q2): ?>
    <div class="footer-quotes">
      <?php if ($q1): ?>
        <p class="quote quote-default"><?= htmlspecialchars($q1) ?></p>
      <?php endif; ?>
      <?php if ($q2): ?>
        <p class="quote quote-alt"><?= htmlspecialchars($q2) ?></p>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</footer>
</body>