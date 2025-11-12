<?php
require_once 'controller/loginController.php';

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $senha = $_POST['senha'] ?? null;
    
    try {
        if ($auth->login($email, $senha)) {
            header("Location: index.php");
            exit;
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <title>Login</title>
    </head>
    <body>
        <div class="container-fluid bg-light min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100">
                <div class="p-5 rounded shadow col-xxl-3 col-xl-5 col-lg-5 col-md-7 col-sm-9 bg-white">
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <button type="submit" class="btn btn-primary w-100 mb-2">Entrar</button>
                            <a href="register.php"  class="btn btn-link">Não tem uma conta?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>