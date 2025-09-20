<div class="container my-4">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
          <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
               style="width: 60px; height: 60px; font-size: 24px;">
            <?= strtoupper(substr($aluno['nome'], 0, 2)) ?>
          </div>
          <div>
            <h2><?= htmlspecialchars($aluno['nome']) ?></h2>
            <p class="text-muted mb-0">
              <i class="bi bi-envelope"></i> <?= htmlspecialchars($aluno['email']) ?>
            </p>
            <small class="text-muted">
              <i class="bi bi-calendar"></i> 
              Cadastrado em <?= date('d/m/Y', strtotime($aluno['created_at'])) ?>
            </small>
          </div>
        </div>
        <div class="btn-group">
          <a href="?route=professor/gerenciarAlunos" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
          </a>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGerenciarMaterias">
            <i class="bi bi-gear"></i> Gerenciar Matérias
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Estatísticas do Aluno -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card bg-primary text-white">
        <div class="card-body text-center">
          <h4><?= count($materias) ?></h4>
          <small>Total de Matérias</small>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-success text-white">
        <div class="card-body text-center">
          <h4><?= $totalAcessos ?></h4>
          <small>Acessos Recentes</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Lista de Matérias do Aluno -->
  <div class="card mb-4">
    <div class="card-body">
      <h4 class="mb-3">Matérias Vinculadas</h4>
      <?php if (!empty($materias)): ?>
        <ul class="list-group">
          <?php foreach ($materias as $materia): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($materia['nome']) ?>
              <a href="?route=professor/removerMateriaAluno&aluno_id=<?= $aluno['id'] ?>&materia_id=<?= $materia['id'] ?>" 
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Remover esta matéria do aluno?')">
                Remover
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="alert alert-info">Nenhuma matéria vinculada a este aluno.</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Atividade Recente -->
  <div class="card mb-4">
    <div class="card-body">
      <h4 class="mb-3">Atividade Recente</h4>
      <?php if (!empty($acessos)): ?>
        <ul class="list-group">
          <?php foreach ($acessos as $acesso): ?>
            <li class="list-group-item">
              <?= htmlspecialchars($acesso['titulo']) ?> 
              <small class="text-muted">(<?= date('d/m/Y H:i', strtotime($acesso['data_acesso'])) ?>)</small>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="alert alert-info">Nenhuma atividade registrada.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Modal Gerenciar Matérias -->
<div class="modal fade" id="modalGerenciarMaterias" tabindex="-1" aria-labelledby="modalGerenciarMateriasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="?route=professor/adicionarMateriaAluno">
        <div class="modal-header">
          <h5 class="modal-title" id="modalGerenciarMateriasLabel">Adicionar Matéria ao Aluno</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="aluno_id" value="<?= $aluno['id'] ?>">
          <div class="mb-3">
            <label for="materia_id" class="form-label">Selecione a Matéria</label>
            <select class="form-select" id="materia_id" name="materia_id" required>
              <?php foreach ($todasMaterias as $m): ?>
                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Adicionar</button>
        </div>
      </form>
    </div>
  </div>
</div>