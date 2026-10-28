<?php

require_once __DIR__ . '/../models/LearningRequest.php';
require_once __DIR__ . '/../helpers/auth.php';

function requestLearning()
{
    requireNormalUser();

    $teachingSkillId = getQueryValue('teaching_skill_id');

    if (!isValidRequestTeachingSkillId($teachingSkillId)) {
        showRequestTargetNotFound();
        return;
    }

    $teachingSkill = getRequestableTeachingSkill((int) $teachingSkillId);

    if (!$teachingSkill) {
        showRequestTargetNotFound();
        return;
    }

    $pageTitle = 'Request to Learn';
    $errors = array();
    $message = '';
    $isOwnTeachingSkill = (int) $teachingSkill['teacher_id'] === (int) $_SESSION['user_id'];

    if ($isOwnTeachingSkill) {
        $errors[] = 'You cannot request to learn your own teaching skill.';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$isOwnTeachingSkill) {
        $message = trim(getPostValue('message'));

        if ($message === '') {
            $errors[] = 'Message is required.';
        } elseif (strlen($message) > 500) {
            $errors[] = 'Message must not exceed 500 characters.';
        }

        if (empty($errors) && pendingLearningRequestExists(
            $_SESSION['user_id'],
            (int) $teachingSkillId
        )) {
            $errors[] = 'You already have a pending request for this teaching skill.';
        }

        if (empty($errors)) {
            if (createLearningRequest(
                $_SESSION['user_id'],
                $teachingSkill['teacher_id'],
                (int) $teachingSkillId,
                $message
            )) {
                $_SESSION['request_success_message'] = 'Learning request sent successfully.';
                header('Location: index.php?action=requests-sent');
                exit;
            }

            $errors[] = 'The learning request could not be sent. Please try again.';
        }
    }

    require __DIR__ . '/../views/requests/create.php';
}

function showSentRequests()
{
    requireNormalUser();

    $pageTitle = 'Requests Sent';
    $requests = getSentLearningRequests($_SESSION['user_id']);
    $successMessage = isset($_SESSION['request_success_message'])
        ? $_SESSION['request_success_message']
        : '';
    unset($_SESSION['request_success_message']);

    require __DIR__ . '/../views/requests/sent.php';
}

function showReceivedRequests()
{
    requireNormalUser();

    $pageTitle = 'Requests Received';
    $requests = getReceivedLearningRequests($_SESSION['user_id']);
    $successMessage = isset($_SESSION['request_status_success'])
        ? $_SESSION['request_status_success']
        : '';
    $errorMessage = isset($_SESSION['request_status_error'])
        ? $_SESSION['request_status_error']
        : '';
    unset($_SESSION['request_status_success'], $_SESSION['request_status_error']);

    require __DIR__ . '/../views/requests/received.php';
}

function changeRequestStatus($newStatus)
{
    requireNormalUser();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?action=requests-received');
        exit;
    }

    $requestId = getPostValue('request_id');
    $allowedStatuses = array('Accepted', 'Rejected');

    if (!in_array($newStatus, $allowedStatuses, true) || !isValidRequestId($requestId)) {
        $_SESSION['request_status_error'] = 'The request could not be updated.';
        header('Location: index.php?action=requests-received');
        exit;
    }

    if (updateLearningRequestStatus((int) $requestId, $_SESSION['user_id'], $newStatus)) {
        $_SESSION['request_status_success'] = 'Learning request ' . strtolower($newStatus) . '.';
    } else {
        $_SESSION['request_status_error'] =
            'The request could not be updated. It may not belong to you or is no longer pending.';
    }

    header('Location: index.php?action=requests-received');
    exit;
}

function isValidRequestTeachingSkillId($teachingSkillId)
{
    return filter_var($teachingSkillId, FILTER_VALIDATE_INT) !== false &&
        (int) $teachingSkillId > 0;
}

function isValidRequestId($requestId)
{
    return filter_var($requestId, FILTER_VALIDATE_INT) !== false &&
        (int) $requestId > 0;
}

function showRequestTargetNotFound()
{
    http_response_code(404);
    $pageTitle = 'Teaching Skill Not Found';
    require __DIR__ . '/../views/errors/404.php';
}
