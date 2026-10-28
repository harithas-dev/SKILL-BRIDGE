<?php

function getDatabaseConnection()
{
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'skillbridge';

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
        die('Database connection failed: ' . $connection->connect_error);
    }

    if (!$connection->set_charset('utf8mb4')) {
        die('Unable to set the database character set.');
    }

    return $connection;
}
