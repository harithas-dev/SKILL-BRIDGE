<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/Notification.php';

function getRequestableTeachingSkill($teachingSkillId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT teaching_skills.teaching_skill_id,
                teaching_skills.user_id AS teacher_id,
                users.first_name,
                users.last_name,
                skills.skill_name,
                skill_categories.category_name
         FROM teaching_skills
         INNER JOIN users ON teaching_skills.user_id = users.user_id
         INNER JOIN skills ON teaching_skills.skill_id = skills.skill_id
         INNER JOIN skill_categories ON skills.category_id = skill_categories.category_id
         WHERE teaching_skills.teaching_skill_id = ?
           AND users.account_status = \'active\'
           AND users.role = \'user\''
    );
    $statement->bind_param('i', $teachingSkillId);
    $statement->execute();
    $result = $statement->get_result();
    $teachingSkill = $result->fetch_assoc();

    $statement->close();
    $connection->close();

    return $teachingSkill ? $teachingSkill : null;
}

function pendingLearningRequestExists($learnerId, $teachingSkillId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT request_id
         FROM learning_requests
         WHERE learner_id = ?
           AND teaching_skill_id = ?
           AND status = \'Pending\''
    );
    $statement->bind_param('ii', $learnerId, $teachingSkillId);
    $statement->execute();
    $result = $statement->get_result();
    $exists = $result->num_rows > 0;

    $statement->close();
    $connection->close();

    return $exists;
}

function createLearningRequest($learnerId, $teacherId, $teachingSkillId, $message)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'INSERT INTO learning_requests
            (learner_id, teacher_id, teaching_skill_id, message)
         VALUES (?, ?, ?, ?)'
    );
    $statement->bind_param(
        'iiis',
        $learnerId,
        $teacherId,
        $teachingSkillId,
        $message
    );
    $requestCreated = $statement->execute();
    $statement->close();
    $connection->close();

    if (!$requestCreated) {
        return false;
    }

    return createNotification(
        $teacherId,
        'You received a new learning request.'
    );
}

function getSentLearningRequests($learnerId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT learning_requests.request_id,
                learning_requests.message,
                learning_requests.status,
                learning_requests.request_date,
                users.first_name AS teacher_first_name,
                users.last_name AS teacher_last_name,
                CASE WHEN learning_requests.status = \'Accepted\'
                    THEN users.email ELSE NULL END AS teacher_email,
                CASE WHEN learning_requests.status = \'Accepted\'
                    THEN users.phone ELSE NULL END AS teacher_phone,
                skills.skill_name
         FROM learning_requests
         INNER JOIN users ON learning_requests.teacher_id = users.user_id
         INNER JOIN teaching_skills
             ON learning_requests.teaching_skill_id = teaching_skills.teaching_skill_id
         INNER JOIN skills ON teaching_skills.skill_id = skills.skill_id
         WHERE learning_requests.learner_id = ?
         ORDER BY learning_requests.request_date DESC, learning_requests.request_id DESC'
    );
    $statement->bind_param('i', $learnerId);
    $statement->execute();
    $result = $statement->get_result();
    $requests = array();

    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }

    $statement->close();
    $connection->close();

    return $requests;
}

function getReceivedLearningRequests($teacherId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT learning_requests.request_id,
                learning_requests.message,
                learning_requests.status,
                learning_requests.request_date,
                learning_requests.accepted_date,
                users.first_name AS learner_first_name,
                users.last_name AS learner_last_name,
                CASE WHEN learning_requests.status = \'Accepted\'
                    THEN users.email ELSE NULL END AS learner_email,
                CASE WHEN learning_requests.status = \'Accepted\'
                    THEN users.phone ELSE NULL END AS learner_phone,
                skills.skill_name
         FROM learning_requests
         INNER JOIN users ON learning_requests.learner_id = users.user_id
         INNER JOIN teaching_skills
             ON learning_requests.teaching_skill_id = teaching_skills.teaching_skill_id
         INNER JOIN skills ON teaching_skills.skill_id = skills.skill_id
         WHERE learning_requests.teacher_id = ?
         ORDER BY learning_requests.request_date DESC, learning_requests.request_id DESC'
    );
    $statement->bind_param('i', $teacherId);
    $statement->execute();
    $result = $statement->get_result();
    $requests = array();

    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }

    $statement->close();
    $connection->close();

    return $requests;
}

function updateLearningRequestStatus($requestId, $teacherId, $newStatus)
{
    $connection = getDatabaseConnection();
    $selectStatement = $connection->prepare(
        'SELECT learner_id
         FROM learning_requests
         WHERE request_id = ? AND teacher_id = ? AND status = \'Pending\''
    );
    $selectStatement->bind_param('ii', $requestId, $teacherId);
    $selectStatement->execute();
    $request = $selectStatement->get_result()->fetch_assoc();
    $selectStatement->close();

    if (!$request) {
        $connection->close();
        return false;
    }

    $updateStatement = $connection->prepare(
        'UPDATE learning_requests
         SET status = ?,
             accepted_date = CASE WHEN ? = \'Accepted\' THEN CURRENT_TIMESTAMP ELSE NULL END
         WHERE request_id = ? AND teacher_id = ? AND status = \'Pending\''
    );
    $updateStatement->bind_param(
        'ssii',
        $newStatus,
        $newStatus,
        $requestId,
        $teacherId
    );
    $updateStatement->execute();
    $updated = $updateStatement->affected_rows === 1;
    $updateStatement->close();
    $connection->close();

    if (!$updated) {
        return false;
    }

    $notificationMessage = $newStatus === 'Accepted'
        ? 'Your learning request was accepted.'
        : 'Your learning request was rejected.';

    return createNotification(
        $request['learner_id'],
        $notificationMessage
    );
}
