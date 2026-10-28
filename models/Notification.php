<?php

require_once __DIR__ . '/../config/database.php';

function createNotification($userId, $message)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'INSERT INTO notifications (user_id, message) VALUES (?, ?)'
    );
    $statement->bind_param('is', $userId, $message);
    $created = $statement->execute();
    $statement->close();
    $connection->close();

    return $created;
}

function getRecentNotifications($userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT notification_id, message, is_read, created_at
         FROM notifications
         WHERE user_id = ?
         ORDER BY created_at DESC, notification_id DESC
         LIMIT 5'
    );
    $statement->bind_param('i', $userId);
    $statement->execute();
    $result = $statement->get_result();
    $notifications = array();

    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    $statement->close();
    $connection->close();

    return $notifications;
}

function getNotificationsByUser($userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT notification_id, message, is_read, created_at
         FROM notifications
         WHERE user_id = ?
         ORDER BY created_at DESC, notification_id DESC'
    );
    $statement->bind_param('i', $userId);
    $statement->execute();
    $result = $statement->get_result();
    $notifications = array();

    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    $statement->close();
    $connection->close();

    return $notifications;
}

function getUnreadNotificationCount($userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT COUNT(*) AS unread_count
         FROM notifications
         WHERE user_id = ? AND is_read = FALSE'
    );
    $statement->bind_param('i', $userId);
    $statement->execute();
    $result = $statement->get_result()->fetch_assoc();

    $statement->close();
    $connection->close();

    return (int) $result['unread_count'];
}

function markAllNotificationsRead($userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'UPDATE notifications SET is_read = TRUE WHERE user_id = ? AND is_read = FALSE'
    );
    $statement->bind_param('i', $userId);
    $updated = $statement->execute();

    $statement->close();
    $connection->close();

    return $updated;
}
