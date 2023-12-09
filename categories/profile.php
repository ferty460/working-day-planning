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
            <div class="flex">

                <!-------------------- PROFILE DETAILS -------------------->
                <div class="profile">
                    <img src="../assets/images/profile.svg" alt="profile" class="profile-img">
                    <div class="user-details">
                        <h4 class="username"><?php echo $_SESSION['user_surname']; ?></h4>
                        <h4 class="name_details"><?php echo $_SESSION['user_name'] . ' ' . $_SESSION['user_lastname'];  ?></h4>
                        <h5 class="email"><?php echo $_SESSION['user_email'] ?></h5>
                    </div>
                </div>

                <div class="title__block">
                    <?php if ($_SESSION['user_role'] === 'admin') { ?>
                        <!-------------------- EMPLOYERS -------------------->
                        <form action="../functions/add_employee.php" method="post" id="myForm">
                            <div>
                                <select onchange="document.getElementById('myForm').submit()" name="user_id">
                                    <option>--Добавить работника--</option>
                                    <?php foreach ($users as $user) {
                                        echo '<option value="' . $user['id'] . '">' . $user['surname'] . ' ' . $user['name'] . ' ' . $user['lastname'] . '</option>';
                                    } ?>
                                </select>
                                <input type="hidden" name="my_id" value="<?php echo $_SESSION['user_id']; ?>">
                            </div>
                        </form>

                        <!-------------------- TASKS -------------------->
                        <div>
                            <h3 class="title" style="margin-left: 0; padding-left: 0;">Мои подписечники</h3>
                            <?php
                            if (empty($employees)) echo "<p>Работников нет</p>";
                            else {
                                foreach ($employees as $employee) { ?>
                                    <p><?php echo $employee['surname'] . ' ' . $employee['name'] . ' ' . $employee['lastname']; ?></p>
                            <?php }} ?>
                        </div>
                    <?php } ?>

                    <?php if ($_SESSION['user_role'] === 'user') { ?>
                        <div>
                            <h3 class="title" style="margin-left: 0; padding-left: 0;">Мой работодатель</h3>
                            <p>
                                <?php
                                if (empty($employer)) echo "Работодателя нет";
                                else echo $employer['surname'] . ' ' . $employer['name'] . ' ' . $employer['lastname'];
                                ?>
                            </p>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </section>
    </main>

    <?php include "../blocks/footer.php" ?>

    <script src="../assets/js/header.js"></script>
</body>

</html>