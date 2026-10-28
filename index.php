<?php

ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
session_start();

require_once __DIR__ . '/helpers/input.php';

require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/ProfileController.php';
require_once __DIR__ . '/controllers/TeachingSkillController.php';
require_once __DIR__ . '/controllers/SearchController.php';
require_once __DIR__ . '/controllers/TeacherController.php';
require_once __DIR__ . '/controllers/RequestController.php';
require_once __DIR__ . '/controllers/NotificationController.php';
require_once __DIR__ . '/controllers/AdminController.php';

$action = getQueryValue('action');
if ($action === '') {
    $action = 'home';
}

$unreadNotificationCount = 0;
if ($action !== 'notifications' && isset($_SESSION['user_id'], $_SESSION['role']) && $_SESSION['role'] === 'user') {
    $unreadNotificationCount = getUnreadNotificationCount((int) $_SESSION['user_id']);
}

switch ($action) {
    case 'home':
        showHomePage();
        break;

    case 'register':
        register();
        break;

    case 'login':
        login();
        break;

    case 'logout':
        logout();
        break;

    case 'dashboard':
        showDashboard();
        break;

    case 'profile':
        showProfile();
        break;

    case 'edit-profile':
        editProfile();
        break;

    case 'teaching-skills':
        showTeachingSkills();
        break;

    case 'add-teaching-skill':
        addTeachingSkill();
        break;

    case 'edit-teaching-skill':
        editTeachingSkill();
        break;

    case 'delete-teaching-skill':
        deleteTeachingSkill();
        break;

    case 'search':
        showTeacherSearch();
        break;

    case 'teacher':
        showTeacherProfile();
        break;

    case 'request-learning':
        requestLearning();
        break;

    case 'requests-sent':
        showSentRequests();
        break;

    case 'requests-received':
        showReceivedRequests();
        break;

    case 'accept-request':
        changeRequestStatus('Accepted');
        break;

    case 'reject-request':
        changeRequestStatus('Rejected');
        break;

    case 'notifications':
        showNotifications();
        break;

    case 'admin-dashboard':
        showAdminDashboard();
        break;

    case 'admin-users':
        showAdminUsers();
        break;

    case 'admin-user-status':
        changeAdminUserStatus();
        break;

    case 'admin-categories':
        showAdminCategories();
        break;

    case 'admin-category-create':
        createAdminCategoryPage();
        break;

    case 'admin-category-edit':
        editAdminCategoryPage();
        break;

    case 'admin-category-delete':
        deleteAdminCategoryAction();
        break;

    case 'admin-skills':
        showAdminSkills();
        break;

    case 'admin-skill-create':
        createAdminSkillPage();
        break;

    case 'admin-skill-edit':
        editAdminSkillPage();
        break;

    case 'admin-skill-delete':
        deleteAdminSkillAction();
        break;

    case 'admin-requests':
        showAdminRequests();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/views/errors/404.php';
        break;
}
