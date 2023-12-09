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
    <title>Группа | Worky✔</title>
</head>

<body>

    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $groupId = $_GET['id'];
    $group = getGroupById($groupId);
    $employees = empty(getEmployeesList($_SESSION['user_id'])) ? null : getEmployeesList($_SESSION['user_id']);
    $usersInGroup = empty(getUsersFromGroup($groupId)) ? null : getUsersFromGroup($groupId);

    if (check_auth()) {
        $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        die();
    }

    if ($_SESSION['user_role'] !== 'admin') {
        header("Location: ../work.php");
    }

    include "../blocks/header.php";
    ?>

    <main class="main">
        <section class="task__section">

            <!-------------------- HEAD -------------------->
            <div class="title__block">
                <div style="display: flex; justify-content: space-between;">
                    <h1 class="title">Группа</h1>
                    <form action="../functions/delete_group.php" method="post">
                        <input type="hidden" name="group_id" value="<?php echo $groupId ?>">
                        <input type="submit" value="Удалить" class="delete">
                    </form>
                </div>
                <hr class="line">
            </div>
            <div class="flex">

                <!-------------------- FORM TO EDIT -------------------->
                <form action="../functions/edit_group.php" method="post">
                    <div class="theme-description">
                        <img src="../assets/images/group.png" alt="folder" class="folder-img">
                        <input type="text" name="theme" placeholder="Тема группы" value="<?php echo $group['theme'] ?>" required>
                        <textarea name="description" placeholder="Описание"><?php echo $group['description'] ?></textarea>
                        <div class="block-buttons">
                            <div class="buttons" style="justify-content:left;">
                                <input type="hidden" name="groupId" value="<?php echo $groupId; ?>">
                                <input type="submit" value="Сохранить" class="ok" style="margin-left: 0rem;">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="options-tasks">

                    <!-------------------- OPTIONAL PANEL -------------------->
                    <div class="options">
                        <div class="dropdown">
                            <form action="../functions/user_to_group.php" method="post" id="myForm">
                                <input type="hidden" name="group_id" value="<?php echo $groupId; ?>">
                                <select onchange="document.getElementById('myForm').submit()" name="user_id">
                                    <option>--Добавить работника--</option>
                                    <?php foreach ($employees as $employee) {
                                        echo '<option value="' . $employee['id'] . '">' . $employee['surname'] . ' ' . $employee['name'] . ' ' . $employee['lastname'] . '</option>';
                                    } ?>
                                </select>
                            </form>
                        </div>

                    </div>

                    <!-------------------- TASKS -------------------->
                    <div class="tasks folder-tasks">
                        <?php
                        if (!empty($usersInGroup)) {
                            foreach ($usersInGroup as $user) {
                                echo '<a href="user.php?id=' . $user['id'] . '">';
                                echo '<div class="task task__low">'; // high | normal | low | done
                                echo '<div class="details__task"><h4 class="theme__task">' . $user['name'] . ' ' . $user['surname'] . ' ' . $user['lastname'] . '</h4>';
                                echo '<p class="description__task">' . $user['email'] . '</p></div></div></a>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include "../blocks/footer.php" ?>

    <script src="../assets/js/header.js"></script>
</body>

</html>