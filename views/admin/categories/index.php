<?php require __DIR__ . '/../../partials/header.php'; ?>

<section class="content-page"><div class="container">
    <div class="page-heading"><div><p class="eyebrow">Administration</p><h1>Manage Categories</h1></div><a class="button" href="index.php?action=admin-category-create">Add Category</a></div>
    <?php require __DIR__ . '/../messages.php'; ?>
    <div class="table-wrapper"><table class="admin-table">
        <thead><tr><th>Category</th><th>Skills</th><th>Actions</th></tr></thead>
        <tbody><?php foreach ($categories as $category): ?><tr>
            <td><?php echo htmlspecialchars($category['category_name']); ?></td>
            <td><?php echo (int) $category['skill_count']; ?></td>
            <td class="table-actions">
                <a class="button button-small button-secondary" href="index.php?action=admin-category-edit&amp;id=<?php echo (int) $category['category_id']; ?>">Edit</a>
                <form class="admin-delete-form" action="index.php?action=admin-category-delete" method="post"><input type="hidden" name="category_id" value="<?php echo (int) $category['category_id']; ?>"><button class="button button-small button-danger" type="submit">Delete</button></form>
            </td>
        </tr><?php endforeach; ?></tbody>
    </table></div>
</div></section>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
