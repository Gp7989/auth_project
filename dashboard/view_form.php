<?php
require_once '../helpers/auth_helper.php';
requireLogin();

require_once '../helpers/permission_helper.php';
require_once '../database/db.php';

if (!hasPermission('view')) {
    die("Unauthorized");
}

$formId = intval($_GET['id']);
$userId = currentUserId();

$stmt = $conn->prepare("
    SELECT *
    FROM admissions
    WHERE id = ? AND user_id = ?
");
$stmt->bind_param("ii", $formId, $userId);
$stmt->execute();
$result = $stmt->get_result();

$form = $result->fetch_assoc();

if (!$form) {
    die("Form not found or access denied.");
}
?>
