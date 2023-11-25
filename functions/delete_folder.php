<?php

require_once __DIR__. '/db/boot.php';

$folderId = $_POST['folder_id'];

$stmt = pdo()->prepare("UPDATE `tasks` SET folder = NULL WHERE folder = :folder");
$stmt->execute(['folder' => $folderId]);

$stmt = pdo()->prepare("DELETE FROM folders WHERE id = :id");
$stmt->execute(['id' => $folderId]);

header("Location: ../index.php");