<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/media.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <title>Профиль | Worky✔</title>
</head>

<body>
    <?php include "blocks/header.php" ?>

    <main class="main">
        <section class="task__section">
            <div class="flex">
                <div class="profile">
                    <img src="assets/images/profile.svg" alt="profile" class="profile-img">
                    <div class="user-details">
                        <h4 class="username">username</h4>
                        <h5 class="email">user@email.com</h5>
                    </div>
                </div>
                <div class="tasks">
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
                </div>
            </div>
        </section>
    </main>
</body>

</html>