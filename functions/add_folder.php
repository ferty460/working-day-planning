<?php

require_once __DIR__. '/db/boot.php';

// Добавим задачу пользователю
$stmt = pdo()->prepare("INSERT INTO `folders` (`theme`, `description`, `user`) VALUES (:theme, :description, :user)");
$stmt->execute([
    'theme' => $_POST['theme'],
    'description' => $_POST['description'],
    'user' => $_SESSION['user_id'],
]);

$folderId = pdo()->lastInsertId();

header('Location: ../categories/folder.php?id=' . $folderId);