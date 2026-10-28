<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="content-page">
    <div class="container">
        <div class="page-heading">
            <div>
                <p class="eyebrow">Teach on SkillBridge</p>
                <h1>My Teaching Skills</h1>
            </div>
            <a class="button" href="index.php?action=add-teaching-skill">Add Teaching Skill</a>
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

        <?php if (empty($teachingSkills)): ?>
            <div class="empty-state">
                <h2>No teaching skills yet</h2>
                <p>Add a skill you can teach to start building your teacher profile.</p>
                <a class="button" href="index.php?action=add-teaching-skill">Add Teaching Skill</a>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Skill</th>
                            <th>Experience</th>
                            <th>Years</th>
                            <th>Description</th>
                            <th>Hourly rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teachingSkills as $teachingSkill): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($teachingSkill['skill_name']); ?></strong>
                                    <span class="table-subtext">
                                        <?php echo htmlspecialchars($teachingSkill['category_name']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($teachingSkill['experience_level']); ?></td>
                                <td>
                                    <?php echo $teachingSkill['years_experience'] === null
                                        ? 'Not provided'
                                        : htmlspecialchars($teachingSkill['years_experience']); ?>
                                </td>
                                <td class="description-cell">
                                    <?php echo nl2br(htmlspecialchars($teachingSkill['description'])); ?>
                                </td>
                                <td>Rs. <?php echo number_format($teachingSkill['hourly_rate'], 2); ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a class="button button-small" href="index.php?action=edit-teaching-skill&amp;id=<?php echo (int) $teachingSkill['teaching_skill_id']; ?>">Edit</a>
                                        <form class="inline-form delete-skill-form" action="index.php?action=delete-teaching-skill" method="post">
                                            <input type="hidden" name="teaching_skill_id" value="<?php echo (int) $teachingSkill['teaching_skill_id']; ?>">
                                            <button class="button button-small button-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
