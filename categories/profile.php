<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/media.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title>Профиль | Worky✔</title>
</head>

<body>
    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $tasks = getAllTasks();

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        die();
    }
    ?>
    <?php include "../blocks/header.php" ?>
    <main class="main">
        <section class="task__section">
            <div class="flex">
                <div class="profile">
                    <img src="../assets/images/profile.svg" alt="profile" class="profile-img">
                    <div class="user-details">
                        <h4 class="username"><?php echo $_SESSION['user_name'] ?></h4>
                        <h5 class="email"><?php echo $_SESSION['user_email'] ?></h5>
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
            </div>
        </section>
    </main>
    
    <script src="../assets/js/header.js"></script>
</body>

</html>