<?php

require_once __DIR__. '/db/boot.php';

$taskId = $_POST['task_id'];

$stmt = pdo()->prepare("DELETE FROM subtasks WHERE task = :task");
$stmt->execute(['task' => $taskId]);

$stmt = pdo()->prepare("DELETE FROM tasks WHERE id = :id");
$stmt->execute(['id' => $taskId]);

header("Location: ../index.php");
