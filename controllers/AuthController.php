<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/auth.php';

function register()
{
    redirectIfLoggedIn();

    $pageTitle = 'Register';
    $errors = array();
    $firstName = '';
    $lastName = '';
    $email = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = trim(getPostValue('first_name'));
        $lastName = trim(getPostValue('last_name'));
        $email = strtolower(trim(getPostValue('email')));
        $password = getPostValue('password');
        $confirmPassword = getPostValue('confirm_password');

        if ($firstName === '' || $lastName === '' || $email === '' ||
            $password === '' || $confirmPassword === '') {
            $errors[] = 'All fields are required.';
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (strlen($firstName) > 50 || strlen($lastName) > 50) {
            $errors[] = 'First name and last name must not exceed 50 characters.';
        }

        if (strlen($email) > 100) {
            $errors[] = 'Email address must not exceed 100 characters.';
        }

        if ($password !== '' && strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Password confirmation does not match.';
        }

        if (empty($errors) && userEmailExists($email)) {
            $errors[] = 'An account with this email address already exists.';
        }

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if (createUser($firstName, $lastName, $email, $hashedPassword)) {
                $_SESSION['success_message'] = 'Registration successful. You can now log in.';
                header('Location: index.php?action=login');
                exit;
            }

            $errors[] = 'Registration could not be completed. Please try again.';
        }
    }

    require __DIR__ . '/../views/auth/register.php';
}

function login()
{
    redirectIfLoggedIn();

    $pageTitle = 'Login';
    $errors = array();
    $email = '';
    $successMessage = isset($_SESSION['success_message'])
        ? $_SESSION['success_message']
        : '';
    unset($_SESSION['success_message']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = strtolower(trim(getPostValue('email')));
        $password = getPostValue('password');

        if ($email === '' || $password === '') {
            $errors[] = 'Email and password are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        } else {
            $user = findUserByEmail($email);

            if (!$user || !password_verify($password, $user['password'])) {
                $errors[] = 'Invalid email or password.';
            } elseif ($user['account_status'] === 'disabled') {
                $errors[] = 'This account has been disabled.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['role'] = $user['role'];

                header('Location: index.php?action=dashboard');
                exit;
            }
        }
    }

    require __DIR__ . '/../views/auth/login.php';
}

function logout()
{
    $_SESSION = array();

    if (ini_get('session.use_cookies')) {
        $cookieParameters = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $cookieParameters['path'],
            $cookieParameters['domain'],
            $cookieParameters['secure'],
            $cookieParameters['httponly']
        );
    }

    session_destroy();
    header('Location: index.php?action=login&logged_out=1');
    exit;
}
