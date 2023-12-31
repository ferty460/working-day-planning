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
    <title>Добавление группы | Worky✔</title>
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

    if ($_SESSION['user_role'] !== 'admin') {
        header("Location: ../work.php");
    }

    include "../blocks/header.php"; 
    ?>

    <main class="main">
        <section class="task__section">
            <div class="title__block">
                <h1 class="title">Добавление группы</h1>
                <hr class="line">
            </div>
            <form action="../functions/add_group.php" method="post" style="width: 100%;">
                <div class="center">

                    <!-------------------- THEME AND DESCRIPTION -------------------->
                    <div class="theme-description form" style="margin: 0 auto;">
                        <img src="../assets/images/group.png" alt="folder" class="folder-img">
                        <input type="text" name="theme" placeholder="Тема группы">
                        <textarea name="description" placeholder="Описание"></textarea>
                    </div>

                    <!-------------------- BUTTONS -------------------->
                    <div class="block-buttons">
                        <div class="buttons" style="justify-content:center;">
                            <input type="button" value="Отмена" class="cancel_ok" onclick="window.history.back()">
                            <input type="submit" value="Готово" class="ok">
                        </div>
                    </div>
                    
                </div>
            </form>
        </section>
    </main>

    <?php include "../blocks/footer.php" ?>
    
    <script src="../assets/js/header.js"></script>
</body>

</html>