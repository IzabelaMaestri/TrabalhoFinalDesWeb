<?php include_once 'app/views/partials/header.php'; ?>

<div class="container my-4">
  <div class="row">
    <!-- Cabeçalho -->
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2><i class="bi bi-lightbulb"></i> Disciplinas Sugeridas</h2>
          <p class="text-muted mb-0">
            Baseadas na popularidade e disponibilidade de materiais
          </p>
        </div>
        <div>
          <a href="?route=aluno/minhasDisciplinas" class="btn btn-outline-primary">
            <i class="bi bi-bookmark-check"></i> Minhas Disciplinas
          </a>
        </div>
      </div>
    </div>
  </div>

  <?php if (empty($disciplinasComEstatisticas)): ?>
  <!-- Estado vazio -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 bg-light text-center py-5">
        <div class="card-body">
          <i class="bi bi-check-circle display-1 text-success mb-3"></i>
          <h4 class="text-muted">Parabéns!</h4>
          <p class="text-muted mb-4">Você já selecionou todas as disciplinas disponíveis com materiais.</p>
          <a href="?route=aluno/minhasDisciplinas" class="btn btn-success">
            <i class="bi bi-bookmark-check"></i> Ver Minhas Disciplinas
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php else: ?>
  
  <!-- Algoritmo de sugestão -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-info">
        <div class="card-header bg-info text-white">
          <h6 class="mb-0"><i class="bi bi-info-circle"></i> Como funcionam as sugestões?</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <h6><i class="bi bi-graph-up text-primary"></i> Popularidade</h6>
              <p class="small mb-0">Disciplinas mais escolhidas por outros alunos</p>
            </div>
            <div class="col-md-4">
              <h6><i class="bi bi-collection text-success"></i> Materiais Disponíveis</h6>
              <p class="small mb-0">Quantidade e variedade de conteúdo</p>
            </div>
            <div class="col-md-4">
              <h6><i class="bi bi-people text-warning"></i> Professores Ativos</h6>
              <p class="small mb-0">Educadores que compartilham conteúdo</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Lista de sugestões -->
  <div class="row">
    <?php foreach ($disciplinasComEstatisticas as $index => $disciplina): ?>
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="card h-100 shadow-sm border-0 position-relative">
        <!-- Badge de ranking -->
        <div class="position-absolute top-0 start-0 translate-middle">
          <span class="badge bg-<?= $index < 3 ? ['danger', 'warning', 'info'][$index] : 'secondary' ?> rounded-circle" 
                style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center;">
            <?= $index + 1 ?>
          </span>
        </div>
        
        <div class="card-body pt-4">
          <!-- Título da disciplina -->
          <div class="text-center mb-3">
            <h5 class="card-title">
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
              $icon = $icons[$disciplina['disciplina']] ?? 'book';
              ?>
              <i class="bi bi-<?= $icon ?> text-primary me-2"></i>
              <?= ucfirst(str_replace('_', ' ', $disciplina['disciplina'])) ?>
            </h5>
          </div>
          
          <!-- Estatísticas -->
          <div class="row text-center mb-3">
            <div class="col-4">
              <div class="border-end">
                <h6 class="text-primary mb-1"><?= $disciplina['total_materiais'] ?></h6>
                <small class="text-muted">Materiais</small>
              </div>
            </div>
            <div class="col-4">
              <div class="border-end">
                <h6 class="text-success mb-1"><?= $disciplina['total_alunos'] ?></h6>
                <small class="text-muted">Alunos</small>
              </div>
            </div>
            <div class="col-4">
              <h6 class="text-warning mb-1"><?= count($disciplina['professores']) ?></h6>
              <small class="text-muted">Professores</small>
            </div>
          </div>
          
          <!-- Tipos de materiais -->
          <div class="mb-3">
            <h6 class="small text-muted mb-2">Tipos de Material:</h6>
            <div class="d-flex flex-wrap gap-1">
              <?php foreach (array_slice($disciplina['tipos_materiais'], 0, 3) as $tipo): ?>
                <span class="badge bg-light text-dark border">
                  <?php
                  $tiposNomes = [
                    'pdf' => 'PDF',
                    'video' => 'Vídeo', 
                    'link' => 'Link',
                    'apresentacao' => 'Slides',
                    'exercicio' => 'Exercícios'
                  ];
                  echo $tiposNomes[$tipo['tipo']] ?? ucfirst($tipo['tipo']);
                  ?>
                  (<?= $tipo['quantidade'] ?>)
                </span>
              <?php endforeach; ?>
            </div>
          </div>
          
          <!-- Professores -->
          <?php if (!empty($disciplina['professores'])): ?>
          <div class="mb-3">
            <h6 class="small text-muted mb-2">Professores:</h6>
            <div class="text-muted small">
              <?php foreach (array_slice($disciplina['professores'], 0, 2) as $prof): ?>
                <i class="bi bi-person-check me-1"></i><?= htmlspecialchars($prof) ?><br>
              <?php endforeach; ?>
              <?php if (count($disciplina['professores']) > 2): ?>
                <small class="text-muted">+<?= count($disciplina['professores']) - 2 ?> outros</small>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>
          
          <!-- Score de recomendação -->
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
              <small class="text-muted">Pontuação:</small>
              <div class="d-flex align-items-center">
                <?php $scorePercent = min(100, ($disciplina['score'] / 10) * 100); ?>
                <div class="progress me-2" style="width: 60px; height: 8px;">
                  <div class="progress-bar bg-success" style="width: <?= $scorePercent ?>%"></div>
                </div>
                <small class="text-success fw-bold"><?= number_format($disciplina['score'], 1) ?></small>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Ação -->
        <div class="card-footer bg-transparent border-0">
          <form method="POST" action="?route=aluno/escolherMaterias" class="d-grid">
            <input type="hidden" name="disciplinas[]" value="<?= $disciplina['disciplina'] ?>">
            <button type="submit" class="btn btn-outline-primary btn-sm">
              <i class="bi bi-plus-circle"></i> Adicionar Disciplina
            </button>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  
  <!-- Ação para ver todas -->
  <div class="row mt-4">
    <div class="col-12 text-center">
      <div class="card border-0 bg-light">
        <div class="card-body">
          <h6>Não encontrou o que procura?</h6>
          <p class="text-muted mb-3">Explore todas as disciplinas disponíveis e faça sua própria seleção.</p>
          <a href="?route=aluno/escolherMaterias" class="btn btn-primary">
            <i class="bi bi-grid"></i> Ver Todas as Disciplinas
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<script>
// Adicionar efeito hover nos cards
document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.card');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-5px)';
      this.style.transition = 'transform 0.3s ease';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
});
</script>

<?php include_once 'app/views/partials/footer.php'; ?>
