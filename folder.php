<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/media.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <title>Папка | Worky✔</title>
</head>

<body>
    <?php include "blocks/header.php" ?>

    <main class="main">
        <section class="task__section">
            <div class="title__block">
                <h1 class="title">Добавление задачи</h1>
                <hr class="line">
            </div>
            <div class="flex">
                <div class="theme-description form">
                    <img src="assets/images/folder.svg" alt="folder" class="folder-img">
                    <input type="text" name="subtask-theme" placeholder="Тема задачи">
                    <textarea name="subtask-description" placeholder="Описание"></textarea>
                </div>
                <div class="tasks" style="width: 50%;">
                    <div class="task task__high">
                        <div class="details__task">
                            <h4 class="theme__task">Тема</h4>
                            <p class="description__task">Задача не выполнена!</p>
                        </div>
                        <div>
                            <p class="date__task">03.11.2023</p>
                        </div>
                    </div>
                    <div class="task task__normal">
                        <div class="details__task">
                            <h4 class="theme__task">Тема</h4>
                            <p class="description__task">Задача не выполнена!</p>
                        </div>
                        <div>
                            <p class="date__task">03.11.2023</p>
                        </div>
                    </div>
                    <div class="task task__low">
                        <div class="details__task">
                            <h4 class="theme__task">Тема</h4>
                            <p class="description__task">Задача не выполнена!</p>
                        </div>
                        <div>
                            <p class="date__task">03.11.2023</p>
                        </div>
                    </div>
                    <div class="task task__done">
                        <div class="details__task">
                            <h4 class="theme__task">Тема</h4>
                            <p class="description__task">Задача выполнена!</p>
                        </div>
                        <div>
                            <p class="date__task">03.11.2023</p>
                        </div>
                    </div>
                    <div class="block-buttons">
                        <div class="buttons">
                            <input type="button" value="Удалить" class="delete">
                            <input type="submit" value="Готово" class="ok">
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
</body>

</html>