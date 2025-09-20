<div class="container mt-4">
    <h2>Matérias Disponíveis</h2>

    <?php if (!empty($materias)): ?>
        <ul class="list-group">
            <?php foreach ($materias as $materia): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($materia['nome']) ?>
                    <a href="?route=aluno/adicionarMateria&id=<?= $materia['id'] ?>" class="btn btn-sm btn-primary">Selecionar</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-info">Nenhuma matéria disponível.</div>
    <?php endif; ?>
</div>