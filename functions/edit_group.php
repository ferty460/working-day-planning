<?php

require_once __DIR__. '/db/boot.php';

$groupId = $_POST['groupId'];

$stmt = pdo()->prepare("UPDATE `groups` SET theme = :theme, description = :description WHERE id = :id");
$stmt->execute([
    'theme' => $_POST['theme'],
    'description' => $_POST['description'],
    'id' => $groupId,
]);

header("Location: ../work.php");