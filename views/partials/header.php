<?php
global $unreadNotificationCount;

if (!isset($pageTitle)) {
    $pageTitle = 'SkillBridge';
}

$currentAction = getQueryValue('action');
if ($currentAction === '') {
    $currentAction = 'home';
}

if (!isset($unreadNotificationCount)) {
    $unreadNotificationCount = 0;
}

function navigationLinkClass($actions, $currentAction)
{
    return in_array($currentAction, $actions, true) ? 'nav-link active' : 'nav-link';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | SkillBridge</title>
    <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand" href="index.php">SkillBridge</a>
            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="main-navigation">
                <span class="visually-hidden">Toggle navigation</span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </button>
            <nav id="main-navigation" class="main-navigation" aria-label="Main navigation">
                <?php if (isset($_SESSION['user_id'], $_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <span class="nav-context">Administration</span>
                    <a class="<?php echo navigationLinkClass(array('admin-dashboard'), $currentAction); ?>" href="index.php?action=admin-dashboard">Dashboard</a>
                    <details class="nav-dropdown <?php echo in_array($currentAction, array('admin-users', 'admin-user-status', 'admin-categories', 'admin-category-create', 'admin-category-edit', 'admin-skills', 'admin-skill-create', 'admin-skill-edit'), true) ? 'active' : ''; ?>">
                        <summary>Manage</summary>
                        <div class="nav-dropdown-menu">
                            <a href="index.php?action=admin-users">Users</a>
                            <a href="index.php?action=admin-categories">Categories</a>
                            <a href="index.php?action=admin-skills">Skills</a>
                        </div>
                    </details>
                    <a class="<?php echo navigationLinkClass(array('admin-requests'), $currentAction); ?>" href="index.php?action=admin-requests">Requests</a>
                    <details class="nav-dropdown nav-user-menu">
                        <summary><?php echo htmlspecialchars($_SESSION['first_name']); ?></summary>
                        <div class="nav-dropdown-menu nav-dropdown-menu-right">
                            <a href="index.php?action=logout">Logout</a>
                        </div>
                    </details>
                <?php elseif (isset($_SESSION['user_id'])): ?>
                    <a class="<?php echo navigationLinkClass(array('home'), $currentAction); ?>" href="index.php">Home</a>
                    <a class="<?php echo navigationLinkClass(array('search', 'teacher', 'request-learning'), $currentAction); ?>" href="index.php?action=search">Find Teachers</a>
                    <a class="<?php echo navigationLinkClass(array('dashboard'), $currentAction); ?>" href="index.php?action=dashboard">Dashboard</a>
                    <details class="nav-dropdown <?php echo in_array($currentAction, array('requests-sent', 'requests-received'), true) ? 'active' : ''; ?>">
                        <summary>Requests</summary>
                        <div class="nav-dropdown-menu">
                            <a href="index.php?action=requests-sent">Requests Sent</a>
                            <a href="index.php?action=requests-received">Requests Received</a>
                        </div>
                    </details>
                    <details class="nav-dropdown nav-user-menu <?php echo in_array($currentAction, array('profile', 'edit-profile', 'teaching-skills', 'add-teaching-skill', 'edit-teaching-skill', 'notifications'), true) ? 'active' : ''; ?>">
                        <summary><?php echo htmlspecialchars($_SESSION['first_name']); ?></summary>
                        <div class="nav-dropdown-menu nav-dropdown-menu-right">
                            <a href="index.php?action=profile">My Profile</a>
                            <a href="index.php?action=teaching-skills">My Teaching Skills</a>
                            <a class="notification-nav-link" href="index.php?action=notifications">
                                Notifications
                                <?php if ($unreadNotificationCount > 0): ?>
                                    <span class="notification-count" aria-label="<?php echo (int) $unreadNotificationCount; ?> unread notifications"><?php echo (int) $unreadNotificationCount; ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="index.php?action=logout">Logout</a>
                        </div>
                    </details>
                <?php else: ?>
                    <a class="<?php echo navigationLinkClass(array('home'), $currentAction); ?>" href="index.php">Home</a>
                    <a class="<?php echo navigationLinkClass(array('search', 'teacher'), $currentAction); ?>" href="index.php?action=search">Find Teachers</a>
                    <a class="<?php echo navigationLinkClass(array('register'), $currentAction); ?>" href="index.php?action=register">Register</a>
                    <a class="<?php echo navigationLinkClass(array('login'), $currentAction); ?> nav-login" href="index.php?action=login">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main>
