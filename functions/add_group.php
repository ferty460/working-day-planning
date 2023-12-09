<?php

require_once __DIR__. '/db/boot.php';

// Добавим проект (папку) пользователю
$stmt = pdo()->prepare("INSERT INTO `groups` (`theme`, `description`, `user`) VALUES (:theme, :description, :user)");
$stmt->execute([
    'theme' => $_POST['theme'],
    'description' => $_POST['description'],
    'user' => $_SESSION['user_id'],
]);

$groupId = pdo()->lastInsertId();

header('Location: ../categories/group.php?id=' . $groupId);