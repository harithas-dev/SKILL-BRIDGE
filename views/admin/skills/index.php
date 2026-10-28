<?php require __DIR__ . '/../../partials/header.php'; ?>

<section class="content-page"><div class="container">
    <div class="page-heading"><div><p class="eyebrow">Administration</p><h1>Manage Skills</h1></div><a class="button" href="index.php?action=admin-skill-create">Add Skill</a></div>
    <?php require __DIR__ . '/../messages.php'; ?>
    <div class="table-wrapper"><table class="admin-table">
        <thead><tr><th>Skill</th><th>Category</th><th>Teaching listings</th><th>Actions</th></tr></thead>
        <tbody><?php foreach ($skills as $skill): ?><tr>
            <td><?php echo htmlspecialchars($skill['skill_name']); ?></td>
            <td><?php echo htmlspecialchars($skill['category_name']); ?></td>
            <td><?php echo (int) $skill['teaching_count']; ?></td>
            <td class="table-actions">
                <a class="button button-small button-secondary" href="index.php?action=admin-skill-edit&amp;id=<?php echo (int) $skill['skill_id']; ?>">Edit</a>
                <form class="admin-delete-form" action="index.php?action=admin-skill-delete" method="post"><input type="hidden" name="skill_id" value="<?php echo (int) $skill['skill_id']; ?>"><button class="button button-small button-danger" type="submit">Delete</button></form>
            </td>
        </tr><?php endforeach; ?></tbody>
    </table></div>
</div></section>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
