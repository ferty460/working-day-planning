<?php

require_once '../functions/db/boot.php';
$folders = getAllFolders();

?>

<header class="header">
    <nav class="navbar">
        <div class="container">

            <div class="navbar-header">
                <button class="navbar-toggler" data-toggle="open-navbar1">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <a href="../main.php">
                    <h4>Worky<span>✔</span></h4>
                </a>
            </div>

            <div class="navbar-menu" id="open-navbar1">
                <ul class="navbar-nav">
                    <?php if ($_SESSION['user_id'] != null) { ?>
                        <li><a href="../index.php">Рабочий стол</a></li>
                        <li class="navbar-dropdown">
                            <a href="#" class="dropdown-toggler" data-dropdown="my-dropdown-id">
                                Мои папки <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown" id="my-dropdown-id">
                                <?php if (empty($folders)) echo '<li><a href="#">Папок нет</a></li>'; ?>
                                <?php foreach ($folders as $folder) {
                                    echo '<li><a href="../categories/folder.php?id=' . $folder['id'] . '">' . $folder['theme'] . '</a></li>';
                                } ?>
                            </ul>
                        </li>
                        <li><a href="../categories/profile.php">Профиль</a></li>
                        <li>
                            <a href="#">
                                <form action="../functions/do_logout.php" method="post"><button type="submit">Выйти</button></form>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li><a href="../categories/login.php">Войти</a></li>
                        <li><a href="../categories/registration.php">Зарегистрироваться</a></li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </nav>
</header>