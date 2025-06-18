<?php
session_start();

// Simple authentication functions
function isLoggedIn() {
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user_type'] === 'admin';
}

function isStudent() {
    return isLoggedIn() && $_SESSION['user_type'] === 'student';
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function redirectIfNotAdmin() {
    if (!isAdmin()) {
        header("Location: login.php");
        exit();
    }
}

function redirectIfNotStudent() {
    if (!isStudent()) {
        header("Location: login.php");
        exit();
    }
}

// Test user credentials (in a real app, use a database)
function authenticateUser($email, $password, $userType) {
    $validUsers = [
        'student' => [
            'email' => 'student@school.edu',
            'password' => 'student123'
        ],
        'admin' => [
            'email' => 'admin@school.edu',
            'password' => 'admin123'
        ]
    ];

    if ($email === $validUsers[$userType]['email'] && $password === $validUsers[$userType]['password']) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_type'] = $userType;
        return true;
    }
    return false;
}

// Add to includes/auth.php

function registerStudent($fullName, $email, $password) {
    // In a real application, you would:
    // 1. Validate inputs
    // 2. Check if email already exists
    // 3. Hash the password
    // 4. Save to database
    // 5. Return true on success or false on failure
    
    // For demo purposes, we'll just return true
    return true;
}

function emailExists($email) {
    // In a real app, check database if email exists
    return false;
}

?>