<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="content-page">
    <div class="container">
        <div class="page-heading">
            <div>
                <p class="eyebrow">Learning requests</p>
                <h1>Requests Sent</h1>
            </div>
            <div class="page-heading-actions">
                <a class="button button-secondary" href="index.php?action=requests-received">Requests Received</a>
                <a class="button" href="index.php?action=search">Find Teachers</a>
            </div>
        </div>

        <?php if ($successMessage !== ''): ?>
            <div class="alert alert-success" role="status">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($requests)): ?>
            <div class="empty-state">
                <h2>No requests sent yet</h2>
                <p>Find a teacher and request to learn one of their skills.</p>
                <a class="button" href="index.php?action=search">Find Teachers</a>
            </div>
        <?php else: ?>
            <div class="request-list">
                <?php foreach ($requests as $request): ?>
                    <article class="request-card">
                        <div class="request-card-heading">
                            <div>
                                <h2><?php echo htmlspecialchars($request['skill_name']); ?></h2>
                                <p>
                                    Teacher:
                                    <?php echo htmlspecialchars(
                                        $request['teacher_first_name'] . ' ' . $request['teacher_last_name']
                                    ); ?>
                                </p>
                            </div>
                            <span class="status-badge status-<?php echo strtolower(htmlspecialchars($request['status'])); ?>">
                                <?php echo htmlspecialchars($request['status']); ?>
                            </span>
                        </div>
                        <p class="request-message"><?php echo nl2br(htmlspecialchars($request['message'])); ?></p>
                        <time datetime="<?php echo htmlspecialchars($request['request_date']); ?>">
                            Sent <?php echo htmlspecialchars(date('F j, Y g:i A', strtotime($request['request_date']))); ?>
                        </time>
                        <?php if ($request['status'] === 'Accepted'): ?>
                            <div class="contact-card">
                                <h3>Teacher contact details</h3>
                                <p>
                                    <?php echo htmlspecialchars(
                                        $request['teacher_first_name'] . ' ' . $request['teacher_last_name']
                                    ); ?>
                                </p>
                                <p>
                                    Email:
                                    <a href="mailto:<?php echo htmlspecialchars($request['teacher_email']); ?>">
                                        <?php echo htmlspecialchars($request['teacher_email']); ?>
                                    </a>
                                </p>
                                <p>
                                    Phone:
                                    <?php echo $request['teacher_phone'] !== null && $request['teacher_phone'] !== ''
                                        ? htmlspecialchars($request['teacher_phone'])
                                        : 'Not provided'; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
