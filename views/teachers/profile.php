<?php
$firstInitial = strtoupper(substr($teacher['first_name'], 0, 1));
$lastInitial = strtoupper(substr($teacher['last_name'], 0, 1));
require __DIR__ . '/../partials/header.php';
?>

<section class="content-page">
    <div class="container teacher-profile-container">
        <div class="public-profile-heading">
            <div class="default-avatar" aria-label="Default profile avatar">
                <?php echo htmlspecialchars($firstInitial . $lastInitial); ?>
            </div>
            <div>
                <p class="eyebrow">Teacher profile</p>
                <h1><?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?></h1>
                <p><?php echo htmlspecialchars($teacher['location'] ? $teacher['location'] : 'Location not provided'); ?></p>
            </div>
        </div>

        <div class="public-profile-about">
            <h2>About</h2>
            <p><?php echo $teacher['bio']
                ? nl2br(htmlspecialchars($teacher['bio']))
                : 'This teacher has not added a bio yet.'; ?></p>
        </div>

        <div class="teaching-options-heading">
            <h2>Teaching skills</h2>
            <p>Choose the specific skill you would like to learn.</p>
        </div>

        <div class="teaching-options">
            <?php foreach ($teachingSkills as $teachingSkill): ?>
                <article class="teaching-option-card">
                    <div class="teaching-option-title">
                        <div>
                            <h3><?php echo htmlspecialchars($teachingSkill['skill_name']); ?></h3>
                            <p><?php echo htmlspecialchars($teachingSkill['category_name']); ?></p>
                        </div>
                        <strong>Rs. <?php echo number_format($teachingSkill['hourly_rate'], 2); ?>/hour</strong>
                    </div>
                    <dl class="teacher-summary">
                        <div>
                            <dt>Experience level</dt>
                            <dd><?php echo htmlspecialchars($teachingSkill['experience_level']); ?></dd>
                        </div>
                        <?php if ($teachingSkill['years_experience'] !== null): ?>
                            <div>
                                <dt>Years of experience</dt>
                                <dd><?php echo (int) $teachingSkill['years_experience']; ?></dd>
                            </div>
                        <?php endif; ?>
                    </dl>
                    <p class="teacher-description">
                        <?php echo nl2br(htmlspecialchars($teachingSkill['description'])); ?>
                    </p>

                    <?php if (isset($_SESSION['user_id']) &&
                        (int) $_SESSION['user_id'] === (int) $teacher['user_id']): ?>
                        <span class="own-skill-label">This is your teaching skill</span>
                    <?php else: ?>
                        <a class="button" href="index.php?action=request-learning&amp;teaching_skill_id=<?php echo (int) $teachingSkill['teaching_skill_id']; ?>">Request to Learn</a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
