<?php

session_start();

function pdo(): PDO {
    static $pdo;

    if (!$pdo) {
        $config = include __DIR__.'/config.php';
        // Подключение к БД
        $dsn = 'mysql:dbname='.$config['db_name'].';host='.$config['db_host'];
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}

function flash(?string $message = null) {
    if ($message) {
        $_SESSION['flash'] = $message;
    } else {
        if (!empty($_SESSION['flash'])) { ?>
          <div class="alert alert-danger mb-3">
              <?=$_SESSION['flash']?>
          </div>
        <?php }
        unset($_SESSION['flash']);
    }
}

function check_auth(): bool {
    return !!($_SESSION['user_id'] ?? false);
}

function getAllTasks() {
    $stmt = pdo()->prepare("SELECT * FROM `tasks` WHERE user_id = :user_id");
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
    ]);
    return $stmt->fetchAll();
}

function getTaskById($taskId) {
    $stmt = pdo()->prepare("SELECT * FROM `tasks` WHERE `id` = :id");
    $stmt->execute(['id' => $taskId]);
    return $stmt->fetch();
}

function getSubtasksByTaskId($taskId) {
    $stmt = pdo()->prepare("SELECT * FROM `subtasks` WHERE `task` = :id");
    $stmt->execute(['id' => $taskId]);
    return $stmt->fetchAll();
}

function getSubtaskById($subtaskId) {
    $stmt = pdo()->prepare("SELECT * FROM `subtasks` WHERE `id` = :id");
    $stmt->execute(['id' => $subtaskId]);
    return $stmt->fetch();
}

function getPercentageCompletedSubtasksInTask($taskId) {
    // Получаем общее количество подзадач в задаче
    $totalSubtasks = pdo()->prepare("SELECT COUNT(*) FROM `subtasks` WHERE `task` = :taskId");
    $totalSubtasks->execute(['taskId' => $taskId]);
    $total = $totalSubtasks->fetchColumn();

    // Получаем количество выполненных подзадач
    $completedSubtasks = pdo()->prepare("SELECT COUNT(*) FROM `subtasks` WHERE `is_completed` = :is_completed AND `task` = :taskId");
    $completedSubtasks->execute([
        'is_completed' => true,
        'taskId' => $taskId,
    ]);
    $completed = $completedSubtasks->fetchColumn();

    // Вычисляем процент выполненных подзадач
    $percentage = $total == 0 ? 0 : ($completed / $total) * 100;

    return $percentage;
}