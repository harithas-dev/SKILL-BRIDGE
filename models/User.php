<?php

require_once __DIR__ . '/../config/database.php';

function findUserByEmail($email)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT user_id, first_name, last_name, email, password, role, account_status
         FROM users
         WHERE email = ?'
    );
    $statement->bind_param('s', $email);
    $statement->execute();

    $result = $statement->get_result();
    $user = $result->fetch_assoc();

    $statement->close();
    $connection->close();

    return $user ? $user : null;
}

function userEmailExists($email)
{
    return findUserByEmail($email) !== null;
}

function createUser($firstName, $lastName, $email, $hashedPassword)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'INSERT INTO users (first_name, last_name, email, password)
         VALUES (?, ?, ?, ?)'
    );
    $statement->bind_param('ssss', $firstName, $lastName, $email, $hashedPassword);
    $created = $statement->execute();

    $statement->close();
    $connection->close();

    return $created;
}

function findUserById($userId)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'SELECT user_id, first_name, last_name, email, phone, location, bio,
                profile_image, role, account_status, created_at
         FROM users
         WHERE user_id = ?'
    );
    $statement->bind_param('i', $userId);
    $statement->execute();

    $result = $statement->get_result();
    $user = $result->fetch_assoc();

    $statement->close();
    $connection->close();

    return $user ? $user : null;
}

function updateUserProfile($userId, $firstName, $lastName, $phone, $location, $bio)
{
    $connection = getDatabaseConnection();
    $statement = $connection->prepare(
        'UPDATE users
         SET first_name = ?, last_name = ?, phone = ?, location = ?, bio = ?
         WHERE user_id = ?'
    );
    $statement->bind_param(
        'sssssi',
        $firstName,
        $lastName,
        $phone,
        $location,
        $bio,
        $userId
    );
    $updated = $statement->execute();

    $statement->close();
    $connection->close();

    return $updated;
}
