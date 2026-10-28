<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="form-page">
    <div class="form-card">
        <p class="eyebrow">Create an account</p>
        <h1>Join SkillBridge</h1>
        <p class="form-intro">Create one account to learn skills, teach skills, or do both.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="registration-form" action="index.php?action=register" method="post" novalidate>
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First name</label>
                    <input type="text" id="first_name" name="first_name" maxlength="50" autocomplete="given-name"
                        value="<?php echo htmlspecialchars($firstName); ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name" maxlength="50" autocomplete="family-name"
                        value="<?php echo htmlspecialchars($lastName); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" maxlength="100" autocomplete="email"
                    value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" minlength="6" autocomplete="new-password" required>
                <small>Use at least 6 characters.</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm password</label>
                <input type="password" id="confirm_password" name="confirm_password" minlength="6" autocomplete="new-password" required>
            </div>

            <button class="button button-full" type="submit">Register</button>
        </form>

        <p class="form-link">Already registered? <a href="index.php?action=login">Log in</a></p>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
