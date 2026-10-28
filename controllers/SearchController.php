<?php

require_once __DIR__ . '/../models/Search.php';

function showTeacherSearch()
{
    $pageTitle = 'Find Teachers';

    $categories = getSearchCategories();
    $experienceLevels = ['Beginner', 'Intermediate', 'Advanced', 'Expert'];

    $errors = [];
    $teachers = [];

    $keyword = trim(getQueryValue('keyword'));
    $categoryId = trim(getQueryValue('category_id'));
    $experienceLevel = trim(getQueryValue('experience_level'));
    $location = trim(getQueryValue('location'));
    $maxPrice = trim(getQueryValue('max_price'));

    $hasSearch =
        $keyword !== '' ||
        $categoryId !== '' ||
        $experienceLevel !== '' ||
        $location !== '' ||
        $maxPrice !== '';

    if (strlen($keyword) > 100) {
        $errors[] = 'Keyword must not exceed 100 characters.';
    }

    if (
        $categoryId !== '' &&
        (!ctype_digit($categoryId) || (int) $categoryId < 1)
    ) {
        $errors[] = 'Please select a valid category.';
    }

    if (
        $experienceLevel !== '' &&
        !in_array($experienceLevel, $experienceLevels, true)
    ) {
        $errors[] = 'Please select a valid experience level.';
    }

    if (strlen($location) > 100) {
        $errors[] = 'Location must not exceed 100 characters.';
    }

    if (
        $maxPrice !== '' &&
        (
            !is_numeric($maxPrice) ||
            (float) $maxPrice < 0 ||
            (float) $maxPrice > 99999999.99
        )
    ) {
        $errors[] = 'Maximum price must be a valid non-negative number.';
    }

    if ($hasSearch && empty($errors)) {
        $teachers = searchTeachers(
            $keyword,
            $categoryId === '' ? 0 : (int) $categoryId,
            $experienceLevel,
            $location,
            $maxPrice === '' ? null : (float) $maxPrice
        );
    }

    require __DIR__ . '/../views/search/index.php';
}