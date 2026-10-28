<?php
$firstInitial = strtoupper(substr($user['first_name'], 0, 1));
$lastInitial = strtoupper(substr($user['last_name'], 0, 1));
require __DIR__ . '/../partials/header.php';
?>

<section class="profile-page">
    <div class="container profile-container">
        <?php if ($successMessage !== ''): ?>
            <div class="alert alert-success" role="status">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-heading">
                <div class="default-avatar" aria-label="Default profile avatar">
                    <?php echo htmlspecialchars($firstInitial . $lastInitial); ?>
                </div>
                <div>
                    <p class="eyebrow">My profile</p>
                    <h1>
                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                    </h1>
                    <p>Member since <?php echo htmlspecialchars(date('F Y', strtotime($user['created_at']))); ?></p>
                </div>
                <a class="button profile-edit-button" href="index.php?action=edit-profile">Edit profile</a>
            </div>

            <dl class="profile-details">
                <div>
                    <dt>Email</dt>
                    <dd><?php echo htmlspecialchars($user['email']); ?></dd>
                </div>
                <div>
                    <dt>Phone</dt>
                    <dd><?php echo $user['phone'] ? htmlspecialchars($user['phone']) : 'Not provided'; ?></dd>
                </div>
                <div>
                    <dt>Location</dt>
                    <dd><?php echo $user['location'] ? htmlspecialchars($user['location']) : 'Not provided'; ?></dd>
                </div>
                <div class="profile-bio">
                    <dt>Bio</dt>
                    <dd><?php echo $user['bio'] ? nl2br(htmlspecialchars($user['bio'])) : 'Not provided'; ?></dd>
                </div>
            </dl>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
