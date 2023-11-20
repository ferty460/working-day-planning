<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/media.css">
    <link rel="stylesheet" href="../assets/css/tabs.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title>Задача | Worky✔</title>
</head>

<body>
    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $taskId = $_GET['id'];
    $task = getTaskById($taskId);
    $subtasks = getSubtasksByTaskId($taskId);

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        die();
    }
    if ($task['user_id'] != $user['id']) header('Location: login.php');
    ?>
    <?php include "../blocks/header.php" ?>
    <main class="main">
        <section class="task__section">
            <div class="container-fluid">
                <div class="row">
                    <div id="SubtasksLink" class="col-sm-4 heading-design tab-link link-active">
                        <h1 class="mb-0"><strong>Подзадачи</strong></h1>
                    </div>
                    <div id="EditTaskLink" class="col-sm-4 heading-prog tab-link">
                        <h1 class="mb-0"><strong>Редактирование задачи</strong></h1>
                    </div>
                </div>
            </div>

            <div id="Subtasks" class="container-fluid tab-content tab-active">
                <div class="container-fluid">
                    <div class="subtask__block">
                        <h3 class="subtitle">Подзадачи</h3>
                        <div class="form-list">
                            <form action="../functions/add_subtask.php" method="post">
                                <div class="theme-description">
                                    <input type="text" name="task-theme" placeholder="Тема задачи">
                                    <textarea name="task-description" placeholder="Описание"></textarea>
                                    <input type="hidden" name="taskId" value="<?php echo $taskId; ?>">
                                    <input type="submit" value="Добавить" class="cancel">
                                </div>
                            </form>
                            <div class="task__list">
                                <?php if (empty($subtasks)) echo '<h4 style="text-align: center; font-weight: bold; font-size: 24px;">Подзадач нет</h4>'; ?>
                                <?php foreach ($subtasks as $subtask) {
                                    $class = $subtask['is_completed'] ? 'done' : 'low';
                                    $is_completed = $subtask['is_completed'] ? 'Подзадача выполнена!' : 'Подзадача не выполнена!';

                                    echo '<div class="task__item"><div class="task task__' . $class . ' subtask"><div class="details__task">';
                                    echo '<h4 class="theme__task">' . $subtask['theme'] . '</h4><p class="description__task">' . $is_completed . '</p></div>';
                                    if ($class = 'low') {
                                        echo '<div><form action=""><input class="ok" type="button" value="Выполнить"></form></div></div></div>';
                                    } else {
                                        echo '<div><p class="date__task">' . $subtask['date_completed'] . '</p></div>';
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="EditTask" class="container-fluid tab-content">
                <div class="container-fluid">
                    <div class="task__block">
                        <h3 style="margin-left: 2rem; margin-bottom: 1rem; font-size: 24px; font-weight: bold;">Редактирование задачи</h3>
                        <form action="">
                            <div class="theme-description-priority">
                                <div class="theme-description form">
                                    <?php
                                    echo '<input type="text" name="subtask-theme" placeholder="Тема задачи" value="' . $task['name'] . '">';
                                    echo '<textarea name="subtask-description" placeholder="Описание">' . $task['description'] . '</textarea>';
                                    ?>
                                </div>
                                <div class="priority-date">
                                    <div class="task-priority">
                                        <h3 class="subtitle">Приоритет задачи</h3>
                                        <div class="tasks">
                                            <div class="radio__priority">
                                                <input type="radio" name="priority" value="high" <?php if ($task['priority'] == 'high') echo 'checked'; ?>>
                                                <div class="task task__high subtask">
                                                    <span>Высокий</span>
                                                </div>
                                            </div>
                                            <div class="radio__priority">
                                                <input type="radio" name="priority" value="normal" <?php if ($task['priority'] == 'normal') echo 'checked'; ?>>
                                                <div class="task task__normal subtask">
                                                    <span>Обычный</span>
                                                </div>
                                            </div>
                                            <div class="radio__priority">
                                                <input type="radio" name="priority" value="low" <?php if ($task['priority'] == 'low') echo 'checked'; ?>>
                                                <div class="task task__low subtask">
                                                    <span>Низкий</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="date">
                                        <input type="date" name="date" <?php echo 'value="' . $task['date'] . '"' ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-buttons">
                                <div class="progress">
                                    <h3 class="subtitle">Шкала прогресса</h3>
                                    <progress value="10" max="100" class="scale"></progress>
                                </div>
                                <div class="buttons">
                                    <input type="button" value="Удалить" class="delete">
                                    <input type="submit" value="Готово" class="ok">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="../assets/js/tabs.js"></script>
</body>

</html>