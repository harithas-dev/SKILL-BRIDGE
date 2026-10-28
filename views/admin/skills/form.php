<?php if (!empty($errors)): ?><div class="alert alert-error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?php echo htmlspecialchars($error); ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form action="<?php echo htmlspecialchars($formAction); ?>" method="post">
    <div class="form-group"><label for="skill_name">Skill name</label><input id="skill_name" name="skill_name" maxlength="100" value="<?php echo htmlspecialchars($skillName); ?>" required></div>
    <div class="form-group"><label for="category_id">Category</label><select id="category_id" name="category_id" required><option value="">Select a category</option><?php foreach ($categories as $category): ?><option value="<?php echo (int) $category['category_id']; ?>" <?php echo (string) $categoryId === (string) $category['category_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['category_name']); ?></option><?php endforeach; ?></select></div>
    <div class="form-actions"><button class="button" type="submit">Save Skill</button><a class="button button-secondary" href="index.php?action=admin-skills">Cancel</a></div>
</form>
