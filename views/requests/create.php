<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="form-page">
    <div class="form-card form-card-small">
        <p class="eyebrow">Learning request</p>
        <h1>Request to Learn</h1>

        <div class="request-target">
            <span>Teacher</span>
            <strong><?php echo htmlspecialchars($teachingSkill['first_name'] . ' ' . $teachingSkill['last_name']); ?></strong>
            <span>Skill</span>
            <strong><?php echo htmlspecialchars($teachingSkill['skill_name']); ?></strong>
            <small><?php echo htmlspecialchars($teachingSkill['category_name']); ?></small>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!$isOwnTeachingSkill): ?>
            <form action="index.php?action=request-learning&amp;teaching_skill_id=<?php echo (int) $teachingSkill['teaching_skill_id']; ?>" method="post">
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" maxlength="500" rows="6"
                        placeholder="Introduce yourself and explain what you would like to learn."
                        required><?php echo htmlspecialchars($message); ?></textarea>
                    <small>Maximum 500 characters.</small>
                </div>

                <div class="form-actions">
                    <button class="button" type="submit">Send request</button>
                    <a class="button button-secondary" href="index.php?action=teacher&amp;id=<?php echo (int) $teachingSkill['teacher_id']; ?>">Cancel</a>
                </div>
            </form>
        <?php else: ?>
            <a class="button button-secondary" href="index.php?action=teacher&amp;id=<?php echo (int) $teachingSkill['teacher_id']; ?>">Return to profile</a>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
