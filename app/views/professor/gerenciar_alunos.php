<div class="container my-4">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2><i class="bi bi-people"></i> Gerenciar Alunos</h2>
          <p class="text-muted mb-0">Administre as matérias e progresso dos seus alunos</p>
        </div>
        <div class="btn-group">
          <a href="?route=professor/dashboard" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
          </a>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarMateria">
            <i class="bi bi-plus-circle"></i> Adicionar Matéria
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Estatísticas Gerais -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card bg-primary text-white">
        <div class="card-body text-center">
          <h4><?= count($alunos) ?></h4>
          <small>Total de Alunos</small>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-success text-white">
        <div class="card-body text-center">
          <h4><?= count(array_filter($alunos, function($a) { return $a['total_materias'] > 0; })) ?></h4>
          <small>Alunos Ativos</small>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-info text-white">
        <div class="card-body text-center">
          <h4><?= array_sum(array_column($alunos, 'total_materias')) ?></h4>
          <small>Total de Matérias Vinculadas</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Lista de Alunos -->
  <div class="card">
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Matérias</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($alunos as $aluno): ?>
            <tr>
              <td><?= htmlspecialchars($aluno['nome']) ?></td>
              <td><?= htmlspecialchars($aluno['email']) ?></td>
              <td><?= htmlspecialchars($aluno['total_materias']) ?></td>
              <td>
                <a href="?route=professor/detalhesAluno&id=<?= $aluno['id'] ?>" class="btn btn-sm btn-info">Detalhes</a>
                <a href="?route=professor/removerMateriaAluno&id=<?= $aluno['id'] ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Tem certeza que deseja remover todas as matérias deste aluno?')">Remover</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Adicionar Matéria -->
<div class="modal fade" id="modalAdicionarMateria" tabindex="-1" aria-labelledby="modalAdicionarMateriaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="?route=professor/adicionarMateriaAluno">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAdicionarMateriaLabel">Adicionar Matéria ao Aluno</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="aluno_id" class="form-label">Selecione o Aluno</label>
            <select class="form-select" id="aluno_id" name="aluno_id" required>
              <?php foreach ($alunos as $aluno): ?>
                <option value="<?= $aluno['id'] ?>"><?= htmlspecialchars($aluno['nome']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="materia_id" class="form-label">Selecione a Matéria</label>
            <select class="form-select" id="materia_id" name="materia_id" required>
              <?php foreach ($materias as $m): ?>
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