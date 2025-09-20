<?php include_once 'app/views/partials/header.php'; ?>

<div class="container my-4">
  <!-- Cabeçalho do perfil -->
  <div class="row">
    <div class="col-12">
      <div class="card bg-gradient text-white mb-4" style="background: linear-gradient(135deg, #dc3545, #6f42c1);">
        <div class="card-body text-center py-5">
          <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-person-fill fs-1 text-white"></i>
          </div>
          <h2><?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário') ?></h2>
          <p class="mb-1">
            <span class="badge bg-light text-dark">
              <?= $_SESSION['usuario_tipo'] === 'aluno' ? 'Aluno' : 'Professor' ?>
            </span>
          </p>
          <small class="opacity-75">Membro desde <?= date('d/m/Y') ?></small>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Formulário de edição -->
    <div class="col-md-8">
      <!-- Dados Pessoais -->
      <div class="card shadow mb-4">
        <div class="card-header">
          <h5><i class="bi bi-person-gear"></i> Dados Pessoais</h5>
        </div>
        <div class="card-body">
          <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <i class="bi bi-check-circle"></i> <?= $mensagem ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
          
          <?php if (!empty($erro)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <i class="bi bi-exclamation-triangle"></i> <?= $erro ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form method="POST" action="?route=usuario/atualizarPerfil">
            <div class="row">
              <!-- Nome -->
              <div class="col-md-6 mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome" 
                       value="<?= htmlspecialchars($usuario['nome'] ?? $_SESSION['usuario_nome']) ?>" required>
              </div>

              <!-- Email -->
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
              </div>
            </div>

            <!-- Tipo de usuário (somente leitura) -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="tipo" class="form-label">Tipo de Conta</label>
                <input type="text" class="form-control" id="tipo" 
                       value="<?= $_SESSION['usuario_tipo'] === 'aluno' ? 'Aluno' : 'Professor' ?>" readonly>
              </div>

              <!-- Nível escolar (apenas para alunos) -->
              <?php if ($_SESSION['usuario_tipo'] === 'aluno'): ?>
              <div class="col-md-6 mb-3">
                <label for="nivel_escolar" class="form-label">Nível de Ensino</label>
                <select class="form-select" id="nivel_escolar" name="nivel_escolar">
                  <option value="">Selecione...</option>
                  <option value="6º ano" <?= ($usuario['nivel_escolar'] ?? '') === '6º ano' ? 'selected' : '' ?>>6º ano</option>
                  <option value="7º ano" <?= ($usuario['nivel_escolar'] ?? '') === '7º ano' ? 'selected' : '' ?>>7º ano</option>
                  <option value="8º ano" <?= ($usuario['nivel_escolar'] ?? '') === '8º ano' ? 'selected' : '' ?>>8º ano</option>
                  <option value="9º ano" <?= ($usuario['nivel_escolar'] ?? '') === '9º ano' ? 'selected' : '' ?>>9º ano</option>
                  <option value="1º ano EM" <?= ($usuario['nivel_escolar'] ?? '') === '1º ano EM' ? 'selected' : '' ?>>1º ano EM</option>
                  <option value="2º ano EM" <?= ($usuario['nivel_escolar'] ?? '') === '2º ano EM' ? 'selected' : '' ?>>2º ano EM</option>
                  <option value="3º ano EM" <?= ($usuario['nivel_escolar'] ?? '') === '3º ano EM' ? 'selected' : '' ?>>3º ano EM</option>
                  <option value="Superior" <?= ($usuario['nivel_escolar'] ?? '') === 'Superior' ? 'selected' : '' ?>>Superior</option>
                </select>
              </div>
              <?php endif; ?>
            </div>

            <!-- Botão de atualizar -->
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Atualizar Dados Pessoais
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Alterar Senha -->
      <div class="card shadow mb-4">
        <div class="card-header">
          <h5><i class="bi bi-shield-lock"></i> Alterar Senha</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="?route=usuario/alterarSenha" id="formSenha">
            <div class="row">
              <!-- Senha atual -->
              <div class="col-md-4 mb-3">
                <label for="senha_atual" class="form-label">Senha Atual</label>
                <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
              </div>

              <!-- Nova senha -->
              <div class="col-md-4 mb-3">
                <label for="nova_senha" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" id="nova_senha" name="nova_senha" 
                       minlength="8" required>
                <div class="form-text">Mínimo 8 caracteres</div>
              </div>

              <!-- Confirmar nova senha -->
              <div class="col-md-4 mb-3">
                <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" 
                       minlength="8" required>
              </div>
            </div>

            <!-- Botão de alterar senha -->
            <div class="d-grid">
              <button type="submit" class="btn btn-warning">
                <i class="bi bi-key"></i> Alterar Senha
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Zona de Perigo -->
      <div class="card shadow border-danger">
        <div class="card-header bg-danger text-white">
          <h5><i class="bi bi-exclamation-triangle"></i> Zona de Perigo</h5>
        </div>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h6 class="text-danger">Excluir Conta</h6>
              <p class="text-muted mb-0">
                Esta ação é irreversível. Todos os seus dados, materiais e progresso serão permanentemente removidos.
              </p>
            </div>
            <div class="col-md-4 text-end">
              <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir">
                <i class="bi bi-trash"></i> Excluir Conta
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar com informações -->
    <div class="col-md-4">
      <!-- Estatísticas do usuário -->
      <div class="card shadow mb-4">
        <div class="card-header">
          <h6><i class="bi bi-graph-up"></i> Suas Estatísticas</h6>
        </div>
        <div class="card-body">
          <?php if ($_SESSION['usuario_tipo'] === 'aluno'): ?>
          <!-- Estatísticas do Aluno -->
          <div class="text-center mb-3">
            <h4 class="text-primary">142</h4>
            <small>Materiais Acessados</small>
          </div>
          <div class="text-center mb-3">
            <h4 class="text-success">28h</h4>
            <small>Tempo de Estudo</small>
          </div>
          <div class="text-center mb-3">
            <h4 class="text-info">6</h4>
            <small>Disciplinas Seguindo</small>
          </div>
          <div class="text-center">
            <h4 class="text-warning">15</h4>
            <small>Materiais Concluídos</small>
          </div>
          <?php else: ?>
          <!-- Estatísticas do Professor -->
          <div class="text-center mb-3">
            <h4 class="text-primary">18</h4>
            <small>Materiais Publicados</small>
          </div>
          <div class="text-center mb-3">
            <h4 class="text-success">84</h4>
            <small>Alunos Conectados</small>
          </div>
          <div class="text-center mb-3">
            <h4 class="text-info">1,247</h4>
            <small>Total de Visualizações</small>
          </div>
          <div class="text-center">
            <h4 class="text-warning">4.8</h4>
            <small>Avaliação Média</small>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Configurações de privacidade -->
      <div class="card shadow mb-4">
        <div class="card-header">
          <h6><i class="bi bi-shield-check"></i> Privacidade</h6>
        </div>
        <div class="card-body">
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="perfil_publico" checked>
            <label class="form-check-label" for="perfil_publico">
              Perfil público
            </label>
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="receber_emails" checked>
            <label class="form-check-label" for="receber_emails">
              Receber emails informativos
            </label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="mostrar_progresso">
            <label class="form-check-label" for="mostrar_progresso">
              Mostrar progresso publicamente
            </label>
          </div>
        </div>
      </div>

      <!-- Ações rápidas -->
      <div class="card shadow">
        <div class="card-header">
          <h6><i class="bi bi-lightning"></i> Ações Rápidas</h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <?php if ($_SESSION['usuario_tipo'] === 'aluno'): ?>
            <a href="?route=aluno/dashboard" class="btn btn-outline-primary btn-sm">
              <i class="bi bi-house"></i> Ir para Dashboard
            </a>
            <a href="?route=material/meus" class="btn btn-outline-success btn-sm">
              <i class="bi bi-journal-text"></i> Meus Materiais
            </a>
            <a href="?route=aluno/escolherMaterias" class="btn btn-outline-info btn-sm">
              <i class="bi bi-gear"></i> Gerenciar Disciplinas
            </a>
            <?php else: ?>
            <a href="?route=dashboard/professor" class="btn btn-outline-primary btn-sm">
              <i class="bi bi-house"></i> Ir para Dashboard
            </a>
            <a href="?route=material/meus" class="btn btn-outline-success btn-sm">
              <i class="bi bi-files"></i> Meus Materiais
            </a>
            <a href="?route=material/cadastro" class="btn btn-outline-warning btn-sm">
              <i class="bi bi-plus-circle"></i> Novo Material
            </a>
            <?php endif; ?>
            <a href="?route=auth/logout" class="btn btn-outline-danger btn-sm" onclick="return confirm('Tem certeza que deseja sair da sua conta?')">
              <i class="bi bi-box-arrow-right"></i> Sair da Conta
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de confirmação para excluir conta -->
<div class="modal fade" id="modalExcluir" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="bi bi-exclamation-triangle"></i> Confirmar Exclusão
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger border-0">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <strong>⚠️ ATENÇÃO!</strong> Esta ação é <strong>irreversível</strong>.
        </div>
        
        <p class="mb-3">Ao excluir sua conta, você perderá <strong>permanentemente</strong>:</p>
        <ul class="mb-4">
          <?php if ($_SESSION['usuario_tipo'] === 'aluno'): ?>
          <li>✗ Todo o progresso de estudos</li>
          <li>✗ Lista de disciplinas selecionadas</li>
          <li>✗ Histórico de materiais acessados</li>
          <li>✗ Dados pessoais e preferências</li>
          <?php else: ?>
          <li>✗ Todos os materiais publicados</li>
          <li>✗ Estatísticas de visualizações</li>
          <li>✗ Lista de alunos associados</li>
          <li>✗ Dados pessoais e preferências</li>
          <?php endif; ?>
        </ul>
        
        <div class="bg-light p-3 rounded mb-3">
          <label for="confirmacaoTexto" class="form-label">
            <strong>Para confirmar, digite "EXCLUIR" no campo abaixo:</strong>
          </label>
          <input type="text" class="form-control" id="confirmacaoTexto" placeholder="Digite EXCLUIR para confirmar">
        </div>
          <li>Conexões com alunos</li>
          <li>Estatísticas de ensino</li>
          <?php endif; ?>
          <li>Dados pessoais e configurações</li>
        </ul>

        <div class="form-floating mt-3">
          <input type="password" class="form-control" id="senhaConfirmacao" placeholder="Senha">
          <label for="senhaConfirmacao">Digite sua senha para confirmar</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle"></i> Cancelar
        </button>
        <form method="POST" action="?route=usuario/excluirConta" class="d-inline">
          <button type="submit" class="btn btn-secondary" id="btnConfirmarExclusao" disabled>
            <i class="bi bi-trash"></i> Sim, Excluir Minha Conta Permanentemente
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Validação do formulário de senha
document.getElementById('formSenha').addEventListener('submit', function(e) {
  const novaSenha = document.getElementById('nova_senha').value;
  const confirmarSenha = document.getElementById('confirmar_senha').value;
  
  if (novaSenha !== confirmarSenha) {
    e.preventDefault();
    alert('As senhas não coincidem!');
    return false;
  }
  
  if (novaSenha.length < 8) {
    e.preventDefault();
    alert('A nova senha deve ter pelo menos 8 caracteres!');
    return false;
  }
});

// Validação do modal de exclusão
document.getElementById('confirmacaoTexto').addEventListener('input', function() {
  const texto = this.value.toUpperCase();
  const btn = document.getElementById('btnConfirmarExclusao');
  
  if (texto === 'EXCLUIR') {
    btn.disabled = false;
    btn.classList.remove('btn-secondary');
    btn.classList.add('btn-danger');
  } else {
    btn.disabled = true;
    btn.classList.remove('btn-danger');
    btn.classList.add('btn-secondary');
  }
});

// Resetar modal quando fechar
document.getElementById('modalExcluir').addEventListener('hidden.bs.modal', function() {
  document.getElementById('confirmacaoTexto').value = '';
  const btn = document.getElementById('btnConfirmarExclusao');
  btn.disabled = true;
  btn.classList.remove('btn-danger');
  btn.classList.add('btn-secondary');
});

// Confirmação adicional antes de excluir
document.getElementById('btnConfirmarExclusao').addEventListener('click', function(e) {
  if (!confirm('Tem ABSOLUTA CERTEZA? Esta ação é irreversível!')) {
    e.preventDefault();
  }
});

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
