<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/media.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title>Регистрация | Worky✔</title>
</head>

<body>
    <?php require_once "../functions/db/boot.php" ?>

    <?php
    if (check_auth()) {
        header('Location: ../index.php');
        die;
    }
    ?>
    <main class="main">
        <section class="task__section">
            <div class="login" style="text-align: center;">
                <div class="user-login-details">
                    <div>
                        <h2 class="title">Регистрация</h2>
                        <img src="../assets/images/profile.svg" alt="profile" class="login-img">
                    </div>
                    <form action="../functions/do_register.php" method="post">
                        <?php flash(); ?>
                        <input type="text" name="username" id="username" class="input_username" placeholder="Имя пользователя"><br>
                        <input type="password" name="password" id="password" class="input_password" placeholder="Пароль"><br>

                        <input type="submit" value="Зарегистрироваться" class="cancel login_input">
                        <div style="margin-top: 1rem;">
                            <span>или </span><a href="login.php">Войти</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>