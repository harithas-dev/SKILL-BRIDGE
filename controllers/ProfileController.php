<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/auth.php';

function showProfile()
{
    requireLogin();

    $user = findUserById($_SESSION['user_id']);

    if (!$user) {
        clearInvalidUserSession();
    }

    $pageTitle = 'My Profile';
    $successMessage = isset($_SESSION['profile_success_message'])
        ? $_SESSION['profile_success_message']
        : '';
    unset($_SESSION['profile_success_message']);

    require __DIR__ . '/../views/profile/view.php';
}

function editProfile()
{
    requireLogin();

    $user = findUserById($_SESSION['user_id']);

    if (!$user) {
        clearInvalidUserSession();
    }

    $pageTitle = 'Edit Profile';
    $errors = array();
    $firstName = $user['first_name'];
    $lastName = $user['last_name'];
    $phone = $user['phone'] ? $user['phone'] : '';
    $location = $user['location'] ? $user['location'] : '';
    $bio = $user['bio'] ? $user['bio'] : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = trim(getPostValue('first_name'));
        $lastName = trim(getPostValue('last_name'));
        $phone = trim(getPostValue('phone'));
        $location = trim(getPostValue('location'));
        $bio = trim(getPostValue('bio'));

        if ($firstName === '' || $lastName === '') {
            $errors[] = 'First name and last name are required.';
        }

        if (strlen($firstName) > 50 || strlen($lastName) > 50) {
            $errors[] = 'First name and last name must not exceed 50 characters.';
        }

        if (strlen($phone) > 20) {
            $errors[] = 'Phone number must not exceed 20 characters.';
        }

        if (strlen($location) > 100) {
            $errors[] = 'Location must not exceed 100 characters.';
        }

        if (strlen($bio) > 500) {
            $errors[] = 'Bio must not exceed 500 characters.';
        }

        if (empty($errors)) {
            if (updateUserProfile(
                $_SESSION['user_id'],
                $firstName,
                $lastName,
                $phone,
                $location,
                $bio
            )) {
                $_SESSION['first_name'] = $firstName;
                $_SESSION['profile_success_message'] = 'Your profile has been updated.';
                header('Location: index.php?action=profile');
                exit;
            }

            $errors[] = 'Your profile could not be updated. Please try again.';
        }
    }

    require __DIR__ . '/../views/profile/edit.php';
}

function clearInvalidUserSession()
{
    $_SESSION = array();
    session_destroy();
    header('Location: index.php?action=login');
    exit;
}
