<?php include_once 'app/views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= htmlspecialchars($material['titulo']) ?></h4>
                    <span class="badge bg-primary"><?= htmlspecialchars($material['materia']) ?></span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <strong>Tipo:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?php
                            $iconTypes = [
                                'pdf' => 'file-pdf text-danger',
                                'video' => 'play-circle text-primary',
                                'link' => 'globe text-info',
                                'apresentacao' => 'file-earmark-slides text-warning',
                                'exercicio' => 'list-check text-success'
                            ];
                            $icon = $iconTypes[$material['tipo']] ?? 'file-text text-muted';
                            ?>
                            <i class="bi bi-<?= $icon ?>"></i> 
                            <?= ucfirst($material['tipo']) ?>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <strong>Nível:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge bg-info"><?= htmlspecialchars($material['nivel']) ?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <strong>Descrição:</strong>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0"><?= nl2br(htmlspecialchars($material['descricao'])) ?></p>
                        </div>
                    </div>
                    
                    <?php if ($material['link']): ?>
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <strong>Link:</strong>
                        </div>
                        <div class="col-sm-9">
                            <a href="<?= htmlspecialchars($material['link']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-up-right"></i> Acessar Link
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($material['arquivo']): ?>
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <strong>Arquivo:</strong>
                        </div>
                        <div class="col-sm-9">
                            <a href="public/uploads/<?= htmlspecialchars($material['arquivo']) ?>" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-download"></i> Baixar Arquivo
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <strong>Criado em:</strong>
                        </div>
                        <div class="col-sm-9">
                            <small class="text-muted">
                                <?= date('d/m/Y H:i', strtotime($material['created_at'] ?? 'now')) ?>
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <button onclick="history.back()" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </button>
                        
                        <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'educador'): ?>
                        <div>
                            <a href="?route=material/form&id=<?= $material['id'] ?>" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <button onclick="excluirMaterial(<?= $material['id'] ?>)" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Excluir
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function excluirMaterial(id) {
    if (confirm('Tem certeza que deseja excluir este material?')) {
        fetch(`?route=material/excluir&id=${id}`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Material excluído com sucesso!');
                    window.location.href = '?route=material/meus';
                } else {
                    alert('Erro ao excluir material');
                }
            });
    }
}
</script>

<?php include_once 'app/views/partials/footer.php'; ?>
