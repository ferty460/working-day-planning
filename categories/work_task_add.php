<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/media.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>Добавление задачи | Worky✔</title>
</head>

<body>

    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $users = getEmployeesList($_SESSION['user_id']);

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        die();
    }

    if (empty($users)) {
        header("Location: profile.php");
    }

    include "../blocks/header.php";
    ?>

    <main class="main">
        <section class="task__section">
            <div class="title__block">
                <h1 class="title">Добавление задачи</h1>
                <hr class="line">
            </div>
            <div class="task__block">
                <form action="../functions/add_task.php" method="post">
                    <div class="theme-description-priority">

                        <!-------------------- THEME AND DESCRIPTION -------------------->
                        <div class="theme-description form">
                            <select name="user_id" style="margin-bottom: .5rem; padding: 5px; border: 1px solid #494949; border-radius: 10px;" required>
                                <?php foreach ($users as $user) {
                                    echo '<option value="' . $user['id'] . '">' . $user['surname'] . ' ' . $user['name'] . ' ' . $user['lastname'] . '</option>';
                                } ?>
                            </select>
                            <input type="hidden" name="role" value="work">
                            <input type="text" name="task-theme" placeholder="Тема задачи" required>
                            <textarea name="task-description" placeholder="Описание"></textarea>
                        </div>

                        <!-------------------- PRIORITY AND DATE -------------------->
                        <div class="priority-date">
                            <div class="task-priority">
                                <h3 class="subtitle">Приоритет задачи</h3>
                                <div class="tasks">
                                    <div class="radio__priority">
                                        <input type="radio" name="priority" value='high'>
                                        <div class="task task__high subtask">
                                            <span>Высокий</span>
                                        </div>
                                    </div>
                                    <div class="radio__priority">
                                        <input type="radio" name="priority" value='normal'>
                                        <div class="task task__normal subtask">
                                            <span>Обычный</span>
                                        </div>
                                    </div>
                                    <div class="radio__priority">
                                        <input type="radio" name="priority" value='low' checked>
                                        <div class="task task__low subtask">
                                            <span>Низкий</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="date">
                                <input type="date" name="date" required>
                            </div>
                        </div>

                    </div>

                    <!-------------------- BUTTONS -------------------->
                    <div class="block-buttons">
                        <div class="buttons">
                            <input type="button" value="Отмена" class="cancel_ok" onclick="window.history.back()">
                            <input type="submit" value="Готово" class="ok">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php include "../blocks/footer.php" ?>

    <script src="../assets/js/header.js"></script>
</body>

</html>