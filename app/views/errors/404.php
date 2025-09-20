<?php include_once 'app/views/partials/header.php'; ?>

<div class="error-page d-flex align-items-center justify-content-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-6">
        <div class="text-center">
          <!-- Código do erro -->
          <div class="error-code mb-4">
            <h1 class="display-1 fw-bold text-primary"><?= $error['code'] ?></h1>
            <div class="error-divider bg-primary mx-auto mb-4"></div>
          </div>
          
          <!-- Conteúdo do erro -->
          <div class="error-content">
            <h2 class="h3 mb-3 text-dark"><?= htmlspecialchars($error['title']) ?></h2>
            <p class="lead mb-4 text-muted"><?= htmlspecialchars($error['message']) ?></p>
            
            <?php if (!empty($error['suggestion'])): ?>
            <div class="alert alert-info border-0 mb-4">
              <i class="bi bi-info-circle me-2"></i>
              <?= htmlspecialchars($error['suggestion']) ?>
            </div>
            <?php endif; ?>
          </div>
          
          <!-- Ações -->
          <div class="error-actions">
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <button onclick="history.back()" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Voltar
              </button>
              <a href="?route=site/home" class="btn btn-primary">
                <i class="bi bi-house me-2"></i>Página Inicial
              </a>
              
              <?php if (!isset($_SESSION['usuario_id'])): ?>
              <a href="?route=auth/login" class="btn btn-outline-secondary">
                <i class="bi bi-person me-2"></i>Fazer Login
              </a>
              <?php else: ?>
              <a href="?route=dashboard/<?= $_SESSION['usuario_tipo'] ?? 'aluno' ?>" class="btn btn-outline-secondary">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
              </a>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Informações adicionais para desenvolvimento -->
          <?php if (defined('DEBUG_MODE') && DEBUG_MODE): ?>
          <div class="mt-5">
            <details class="text-start">
              <summary class="btn btn-sm btn-outline-warning">
                <i class="bi bi-bug me-2"></i>Informações de Debug
              </summary>
              <div class="mt-3 p-3 bg-light rounded">
                <small class="text-muted">
                  <strong>URL:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?><br>
                  <strong>Método:</strong> <?= $_SERVER['REQUEST_METHOD'] ?? 'N/A' ?><br>
                  <strong>User Agent:</strong> <?= $_SERVER['HTTP_USER_AGENT'] ?? 'N/A' ?><br>
                  <strong>Timestamp:</strong> <?= date('Y-m-d H:i:s') ?><br>
                  <strong>IP:</strong> <?= $_SERVER['REMOTE_ADDR'] ?? 'N/A' ?>
                </small>
              </div>
            </details>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CSS específico para páginas de erro -->
<style>
.error-page {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  min-height: calc(100vh - 120px);
}

.error-code h1 {
  font-size: 8rem;
  line-height: 1;
  text-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.error-divider {
  width: 80px;
  height: 4px;
  border-radius: 2px;
}

.error-content {
  margin: 2rem 0;
}

.error-actions .btn {
  min-width: 140px;
}

@media (max-width: 768px) {
  .error-code h1 {
    font-size: 6rem;
  }
  
  .error-actions .d-flex {
    flex-direction: column;
    align-items: center;
  }
  
  .error-actions .btn {
    width: 200px;
  }
}

/* Animação sutil */
.error-code h1 {
  animation: pulse 2s infinite alternate;
}

@keyframes pulse {
  from { opacity: 0.8; }
  to { opacity: 1; }
}
</style>

<script>
// Auto-refresh para erro 503 (manutenção)
<?php if ($error['code'] == 503): ?>
setTimeout(() => {
  if (confirm('Tentar novamente?')) {
    location.reload();
  }
}, 30000); // 30 segundos
<?php endif; ?>

// Log do erro (apenas em desenvolvimento)
<?php if (defined('DEBUG_MODE') && DEBUG_MODE): ?>
console.error('Erro <?= $error['code'] ?>:', {
  title: '<?= addslashes($error['title']) ?>',
  message: '<?= addslashes($error['message']) ?>',
  url: '<?= $_SERVER['REQUEST_URI'] ?? '' ?>',
  timestamp: '<?= date('c') ?>'
});
<?php endif; ?>
</script>

<?php include_once 'app/views/partials/footer.php'; ?>
