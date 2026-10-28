<?php require __DIR__ . '/partials/header.php'; ?>

<section class="hero">
    <div class="container">
        <p class="eyebrow">Community Skill Sharing Platform</p>
        <h1>Learn a skill. Share a skill.</h1>
        <p class="hero-text">
            SkillBridge connects learners with people in their community who are ready to teach.
        </p>
        <form class="home-search" action="index.php" method="get">
            <input type="hidden" name="action" value="search">
            <label class="visually-hidden" for="home-keyword">Search by skill name</label>
            <input type="search" id="home-keyword" name="keyword"
                maxlength="100" placeholder="What would you like to learn?">
            <button class="button" type="submit">Find Teachers</button>
        </form>
        <div class="hero-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="button" href="index.php?action=dashboard">Open dashboard</a>
            <?php else: ?>
                <a class="button" href="index.php?action=register">Create an account</a>
                <a class="button button-secondary" href="index.php?action=login">Log in</a>
            <?php endif; ?>
        </div>
        <div class="home-feature-grid">
            <article class="home-feature-card"><strong>Share what you know</strong><span>Create teaching listings with your experience and hourly rate.</span></article>
            <article class="home-feature-card"><strong>Find the right teacher</strong><span>Search by skill, category, location, experience, and price.</span></article>
            <article class="home-feature-card"><strong>Connect safely</strong><span>Contact details stay private until a learning request is accepted.</span></article>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
