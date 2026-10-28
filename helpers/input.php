<?php

function getPostValue($name)
{
    return isset($_POST[$name]) && is_string($_POST[$name]) ? $_POST[$name] : '';
}

function getQueryValue($name)
{
    return isset($_GET[$name]) && is_string($_GET[$name]) ? $_GET[$name] : '';
}
