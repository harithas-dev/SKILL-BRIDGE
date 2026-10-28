<?php require __DIR__ . '/../partials/header.php'; ?>

<section class="content-page">
    <div class="container">
        <div class="page-heading search-heading">
            <div>
                <p class="eyebrow">Learn from the community</p>
                <h1>Find Teachers</h1>
            </div>
        </div>

        <form class="search-filters" action="index.php" method="get">
            <input type="hidden" name="action" value="search">

            <div class="form-group search-keyword">
                <label for="keyword">Skill name</label>
                <input type="search" id="keyword" name="keyword" maxlength="100"
                    placeholder="Example: Photoshop"
                    value="<?php echo htmlspecialchars($keyword); ?>">
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">All categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo (int) $category['category_id']; ?>"
                            <?php echo (string) $categoryId === (string) $category['category_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['category_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="experience_level">Experience level</label>
                <select id="experience_level" name="experience_level">
                    <option value="">All levels</option>
                    <?php foreach ($experienceLevels as $level): ?>
                        <option value="<?php echo $level; ?>"
                            <?php echo $experienceLevel === $level ? 'selected' : ''; ?>>
                            <?php echo $level; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" maxlength="100"
                    placeholder="Example: Colombo"
                    value="<?php echo htmlspecialchars($location); ?>">
            </div>

            <div class="form-group">
                <label for="max_price">Maximum hourly price (Rs.)</label>
                <input type="number" id="max_price" name="max_price" min="0"
                    max="99999999.99" step="0.01"
                    value="<?php echo htmlspecialchars($maxPrice); ?>">
            </div>

            <div class="search-actions">
                <button class="button" type="submit">Search</button>
                <a class="button button-secondary" href="index.php?action=search">Clear</a>
            </div>
        </form>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif (!$hasSearch): ?>
            <div class="empty-state search-state">
                <h2>Search for a skill</h2>
                <p>Enter a skill or choose one or more filters to find available teachers.</p>
            </div>
        <?php elseif (empty($teachers)): ?>
            <div class="empty-state search-state">
                <h2>No teachers found</h2>
                <p>Try changing or clearing some of your search filters.</p>
            </div>
        <?php else: ?>
            <p class="results-count">
                <?php echo count($teachers); ?> teaching option<?php echo count($teachers) === 1 ? '' : 's'; ?> found
            </p>
            <div class="teacher-grid">
                <?php foreach ($teachers as $teacher): ?>
                    <article class="teacher-card">
                        <div class="teacher-card-heading">
                            <div class="teacher-avatar" aria-hidden="true">
                                <?php echo htmlspecialchars(
                                    strtoupper(substr($teacher['first_name'], 0, 1)) .
                                    strtoupper(substr($teacher['last_name'], 0, 1))
                                ); ?>
                            </div>
                            <div>
                                <h2><?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?></h2>
                                <p><?php echo htmlspecialchars($teacher['location'] ? $teacher['location'] : 'Location not provided'); ?></p>
                            </div>
                        </div>
                        <div class="teacher-skill">
                            <strong><?php echo htmlspecialchars($teacher['skill_name']); ?></strong>
                            <span><?php echo htmlspecialchars($teacher['category_name']); ?></span>
                        </div>
                        <dl class="teacher-summary">
                            <div>
                                <dt>Experience</dt>
                                <dd><?php echo htmlspecialchars($teacher['experience_level']); ?></dd>
                            </div>
                            <div>
                                <dt>Hourly rate</dt>
                                <dd>Rs. <?php echo number_format($teacher['hourly_rate'], 2); ?></dd>
                            </div>
                        </dl>
                        <p class="teacher-description">
                            <?php echo nl2br(htmlspecialchars($teacher['description'])); ?>
                        </p>
                        <a class="button" href="index.php?action=teacher&amp;id=<?php echo (int) $teacher['user_id']; ?>">View Profile</a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
