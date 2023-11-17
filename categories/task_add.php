<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/media.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title>Добавление задачи | Worky✔</title>
</head>

<body>
    <?php
    require_once '../functions/db/boot.php';

    $user = null;

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        die();
    }
    ?>
    <?php if ($user) { ?>
    <?php include "../blocks/header.php" ?>
    <main class="main">
        <section class="task__section">
            <div class="title__block">
                <h1 class="title">Добавление задачи</h1>
                <hr class="line">
            </div>
            <div class="task__block">
                <form action="">
                    <div class="theme-description-priority">
                        <div class="theme-description form">
                            <input type="text" name="subtask-theme" placeholder="Тема задачи">
                            <textarea name="subtask-description" placeholder="Описание"></textarea>
                        </div>
                        <div class="priority-date">
                            <div class="task-priority">
                                <h3 class="subtitle">Приоритет задачи</h3>
                                <div class="tasks">
                                    <div class="radio__priority">
                                        <input type="radio" name="high">
                                        <div class="task task__high subtask">
                                            <span>Высокий</span>
                                        </div>
                                    </div>
                                    <div class="radio__priority">
                                        <input type="radio" name="normal">
                                        <div class="task task__normal subtask">
                                            <span>Обычный</span>
                                        </div>
                                    </div>
                                    <div class="radio__priority">
                                        <input type="radio" name="low">
                                        <div class="task task__low subtask">
                                            <span>Низкий</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="date">
                                <input type="date" name="date">
                            </div>
                        </div>
                    </div>
                    <div class="block-buttons">
                        <div class="buttons">
                            <input type="button" value="Отмена" class="cancel_ok">
                            <input type="submit" value="Готово" class="ok">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php } ?>
</body>

</html>