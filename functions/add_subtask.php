<?php

require_once __DIR__. '/db/boot.php';

$taskId = $_POST['taskId'];

// Добавим подзадачу пользователю
$stmt = pdo()->prepare("INSERT INTO `subtasks` (`theme`, `description`, `is_completed`, `task`) VALUES (:theme, :description, :is_completed, :task)");
$stmt->execute([
    'theme' => $_POST['task-theme'],
    'description' => $_POST['task-description'],
    'is_completed' => false,
    'task' => $taskId,
]);

header('Location: ../categories/task.php?id=' . $taskId);