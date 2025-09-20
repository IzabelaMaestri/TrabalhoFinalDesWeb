<?php include_once 'app/views/partials/header.php'; ?>

<div class="error-page d-flex align-items-center justify-content-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-6">
        <div class="text-center">
          <!-- Ícone específico para 403 -->
          <div class="error-icon mb-4">
            <i class="bi bi-shield-exclamation text-warning" style="font-size: 6rem;"></i>
          </div>
          
          <!-- Código do erro -->
          <div class="error-code mb-4">
            <h1 class="display-2 fw-bold text-warning"><?= $error['code'] ?></h1>
            <div class="error-divider bg-warning mx-auto mb-4"></div>
          </div>
          
          <!-- Conteúdo do erro -->
          <div class="error-content">
            <h2 class="h3 mb-3 text-dark"><?= htmlspecialchars($error['title']) ?></h2>
            <p class="lead mb-4 text-muted"><?= htmlspecialchars($error['message']) ?></p>
            
            <div class="alert alert-warning border-0 mb-4">
              <i class="bi bi-exclamation-triangle me-2"></i>
              <?= htmlspecialchars($error['suggestion']) ?>
            </div>
          </div>
          
          <!-- Ações específicas para 403 -->
          <div class="error-actions">
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <a href="?route=auth/login" class="btn btn-warning">
                <i class="bi bi-person-check me-2"></i>Fazer Login
              </a>
              <a href="?route=site/home" class="btn btn-outline-warning">
                <i class="bi bi-house me-2"></i>Página Inicial
              </a>
              <button onclick="history.back()" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Voltar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.error-page {
  background: linear-gradient(135deg, #fff3cd 0%, #fef7e0 100%);
  min-height: calc(100vh - 120px);
}
.error-divider {
  width: 80px;
  height: 4px;
  border-radius: 2px;
}
</style>

<?php include_once 'app/views/partials/footer.php'; ?>
