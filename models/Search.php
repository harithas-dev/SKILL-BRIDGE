<?php

require_once __DIR__ . '/../config/database.php';

function getSearchCategories()
{
    $connection = getDatabaseConnection();
    $result = $connection->query(
        'SELECT category_id, category_name
         FROM skill_categories
         ORDER BY category_name'
    );
    $categories = array();

    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    $connection->close();
    return $categories;
}

function searchTeachers($keyword, $categoryId, $experienceLevel, $location, $maxPrice)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT teaching_skills.teaching_skill_id,
                users.user_id,
                users.first_name,
                users.last_name,
                users.location,
                skills.skill_name,
                skill_categories.category_name,
                teaching_skills.experience_level,
                teaching_skills.description,
                teaching_skills.hourly_rate
         FROM teaching_skills
         INNER JOIN users ON teaching_skills.user_id = users.user_id
         INNER JOIN skills ON teaching_skills.skill_id = skills.skill_id
         INNER JOIN skill_categories ON skills.category_id = skill_categories.category_id
         WHERE users.account_status = \'active\'
           AND users.role = \'user\'
           AND (? = \'\' OR skills.skill_name LIKE CONCAT(\'%\', ?, \'%\'))
           AND (? = 0 OR skill_categories.category_id = ?)
           AND (? = \'\' OR teaching_skills.experience_level = ?)
           AND (? = \'\' OR users.location LIKE CONCAT(\'%\', ?, \'%\'))
           AND (? IS NULL OR teaching_skills.hourly_rate <= ?)
         ORDER BY skills.skill_name, users.first_name, users.last_name'
    );
    $statement->bind_param(
        'ssiissssdd',
        $keyword,
        $keyword,
        $categoryId,
        $categoryId,
        $experienceLevel,
        $experienceLevel,
        $location,
        $location,
        $maxPrice,
        $maxPrice
    );
    $statement->execute();
    $result = $statement->get_result();
    $teachers = array();

    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }

    $statement->close();
    $connection->close();

    return $teachers;
}
