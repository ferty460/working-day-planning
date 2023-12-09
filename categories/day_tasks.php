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
    <title>Задачи на день | Worky✔</title>
</head>

<body>
    
    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $date = $_GET['day'];
    $year = explode('-', $date)[0];
    $month = getMonthName(explode('-', $date)[1]);
    $day = explode('-', $date)[2];
    $tasks = getTasksByDate($date, $_SESSION['user_id']);

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        die();
    }

    include "../blocks/header.php";
    ?>

    <main class="main">
        <section class="task__section">
            <h2 class="title" style="text-align: center;"> Задачи на <?php echo "$day $month $year"; ?> года</h2>
            <div class="flex">

                <!-------------------- TASKS -------------------->
                <div class="tasks">
                    <?php if (empty($tasks)) echo '<h3 style="font-size:18px;margin-top:1rem;text-align:center;">Задач нет</h3>'; ?>
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
                
            </div>
        </section>
    </main>

    <?php include "../blocks/footer.php" ?>

    <script src="../assets/js/header.js"></script>
</body>

</html>