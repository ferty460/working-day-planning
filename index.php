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
    <?php include "blocks/header.php" ?>

    <main class="main">
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
                    <div class="add__folder">
                        <h3>Мои папки</h3>
                        <p>+</p>
                    </div>
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

        <section class="content">
            <div class="option__panel">
                <hr class="hr">
                <div class="options">
                    <a href="#" class="add__task">+ Добавить задачу</a>
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
        </section>
    </main>

    <script src="assets/js/calendar.js"></script>
</body>

</html>