<?php

require_once __DIR__. '/db/boot.php';

$groupId = $_POST['group_id'];

$stmt = pdo()->prepare("DELETE FROM `users_groups` WHERE group_id = :group_id");
$stmt->execute(['group_id' => $groupId]);

$stmt = pdo()->prepare("DELETE FROM groups WHERE id = :id");
$stmt->execute(['id' => $groupId]);

header("Location: ../work.php");