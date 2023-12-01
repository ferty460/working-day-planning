<?php

require_once __DIR__.'/db/boot.php';

// проверяем наличие пользователя с указанными данными
$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `email` = :email");
$stmt->execute([
    'email' => $_POST['email'],
]);
if (!$stmt->rowCount()) {
    flash('Неверный email или пароль!');
    header("Location: {$_SERVER['HTTP_REFERER']}"); 
    die;
}
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// проверяем пароль
if (password_verify($_POST['password'], $user['password'])) {
    if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = pdo()->prepare('UPDATE `users` SET `password` = :password WHERE `username` = :username');
        $stmt->execute([
            'username' => $_POST['username'],
            'password' => $newHash,
        ]);
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['username'];
    $_SESSION['user_email'] = $user['email'];
    header('Location: ../main.php');
    die;
}

flash('Неверный email или пароль!');
header("Location: {$_SERVER['HTTP_REFERER']}"); 