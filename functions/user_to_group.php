<?php

require_once __DIR__. '/db/boot.php';

$groupId = $_POST['group_id'];
$userId = $_POST['user_id'];

$stmt = pdo()->prepare("REPLACE INTO users_groups (user_id, group_id) VALUES (:user_id, :group_id);");
$stmt->execute([
    'user_id' => $userId,
    'group_id' => $groupId,
]);

header("Location: {$_SERVER['HTTP_REFERER']}");