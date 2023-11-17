<?php

require_once __DIR__.'/db/boot.php';

$_SESSION['user_id'] = null;
header('Location: ../categories/login.php');