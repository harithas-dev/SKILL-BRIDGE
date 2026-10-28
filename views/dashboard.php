<?php require __DIR__ . '/partials/header.php'; ?>

<section class="dashboard-page">
    <div class="container">
        <p class="eyebrow">Authenticated area</p>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</h1>
        <p class="dashboard-intro">Here is a summary of your SkillBridge activity.</p>

        <div class="dashboard-stats">
            <a class="dashboard-stat" href="index.php?action=teaching-skills">
                <strong><?php echo (int) $counts['teaching_skill_count']; ?></strong>
                <span>My Teaching Skills</span>
            </a>
            <a class="dashboard-stat" href="index.php?action=requests-sent">
                <strong><?php echo (int) $counts['sent_request_count']; ?></strong>
                <span>Requests Sent</span>
            </a>
            <a class="dashboard-stat" href="index.php?action=requests-received">
                <strong><?php echo (int) $counts['received_request_count']; ?></strong>
                <span>Requests Received</span>
            </a>
            <div class="dashboard-stat">
                <strong><?php echo (int) $counts['accepted_request_count']; ?></strong>
                <span>Accepted Requests</span>
            </div>
        </div>

        <section class="dashboard-section" aria-labelledby="shortcuts-heading">
            <h2 id="shortcuts-heading">Quick links</h2>
            <div class="dashboard-shortcuts">
                <a class="button button-secondary" href="index.php?action=profile">My Profile</a>
                <a class="button button-secondary" href="index.php?action=teaching-skills">My Teaching Skills</a>
                <a class="button button-secondary" href="index.php?action=requests-sent">Requests Sent</a>
                <a class="button button-secondary" href="index.php?action=requests-received">Requests Received</a>
                <a class="button button-secondary" href="index.php?action=search">Find Teachers</a>
            </div>
        </section>

        <section class="dashboard-section" aria-labelledby="recent-notifications-heading">
            <div class="section-heading">
                <h2 id="recent-notifications-heading">Recent Notifications</h2>
                <a href="index.php?action=notifications">View all</a>
            </div>

            <?php if (empty($recentNotifications)): ?>
                <div class="empty-state compact-empty-state">
                    <p>You do not have any notifications yet.</p>
                </div>
            <?php else: ?>
                <div class="notification-list">
                    <?php foreach ($recentNotifications as $notification): ?>
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
        </section>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
