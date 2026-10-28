<?php

require_once __DIR__ . '/../models/User.php';

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: index.php?action=login');
        exit;
    }

    $user = findUserById($_SESSION['user_id']);

    if (!$user || $user['account_status'] !== 'active') {
        $_SESSION = array();
        session_destroy();
        header('Location: index.php?action=login&disabled=1');
        exit;
    }

    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['role'] = $user['role'];
}

function redirectIfLoggedIn()
{
    if (isLoggedIn()) {
        header('Location: index.php?action=dashboard');
        exit;
    }
}

function requireNormalUser()
{
    requireLogin();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        header('Location: index.php?action=dashboard');
        exit;
    }
}

function requireAdmin()
{
    requireLogin();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php?action=dashboard');
        exit;
    }
}
