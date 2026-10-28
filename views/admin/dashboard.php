<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="content-page">
    <div class="container">
        <p class="eyebrow">Administration</p>
        <h1>Admin Dashboard</h1>
        <div class="admin-stats">
            <?php
            $statistics = array(
                'Total Users' => $counts['total_users'],
                'Total Teachers' => $counts['total_teachers'],
                'Total Teaching Skills' => $counts['total_teaching_skills'],
                'Total Learning Requests' => $counts['total_requests'],
                'Pending Requests' => $counts['pending_requests'],
                'Accepted Requests' => $counts['accepted_requests']
            );
            foreach ($statistics as $label => $value):
            ?>
                <div class="dashboard-stat">
                    <strong><?php echo (int) $value; ?></strong>
                    <span><?php echo htmlspecialchars($label); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="admin-shortcuts">
            <a class="button" href="index.php?action=admin-users">Manage Users</a>
            <a class="button" href="index.php?action=admin-categories">Manage Categories</a>
            <a class="button" href="index.php?action=admin-skills">Manage Skills</a>
            <a class="button" href="index.php?action=admin-requests">View Learning Requests</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
