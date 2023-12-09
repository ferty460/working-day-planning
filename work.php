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
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/calendar.css">
    <title>Работа | Рабочий стол | Worky✔</title>
</head>

<body>

    <?php
    require_once __DIR__ . '/functions/db/boot.php';

    $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
    if ($sort == 'near') {
        $tasks = getNearestWorkTasks();
        $employerTasks = getNearestTasksByEmployer($_SESSION['user_id']);
    } else if ($sort == 'far') {
        $tasks = getFarestWorkTasks();
        $employerTasks = getFarestEmployerTasks($_SESSION['user_id']);
    } else if ($sort == 'a-z') {
        $tasks = getA_ZWorkTasks();
        $employerTasks = getA_ZEmployerTasks($_SESSION['user_id']);
    } else if ($sort == 'z-a') {
        $tasks = getZ_AWorkTasks();
        $employerTasks = getZ_AEmployerTasks($_SESSION['user_id']);
    } else if ($sort == 'important') {
        $tasks = getHighToLowWorkTasks();
        $employerTasks = getHighToLowEmployerTasks($_SESSION['user_id']);
    } else if ($sort == 'unimportant') {
        $tasks = getLowToHighWorkTasks();
        $employerTasks = getLowToHighEmployerTasks($_SESSION['user_id']);
    } else if ($sort == 'completed') {
        $tasks = getCompletedWorkTasks();
        $employerTasks = getCompletedEmployerTasks($_SESSION['user_id']);
    } else if ($sort == 'unfulfilled') {
        $tasks = getUnfulfilledWorkTasks();
        $employerTasks = getUnfulfilledEmployerTasks($_SESSION['user_id']);
    } else {
        $tasks = getNearestWorkTasks();
        $employerTasks = getNearestTasksByEmployer($_SESSION['user_id']);
    }

    $user = null;
    $folders = getAllFolders();
    $groups = getAllGroups();
    $userGroups = getGroupsByUser($_SESSION['user_id']);

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
        <nav class="navbar">
            <div class="container">

                <div class="navbar-header">
                    <button class="navbar-toggler" data-toggle="open-navbar1">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <a href="main.php">
                        <h4>Worky<span>✔</span></h4>
                    </a>
                </div>

                <div class="navbar-menu" id="open-navbar1">
                    <ul class="navbar-nav">
                        <?php if ($_SESSION['user_id'] != null) { ?>
                            <li class="navbar-dropdown">
                                <a href="#" class="dropdown-toggler" data-dropdown="my-dropdown-id">
                                    Рабочий стол <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown" id="my-dropdown-id">
                                    <li class="active"><a href="work.php">Работа</a></li>
                                    <li><a href="index.php">Дом</a></li>
                                </ul>
                            </li>
                            <li><a href="categories/profile.php">Профиль</a></li>
                            <li><a href="#">
                                    <form action="functions/do_logout.php" method="post"><button type="submit">Выйти</button></form>
                                </a></li>
                        <?php } else { ?>
                            <li><a href="categories/login.php">Войти</a></li>
                            <li><a href="categories/registration.php">Зарегистрироваться</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main">

        <!------------------ SIDE PANEL (CALENDAR, FOLDERS) ------------------>
        <section class="side-panel">

            <div class="calendar"></div>

            <div class="other">
                <div class="today">
                    <img src="assets/images/calendar.png" alt="today" class="today-img">
                    <div class="details__today">
                        <h3>Сегодня:</h3>
                        <p class="date_">
                            <?php
                            $fmt = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
                            $fmt->setPattern('d MMMM, EEE');
                            echo $fmt->format(new DateTime());
                            ?>
                        </p>
                    </div>
                </div>
                <?php if ($_SESSION['user_role'] === 'admin') { ?>
                    <div class="folders">
                        <a href="categories/group_add.php">
                            <div class="add__folder">
                                <h3>Мои группы</h3>
                                <p>+</p>
                            </div>
                        </a>
                        <?php
                        if (empty($groups)) echo '<h3 style="font-size:18px;margin-top:1rem;text-align:center;">Групп нет</h3>';
                        foreach ($groups as $group) {
                            echo '<a href="categories/group.php?id=' . $group['id'] . '">';
                            echo '<div class="folder"><img class="folder-img1" src="assets/images/group.png" alt="group"><h4>' . $group['theme'] . '</h4></div></a>';
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>

        </section>

        <!------------------ TASKS ------------------>
        <section class="content">

            <div class="option__panel">
                <hr class="hr">
                <div class="options">
                    <?php if ($_SESSION['user_role'] === 'admin') { ?>
                        <a href="categories/work_task_add.php" class="add__task">+ Добавить задачу</a>
                    <?php } else echo '<div></div>'; ?>
                    <div class="block__sort">
                        <img src="assets/images/sort.png" alt="sort" class="img__sort">
                        <div class="dropdown">
                            <button class="dropbtn">Сортировка</button>
                            <div class="dropdown-content">
                                <a href="?sort=near">По дате &darr;</a>
                                <a href="?sort=far">По дате &uarr;</a>
                                <a href="?sort=a-z">По названию &darr;</a>
                                <a href="?sort=z-a">По названию &uarr;</a>
                                <a href="?sort=important">По важности &darr;</a>
                                <a href="?sort=unimportant">По важности &uarr;</a>
                                <a href="?sort=completed">Выполненные</a>
                                <a href="?sort=unfulfilled">Невыполненные</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tasks">
                <?php
                if ($_SESSION['user_role'] === 'home') {
                    foreach ($tasks as $task) {
                        $class = $task['status'] ? 'done' : $task['priority'];
                        $is_completed = $task['status'] ? 'Задача выполнена!' : 'Задача не выполнена!';

                        echo '<a href="categories/task.php?id=' . $task['id'] . '">';
                        echo '<div class="task task__' . $class . '">'; // high | normal | low | done
                        echo '<div class="details__task"><h4 class="theme__task">' . $task['name'] . '</h4>';
                        echo '<p class="description__task">' . $is_completed . '</p></div>';
                        echo '<div><p class="date__task">' . $task['date'] . '</p></div></div></a>';
                    }
                } else {
                    foreach ($employerTasks as $task) {
                        $class = $task['status'] ? 'done' : $task['priority'];
                        $is_completed = $task['status'] ? 'Задача выполнена!' : 'Задача не выполнена!';

                        echo '<a href="categories/task.php?id=' . $task['id'] . '">';
                        echo '<div class="task task__' . $class . '">'; // high | normal | low | done
                        echo '<div class="details__task"><h4 class="theme__task">' . $task['name'] . '</h4>';
                        echo '<p class="description__task">' . $is_completed . '</p></div>';
                        echo '<div><p class="date__task">' . $task['date'] . '</p></div></div></a>';
                    }
                }
                ?>
            </div>

        </section>
    </main>

    <footer class="footer" id="footer">
        <div class="footer__copy">
            <div class="container">
                <p>Курсовая работа</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/header.js"></script>
    <script src="assets/js/calendar.js"></script>
</body>

</html>