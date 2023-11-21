<?php

require_once __DIR__. '/db/boot.php';

$taskId = $_POST['task_id'];

$stmt = pdo()->prepare("UPDATE `tasks` SET name = :name, description = :description, priority = :priority, date = :date WHERE id = :id");
$stmt->execute([
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'priority' => $_POST['priority'],
    'date' => $_POST['date'],
    'id' => $taskId,
]);

header("Location: ../index.php");