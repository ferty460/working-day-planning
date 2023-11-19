<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/media.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title>Задача | Worky✔</title>
</head>

<body>
    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $taskId = $_GET['id'];
    $stmt = pdo()->prepare("SELECT * FROM `tasks` WHERE `id` = :id");
    $stmt->execute(['id' => $taskId]);
    $task = $stmt->fetch();

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
            <div class="title__block">
                <h1 class="title">Задача</h1>
                <hr class="line">
            </div>
            <div class="subtask__block">
                <h3 class="subtitle">Подзадачи</h3>
                <div class="form-list">
                    <form action="">
                        <div class="theme-description">
                            <input type="text" name="task-theme" placeholder="Тема задачи">
                            <textarea name="task-description" placeholder="Описание"></textarea>
                            <input type="submit" value="Добавить" class="cancel">
                        </div>
                    </form>
                    <div class="task__list">
                        <div class="task__item">
                            <div class="task task__low subtask">
                                <div class="details__task">
                                    <h4 class="theme__task">Тема</h4>
                                    <p class="description__task">Задача не выполнена!</p>
                                </div>
                                <div>
                                    <form action="">
                                        <input class="ok" type="button" value="Выполнить">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="task__item">
                            <div class="task task__low subtask">
                                <div class="details__task">
                                    <h4 class="theme__task">Тема</h4>
                                    <p class="description__task">Задача не выполнена!</p>
                                </div>
                                <div>
                                    <form action="">
                                        <input class="ok" type="button" value="Выполнить">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="task__item">
                            <div class="task task__low subtask">
                                <div class="details__task">
                                    <h4 class="theme__task">Тема</h4>
                                    <p class="description__task">Задача не выполнена!</p>
                                </div>
                                <div>
                                    <form action="">
                                        <input class="ok" type="button" value="Выполнить">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="task task__done subtask">
                            <div class="details__task">
                                <h4 class="theme__task">Тема</h4>
                                <p class="description__task">Задача выполнена!</p>
                            </div>
                            <div>
                                <p class="date__task">03.11.2023</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="task__block">
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
        </section>
    </main>
</body>

</html>