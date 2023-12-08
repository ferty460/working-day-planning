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
    <title>Регистрация | Worky✔</title>
</head>

<body>

    <?php
    require_once "../functions/db/boot.php";

    if (check_auth()) {
        header('Location: ../index.php');
        die;
    }

    include "../blocks/header.php";
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

                        <h4 class="subtitle" style="margin-bottom: .5rem;">--- Выберите роль ---</h4>
                        <div class="role radio__priority">
                            <input type="radio" name="role" value="user" checked>
                            <div class="task task__low subtask">
                                <span>Я работник</span>
                            </div>
                        </div>
                        <div class="role radio__priority">
                            <input type="radio" name="role" value="admin">
                            <div class="task task__high subtask">
                                <span>Я работодатель</span>
                            </div>
                        </div>

                        <input type="text" name="name" id="username" class="input_username" placeholder="Имя" required><br>
                        <input type="text" name="surname" id="username" class="input_username" placeholder="Фамилия" required><br>
                        <input type="text" name="lastname" id="username" class="input_username" placeholder="Отчество (необязательно)"><br>
                        <input type="email" name="email" id="email" class="input_username" placeholder="Email пользователя" required><br>
                        <input type="password" name="password" id="password" class="input_password" placeholder="Пароль" required><br>

                        <img src="../functions/captcha.php" alt="Captcha" class="captcha"><br>
                        <input type="text" id="captcha" name="captcha_code" class="input_password" placeholder="Код с картинки"><br>

                        <input type="submit" value="Зарегистрироваться" class="cancel login_input">
                        <div style="margin-top: 1rem;">
                            <span>или </span><a href="login.php" class="or_link">Войти</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php include "../blocks/footer.php" ?>

</body>

</html>