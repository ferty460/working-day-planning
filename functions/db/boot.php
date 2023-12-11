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

// USEFUL FUNCTIONS
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

function getFolderById($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM `folders` WHERE `id` = :id");
    $stmt->execute(['id' => $folderId]);
    return $stmt->fetch();
}

function getTasksByDate($date, $employerId) {
    $stmt = pdo()->prepare("SELECT * FROM `tasks` WHERE (user_id = :user_id OR employer = :employer_id) AND date = :date");
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'employer_id' => $employerId,
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
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND role = :role ORDER BY date ASC");
    $stmt->execute(['folder' => $folderId, 'role' => 'home']);
    return $stmt->fetchAll();
}

function getFarestTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND role = :role ORDER BY date DESC");
    $stmt->execute(['folder' => $folderId, 'role' => 'home']);
    return $stmt->fetchAll();
}

function getA_ZTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND role = :role ORDER BY name ASC");
    $stmt->execute(['folder' => $folderId, 'role' => 'home']);
    return $stmt->fetchAll();
}

function getZ_ATasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND role = :role ORDER BY name DESC");
    $stmt->execute(['folder' => $folderId, 'role' => 'home']);
    return $stmt->fetchAll();
}

function getHighToLowTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND role = :role ORDER BY FIELD(priority, 'high', 'normal', 'low')");
    $stmt->execute(['folder' => $folderId, 'role' => 'home']);
    return $stmt->fetchAll();
}

function getLowToHighTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND role = :role ORDER BY FIELD(priority, 'low', 'normal', 'high')");
    $stmt->execute(['folder' => $folderId, 'role' => 'home']);
    return $stmt->fetchAll();
}

function getCompletedTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND role = :role AND status = :status");
    $stmt->execute([
        'folder' => $folderId,
        'role' => 'home',
        'status' => true
    ]);
    return $stmt->fetchAll();
}

function getUnfulfilledTasksInFolder($folderId) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE folder = :folder AND role = :role AND status = :status");
    $stmt->execute([
        'folder' => $folderId,
        'role' => 'home',
        'status' => false
    ]);
    return $stmt->fetchAll();
}

// TASKS SORT
function getNearestTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY date ASC");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'home']);
    return $stmt->fetchAll();
}

function getFarestTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY date DESC");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'home']);
    return $stmt->fetchAll();
}

function getA_ZTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY name ASC");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'home']);
    return $stmt->fetchAll();
}

function getZ_ATasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY name DESC");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'home']);
    return $stmt->fetchAll();
}

function getHighToLowTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY FIELD(priority, 'high', 'normal', 'low')");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'home']);
    return $stmt->fetchAll();
}

function getLowToHighTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY FIELD(priority, 'low', 'normal', 'high')");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'home']);
    return $stmt->fetchAll();
}

function getCompletedTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role AND status = :status");
    $stmt->execute([
        'user' => $_SESSION['user_id'],
        'role' => 'home',
        'status' => true
    ]);
    return $stmt->fetchAll();
}

function getUnfulfilledTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role AND status = :status");
    $stmt->execute([
        'user' => $_SESSION['user_id'],
        'role' => 'home',
        'status' => false, 
    ]);
    return $stmt->fetchAll();
}

// WORK TASKS SORT
function getNearestWorkTasks($id) {
    $stmt = pdo()->prepare("SELECT * FROM `tasks` WHERE user_id = :user AND `role` = :role ORDER BY date ASC");
    $stmt->execute(['user' => $id, 'role' => 'work']);
    return $stmt->fetchAll();
}

function getFarestWorkTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY date DESC");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'work']);
    return $stmt->fetchAll();
}

function getA_ZWorkTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY name ASC");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'work']);
    return $stmt->fetchAll();
}

function getZ_AWorkTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY name DESC");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'work']);
    return $stmt->fetchAll();
}

function getHighToLowWorkTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY FIELD(priority, 'high', 'normal', 'low')");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'work']);
    return $stmt->fetchAll();
}

function getLowToHighWorkTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role ORDER BY FIELD(priority, 'low', 'normal', 'high')");
    $stmt->execute(['user' => $_SESSION['user_id'], 'role' => 'work']);
    return $stmt->fetchAll();
}

function getCompletedWorkTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role AND status = :status");
    $stmt->execute([
        'user' => $_SESSION['user_id'],
        'role' => 'work',
        'status' => true
    ]);
    return $stmt->fetchAll();
}

function getUnfulfilledWorkTasks() {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE user_id = :user AND role = :role AND status = :status");
    $stmt->execute([
        'user' => $_SESSION['user_id'],
        'role' => 'work',
        'status' => false
    ]);
    return $stmt->fetchAll();
}

// EMPLOYER TASKS SORT
function getNearestTasksByEmployer($id) {
    $stmt = pdo()->prepare("SELECT * FROM `tasks` WHERE `employer` = :employer");
    $stmt->execute(['employer' => $id]);
    return $stmt->fetchAll();
}

function getFarestEmployerTasks($id) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE  role = :role AND `employer` = :employer ORDER BY date DESC");
    $stmt->execute(['role' => 'work', 'employer' => $id]);
    return $stmt->fetchAll();
}

function getA_ZEmployerTasks($id) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE role = :role AND `employer` = :employer ORDER BY name ASC");
    $stmt->execute(['role' => 'work', 'employer' => $id]);
    return $stmt->fetchAll();
}

function getZ_AEmployerTasks($id) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE role = :role AND `employer` = :employer ORDER BY name DESC");
    $stmt->execute(['role' => 'work', 'employer' => $id]);
    return $stmt->fetchAll();
}

function getHighToLowEmployerTasks($id) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE role = :role AND `employer` = :employer ORDER BY FIELD(priority, 'high', 'normal', 'low')");
    $stmt->execute(['role' => 'work', 'employer' => $id]);
    return $stmt->fetchAll();
}

function getLowToHighEmployerTasks($id) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE role = :role AND `employer` = :employer ORDER BY FIELD(priority, 'low', 'normal', 'high')");
    $stmt->execute([ 'role' => 'work', 'employer' => $id]);
    return $stmt->fetchAll();
}

function getCompletedEmployerTasks($id) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE role = :role AND status = :status AND `employer` = :employer");
    $stmt->execute([
        'role' => 'work',
        'status' => true, 'employer' => $id
    ]);
    return $stmt->fetchAll();
}

function getUnfulfilledEmployerTasks($id) {
    $stmt = pdo()->prepare("SELECT * FROM tasks WHERE role = :role AND status = :status AND `employer` = :employer");
    $stmt->execute([
        'role' => 'work',
        'status' => false, 'employer' => $id
    ]);
    return $stmt->fetchAll();
}

function getUserList() {
    $stmt = pdo()->prepare("SELECT * FROM users WHERE role = :role AND employer_id IS NULL");
    $stmt->execute(['role' => 'user']);
    return $stmt->fetchAll();
}

function getEmployeesList($id) {
    $stmt = pdo()->prepare("SELECT * FROM users WHERE employer_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll();
}

function getEmployerById($id) {
    $stmt = pdo()->prepare("SELECT * FROM users WHERE id IN (SELECT employer_id FROM users WHERE id = :id);");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function getAllGroups() {
    $stmt = pdo()->prepare("SELECT * FROM groups WHERE user = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    return $stmt->fetchAll();
}

function getGroupById($id) {
    $stmt = pdo()->prepare("SELECT * FROM `groups` WHERE `id` = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function getUsersFromGroup($id) {
    $stmt = pdo()->prepare("SELECT * FROM users JOIN users_groups ON users.id = users_groups.user_id WHERE users_groups.group_id = :group_id;");
    $stmt->execute(['group_id' => $id]);
    return $stmt->fetchAll();
}

function getGroupsByUser($id) {
    $stmt = pdo()->prepare("SELECT * FROM groups JOIN users_groups ON groups.id = users_groups.group_id WHERE users_groups.user_id = :user_id;");
    $stmt->execute(['user_id' => $id]);
    return $stmt->fetchAll();
}

function getUserById($id) {
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function getUserByTaskId($id) {
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}