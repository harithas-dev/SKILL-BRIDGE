<?php

require_once __DIR__ . '/../models/TeachingSkill.php';
require_once __DIR__ . '/../helpers/auth.php';

function showTeachingSkills()
{
    requireNormalUser();

    $pageTitle = 'My Teaching Skills';
    $teachingSkills = getTeachingSkillsByUser($_SESSION['user_id']);
    $successMessage = isset($_SESSION['teaching_skill_success'])
        ? $_SESSION['teaching_skill_success']
        : '';
    $errorMessage = isset($_SESSION['teaching_skill_error'])
        ? $_SESSION['teaching_skill_error']
        : '';
    unset($_SESSION['teaching_skill_success'], $_SESSION['teaching_skill_error']);

    require __DIR__ . '/../views/teaching_skills/index.php';
}

function addTeachingSkill()
{
    requireNormalUser();

    $pageTitle = 'Add Teaching Skill';
    $skills = getAllSkills();
    $errors = array();
    $skillId = '';
    $experienceLevel = '';
    $yearsExperience = '';
    $description = '';
    $hourlyRate = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $skillId = trim(getPostValue('skill_id'));
        $experienceLevel = trim(getPostValue('experience_level'));
        $yearsExperience = trim(getPostValue('years_experience'));
        $description = trim(getPostValue('description'));
        $hourlyRate = trim(getPostValue('hourly_rate'));

        $errors = validateTeachingSkill(
            $skillId,
            $experienceLevel,
            $yearsExperience,
            $description,
            $hourlyRate,
            $_SESSION['user_id']
        );

        if (empty($errors)) {
            $yearsValue = $yearsExperience === '' ? null : (int) $yearsExperience;

            if (createTeachingSkill(
                $_SESSION['user_id'],
                (int) $skillId,
                $experienceLevel,
                $yearsValue,
                $description,
                $hourlyRate
            )) {
                $_SESSION['teaching_skill_success'] = 'Teaching skill added successfully.';
                header('Location: index.php?action=teaching-skills');
                exit;
            }

            $errors[] = 'The teaching skill could not be added. Please try again.';
        }
    }

    require __DIR__ . '/../views/teaching_skills/create.php';
}

function editTeachingSkill()
{
    requireNormalUser();

    $teachingSkillId = getQueryValue('id');

    if (!isPositiveInteger($teachingSkillId)) {
        showTeachingSkillNotFound();
        return;
    }

    $teachingSkill = getTeachingSkillByIdForUser(
        (int) $teachingSkillId,
        $_SESSION['user_id']
    );

    if (!$teachingSkill) {
        showTeachingSkillNotFound();
        return;
    }

    $pageTitle = 'Edit Teaching Skill';
    $skills = getAllSkills();
    $errors = array();
    $skillId = (string) $teachingSkill['skill_id'];
    $experienceLevel = $teachingSkill['experience_level'];
    $yearsExperience = $teachingSkill['years_experience'] === null
        ? ''
        : (string) $teachingSkill['years_experience'];
    $description = $teachingSkill['description'];
    $hourlyRate = $teachingSkill['hourly_rate'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $skillId = trim(getPostValue('skill_id'));
        $experienceLevel = trim(getPostValue('experience_level'));
        $yearsExperience = trim(getPostValue('years_experience'));
        $description = trim(getPostValue('description'));
        $hourlyRate = trim(getPostValue('hourly_rate'));

        $errors = validateTeachingSkill(
            $skillId,
            $experienceLevel,
            $yearsExperience,
            $description,
            $hourlyRate,
            $_SESSION['user_id'],
            (int) $teachingSkillId
        );

        if (empty($errors)) {
            $yearsValue = $yearsExperience === '' ? null : (int) $yearsExperience;

            if (updateTeachingSkill(
                (int) $teachingSkillId,
                $_SESSION['user_id'],
                (int) $skillId,
                $experienceLevel,
                $yearsValue,
                $description,
                $hourlyRate
            )) {
                $_SESSION['teaching_skill_success'] = 'Teaching skill updated successfully.';
                header('Location: index.php?action=teaching-skills');
                exit;
            }

            $errors[] = 'The teaching skill could not be updated. Please try again.';
        }
    }

    require __DIR__ . '/../views/teaching_skills/edit.php';
}

function deleteTeachingSkill()
{
    requireNormalUser();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?action=teaching-skills');
        exit;
    }

    $teachingSkillId = getPostValue('teaching_skill_id');

    if (!isPositiveInteger($teachingSkillId)) {
        $_SESSION['teaching_skill_error'] = 'Invalid teaching skill.';
    } elseif (deleteTeachingSkillByOwner(
        (int) $teachingSkillId,
        $_SESSION['user_id']
    )) {
        $_SESSION['teaching_skill_success'] = 'Teaching skill deleted successfully.';
    } else {
        $_SESSION['teaching_skill_error'] = 'Teaching skill not found or you do not own it.';
    }

    header('Location: index.php?action=teaching-skills');
    exit;
}

function validateTeachingSkill(
    $skillId,
    $experienceLevel,
    $yearsExperience,
    $description,
    $hourlyRate,
    $userId,
    $excludedTeachingSkillId = null
) {
    $errors = array();
    $allowedExperienceLevels = array('Beginner', 'Intermediate', 'Advanced', 'Expert');

    if (!isPositiveInteger($skillId) || !skillExists((int) $skillId)) {
        $errors[] = 'Please select a valid skill.';
    }

    if (!in_array($experienceLevel, $allowedExperienceLevels, true)) {
        $errors[] = 'Please select a valid experience level.';
    }

    if ($yearsExperience !== '' &&
        (!ctype_digit($yearsExperience) || (float) $yearsExperience > 2147483647)) {
        $errors[] = 'Years of experience must be a valid non-negative whole number.';
    }

    if ($description === '') {
        $errors[] = 'Description is required.';
    } elseif (strlen($description) > 500) {
        $errors[] = 'Description must not exceed 500 characters.';
    }

    if ($hourlyRate === '' || !is_numeric($hourlyRate) || (float) $hourlyRate < 0) {
        $errors[] = 'Hourly rate must be a non-negative number.';
    } elseif ((float) $hourlyRate > 99999999.99) {
        $errors[] = 'Hourly rate is too large.';
    }

    if (empty($errors) && teachingSkillExistsForUser(
        $userId,
        (int) $skillId,
        $excludedTeachingSkillId
    )) {
        $errors[] = 'You have already listed this teaching skill.';
    }

    return $errors;
}

function isPositiveInteger($value)
{
    return filter_var($value, FILTER_VALIDATE_INT) !== false && (int) $value > 0;
}

function showTeachingSkillNotFound()
{
    http_response_code(404);
    $pageTitle = 'Teaching Skill Not Found';
    require __DIR__ . '/../views/errors/404.php';
}
