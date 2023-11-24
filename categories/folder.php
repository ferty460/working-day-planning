<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/media.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title>Папка | Worky✔</title>
</head>

<body>

    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $folderId = $_GET['id'];
    $folder = getFolderById($folderId);
    $folderTasks = getTasksFromFolder($folderId);
    $tasks = getAllTasks();

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        die();
    }
    ?>

    <?php include "../blocks/header.php" ?>

    <main class="main">
        <section class="task__section">

            <!-------------------- HEAD -------------------->
            <div class="title__block">
                <div style="display: flex; justify-content: space-between;">
                    <h1 class="title">Папка</h1>
                    <form action="../functions/delete_folder.php" method="post">
                        <input type="hidden" name="folder_id" value="<?php echo $folderId ?>">
                        <input type="submit" value="Удалить" class="delete">
                    </form>
                </div>
                <hr class="line">
            </div>
            <div class="flex">

                <!-------------------- FORM TO EDIT -------------------->
                <form action="../functions/edit_folder.php" method="post" style="width: 30%;">
                    <div class="theme-description">
                        <img src="../assets/images/folder.svg" alt="folder" class="folder-img">
                        <input type="text" name="theme" placeholder="Тема задачи" value="<?php echo $folder['theme'] ?>" required>
                        <textarea name="description" placeholder="Описание"><?php echo $folder['description'] ?></textarea>
                        <div class="block-buttons">
                            <div class="buttons" style="justify-content:left;">
                                <input type="hidden" name="folderId" value="<?php echo $folderId; ?>">
                                <input type="submit" value="Сохранить" class="ok" style="margin-left: 0rem;">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="options-tasks">

                    <!-------------------- OPTIONAL PANEL -------------------->
                    <div class="options">
                        <div class="dropdown">
                            <form action="../functions/task_to_folder.php" method="post" id="myForm">
                                <input type="hidden" name="folder_id" value="<?php echo $folderId; ?>">
                                <select class="dropbtn" onchange="document.getElementById('myForm').submit()">
                                    <option>--Добавить задачу--</option>
                                    <?php foreach ($tasks as $task) {
                                        echo '<option value="' . $task['id'] . '" name="task_id">' . $task['name'] . '</option>';
                                    } ?>
                                </select>
                            </form>
                            <div class="dropdown-content">
                                <a href="#">Ссылка 1</a>
                                <a href="#">Ссылка 2</a>
                                <a href="#">Ссылка 3</a>
                            </div>
                        </div>
                        <div class="block__sort">
                            <img src="../assets/images/sort.png" alt="sort" class="img__sort">
                            <div class="dropdown">
                                <button class="dropbtn">Сортировка</button>
                                <div class="dropdown-content">
                                    <a href="#">Ссылка 1</a>
                                    <a href="#">Ссылка 2</a>
                                    <a href="#">Ссылка 3</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-------------------- TASKS -------------------->
                    <div class="tasks folder-tasks">
                        <?php foreach ($folderTasks as $task) {
                            $class = $task['status'] ? 'done' : $task['priority'];
                            $is_completed = $task['status'] ? 'Задача выполнена!' : 'Задача не выполнена!';

                            echo '<a href="categories/task.php?id=' . $task['id'] . '">';
                            echo '<div class="task task__' . $class . '">'; // high | normal | low | done
                            echo '<div class="details__task"><h4 class="theme__task">' . $task['name'] . '</h4>';
                            echo '<p class="description__task">' . $is_completed . '</p></div>';
                            echo '<div><p class="date__task">' . $task['date'] . '</p></div></div></a>';
                        } ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <script src="../assets/js/header.js"></script>
</body>

</html>