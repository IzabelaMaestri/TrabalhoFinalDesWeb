<div class="container my-4">
  <div class="row">
    <!-- Cabeçalho de boas-vindas -->
    <div class="col-12">
      <div class="card bg-success text-white mb-4">
        <div class="card-body">
          <h2><i class="bi bi-person-workspace"></i> Bem-vindo, Prof. <?= htmlspecialchars($nome ?? 'Professor') ?>!</h2>
          <p class="mb-0">Gerencie seus materiais e acompanhe o progresso dos seus alunos.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Cards de estatísticas -->
    <div class="col-md-3 mb-4">
      <div class="card text-center h-100">
        <div class="card-body">
          <i class="bi bi-files fs-1 text-primary"></i>
          <h4 class="card-title">Materiais</h4>
          <h2 class="text-primary"><?= $materiaisPublicados ?></h2>
          <p class="card-text">Publicados</p>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card text-center h-100">
        <div class="card-body">
          <i class="bi bi-people fs-1 text-success"></i>
          <h4 class="card-title">Alunos</h4>
          <h2 class="text-success"><?= $alunosConectados ?></h2>
          <p class="card-text">Conectados</p>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card text-center h-100">
        <div class="card-body">
          <i class="bi bi-eye fs-1 text-warning"></i>
          <h4 class="card-title">Visualizações</h4>
          <h2 class="text-warning"><?= $visualizacoesMes ?></h2>
          <p class="card-text">Este mês</p>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card text-center h-100">
        <div class="card-body">
          <i class="bi bi-star fs-1 text-info"></i>
          <h4 class="card-title">Avaliação</h4>
          <h2 class="text-info"><?= $avaliacaoMedia ?></h2>
          <p class="card-text">Média</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Materiais mais acessados -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5><i class="bi bi-graph-up"></i> Materiais Mais Acessados</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Material</th>
                  <th>Disciplina</th>
                  <th>Acessos</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <strong>Introdução à Álgebra</strong><br>
                    <small class="text-muted">PDF • 2.3 MB</small>
                  </td>
                  <td><span class="badge bg-primary">Matemática</span></td>
                  <td><span class="badge bg-success">89</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info">
                      <i class="bi bi-eye"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Revolução Francesa</strong><br>
                    <small class="text-muted">Vídeo • 45 min</small>
                  </td>
                  <td><span class="badge bg-warning">História</span></td>
                  <td><span class="badge bg-success">67</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info">
                      <i class="bi bi-eye"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Células e DNA</strong><br>
                    <small class="text-muted">Apresentação • 1.8 MB</small>
                  </td>
                  <td><span class="badge bg-info">Biologia</span></td>
                  <td><span class="badge bg-success">54</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info">
                      <i class="bi bi-eye"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Ações rápidas -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h5><i class="bi bi-lightning-fill"></i> Ações Rápidas</h5>
        </div>
        <div class="card-body">
          <div class="d-grid gap-3">
            <a href="?route=material/cadastro" class="btn btn-primary">
              <i class="bi bi-plus-circle me-2"></i>Novo Material
            </a>
            <a href="?route=material/meus" class="btn btn-success">
              <i class="bi bi-files me-2"></i>Meus Materiais
            </a>
            <a href="?route=professor/gerenciarAlunos" class="btn btn-info">
              <i class="bi bi-people me-2"></i>Gerenciar Alunos
            </a>
            <a href="?route=professor/graficos" class="btn btn-warning">
              <i class="bi bi-graph-up me-2"></i>Relatórios
            </a>
          </div>
        </div>
      </div>

      <!-- Atividade recente -->
      <div class="card mt-3">
        <div class="card-header">
          <h6><i class="bi bi-clock-history"></i> Atividade Recente</h6>
        </div>
        <div class="card-body">
          <div class="list-group list-group-flush">
            <div class="list-group-item px-0">
              <small class="text-muted">Há 2 horas</small><br>
              <strong>Maria Silva</strong> acessou "Equações 2º Grau"
            </div>
            <div class="list-group-item px-0">
              <small class="text-muted">Há 4 horas</small><br>
              <strong>João Santos</strong> baixou "Lista de Exercícios"
            </div>
            <div class="list-group-item px-0">
              <small class="text-muted">Ontem</small><br>
              <strong>Ana Costa</strong> acessou "Revolução Industrial"
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Dica para professores -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card border-warning">
        <div class="card-header bg-warning text-dark">
          <h5><i class="bi bi-lightbulb"></i> Dica Pedagógica</h5>
        </div>
        <div class="card-body">
          <p class="mb-0">🎯 <strong>Diversifique seus materiais:</strong> Combine vídeos, textos, exercícios e atividades práticas para atender diferentes estilos de aprendizagem dos seus alunos!</p>
        </div>
      </div>
    </div>
  </div>
</div>
