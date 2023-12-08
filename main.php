<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- кысыс -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <title>Worky✔</title>
</head>

<?php require_once __DIR__ . '/functions/db/boot.php'; ?>
<?php $_SESSION['user_role'] == 'user' ? flash('Вы вошли как пользователь') : flash('Вы вошли как администратор'); ?>

<body>
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
                                    <li><a href="work.php">Работа</a></li>
                                    <li><a href="index.php">Дом</a></li>
                                </ul>
                            </li>
                            <li><a href="categories/profile.php">Профиль</a></li>
                            <li>
                                <a href="#">
                                    <form action="functions/do_logout.php" method="post"><button type="submit">Выйти</button></form>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li><a href="categories/login.php">Войти</a></li>
                            <li><a href="categories/registration.php">Зарегистрироваться</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main" id="main">
        </div>
        <section class="welcome">
            <div class="container">
                <div class="welcome__head">
                    <h2 class="welcome__heading">Планировщик задач для управления своим рабочим днем</h2>
                    <h3 class="welcome__desc">Ваш гид в мире эффективного планирования рабочего времени!</h3>

                    <div class="welcome__links">
                        <a href="index.php" class="link-primary">Начать</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="about common-section">
            <div class="container">
                <div class="title-wrapper">
                    <h3 class="title">Функциональные возможности</h3>
                    <p class="subtitle">Копим ульту и показываем возможности!</p>
                </div>

                <div class="cards-wrapper">
                    <div class="card">
                        <img src="assets/images/planning.png" alt="icon">
                        <h4>Планирование задач</h4>
                        <p>Пользователи могут создавать свои собственные расписания, планировать свои задачи, события и дедлайны!</p>
                    </div>
                    <div class="card">
                        <img src="assets/images/project-management.png" alt="icon">
                        <h4>Разбиение проектов</h4>
                        <p>Пользователи могут разбивать проекты на задачи, а задачи - на подзадачи, упрощая планирования своего рабочего дня!</p>
                    </div>
                    <div class="card">
                        <img src="assets/images/sort1.png" alt="icon">
                        <h4>Удобная сортировка</h4>
                        <p>Пользователи могут сортировать задачи по разным критериям, упростив себе поиск необходимых данных!</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="services common-section common-section__dark">
            <div class="container">
                <div class="title-wrapper">
                    <h3 class="title">Преимущества</h3>
                    <p class="subtitle">Еще одна реальность покруче фантастики</p>
                </div>

                <div class="cards-wrapper">
                    <div class="card">
                        <img src="assets/images/service1.jpg" alt="icon">
                        <h4>Удобство использования</h4>
                        <p>Добро пожаловать в Worky✔, где удобство и простота превышают все ожидания. Наши интуитивно понятные интерфейсы и функции позволят вам максимально эффективно использовать наше приложение, не отвлекая вас от важнейших задач. Мы стремимся сделать ваш опыт использования максимально комфортным, поэтому вы можете быть уверены, что ваши действия не повлияют на приложение.</p>
                    </div>
                    <div class="card">
                        <img src="assets/images/service1.jpg" alt="icon">
                        <h4>Эффективность</h4>
                        <p>Мы знаем, что эффективность - это ключ к успеху. Поэтому мы используем современные алгоритмы и оптимизации производительности, чтобы обеспечить максимальную производительность приложения. Мы также автоматизируем рутинные задачи, чтобы вы могли сосредоточиться на более важных делах. Наше приложение работает быстро и надежно, поэтому вы можете достигать своих целей с минимальными усилиями.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer" id="footer">
        <div class="footer__desc">
            <div class="container footer__desc-container">
                <div class="footer__about">
                    <h4>О нас</h4>
                    <p>Наше веб-приложение - это инструмент для эффективного планирования рабочего дня. Мы помогаем пользователям организовывать свой день, разбивая проекты на задачи и подзадачи и устанавливая дедлайны. Наша цель - обеспечить максимальную продуктивность и эффективность рабочего процесса.</p>
                </div>

                <div class="footer__links">
                    <h4>Навигационное меню</h4>
                    <ul>
                        <li><a href="index.php">Рабочий стол</a></li>
                        <li><a href="categories/profile.php">Профиль</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer__copy">
            <div class="container">
                <p>Курсовая работа</p>
            </div>
        </div>
    </footer>
    
    <script src="assets/js/header.js"></script>
</body>

</html>