<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/media.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <title>Добавление папки | Worky✔</title>
</head>

<body>
    <?php include "blocks/header.php" ?>

    <main class="main">
        <section class="task__section">
            <div class="title__block">
                <h1 class="title">Добавление папки</h1>
                <hr class="line">
            </div>
            <form action="" style="width: 100%;">
                <div class="center">
                    <div class="theme-description form" style="margin: 0 auto;">
                        <img src="assets/images/folder.svg" alt="folder" class="folder-img">
                        <input type="text" name="subtask-theme" placeholder="Тема задачи">
                        <textarea name="subtask-description" placeholder="Описание"></textarea>
                    </div>
                    <div class="block-buttons">
                        <div class="buttons" style="justify-content:center;">
                            <input type="button" value="Отмена" class="cancel_ok">
                            <input type="submit" value="Готово" class="ok">
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>

</html>