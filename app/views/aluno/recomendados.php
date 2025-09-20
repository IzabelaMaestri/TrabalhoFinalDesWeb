<div class="container mt-4">
    <h2>Materiais Recomendados</h2>

    <?php if (!empty($recomendados)): ?>
        <div class="row">
            <?php foreach ($recomendados as $material): ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($material['titulo']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($material['descricao']) ?></p>
                            <span class="badge bg-info"><?= htmlspecialchars($material['materia']) ?></span>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="?route=material/visualizar&id=<?= $material['id'] ?>" class="btn btn-sm btn-success">Visualizar</a>
                            <a href="?route=aluno/favoritar&id=<?= $material['id'] ?>" class="btn btn-sm btn-warning">Favoritar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Nenhum material recomendado no momento.</div>
    <?php endif; ?>
</div>