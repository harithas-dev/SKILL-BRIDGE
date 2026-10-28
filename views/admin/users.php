<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="content-page">
    <div class="container">
        <div class="page-heading"><div><p class="eyebrow">Administration</p><h1>Manage Users</h1></div></div>
        <?php require __DIR__ . '/messages.php'; ?>
        <div class="table-wrapper">
            <table class="admin-table">
                <thead><tr><th>Name</th><th>Email</th><th>Location</th><th>Role</th><th>Status</th><th>Date joined</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo $user['location'] ? htmlspecialchars($user['location']) : 'Not provided'; ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($user['role'])); ?></td>
                            <td><span class="status-badge status-<?php echo htmlspecialchars($user['account_status']); ?>"><?php echo htmlspecialchars(ucfirst($user['account_status'])); ?></span></td>
                            <td><?php echo htmlspecialchars(date('F j, Y', strtotime($user['created_at']))); ?></td>
                            <td>
                                <?php if ($user['role'] === 'user'): ?>
                                    <form action="index.php?action=admin-user-status" method="post">
                                        <input type="hidden" name="user_id" value="<?php echo (int) $user['user_id']; ?>">
                                        <input type="hidden" name="account_status" value="<?php echo $user['account_status'] === 'active' ? 'disabled' : 'active'; ?>">
                                        <button class="button button-small <?php echo $user['account_status'] === 'active' ? 'button-danger' : ''; ?>" type="submit">
                                            <?php echo $user['account_status'] === 'active' ? 'Disable' : 'Enable'; ?>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="muted-text">Admin account</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
