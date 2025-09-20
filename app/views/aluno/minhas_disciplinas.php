<?php include_once 'app/views/partials/header.php'; ?>

<div class="container my-4">
  <!-- Mensagens -->
  <?php 
  $msg = $_GET['msg'] ?? '';
  $erro = $_GET['erro'] ?? '';
  $disciplina = $_GET['disciplina'] ?? '';
  ?>
  
  <?php if ($msg === 'materia_removida'): ?>
  <div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle me-2"></i>
    <strong>Disciplina removida!</strong> <?= ucfirst(str_replace('_', ' ', $disciplina)) ?> foi removida com sucesso.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <?php elseif ($erro): ?>
  <div class="alert alert-danger alert-dismissible fade show">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>Erro!</strong> 
    <?php
    switch($erro) {
      case 'erro_remocao': echo 'Não foi possível remover a disciplina.'; break;
      case 'disciplina_invalida': echo 'Disciplina inválida.'; break;
      default: echo 'Ocorreu um erro inesperado.';
    }
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <?php endif; ?>

  <div class="row">
    <!-- Cabeçalho -->
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2><i class="bi bi-bookmark-check"></i> Minhas Disciplinas</h2>
          <p class="text-muted mb-0">
            Gerencie as disciplinas que você está estudando
            <span class="badge bg-primary ms-2"><?= count($disciplinas) ?> selecionadas</span>
          </p>
        </div>
        <div>
          <a href="?route=aluno/escolherMaterias" class="btn btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Adicionar Disciplinas
          </a>
        </div>
      </div>
    </div>
  </div>

  <?php if (empty($disciplinas)): ?>
  <!-- Estado vazio -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 bg-light text-center py-5">
        <div class="card-body">
          <i class="bi bi-book display-1 text-muted mb-3"></i>
          <h4 class="text-muted">Nenhuma disciplina selecionada</h4>
          <p class="text-muted mb-4">Comece selecionando as matérias que você está estudando para receber materiais personalizados.</p>
          <a href="?route=aluno/escolherMaterias" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Escolher Disciplinas
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php else: ?>
  <!-- Lista de disciplinas -->
  <div class="row">
    <?php foreach ($disciplinas as $disc): ?>
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="flex-grow-1">
              <h5 class="card-title mb-2">
                <?php
                $icons = [
                  'matematica' => 'calculator',
                  'fisica' => 'lightning', 
                  'quimica' => 'flask',
                  'historia' => 'clock-history',
                  'geografia' => 'globe',
                  'filosofia' => 'lightbulb',
                  'sociologia' => 'people',
                  'portugues' => 'chat-text',
                  'ingles' => 'translate',
                  'espanhol' => 'chat-square-text',
                  'biologia' => 'tree',
                  'ciencias' => 'microscope',
                  'educacao_fisica' => 'bicycle',
                  'artes' => 'palette',
                  'musica' => 'music-note-beamed'
                ];
                $icon = $icons[$disc['disciplina']] ?? 'book';
                ?>
                <i class="bi bi-<?= $icon ?> text-primary me-2"></i>
                <?= ucfirst(str_replace('_', ' ', $disc['disciplina'])) ?>
              </h5>
              <div class="d-flex align-items-center text-muted mb-2">
                <i class="bi bi-calendar3 me-1"></i>
                <small>Adicionada em <?= date('d/m/Y', strtotime($disc['created_at'])) ?></small>
              </div>
            </div>
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="?route=aluno/meusMateriais&disciplina=<?= urlencode($disc['disciplina']) ?>">
                    <i class="bi bi-eye"></i> Ver Materiais
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <button class="dropdown-item text-danger" onclick="removerDisciplina('<?= $disc['disciplina'] ?>')">
                    <i class="bi bi-trash"></i> Remover
                  </button>
                </li>
              </ul>
            </div>
          </div>
          
          <!-- Estatísticas -->
          <div class="row text-center">
            <div class="col-6">
              <div class="border-end">
                <h6 class="text-primary mb-1"><?= $materiaisPorDisciplina[$disc['disciplina']] ?? 0 ?></h6>
                <small class="text-muted">Materiais</small>
              </div>
            </div>
            <div class="col-6">
              <h6 class="text-success mb-1">
                <?php
                // Simular materiais acessados (em produção, vir do banco)
                echo rand(0, $materiaisPorDisciplina[$disc['disciplina']] ?? 0);
                ?>
              </h6>
              <small class="text-muted">Acessados</small>
            </div>
          </div>
        </div>
        
        <!-- Ações rápidas -->
        <div class="card-footer bg-transparent border-0">
          <div class="d-grid gap-2">
            <a href="?route=aluno/meusMateriais&disciplina=<?= urlencode($disc['disciplina']) ?>" 
               class="btn btn-sm btn-outline-primary">
              <i class="bi bi-book"></i> Ver Materiais
            </a>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Ações em lote -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card border-warning">
        <div class="card-header bg-warning text-dark">
          <h6 class="mb-0"><i class="bi bi-tools"></i> Ações Rápidas</h6>
        </div>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h6>Gerenciar todas as disciplinas</h6>
              <p class="text-muted mb-0">
                Você pode adicionar novas disciplinas ou reorganizar suas seleções a qualquer momento.
              </p>
            </div>
            <div class="col-md-4 text-end">
              <a href="?route=aluno/escolherMaterias" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> Editar Seleções
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<!-- Modal de confirmação para remoção -->
<div class="modal fade" id="modalRemover" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="bi bi-exclamation-triangle"></i> Remover Disciplina
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Tem certeza que deseja remover a disciplina <strong id="disciplinaNome"></strong>?</p>
        <div class="alert alert-warning">
          <i class="bi bi-info-circle"></i>
          <strong>Nota:</strong> Você não receberá mais materiais desta disciplina, mas pode readicioná-la a qualquer momento.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle"></i> Cancelar
        </button>
        <form method="POST" action="?route=aluno/removerMateria" class="d-inline">
          <input type="hidden" name="disciplina" id="disciplinaRemover">
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Sim, Remover
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function removerDisciplina(disciplina) {
  const disciplinaNome = disciplina.charAt(0).toUpperCase() + disciplina.slice(1).replace('_', ' ');
  document.getElementById('disciplinaNome').textContent = disciplinaNome;
  document.getElementById('disciplinaRemover').value = disciplina;
  
  const modal = new bootstrap.Modal(document.getElementById('modalRemover'));
  modal.show();
}

// Auto-hide alerts
setTimeout(function() {
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    if (alert.querySelector('.btn-close')) {
      alert.style.transition = 'opacity 0.5s';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 500);
    }
  });
}, 5000);
</script>

<?php include_once 'app/views/partials/footer.php'; ?>
