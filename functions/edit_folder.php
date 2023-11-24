<?php

require_once __DIR__. '/db/boot.php';

$folderId = $_POST['folderId'];

$stmt = pdo()->prepare("UPDATE `folders` SET theme = :theme, description = :description WHERE id = :id");
$stmt->execute([
    'theme' => $_POST['theme'],
    'description' => $_POST['description'],
    'id' => $folderId,
]);

header("Location: ../index.php");
