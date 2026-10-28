<?php

require_once __DIR__ . '/../config/database.php';

function getAllSkills()
{
    $connection = getDatabaseConnection();
    $query = 'SELECT skills.skill_id, skills.skill_name,
                     skill_categories.category_name
              FROM skills
              INNER JOIN skill_categories
                  ON skills.category_id = skill_categories.category_id
              ORDER BY skill_categories.category_name, skills.skill_name';
    $result = $connection->query($query);
    $skills = array();

    while ($row = $result->fetch_assoc()) {
        $skills[] = $row;
    }

    $connection->close();
    return $skills;
}

function skillExists($skillId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare('SELECT skill_id FROM skills WHERE skill_id = ?');
    $statement->bind_param('i', $skillId);
    $statement->execute();
    $result = $statement->get_result();
    $exists = $result->num_rows === 1;

    $statement->close();
    $connection->close();

    return $exists;
}

function getTeachingSkillsByUser($userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT teaching_skills.teaching_skill_id,
                teaching_skills.skill_id,
                teaching_skills.experience_level,
                teaching_skills.years_experience,
                teaching_skills.description,
                teaching_skills.hourly_rate,
                teaching_skills.created_at,
                skills.skill_name,
                skill_categories.category_name
         FROM teaching_skills
         INNER JOIN skills ON teaching_skills.skill_id = skills.skill_id
         INNER JOIN skill_categories ON skills.category_id = skill_categories.category_id
         WHERE teaching_skills.user_id = ?
         ORDER BY teaching_skills.created_at DESC'
    );
    $statement->bind_param('i', $userId);
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

function getTeachingSkillByIdForUser($teachingSkillId, $userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT teaching_skill_id, user_id, skill_id, experience_level,
                years_experience, description, hourly_rate
         FROM teaching_skills
         WHERE teaching_skill_id = ? AND user_id = ?'
    );
    $statement->bind_param('ii', $teachingSkillId, $userId);
    $statement->execute();
    $result = $statement->get_result();
    $teachingSkill = $result->fetch_assoc();

    $statement->close();
    $connection->close();

    return $teachingSkill ? $teachingSkill : null;
}

function teachingSkillExistsForUser($userId, $skillId, $excludedTeachingSkillId = null)
{
    $connection = getDatabaseConnection();

    if ($excludedTeachingSkillId === null) {
        $statement = $connection->prepare(
            'SELECT teaching_skill_id
             FROM teaching_skills
             WHERE user_id = ? AND skill_id = ?'
        );
        $statement->bind_param('ii', $userId, $skillId);
    } else {
        $statement = $connection->prepare(
            'SELECT teaching_skill_id
             FROM teaching_skills
             WHERE user_id = ? AND skill_id = ? AND teaching_skill_id != ?'
        );
        $statement->bind_param('iii', $userId, $skillId, $excludedTeachingSkillId);
    }

    $statement->execute();
    $result = $statement->get_result();
    $exists = $result->num_rows > 0;

    $statement->close();
    $connection->close();

    return $exists;
}

function createTeachingSkill(
    $userId,
    $skillId,
    $experienceLevel,
    $yearsExperience,
    $description,
    $hourlyRate
) {
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'INSERT INTO teaching_skills
            (user_id, skill_id, experience_level, years_experience, description, hourly_rate)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $statement->bind_param(
    'iisisd',
    $userId,
    $skillId,
    $experienceLevel,
    $yearsExperience,
    $description,
    $hourlyRate
);
    $created = $statement->execute();

    $statement->close();
    $connection->close();

    return $created;
}

function updateTeachingSkill(
    $teachingSkillId,
    $userId,
    $skillId,
    $experienceLevel,
    $yearsExperience,
    $description,
    $hourlyRate
) {
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'UPDATE teaching_skills
         SET skill_id = ?, experience_level = ?, years_experience = ?,
             description = ?, hourly_rate = ?
         WHERE teaching_skill_id = ? AND user_id = ?'
    );
    $statement->bind_param(
        'isisdii',
        $skillId,
        $experienceLevel,
        $yearsExperience,
        $description,
        $hourlyRate,
        $teachingSkillId,
        $userId
    );
    $statement->execute();
    $updated = $statement->affected_rows >= 0;

    $statement->close();
    $connection->close();

    return $updated;
}

function deleteTeachingSkillByOwner($teachingSkillId, $userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'DELETE FROM teaching_skills WHERE teaching_skill_id = ? AND user_id = ?'
    );
    $statement->bind_param('ii', $teachingSkillId, $userId);
    $statement->execute();
    $deleted = $statement->affected_rows === 1;

    $statement->close();
    $connection->close();

    return $deleted;
}
