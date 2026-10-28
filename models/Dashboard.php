<?php

require_once __DIR__ . '/../config/database.php';

function getDashboardCounts($userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT
            (SELECT COUNT(*) FROM teaching_skills WHERE user_id = ?) AS teaching_skill_count,
            (SELECT COUNT(*) FROM learning_requests WHERE learner_id = ?) AS sent_request_count,
            (SELECT COUNT(*) FROM learning_requests WHERE teacher_id = ?) AS received_request_count,
            (SELECT COUNT(*)
             FROM learning_requests
             WHERE status = \'Accepted\' AND (learner_id = ? OR teacher_id = ?)
            ) AS accepted_request_count'
    );
    $statement->bind_param('iiiii', $userId, $userId, $userId, $userId, $userId);
    $statement->execute();
    $counts = $statement->get_result()->fetch_assoc();

    $statement->close();
    $connection->close();

    return $counts;
}
