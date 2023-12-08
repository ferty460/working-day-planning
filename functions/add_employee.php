<?php

require_once __DIR__. '/db/boot.php';

$userId = $_POST['user_id'];
$myId = $_POST['my_id'];

$stmt = pdo()->prepare("UPDATE `users` SET employer_id = :employer_id WHERE id = :id");
$stmt->execute([
    'employer_id' => $myId,
    'id' => $userId,
]);

header("Location: {$_SERVER['HTTP_REFERER']}");