<?php

require_once __DIR__. '/db/boot.php';

// Добавим задачу пользователю
$stmt = pdo()->prepare("INSERT INTO `tasks` (`name`, `description`, `status`, `priority`, `date`, `user_id`) VALUES (:name, :description, :status, :priority, :date, :user_id)");
$stmt->execute([
    'name' => $_POST['task-theme'],
    'description' => $_POST['task-description'],
    'status' => false,
    'priority' => $_POST['priority'],
    'date' => $_POST['date'],
    'user_id' => $_SESSION['user_id'],
]);

$taskId = pdo()->lastInsertId();

header('Location: ../categories/task.php?id=' . $taskId);