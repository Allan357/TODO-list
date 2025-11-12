<?php
    require_once 'controller/loginController.php';

    $auth = new AuthController();

    if (!$auth->logged()) {
        header("Location: login.php");
        exit;
    }
    echo "Olá " . $_SESSION['user']['nome'] . "!";

    if (isset($_GET['sair'])) {
        $auth->logout();
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logado página teste</title>
</head>
<body>
    <form action="">
        <button type="submit" name="sair">Sair</button>
    </form>
</body>
</html>