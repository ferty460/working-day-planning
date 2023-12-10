<?php

require_once __DIR__. '/db/boot.php';

flash($_SESSION['user_id']);

$role = $_POST['role'];
$user_id = $role === 'work' ? $_POST['user_id'] : $_SESSION['user_id'];
$employer = $role === 'work' ? $_SESSION['user_id'] : null;

// Добавим задачу пользователю
$stmt = pdo()->prepare("INSERT INTO `tasks` (`name`, `description`, `status`, `priority`, `date`, `role`, `user_id`, `employer`) VALUES (:name, :description, :status, :priority, :date, :role, :user_id, :employer)");
$stmt->execute([
    'name' => $_POST['task-theme'],
    'description' => $_POST['task-description'],
    'status' => false,
    'priority' => $_POST['priority'],
    'date' => $_POST['date'],
    'role' => $role,
    'user_id' => $user_id,
    'employer' => $employer
]);

$taskId = pdo()->lastInsertId();

header('Location: ../categories/task.php?id=' . $taskId);