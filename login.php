<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/media.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <title>Войти | Worky✔</title>
</head>

<body>
    <?php include "blocks/header.php" ?>

    <main class="main">
        <section class="task__section">
            <div class="login">
                <div class="user-login-details">
                    <img src="assets/images/profile.svg" alt="profile" class="login-img">
                    <form action="">
                        <input type="text" name="username" id="username" class="input_username" placeholder="Имя пользователя"><br>
                        <input type="email" name="email" id="email" class="input_email" placeholder="email"><br>
                        <input type="password" name="password" id="password" class="input_password" placeholder="Пароль"><br>

                        <input type="submit" value="Войти" class="cancel login_input">
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>