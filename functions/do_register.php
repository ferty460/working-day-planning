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

$date = date('Y-m-d');
$tasks = [
    [
        'name' => 'Task 1',
        'description' => 'Description 1',
        'status' => false,
        'priority' => 'high',
        'date' => date('Y-m-d', strtotime($date . ' + 1 days')),
        'user_id' => $userId,
    ],
    [
        'name' => 'Task 2',
        'description' => 'Description 2',
        'status' => false,
        'priority' => 'normal',
        'date' => date('Y-m-d', strtotime($date . ' + 2 days')),
        'user_id' => $userId,
    ],
    [
        'name' => 'Task 3',
        'description' => 'Description 3',
        'status' => false,
        'priority' => 'low',
        'date' => date('Y-m-d', strtotime($date . ' + 3 days')),
        'user_id' => $userId,
    ],
    [
        'name' => 'Task 4',
        'description' => 'Description 4',
        'status' => true,
        'priority' => 'normal',
        'date' => date('Y-m-d', strtotime($date . ' + 4 days')),
        'user_id' => $userId,
    ]
];

// добавим пользователю начальные данные
$stmt = pdo()->prepare("INSERT INTO `tasks` (`name`, `description`, `status`, `priority`, `date`, `user_id`) VALUES (:name, :description, :status, :priority, :date, :user_id)");
foreach ($tasks as $task) {
    $stmt->execute($task);
}

header('Location: ../categories/login.php');