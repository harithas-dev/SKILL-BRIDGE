<?php

require_once __DIR__ . '/../config/database.php';

function getAdminDashboardCounts()
{
    $connection = getDatabaseConnection();
    $result = $connection->query(
        'SELECT
            (SELECT COUNT(*) FROM users) AS total_users,
            (SELECT COUNT(DISTINCT teaching_skills.user_id)
             FROM teaching_skills
             INNER JOIN users ON teaching_skills.user_id = users.user_id
             WHERE users.role = \'user\' AND users.account_status = \'active\') AS total_teachers,
            (SELECT COUNT(*) FROM teaching_skills) AS total_teaching_skills,
            (SELECT COUNT(*) FROM learning_requests) AS total_requests,
            (SELECT COUNT(*) FROM learning_requests WHERE status = \'Pending\') AS pending_requests,
            (SELECT COUNT(*) FROM learning_requests WHERE status = \'Accepted\') AS accepted_requests'
    );
    $counts = $result->fetch_assoc();
    $connection->close();
    return $counts;
}

function getAdminUsers()
{
    $connection = getDatabaseConnection();
    $result = $connection->query(
        'SELECT user_id, first_name, last_name, email, location, role, account_status, created_at
         FROM users ORDER BY created_at DESC, user_id DESC'
    );
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $connection->close();
    return $users;
}

function setNormalUserStatus($userId, $currentAdminId, $status)
{
    if (!in_array($status, array('active', 'disabled'), true)) {
        return false;
    }

    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'UPDATE users SET account_status = ?
         WHERE user_id = ? AND user_id != ? AND role = \'user\''
    );
    $statement->bind_param('sii', $status, $userId, $currentAdminId);
    $statement->execute();
    $updated = $statement->affected_rows === 1;
    $statement->close();
    $connection->close();
    return $updated;
}

function getAdminCategories()
{
    $connection = getDatabaseConnection();
    $result = $connection->query(
        'SELECT skill_categories.category_id, skill_categories.category_name,
                COUNT(skills.skill_id) AS skill_count
         FROM skill_categories
         LEFT JOIN skills ON skill_categories.category_id = skills.category_id
         GROUP BY skill_categories.category_id, skill_categories.category_name
         ORDER BY skill_categories.category_name'
    );
    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    $connection->close();
    return $categories;
}

function findAdminCategory($categoryId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT category_id, category_name FROM skill_categories WHERE category_id = ?'
    );
    $statement->bind_param('i', $categoryId);
    $statement->execute();
    $category = $statement->get_result()->fetch_assoc();
    $statement->close();
    $connection->close();
    return $category ? $category : null;
}

function adminCategoryNameExists($name, $excludedId = null)
{
    $connection = getDatabaseConnection();
    if ($excludedId === null) {
        $statement = $connection->prepare(
            'SELECT category_id FROM skill_categories WHERE category_name = ?'
        );
        $statement->bind_param('s', $name);
    } else {
        $statement = $connection->prepare(
            'SELECT category_id FROM skill_categories WHERE category_name = ? AND category_id != ?'
        );
        $statement->bind_param('si', $name, $excludedId);
    }
    $statement->execute();
    $exists = $statement->get_result()->num_rows > 0;
    $statement->close();
    $connection->close();
    return $exists;
}

function createAdminCategory($name)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare('INSERT INTO skill_categories (category_name) VALUES (?)');
    $statement->bind_param('s', $name);
    $created = $statement->execute();
    $statement->close();
    $connection->close();
    return $created;
}

function updateAdminCategory($categoryId, $name)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'UPDATE skill_categories SET category_name = ? WHERE category_id = ?'
    );
    $statement->bind_param('si', $name, $categoryId);
    $updated = $statement->execute();
    $statement->close();
    $connection->close();
    return $updated;
}

function deleteUnusedAdminCategory($categoryId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'DELETE FROM skill_categories
         WHERE category_id = ?
           AND NOT EXISTS (SELECT 1 FROM skills WHERE category_id = ?)'
    );
    $statement->bind_param('ii', $categoryId, $categoryId);
    $statement->execute();
    $deleted = $statement->affected_rows === 1;
    $statement->close();
    $connection->close();
    return $deleted;
}

function getAdminSkills()
{
    $connection = getDatabaseConnection();
    $result = $connection->query(
        'SELECT skills.skill_id, skills.skill_name, skills.category_id,
                skill_categories.category_name,
                COUNT(teaching_skills.teaching_skill_id) AS teaching_count
         FROM skills
         INNER JOIN skill_categories ON skills.category_id = skill_categories.category_id
         LEFT JOIN teaching_skills ON skills.skill_id = teaching_skills.skill_id
         GROUP BY skills.skill_id, skills.skill_name, skills.category_id,
                  skill_categories.category_name
         ORDER BY skill_categories.category_name, skills.skill_name'
    );
    $skills = array();
    while ($row = $result->fetch_assoc()) {
        $skills[] = $row;
    }
    $connection->close();
    return $skills;
}

function findAdminSkill($skillId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT skill_id, skill_name, category_id FROM skills WHERE skill_id = ?'
    );
    $statement->bind_param('i', $skillId);
    $statement->execute();
    $skill = $statement->get_result()->fetch_assoc();
    $statement->close();
    $connection->close();
    return $skill ? $skill : null;
}

function adminCategoryExists($categoryId)
{
    return findAdminCategory($categoryId) !== null;
}

function adminSkillNameExists($name, $categoryId, $excludedId = null)
{
    $connection = getDatabaseConnection();
    if ($excludedId === null) {
        $statement = $connection->prepare(
            'SELECT skill_id FROM skills WHERE skill_name = ? AND category_id = ?'
        );
        $statement->bind_param('si', $name, $categoryId);
    } else {
        $statement = $connection->prepare(
            'SELECT skill_id FROM skills
             WHERE skill_name = ? AND category_id = ? AND skill_id != ?'
        );
        $statement->bind_param('sii', $name, $categoryId, $excludedId);
    }
    $statement->execute();
    $exists = $statement->get_result()->num_rows > 0;
    $statement->close();
    $connection->close();
    return $exists;
}

function createAdminSkill($name, $categoryId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'INSERT INTO skills (skill_name, category_id) VALUES (?, ?)'
    );
    $statement->bind_param('si', $name, $categoryId);
    $created = $statement->execute();
    $statement->close();
    $connection->close();
    return $created;
}

function updateAdminSkill($skillId, $name, $categoryId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'UPDATE skills SET skill_name = ?, category_id = ? WHERE skill_id = ?'
    );
    $statement->bind_param('sii', $name, $categoryId, $skillId);
    $updated = $statement->execute();
    $statement->close();
    $connection->close();
    return $updated;
}

function deleteUnusedAdminSkill($skillId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'DELETE FROM skills
         WHERE skill_id = ?
           AND NOT EXISTS (SELECT 1 FROM teaching_skills WHERE skill_id = ?)'
    );
    $statement->bind_param('ii', $skillId, $skillId);
    $statement->execute();
    $deleted = $statement->affected_rows === 1;
    $statement->close();
    $connection->close();
    return $deleted;
}

function getAdminLearningRequests()
{
    $connection = getDatabaseConnection();
    $result = $connection->query(
        'SELECT learning_requests.request_id, learning_requests.status,
                learning_requests.request_date, learning_requests.accepted_date,
                learner.first_name AS learner_first_name,
                learner.last_name AS learner_last_name,
                teacher.first_name AS teacher_first_name,
                teacher.last_name AS teacher_last_name,
                skills.skill_name
         FROM learning_requests
         INNER JOIN users AS learner ON learning_requests.learner_id = learner.user_id
         INNER JOIN users AS teacher ON learning_requests.teacher_id = teacher.user_id
         INNER JOIN teaching_skills
             ON learning_requests.teaching_skill_id = teaching_skills.teaching_skill_id
         INNER JOIN skills ON teaching_skills.skill_id = skills.skill_id
         ORDER BY learning_requests.request_date DESC, learning_requests.request_id DESC'
    );
    $requests = array();
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
    $connection->close();
    return $requests;
}
