<?php

require_once __DIR__. '/db/boot.php';

$folderId = $_POST['folder_id'];

$stmt = pdo()->prepare("UPDATE `tasks` SET folder = :new_folder WHERE folder = :folder");
$stmt->execute([
    'folder' => $folderId,
    'new_folder' => ''
]);

$stmt = pdo()->prepare("DELETE FROM folders WHERE id = :id");
$stmt->execute(['id' => $folderId]);

header("Location: ../index.php");