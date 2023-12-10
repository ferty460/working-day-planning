<?php

require_once __DIR__. '/db/boot.php';

$taskId = $_POST['task_id'];
$address = $_POST['role'];

$stmt = pdo()->prepare("UPDATE `tasks` SET status = :status WHERE id = :id");
$stmt->execute([
    'status' => true,
    'id' => $taskId,
]);

header("Location: ../$address.php");