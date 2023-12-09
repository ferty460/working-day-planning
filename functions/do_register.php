<?php

require_once __DIR__. '/db/boot.php';

// Проверка капчи
if($_POST["captcha_code"] != $_SESSION["captcha_code"]) {
    flash("Вы робот или введите капчу еще раз");
    header("Location: {$_SERVER['HTTP_REFERER']}");
    die;
}

// Проверим, не занят ли email пользователя
$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `email` = :email");
$stmt->execute(['email' => $_POST['email']]);
if ($stmt->rowCount() > 0) {
    flash("Этот email пользователя уже занят");
    header("Location: {$_SERVER['HTTP_REFERER']}"); // Возврат на форму регистрации
    die; 
}

$role = $_POST['role'];

// Добавим пользователя в базу
$stmt = pdo()->prepare("INSERT INTO `users` (`name`, `surname`, `lastname`, `password`, `email`, `role`) VALUES (:name, :surname, :lastname, :password, :email, :role)");
$stmt->execute([
    'name' => $_POST['name'],
    'surname' => $_POST['surname'],
    'lastname' => $_POST['lastname'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    'email' => $_POST['email'],
    'role' => $role
]);
$userId = pdo()->lastInsertId();

header('Location: ../categories/login.php');