<?php
    require_once 'controller/loginController.php';
    require_once 'controller/taskController.php';

    $auth = new AuthController();

    if (!$auth->logged()) {
        header("Location: login.php");
        exit;
    }

    if (isset($_POST['logout'])) {
        $auth->logout();
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['user']['id'];

    $task = new TaskController();

    if (isset($_POST['task_action'])) {
        $id = $_POST['id'] ?? null;
        $title = htmlspecialchars_decode($_POST['title']) ?? '';
        $description = htmlspecialchars_decode($_POST['description']) ?? '';
        $due_date = empty($_POST['due_date']) ? null : $_POST['due_date'] ?? null;

        if ($_POST['task_action'] === 'add') {
            if ($due_date) {
                $datetime = new DateTime($due_date);
                $due_date = $datetime->format('Y-m-d H:i:s');
            }

            $task->novaTarefa($title, $description, $due_date, $user_id);
        }
        else if ($_POST['task_action'] === 'edit') {
            if (isset($_POST['delete']))
            {
                $task->excluirTarefa($id);
            }
            else if (isset($_POST['make_done']))
            {
                $task->concluirTarefa($id);
            }
            else {
                $task->editarTarefa($id, $title, $description, $due_date);
            }

        }

    }

    $action = $_GET['m'] ?? null;
    $idTarefa = $_GET['id'] ?? null;
    $showModal = in_array($action, ['add', 'edit']);

    if ($action && $idTarefa) {
        $editTask = $task->getUserTask($idTarefa, $user_id);
    }

    $tasks = $task->getUserTasks($_SESSION['user']['id'], $_GET['filter'] ?? null);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <title>Home</title>
    </head>
    <body class="bg-light">
        <?php include 'includes/sidebar.php'; ?>

        <div class="container py-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 align-items-stretch justify-content-center">
            <div class="col">
            <a href="?m=add" class="text-decoration-none text-secondary">
                <div class="card h-100 border-secondary border-2 border-dashed bg-light bg-opacity-50 text-center">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title fw-semibold">Nova Tarefa</h5>
                    <p class="card-text small">Clique aqui para adicionar uma nova tarefa.</p>
                </div>
                </div>
            </a>
            </div>

            <?php foreach ($tasks as $_task): ?>
            <div class="col">
                <a href="home.php?m=edit&id=<?= $_task['id'] ?>" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2 text-capitalize"><?= htmlspecialchars($_task['title']) ?></h5>
                        <p class="card-text text-muted small mb-3 flex-grow-1"><?= htmlspecialchars($_task['description']) ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end d-flex flex-row justify-content-between">
                        <small class="text-<?= $_task['completed'] ? 'success' : 'warning' ?>">
                        <?= $_task['completed'] ? 'Concluida' : 'Pendente' ?>
                        </small>
                        <small class="text-muted">
                        <?= $_task['due_date'] ? date('d/m H:i', strtotime($_task['due_date'])) : 'Sem prazo' ?>
                        </small>
                    </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        </div>

        <?php include 'includes/modal.php'; ?>

        <?php if ($showModal): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = new bootstrap.Modal(document.getElementById('tarefaModal'));
                    modal.show();
                });
            </script>
        <?php endif; ?>
    </body>
</html>