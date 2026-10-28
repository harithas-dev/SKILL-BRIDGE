<?php if (!empty($errors)): ?>
    <div class="alert alert-error" role="alert">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (empty($skills)): ?>
    <div class="alert alert-error" role="alert">
        No skills are available yet. Please try again after skills have been added.
    </div>
<?php else: ?>
    <form action="<?php echo $pageTitle === 'Edit Teaching Skill'
        ? 'index.php?action=edit-teaching-skill&amp;id=' . (int) $teachingSkillId
        : 'index.php?action=add-teaching-skill'; ?>" method="post">
        <div class="form-group">
            <label for="skill_id">Skill</label>
            <select id="skill_id" name="skill_id" required>
                <option value="">Select a skill</option>
                <?php foreach ($skills as $skill): ?>
                    <option value="<?php echo (int) $skill['skill_id']; ?>"
                        <?php echo (string) $skillId === (string) $skill['skill_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($skill['skill_name'] . ' — ' . $skill['category_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="experience_level">Experience level</label>
            <select id="experience_level" name="experience_level" required>
                <option value="">Select an experience level</option>
                <?php foreach (array('Beginner', 'Intermediate', 'Advanced', 'Expert') as $level): ?>
                    <option value="<?php echo $level; ?>"
                        <?php echo $experienceLevel === $level ? 'selected' : ''; ?>>
                        <?php echo $level; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div id="price-guidance" class="price-guidance" aria-live="polite"></div>
        </div>

        <div class="form-group">
            <label for="years_experience">Years of experience <span class="optional">(optional)</span></label>
            <input type="number" id="years_experience" name="years_experience" min="0" max="100" step="1"
                value="<?php echo htmlspecialchars($yearsExperience); ?>">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" maxlength="500" rows="6" required><?php echo htmlspecialchars($description); ?></textarea>
            <small>Maximum 500 characters.</small>
        </div>

        <div class="form-group">
            <label for="hourly_rate">Hourly rate (Rs.)</label>
            <input type="number" id="hourly_rate" name="hourly_rate" min="0" max="99999999.99"
                step="0.01" value="<?php echo htmlspecialchars($hourlyRate); ?>" required>
            <small>The suggested range is guidance only. You may choose your own rate.</small>
        </div>

        <div class="form-actions">
            <button class="button" type="submit">
                <?php echo $pageTitle === 'Edit Teaching Skill' ? 'Save changes' : 'Add teaching skill'; ?>
            </button>
            <a class="button button-secondary" href="index.php?action=teaching-skills">Cancel</a>
        </div>
    </form>
<?php endif; ?>
