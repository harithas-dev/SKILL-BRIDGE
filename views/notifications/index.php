<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="content-page">
    <div class="container notification-container">
        <div class="page-heading">
            <div>
                <p class="eyebrow">Updates</p>
                <h1>Notifications</h1>
            </div>
            <a class="button button-secondary" href="index.php?action=dashboard">Dashboard</a>
        </div>

        <?php if (empty($notifications)): ?>
            <div class="empty-state">
                <h2>No notifications yet</h2>
                <p>Updates about your learning requests will appear here.</p>
            </div>
        <?php else: ?>
            <p class="page-note">Opening this page marks all notifications as read.</p>
            <div class="notification-list">
                <?php foreach ($notifications as $notification): ?>
                    <article class="notification-item <?php echo $notification['is_read'] ? '' : 'notification-unread'; ?>">
                        <div>
                            <p><?php echo htmlspecialchars($notification['message']); ?></p>
                            <time datetime="<?php echo htmlspecialchars($notification['created_at']); ?>">
                                <?php echo htmlspecialchars(date('F j, Y g:i A', strtotime($notification['created_at']))); ?>
                            </time>
                        </div>
                        <span class="read-state">
                            <?php echo $notification['is_read'] ? 'Read' : 'Unread'; ?>
                        </span>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
