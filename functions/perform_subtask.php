<?php

require_once __DIR__. '/db/boot.php';

$subtaskId = $_POST['subtask_id'];

$stmt = pdo()->prepare("UPDATE `subtasks` SET is_completed = :is_completed, date_completed = :date_completed WHERE id = :id");
$stmt->execute([
    'is_completed' => true,
    'date_completed' => date("Y-m-d"),
    'id' => $subtaskId,
]);

header("Location: {$_SERVER['HTTP_REFERER']}");