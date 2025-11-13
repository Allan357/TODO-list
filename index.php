<?php
    require_once 'controller/loginController.php';

    $auth = new AuthController();

    if (!$auth->logged()) {
        header("Location: login.php");
        exit;
    }

    header("Location: home.php");
    exit;
?>