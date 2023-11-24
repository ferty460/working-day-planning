<?php

require_once __DIR__. '/db/boot.php';

$taskId = $_POST['task_id'];
$folderId = $_POST['folder_id'];

$stmt = pdo()->prepare("UPDATE `tasks` SET folder = :folder WHERE id = :id");
$stmt->execute([
    'folder' => $folderId,
    'id' => $taskId,
]);

header("Location: {$_SERVER['HTTP_REFERER']}");