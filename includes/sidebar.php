        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                    ☰
                </button>
                <span class="navbar-brand mb-0 h1">Todo List</span>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start text-white rounded-end" tabindex="-1" id="sidebar" style="--bs-offcanvas-width: 220px; background-color: #2b3035;">
            <div class="offcanvas-body d-flex flex-column justify-content-between">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="home.php?filter=today">Tarefas para Hoje</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="home.php?filter=overdue">Atrasadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="home.php?filter=completed">Concluidas</a>
                    </li>
                </ul>

                <div class="border-top p-3 mt-3 d-flex justify-content-between align-items-center">
                    <div>Olá, <?= htmlspecialchars($_SESSION['user']['nome'] ?? '') ?></div>
                    <form action="home.php" method="post">
                        <button type="submit" name="logout" class="btn btn-sm text-danger">Sair</button>
                    </form>
                    
                </div>
            </div>
        </div>