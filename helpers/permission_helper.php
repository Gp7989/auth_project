<?php
// helpers/permission_helper.php
require_once __DIR__ . '/auth_helper.php';
require_once __DIR__ . '/../database/db.php';


/**
 * Get all permissions for a user
 */
function getUserPermissions(int $userId): array
{
    global $conn;

    $permissions = [];

    // 1️⃣ Permissions via role
    $stmt = $conn->prepare("
        SELECT DISTINCT p.permission_name
        FROM permissions p
        JOIN role_permissions rp ON rp.permission_id = p.id
        JOIN user_roles ur ON ur.role_id = rp.role_id
        WHERE ur.user_id = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $permissions[] = $row['permission_name'];
    }

    // 2️⃣ Extra permissions given directly to user
    $stmt = $conn->prepare("
        SELECT p.permission_name
        FROM permissions p
        JOIN user_permissions up ON up.permission_id = p.id
        WHERE up.user_id = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $permissions[] = $row['permission_name'];
    }

    return array_unique($permissions);
}


/**
 * Check if user has specific permission
 */
function hasPermission(string $permission): bool
{
    $userId = currentUserId();
    if (!$userId) {
        return false;
    }

    $permissions = getUserPermissions($userId);
    return in_array($permission, $permissions);
}

/**
 * Check if user is Admin
 */
function isAdmin(): bool
{
    global $conn;

    $userId = currentUserId();
    if (!$userId) {
        return false;
    }

    $stmt = $conn->prepare("
        SELECT r.role_name
        FROM roles r
        JOIN user_roles ur ON ur.role_id = r.id
        WHERE ur.user_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $role = $result->fetch_assoc();
    return $role && $role['role_name'] === 'Admin';
}
