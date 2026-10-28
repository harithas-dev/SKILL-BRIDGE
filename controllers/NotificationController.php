<?php

require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../helpers/auth.php';

function showNotifications()
{
    requireLogin();

    $pageTitle = 'Notifications';
    $notifications = getNotificationsByUser($_SESSION['user_id']);
    markAllNotificationsRead($_SESSION['user_id']);

    require __DIR__ . '/../views/notifications/index.php';
}
