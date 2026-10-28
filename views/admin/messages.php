<?php if ($successMessage !== ''): ?>
    <div class="alert alert-success" role="status"><?php echo htmlspecialchars($successMessage); ?></div>
<?php endif; ?>
<?php if ($errorMessage !== ''): ?>
    <div class="alert alert-error" role="alert"><?php echo htmlspecialchars($errorMessage); ?></div>
<?php endif; ?>
