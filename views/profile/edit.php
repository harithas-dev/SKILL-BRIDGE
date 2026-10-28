<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="form-page">
    <div class="form-card">
        <p class="eyebrow">My profile</p>
        <h1>Edit profile</h1>
        <p class="form-intro">Update your personal details. Your email cannot be changed here.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?action=edit-profile" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First name</label>
                    <input type="text" id="first_name" name="first_name" maxlength="50"
                        value="<?php echo htmlspecialchars($firstName); ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name" maxlength="50"
                        value="<?php echo htmlspecialchars($lastName); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                <small>Email editing is not available in this phase.</small>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" maxlength="20"
                    value="<?php echo htmlspecialchars($phone); ?>">
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" maxlength="100"
                    value="<?php echo htmlspecialchars($location); ?>">
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" maxlength="500" rows="6"><?php echo htmlspecialchars($bio); ?></textarea>
                <small>Maximum 500 characters.</small>
            </div>

            <div class="form-actions">
                <button class="button" type="submit">Save changes</button>
                <a class="button button-secondary" href="index.php?action=profile">Cancel</a>
            </div>
        </form>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
