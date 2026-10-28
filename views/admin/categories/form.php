<?php if (!empty($errors)): ?><div class="alert alert-error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?php echo htmlspecialchars($error); ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form action="<?php echo htmlspecialchars($formAction); ?>" method="post">
    <div class="form-group"><label for="category_name">Category name</label><input id="category_name" name="category_name" maxlength="100" value="<?php echo htmlspecialchars($categoryName); ?>" required></div>
    <div class="form-actions"><button class="button" type="submit">Save Category</button><a class="button button-secondary" href="index.php?action=admin-categories">Cancel</a></div>
</form>
