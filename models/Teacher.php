<?php

require_once __DIR__ . '/../config/database.php';

function getActiveTeacherProfile($teacherId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT users.user_id, users.first_name, users.last_name,
                users.bio, users.location, users.profile_image
         FROM users
         WHERE users.user_id = ?
           AND users.account_status = \'active\'
           AND users.role = \'user\'
           AND EXISTS (
               SELECT teaching_skill_id
               FROM teaching_skills
               WHERE teaching_skills.user_id = users.user_id
           )'
    );
    $statement->bind_param('i', $teacherId);
    $statement->execute();
    $result = $statement->get_result();
    $teacher = $result->fetch_assoc();

    $statement->close();
    $connection->close();

    return $teacher ? $teacher : null;
}

function getActiveTeacherSkills($teacherId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT teaching_skills.teaching_skill_id,
                teaching_skills.experience_level,
                teaching_skills.years_experience,
                teaching_skills.description,
                teaching_skills.hourly_rate,
                skills.skill_name,
                skill_categories.category_name
         FROM teaching_skills
         INNER JOIN users ON teaching_skills.user_id = users.user_id
         INNER JOIN skills ON teaching_skills.skill_id = skills.skill_id
         INNER JOIN skill_categories ON skills.category_id = skill_categories.category_id
         WHERE teaching_skills.user_id = ?
           AND users.account_status = \'active\'
           AND users.role = \'user\'
         ORDER BY skills.skill_name'
    );
    $statement->bind_param('i', $teacherId);
    $statement->execute();
    $result = $statement->get_result();
    $teachingSkills = array();

    while ($row = $result->fetch_assoc()) {
        $teachingSkills[] = $row;
    }

    $statement->close();
    $connection->close();

    return $teachingSkills;
}
