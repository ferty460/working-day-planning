<?php

session_start();

// PDO
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

// flash messages
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

// USEFULL FUNCTIONS
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

function getAllFolders() {
    $stmt = pdo()->prepare("SELECT * FROM `folders` WHERE user = :user");
    $stmt->execute([
        'user' => $_SESSION['user_id'],
    ]);
    return $stmt->fetchAll();
}

function getTasksFromFolder($folder) {
    $stmt = pdo()->prepare("SELECT * FROM `tasks` WHERE `folder` = :folder");
    $stmt->execute(['folder' => $folder]);
    return $stmt->fetchAll();
}

function getFolderById($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM `folders` WHERE `id` = :id");
    $stmt->execute(['id' => $folderId]);
    return $stmt->fetch();
}

function getTasksByDate($date) {
    $stmt = pdo()->prepare("SELECT * FROM `tasks` WHERE user_id = :user_id AND date = :date");
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'date' => $date
    ]);
    return $stmt->fetchAll();
}

function getMonthName($monthNumber) {
    $fmt = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL, null, null, 'MMMM');
    return $fmt->format(mktime(0, 0, 0, $monthNumber, 10));
}

// TASKS IN FOLDER SORT
function getNearestTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder ORDER BY date ASC");
    $stmt->execute(['folder' => $folderId]);
    return $stmt->fetchAll();
}

function getFarestTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder ORDER BY date DESC");
    $stmt->execute(['folder' => $folderId]);
    return $stmt->fetchAll();
}

function getA_ZTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder ORDER BY name ASC");
    $stmt->execute(['folder' => $folderId]);
    return $stmt->fetchAll();
}

function getZ_ATasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder ORDER BY name DESC");
    $stmt->execute(['folder' => $folderId]);
    return $stmt->fetchAll();
}

function getHighToLowTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder ORDER BY FIELD(priority, 'high', 'normal', 'low')");
    $stmt->execute(['folder' => $folderId]);
    return $stmt->fetchAll();
}

function getLowToHighTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder ORDER BY FIELD(priority, 'low', 'normal', 'high')");
    $stmt->execute(['folder' => $folderId]);
    return $stmt->fetchAll();
}

function getCompletedTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND status = :status");
    $stmt->execute([
        'folder' => $folderId,
        'status' => true
    ]);
    return $stmt->fetchAll();
}

function getUnfulfilledTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND status = :status");
    $stmt->execute([
        'folder' => $folderId,
        'status' => false
    ]);
    return $stmt->fetchAll();
}

// TASKS SORT
function getNearestTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user ORDER BY date ASC");
    $stmt->execute(['user' => $_SESSION['user_id']]);
    return $stmt->fetchAll();
}

function getFarestTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user ORDER BY date DESC");
    $stmt->execute(['user' => $_SESSION['user_id']]);
    return $stmt->fetchAll();
}

function getA_ZTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user ORDER BY name ASC");
    $stmt->execute(['user' => $_SESSION['user_id']]);
    return $stmt->fetchAll();
}

function getZ_ATasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user ORDER BY name DESC");
    $stmt->execute(['user' => $_SESSION['user_id']]);
    return $stmt->fetchAll();
}

function getHighToLowTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user ORDER BY FIELD(priority, 'high', 'normal', 'low')");
    $stmt->execute(['user' => $_SESSION['user_id']]);
    return $stmt->fetchAll();
}

function getLowToHighTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user ORDER BY FIELD(priority, 'low', 'normal', 'high')");
    $stmt->execute(['user' => $_SESSION['user_id']]);
    return $stmt->fetchAll();
}

function getCompletedTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND status = :status");
    $stmt->execute([
        'user' => $_SESSION['user_id'],
        'status' => true
    ]);
    return $stmt->fetchAll();
}

function getUnfulfilledTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND status = :status");
    $stmt->execute([
        'user' => $_SESSION['user_id'],
        'status' => false
    ]);
    return $stmt->fetchAll();
}