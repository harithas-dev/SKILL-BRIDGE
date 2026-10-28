<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="form-page">
    <div class="form-card form-card-small">
        <p class="eyebrow">Welcome back</p>
        <h1>Log in</h1>

        <?php if ($successMessage !== ''): ?>
            <div class="alert alert-success" role="status">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php elseif (isset($_GET['logged_out'])): ?>
            <div class="alert alert-success" role="status">You have been logged out.</div>
        <?php elseif (isset($_GET['disabled'])): ?>
            <div class="alert alert-error" role="alert">This account has been disabled.</div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?action=login" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" maxlength="100" autocomplete="email"
                    value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>

            <button class="button button-full" type="submit">Log in</button>
        </form>

        <p class="form-link">Need an account? <a href="index.php?action=register">Register</a></p>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
