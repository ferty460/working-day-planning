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
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>Задача | Worky✔</title>
</head>

<body>

    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $taskId = $_GET['id'];
    $task = getTaskById($taskId);
    $subtasks = getSubtasksByTaskId($taskId);
    $completedSubtasks = getPercentageCompletedSubtasksInTask($taskId);

    $taskUser = getUserByTaskId($task['user_id']);

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        die();
    }
    if ($task['user_id'] != $user['id'] && $task['employer'] != $user['id']) header('Location: login.php');
    ?>

    <?php include "../blocks/header.php" ?>

    <main class="main">
        <section class="task__section">

            <!------------------ TABS ------------------>
            <div class="container-fluid">
                <div class="row">
                    <div style="display: flex;">
                        <div id="SubtasksLink" class="col-sm-4 heading-design tab-link link-active">
                            <h1 class="mb-0"><strong>Подзадачи</strong></h1>
                        </div>
                        <div id="EditTaskLink" class="col-sm-4 heading-prog tab-link">
                            <h1 class="mb-0"><strong>Редактирование задачи</strong></h1>
                        </div>
                    </div>

                    <div style="display: flex;">
                        <form action="../functions/delete_task.php" method="post">
                            <input type="hidden" name="task_id" value="<?php echo $taskId ?>">
                            <input type="submit" value="Удалить" class="delete">
                        </form>
                        <form action="../functions/perform_task.php" method="post">
                            <input type="hidden" name="task_id" value="<?php echo $taskId ?>">
                            <input type="submit" value="Завершить" class="ok">
                        </form>
                    </div>
                </div>
            </div>

            <!------------------ SUBTASKS ------------------>
            <div id="Subtasks" class="container-fluid tab-content tab-active">
                <div class="container-fluid">
                    <h3 class="subtitle" style="margin-top:1rem;">
                        Задача для <?php echo '<a class="task_user" href="../categories/user.php?id=' . $taskUser['id'] . '">' . $taskUser['surname'] . ' ' . $taskUser['name'] . ' ' . $taskUser['lastname'] . '</a>'; ?>
                    </h3>
                    <div class="subtask__block">
                        <div class="form-list">
                            <form action="../functions/add_subtask.php" method="post">
                                <div class="theme-description">
                                    <input type="text" name="task-theme" placeholder="Тема задачи" required>
                                    <textarea name="task-description" placeholder="Описание"></textarea>
                                    <input type="hidden" name="taskId" value="<?php echo $taskId; ?>">
                                    <input type="submit" value="Добавить" class="cancel">
                                </div>
                            </form>
                            <div class="task__list">
                                <?php if (empty($subtasks)) echo '<h4 style="text-align: center; font-weight: bold; font-size: 24px;">Подзадач нет</h4>'; ?>
                                <?php foreach ($subtasks as $subtask) {
                                    $class = $subtask['is_completed'] ? 'done' : 'low';
                                    $is_completed = $subtask['is_completed'] ? 'Подзадача выполнена!' : $subtask['description'];

                                    echo '<div class="task__item"><div class="task task__' . $class . ' subtask"><div class="details__task">';
                                    echo '<h4 class="theme__task">' . $subtask['theme'] . '</h4><p class="description__task">' . $is_completed . '</p></div>';
                                    if ($subtask['is_completed']) {
                                        echo '<div><p class="date__task">' . $subtask['date_completed'] . '</p></div></div></div>';
                                    } else {
                                        echo '<div><form action="../functions/perform_subtask.php" method="post">
                                        <input type="hidden" name="task_id" value="' . $taskId . '">
                                        <input type="hidden" name="subtask_id" value="' . $subtask['id'] . '">
                                        <input class="ok" type="submit" value="Выполнить"></form></div></div></div>';
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="progress-buttons">
                        <div class="progress tooltip" style="margin-right: 0;">
                            <span class="tooltiptext"><?php echo floor($completedSubtasks) . '%'; ?></span>
                            <h3 class="subtitle">Шкала прогресса</h3>
                            <progress value="<?php echo $completedSubtasks; ?>" max="100" class="scale"></progress>
                        </div>
                    </div>
                </div>
            </div>

            <!------------------ EDIT TASK ------------------>
            <div id="EditTask" class="container-fluid tab-content">
                <div class="container-fluid">
                    <h3 class="subtitle" style="margin-top:1rem;">
                        Задача для <?php echo '<a class="task_user" href="../categories/user.php?id=' . $taskUser['id'] . '">' . $taskUser['surname'] . ' ' . $taskUser['name'] . ' ' . $taskUser['lastname'] . '</a>'; ?>
                    </h3>
                    <div class="task__block">
                        <form action="../functions/edit_task.php" method="post">
                            <div class="theme-description-priority">
                                <div class="theme-description form">
                                    <?php
                                    echo '<input type="text" name="name" placeholder="Тема задачи" value="' . $task['name'] . '" required>';
                                    echo '<textarea name="description" placeholder="Описание">' . $task['description'] . '</textarea>';
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
                                <div class="progress tooltip">
                                    <span class="tooltiptext"><?php echo floor($completedSubtasks) . '%'; ?></span>
                                    <h3 class="subtitle">Шкала прогресса</h3>
                                    <progress value="<?php echo $completedSubtasks; ?>" max="100" class="scale"></progress>
                                </div>
                                <div class="buttons">
                                    <input type="hidden" name="task_id" value="<?php echo $taskId ?>">
                                    <input type="submit" value="Сохранить" class="ok">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </main>
    <?php include "../blocks/footer.php" ?>

    <script src="../assets/js/header.js"></script>
    <script src="../assets/js/tabs.js"></script>
</body>

</html>