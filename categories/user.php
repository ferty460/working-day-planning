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
    <title>Профиль | Worky✔</title>
</head>

<body>

    <?php
    require_once '../functions/db/boot.php';

    $user = null;
    $users = getUserList();
    $employees = empty(getEmployeesList($_SESSION['user_id'])) ? null : getEmployeesList($_SESSION['user_id']);
    $employer = empty(getEmployerById($_SESSION['user_id'])) ? null : getEmployerById($_SESSION['user_id']);

    $employeeId = $_GET['id'];
    $employee = getUserById($employeeId);
    $groups = getGroupsByUser($employeeId);

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
            <div class="flex">

                <!-------------------- PROFILE DETAILS -------------------->
                <div class="profile">
                    <img src="../assets/images/profile.svg" alt="profile" class="profile-img">
                    <div class="user-details">
                        <h4 class="username"><?php echo $employee['surname']; ?></h4>
                        <h4 class="name_details"><?php echo $employee['name'] . ' ' . $employee['lastname'];  ?></h4>
                        <h5 class="email"><?php echo $employee['email'] ?></h5>
                    </div>
                </div>

                <div class="title__block">
                    <!-------------------- GROUPS -------------------->
                    <div>
                        <h3 class="title" style="margin-left: 0; padding-left: 0;">Группы</h3>
                        <?php
                        if (empty($groups)) echo "<p>Групп нет</p>";
                        else {
                            foreach ($groups as $group) {
                                echo '<a href="group.php?id=' . $group['id'] . '">';
                                echo '<div class="task task__normal">'; // high | normal | low | done
                                echo '<div class="details__task"><h4 class="theme__task">' . $group['theme'] . '</h4>';
                                echo '<p class="description__task">' . $group['description'] . '</p></div></div></a>';
                            }
                        } ?>
                    </div>

                    <!-------------------- EMPLOYEES -------------------->
                    
                </div>

            </div>
        </section>
    </main>

    <?php include "../blocks/footer.php" ?>

    <script src="../assets/js/header.js"></script>
</body>

</html>