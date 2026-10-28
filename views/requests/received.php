<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="content-page">
    <div class="container">
        <div class="page-heading">
            <div>
                <p class="eyebrow">Learning requests</p>
                <h1>Requests Received</h1>
            </div>
            <a class="button button-secondary" href="index.php?action=requests-sent">Requests Sent</a>
        </div>

        <?php if ($successMessage !== ''): ?>
            <div class="alert alert-success" role="status">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage !== ''): ?>
            <div class="alert alert-error" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($requests)): ?>
            <div class="empty-state">
                <h2>No requests received yet</h2>
                <p>Learning requests for your teaching skills will appear here.</p>
            </div>
        <?php else: ?>
            <div class="request-list">
                <?php foreach ($requests as $request): ?>
                    <article class="request-card">
                        <div class="request-card-heading">
                            <div>
                                <h2><?php echo htmlspecialchars($request['skill_name']); ?></h2>
                                <p>
                                    Learner:
                                    <?php echo htmlspecialchars(
                                        $request['learner_first_name'] . ' ' . $request['learner_last_name']
                                    ); ?>
                                </p>
                            </div>
                            <span class="status-badge status-<?php echo strtolower(htmlspecialchars($request['status'])); ?>">
                                <?php echo htmlspecialchars($request['status']); ?>
                            </span>
                        </div>

                        <p class="request-message"><?php echo nl2br(htmlspecialchars($request['message'])); ?></p>
                        <time datetime="<?php echo htmlspecialchars($request['request_date']); ?>">
                            Received <?php echo htmlspecialchars(date('F j, Y g:i A', strtotime($request['request_date']))); ?>
                        </time>

                        <?php if ($request['status'] === 'Pending'): ?>
                            <div class="request-actions">
                                <form action="index.php?action=accept-request" method="post">
                                    <input type="hidden" name="request_id"
                                        value="<?php echo (int) $request['request_id']; ?>">
                                    <button class="button" type="submit">Accept</button>
                                </form>
                                <form action="index.php?action=reject-request" method="post">
                                    <input type="hidden" name="request_id"
                                        value="<?php echo (int) $request['request_id']; ?>">
                                    <button class="button button-danger" type="submit">Reject</button>
                                </form>
                            </div>
                        <?php elseif ($request['status'] === 'Accepted'): ?>
                            <div class="contact-card">
                                <h3>Learner contact details</h3>
                                <p>
                                    <?php echo htmlspecialchars(
                                        $request['learner_first_name'] . ' ' . $request['learner_last_name']
                                    ); ?>
                                </p>
                                <p>
                                    Email:
                                    <a href="mailto:<?php echo htmlspecialchars($request['learner_email']); ?>">
                                        <?php echo htmlspecialchars($request['learner_email']); ?>
                                    </a>
                                </p>
                                <p>
                                    Phone:
                                    <?php echo $request['learner_phone'] !== null && $request['learner_phone'] !== ''
                                        ? htmlspecialchars($request['learner_phone'])
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
