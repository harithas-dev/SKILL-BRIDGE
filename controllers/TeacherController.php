<?php

require_once __DIR__ . '/../models/Teacher.php';

function showTeacherProfile()
{
    $teacherId = getQueryValue('id');

    if (!isValidTeacherId($teacherId)) {
        showTeacherNotFound();
        return;
    }

    $teacher = getActiveTeacherProfile((int) $teacherId);

    if (!$teacher) {
        showTeacherNotFound();
        return;
    }

    $teachingSkills = getActiveTeacherSkills((int) $teacherId);
    $pageTitle = $teacher['first_name'] . ' ' . $teacher['last_name'];

    require __DIR__ . '/../views/teachers/profile.php';
}

function isValidTeacherId($teacherId)
{
    return filter_var($teacherId, FILTER_VALIDATE_INT) !== false && (int) $teacherId > 0;
}

function showTeacherNotFound()
{
    http_response_code(404);
    $pageTitle = 'Teacher Not Found';
    require __DIR__ . '/../views/errors/404.php';
}
