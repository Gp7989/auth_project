<?php
// helpers/auth_helper.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Get current logged-in user ID
 */
function currentUserId(): ?int
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Redirect to login if not authenticated
 */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        header("Location: ../auth/login.php");
        exit();
    }
}
