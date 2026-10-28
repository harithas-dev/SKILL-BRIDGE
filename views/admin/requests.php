<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="content-page"><div class="container">
    <div class="page-heading"><div><p class="eyebrow">Administration</p><h1>Learning Requests</h1></div></div>
    <?php if (empty($requests)): ?>
        <div class="empty-state"><h2>No learning requests</h2><p>Learning requests will appear here.</p></div>
    <?php else: ?>
        <div class="table-wrapper"><table class="admin-table">
            <thead><tr><th>Learner</th><th>Teacher</th><th>Skill</th><th>Status</th><th>Requested</th><th>Accepted</th></tr></thead>
            <tbody><?php foreach ($requests as $request): ?><tr>
                <td><?php echo htmlspecialchars($request['learner_first_name'] . ' ' . $request['learner_last_name']); ?></td>
                <td><?php echo htmlspecialchars($request['teacher_first_name'] . ' ' . $request['teacher_last_name']); ?></td>
                <td><?php echo htmlspecialchars($request['skill_name']); ?></td>
                <td><span class="status-badge status-<?php echo strtolower(htmlspecialchars($request['status'])); ?>"><?php echo htmlspecialchars($request['status']); ?></span></td>
                <td><?php echo htmlspecialchars(date('F j, Y g:i A', strtotime($request['request_date']))); ?></td>
                <td><?php echo $request['accepted_date'] ? htmlspecialchars(date('F j, Y g:i A', strtotime($request['accepted_date']))) : 'Not accepted'; ?></td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
    <?php endif; ?>
</div></section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
