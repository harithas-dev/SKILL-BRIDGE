<?php

require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../helpers/auth.php';

function showAdminDashboard()
{
    requireAdmin();
    $pageTitle = 'Admin Dashboard';
    $counts = getAdminDashboardCounts();
    require __DIR__ . '/../views/admin/dashboard.php';
}

function showAdminUsers()
{
    requireAdmin();
    $pageTitle = 'Manage Users';
    $users = getAdminUsers();
    list($successMessage, $errorMessage) = getAdminMessages();
    require __DIR__ . '/../views/admin/users.php';
}

function changeAdminUserStatus()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirectToAdmin('admin-users');
    }

    $userId = getPostValue('user_id');
    $status = getPostValue('account_status');

    if (!isValidAdminId($userId) || !in_array($status, array('active', 'disabled'), true)) {
        setAdminError('Invalid user or account status.');
    } elseif ((int) $userId === (int) $_SESSION['user_id']) {
        setAdminError('You cannot change the status of your own account.');
    } elseif (setNormalUserStatus((int) $userId, $_SESSION['user_id'], $status)) {
        setAdminSuccess($status === 'active' ? 'User enabled successfully.' : 'User disabled successfully.');
    } else {
        setAdminError('The user status could not be changed. Only normal user accounts may be updated.');
    }

    redirectToAdmin('admin-users');
}

function showAdminCategories()
{
    requireAdmin();
    $pageTitle = 'Manage Categories';
    $categories = getAdminCategories();
    list($successMessage, $errorMessage) = getAdminMessages();
    require __DIR__ . '/../views/admin/categories/index.php';
}

function createAdminCategoryPage()
{
    requireAdmin();
    $pageTitle = 'Add Category';
    $categoryName = '';
    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryName = trim(getPostValue('category_name'));
        $errors = validateAdminCategory($categoryName);
        if (empty($errors)) {
            if (createAdminCategory($categoryName)) {
                setAdminSuccess('Category created successfully.');
                redirectToAdmin('admin-categories');
            }
            $errors[] = 'The category could not be created.';
        }
    }

    require __DIR__ . '/../views/admin/categories/create.php';
}

function editAdminCategoryPage()
{
    requireAdmin();
    $categoryId = getQueryValue('id');
    if (!isValidAdminId($categoryId) || !($category = findAdminCategory((int) $categoryId))) {
        setAdminError('Category not found.');
        redirectToAdmin('admin-categories');
    }

    $pageTitle = 'Edit Category';
    $categoryName = $category['category_name'];
    $errors = array();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryName = trim(getPostValue('category_name'));
        $errors = validateAdminCategory($categoryName, (int) $categoryId);
        if (empty($errors)) {
            if (updateAdminCategory((int) $categoryId, $categoryName)) {
                setAdminSuccess('Category updated successfully.');
                redirectToAdmin('admin-categories');
            }
            $errors[] = 'The category could not be updated.';
        }
    }

    require __DIR__ . '/../views/admin/categories/edit.php';
}

function deleteAdminCategoryAction()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirectToAdmin('admin-categories');
    }
    $categoryId = getPostValue('category_id');
    if (!isValidAdminId($categoryId)) {
        setAdminError('Invalid category.');
    } elseif (deleteUnusedAdminCategory((int) $categoryId)) {
        setAdminSuccess('Category deleted successfully.');
    } else {
        setAdminError('The category could not be deleted because it is in use or does not exist.');
    }
    redirectToAdmin('admin-categories');
}

function showAdminSkills()
{
    requireAdmin();
    $pageTitle = 'Manage Skills';
    $skills = getAdminSkills();
    list($successMessage, $errorMessage) = getAdminMessages();
    require __DIR__ . '/../views/admin/skills/index.php';
}

function createAdminSkillPage()
{
    requireAdmin();
    $pageTitle = 'Add Skill';
    $skillName = '';
    $categoryId = '';
    $categories = getAdminCategories();
    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $skillName = trim(getPostValue('skill_name'));
        $categoryId = getPostValue('category_id');
        $errors = validateAdminSkill($skillName, $categoryId);
        if (empty($errors)) {
            if (createAdminSkill($skillName, (int) $categoryId)) {
                setAdminSuccess('Skill created successfully.');
                redirectToAdmin('admin-skills');
            }
            $errors[] = 'The skill could not be created.';
        }
    }

    require __DIR__ . '/../views/admin/skills/create.php';
}

function editAdminSkillPage()
{
    requireAdmin();
    $skillId = getQueryValue('id');
    if (!isValidAdminId($skillId) || !($skill = findAdminSkill((int) $skillId))) {
        setAdminError('Skill not found.');
        redirectToAdmin('admin-skills');
    }

    $pageTitle = 'Edit Skill';
    $skillName = $skill['skill_name'];
    $categoryId = $skill['category_id'];
    $categories = getAdminCategories();
    $errors = array();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $skillName = trim(getPostValue('skill_name'));
        $categoryId = getPostValue('category_id');
        $errors = validateAdminSkill($skillName, $categoryId, (int) $skillId);
        if (empty($errors)) {
            if (updateAdminSkill((int) $skillId, $skillName, (int) $categoryId)) {
                setAdminSuccess('Skill updated successfully.');
                redirectToAdmin('admin-skills');
            }
            $errors[] = 'The skill could not be updated.';
        }
    }

    require __DIR__ . '/../views/admin/skills/edit.php';
}

function deleteAdminSkillAction()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirectToAdmin('admin-skills');
    }
    $skillId = getPostValue('skill_id');
    if (!isValidAdminId($skillId)) {
        setAdminError('Invalid skill.');
    } elseif (deleteUnusedAdminSkill((int) $skillId)) {
        setAdminSuccess('Skill deleted successfully.');
    } else {
        setAdminError('The skill could not be deleted because it is in use or does not exist.');
    }
    redirectToAdmin('admin-skills');
}

function showAdminRequests()
{
    requireAdmin();
    $pageTitle = 'Learning Requests';
    $requests = getAdminLearningRequests();
    require __DIR__ . '/../views/admin/requests.php';
}

function validateAdminCategory($name, $excludedId = null)
{
    $errors = array();
    if ($name === '') {
        $errors[] = 'Category name is required.';
    } elseif (strlen($name) > 100) {
        $errors[] = 'Category name must not exceed 100 characters.';
    } elseif (adminCategoryNameExists($name, $excludedId)) {
        $errors[] = 'A category with this name already exists.';
    }
    return $errors;
}

function validateAdminSkill($name, $categoryId, $excludedId = null)
{
    $errors = array();
    if ($name === '') {
        $errors[] = 'Skill name is required.';
    } elseif (strlen($name) > 100) {
        $errors[] = 'Skill name must not exceed 100 characters.';
    }
    if (!isValidAdminId($categoryId) || !adminCategoryExists((int) $categoryId)) {
        $errors[] = 'Please select a valid category.';
    } elseif ($name !== '' && strlen($name) <= 100 &&
        adminSkillNameExists($name, (int) $categoryId, $excludedId)) {
        $errors[] = 'This skill already exists in the selected category.';
    }
    return $errors;
}

function isValidAdminId($value)
{
    return filter_var($value, FILTER_VALIDATE_INT) !== false && (int) $value > 0;
}

function setAdminSuccess($message)
{
    $_SESSION['admin_success'] = $message;
}

function setAdminError($message)
{
    $_SESSION['admin_error'] = $message;
}

function getAdminMessages()
{
    $messages = array(
        isset($_SESSION['admin_success']) ? $_SESSION['admin_success'] : '',
        isset($_SESSION['admin_error']) ? $_SESSION['admin_error'] : ''
    );
    unset($_SESSION['admin_success'], $_SESSION['admin_error']);
    return $messages;
}

function redirectToAdmin($action)
{
    header('Location: index.php?action=' . $action);
    exit;
}
