        <div class="modal fade" id="tarefaModal" tabindex="-1" aria-labelledby="tarefaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="home.php">
                        <input type="text" hidden name="task_action" value="<?= $action ?>">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tarefaModalLabel">
                                <?= $action === 'edit' ? 'Editar Tarefa' : 'Nova Tarefa' ?>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <?php if ($action === 'edit'): ?>
                                <input type="hidden" name="id" value="<?= htmlspecialchars($editTask['id']) ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="title" class="form-label">Título</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="<?= htmlspecialchars($editTask['title'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($editTask['description'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="due-date" class="form-label">Data de entrega</label>
                                <input type="datetime-local" class="form-control" id="due_date" name="due_date"
                                    value="<?= htmlspecialchars($editTask['due_date'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?php if ($action === 'edit'): ?>
                                <button type="submit" name="delete" class="btn btn-danger">Excluir Tarefa</button>
                                <?php if ($editTask['completed'] === 0): ?>
                                    <button type="submit" name="make_done" class="btn btn-outline-primary mt-auto">Marcar como concluída</button>
                                <?php endif; ?>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary">
                                <?= $action === 'edit' ? 'Salvar Alterações' : 'Salvar Tarefa' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>