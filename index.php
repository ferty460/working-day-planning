<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/media.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <title>Рабочий стол | Worky✔</title>
</head>

<body>

    <?php
    require_once __DIR__.'/functions/db/boot.php';

    $user = null;
    $tasks = getAllTasks();

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: categories/login.php");
        die();
    }
    ?>

    <!------------------ HEADER ------------------>
    <header class="header">
        <nav>
            <div class="navbar">
                <div class="container nav-container">
                    <input class="checkbox" type="checkbox" />
                    <div class="hamburger-lines">
                        <span class="line line1"></span>
                        <span class="line line2"></span>
                        <span class="line line3"></span>
                    </div>
                    <div class="logo">
                        <h1>worky✔</h1>
                    </div>
                    <div class="menu-items">
                        <li><a href="index.php">Рабочий стол</a></li>
                        <li><a href="categories/profile.php">Мой профиль</a></li>
                        <li><form action="functions/do_logout.php" method="post"><button class="logout" type="submit">Выйти</button></form></li>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="main">

        <!------------------ SIDE PANEL (CALENDAR, FOLDERS) ------------------>
        <section class="side-panel">

            <div class="calendar">
                <div class="calendar-header">
                    <span id="currentMonth"></span>
                    <div class="month__buttons">
                        <button id="prevMonth"><</button>
                        <button id="nextMonth">></button>
                    </div>
                </div>
                <table class="calendar-table">
                    <thead>
                        <tr>
                            <th>Пн</th>
                            <th>Вт</th>
                            <th>Ср</th>
                            <th>Чт</th>
                            <th>Пт</th>
                            <th class="weekend">Сб</th>
                            <th class="weekend">Вс</th>
                        </tr>
                    </thead>
                    <tbody id="calendarBody"></tbody>
                </table>
            </div>

            <div class="other">
                <div class="today">
                    <img src="assets/images/calendar.png" alt="today" class="today-img">
                    <div class="details__today">
                        <h3>Сегодня:</h3>
                        <p class="date"></p>
                    </div>
                </div>
                <div class="folders">
                    <a href="categories/folder_add.php">
                        <div class="add__folder">
                            <h3>Мои папки</h3>
                            <p>+</p>
                        </div>
                    </a>
                    <div class="folder">
                        <img src="assets/images/folder.png" alt="folder">
                        <h4>Проект 1</h4>
                    </div>
                    <div class="folder">
                        <img src="assets/images/folder.png" alt="folder">
                        <h4>Проект 2</h4>
                    </div>
                    <div class="folder">
                        <img src="assets/images/folder.png" alt="folder">
                        <h4>Проект 3</h4>
                    </div>
                </div>
            </div>

        </section>

        <!------------------ TASKS ------------------>
        <section class="content">

            <div class="option__panel">
                <hr class="hr">
                <div class="options">
                    <a href="categories/task_add.php" class="add__task">+ Добавить задачу</a>
                    <div class="block__sort">
                        <img src="assets/images/sort.png" alt="sort" class="img__sort">
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
            </div>

            <div class="tasks">
                <?php foreach ($tasks as $task) {
                    $class = $task['status'] ? 'done' : $task['priority'];
                    $is_completed = $task['status'] ? 'Задача выполнена!' : 'Задача не выполнена!';
                    
                    echo '<a href="categories/task.php?id=' . $task['id'] . '">';
                    echo '<div class="task task__' . $class . '">'; // high | normal | low | done
                    echo '<div class="details__task"><h4 class="theme__task">' . $task['name'] . '</h4>';
                    echo '<p class="description__task">' . $is_completed . '</p></div>';
                    echo '<div><p class="date__task">' . $task['date'] . '</p></div></div></a>';
                } ?>
            </div>

        </section>
    </main>

    <script src="assets/js/calendar.js"></script>
</body>

</html>