<header class="header">
    <nav class="navbar">
        <div class="container">

            <div class="navbar-header">
                <button class="navbar-toggler" data-toggle="open-navbar1">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <a href="#">
                    <h4>Worky<span>✔</span></h4>
                </a>
            </div>

            <div class="navbar-menu" id="open-navbar1">
                <ul class="navbar-nav">
                    <li class="active"><a href="../index.php">Рабочий стол</a></li>
                    <li class="navbar-dropdown">
                        <a href="#" class="dropdown-toggler" data-dropdown="my-dropdown-id">
                            Мои папки <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown" id="my-dropdown-id">
                            <li><a href="#">Actions</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="separator"></li>
                            <li><a href="#">Seprated link</a></li>
                            <li class="separator"></li>
                            <li><a href="#">One more seprated link.</a></li>
                        </ul>
                    </li>
                    <li><a href="../categories/profile.php">Профиль</a></li>
                    <li>
                        <a href="#">
                            <form action="../functions/do_logout.php" method="post"><button type="submit">Выйти</button></form>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>