<?php

require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../models/Dashboard.php';
require_once __DIR__ . '/../models/Notification.php';

function showDashboard()
{
    requireLogin();

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header('Location: index.php?action=admin-dashboard');
        exit;
    }

    $pageTitle = 'Dashboard';
    $counts = getDashboardCounts($_SESSION['user_id']);
    $recentNotifications = getRecentNotifications($_SESSION['user_id']);
    require __DIR__ . '/../views/dashboard.php';
}
