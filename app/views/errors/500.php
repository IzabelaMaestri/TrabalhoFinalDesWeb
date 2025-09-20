<?php include_once 'app/views/partials/header.php'; ?>

<div class="error-page d-flex align-items-center justify-content-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-6">
        <div class="text-center">
          <!-- Ícone específico para 500 -->
          <div class="error-icon mb-4">
            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 6rem; animation: shake 2s infinite;"></i>
          </div>
          
          <!-- Código do erro -->
          <div class="error-code mb-4">
            <h1 class="display-2 fw-bold text-danger"><?= $error['code'] ?></h1>
            <div class="error-divider bg-danger mx-auto mb-4"></div>
          </div>
          
          <!-- Conteúdo do erro -->
          <div class="error-content">
            <h2 class="h3 mb-3 text-dark"><?= htmlspecialchars($error['title']) ?></h2>
            <p class="lead mb-4 text-muted"><?= htmlspecialchars($error['message']) ?></p>
            
            <div class="alert alert-danger border-0 mb-4">
              <i class="bi bi-bug me-2"></i>
              <?= htmlspecialchars($error['suggestion']) ?>
            </div>
          </div>
          
          <!-- Ações específicas para 500 -->
          <div class="error-actions">
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <button onclick="location.reload()" class="btn btn-danger">
                <i class="bi bi-arrow-clockwise me-2"></i>Tentar Novamente
              </button>
              <a href="?route=site/home" class="btn btn-outline-danger">
                <i class="bi bi-house me-2"></i>Página Inicial
              </a>
              <button onclick="reportError()" class="btn btn-outline-secondary">
                <i class="bi bi-flag me-2"></i>Reportar Erro
              </button>
            </div>
          </div>
          
          <!-- Informações de debug (apenas se DEBUG estiver ativo) -->
          <?php if (defined('DEBUG') && DEBUG): ?>
          <div class="debug-info mt-5">
            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#debugDetails">
              <i class="bi bi-info-circle me-2"></i>Detalhes Técnicos
            </button>
            <div class="collapse mt-3" id="debugDetails">
              <div class="card text-start">
                <div class="card-body">
                  <h6 class="card-title">Informações de Debug:</h6>
                  <pre class="text-danger small"><?= htmlspecialchars($error['debug'] ?? 'Nenhuma informação de debug disponível') ?></pre>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.error-page {
  background: linear-gradient(135deg, #f8d7da 0%, #fde2e4 100%);
  min-height: calc(100vh - 120px);
}
.error-divider {
  width: 80px;
  height: 4px;
  border-radius: 2px;
}
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
  20%, 40%, 60%, 80% { transform: translateX(5px); }
}
</style>

<script>
function reportError() {
  alert('Por favor, entre em contato com o administrador do sistema.\n\nDetalhes do erro:\n- Código: 500\n- Horário: ' + new Date().toLocaleString());
}
</script>

<?php include_once 'app/views/partials/footer.php'; ?>
