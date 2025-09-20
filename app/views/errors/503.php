<?php include_once 'app/views/partials/header.php'; ?>

<div class="error-page d-flex align-items-center justify-content-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-6">
        <div class="text-center">
          <!-- Ícone específico para 503 -->
          <div class="error-icon mb-4">
            <i class="bi bi-tools text-info" style="font-size: 6rem; animation: bounce 2s infinite;"></i>
          </div>
          
          <!-- Código do erro -->
          <div class="error-code mb-4">
            <h1 class="display-2 fw-bold text-info"><?= $error['code'] ?></h1>
            <div class="error-divider bg-info mx-auto mb-4"></div>
          </div>
          
          <!-- Conteúdo do erro -->
          <div class="error-content">
            <h2 class="h3 mb-3 text-dark"><?= htmlspecialchars($error['title']) ?></h2>
            <p class="lead mb-4 text-muted"><?= htmlspecialchars($error['message']) ?></p>
            
            <div class="alert alert-info border-0 mb-4">
              <i class="bi bi-clock me-2"></i>
              <?= htmlspecialchars($error['suggestion']) ?>
            </div>
          </div>
          
          <!-- Ações específicas para 503 -->
          <div class="error-actions">
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <button id="autoRefreshBtn" onclick="toggleAutoRefresh()" class="btn btn-info">
                <i class="bi bi-arrow-clockwise me-2"></i>Atualizar Automaticamente
              </button>
              <button onclick="location.reload()" class="btn btn-outline-info">
                <i class="bi bi-bootstrap-reboot me-2"></i>Tentar Agora
              </button>
            </div>
            
            <!-- Contador regressivo -->
            <div class="mt-4">
              <div class="progress" style="height: 8px;">
                <div id="refreshProgress" class="progress-bar bg-info" role="progressbar" style="width: 0%"></div>
              </div>
              <small class="text-muted mt-2 d-block">
                <span id="refreshCounter">Tentativa automática em <strong>30</strong> segundos</span>
              </small>
            </div>
          </div>
          
          <!-- Status do sistema -->
          <div class="system-status mt-5">
            <h6 class="text-muted mb-3">Status dos Serviços:</h6>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="card border-0 bg-light">
                  <div class="card-body py-2">
                    <small class="text-muted">Servidor Web</small>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-circle-fill text-success me-2" style="font-size: 0.5rem;"></i>
                      <span class="small">Online</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card border-0 bg-light">
                  <div class="card-body py-2">
                    <small class="text-muted">Base de Dados</small>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-circle-fill text-warning me-2" style="font-size: 0.5rem;"></i>
                      <span class="small">Manutenção</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.error-page {
  background: linear-gradient(135deg, #cce7ff 0%, #e3f2fd 100%);
  min-height: calc(100vh - 120px);
}
.error-divider {
  width: 80px;
  height: 4px;
  border-radius: 2px;
}
@keyframes bounce {
  0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
  40% { transform: translateY(-10px); }
  60% { transform: translateY(-5px); }
}
</style>

<script>
let autoRefresh = false;
let refreshInterval;
let countdown = 30;
let countdownInterval;

function toggleAutoRefresh() {
  autoRefresh = !autoRefresh;
  const btn = document.getElementById('autoRefreshBtn');
  
  if (autoRefresh) {
    btn.innerHTML = '<i class="bi bi-pause me-2"></i>Pausar Atualização';
    btn.classList.remove('btn-info');
    btn.classList.add('btn-warning');
    startCountdown();
  } else {
    btn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Atualizar Automaticamente';
    btn.classList.remove('btn-warning');
    btn.classList.add('btn-info');
    stopCountdown();
  }
}

function startCountdown() {
  countdown = 30;
  updateCountdown();
  
  countdownInterval = setInterval(() => {
    countdown--;
    updateCountdown();
    
    if (countdown <= 0) {
      location.reload();
    }
  }, 1000);
}

function stopCountdown() {
  if (countdownInterval) {
    clearInterval(countdownInterval);
  }
  document.getElementById('refreshProgress').style.width = '0%';
  document.getElementById('refreshCounter').innerHTML = 'Atualização automática pausada';
}

function updateCountdown() {
  const progressPercent = ((30 - countdown) / 30) * 100;
  document.getElementById('refreshProgress').style.width = progressPercent + '%';
  document.getElementById('refreshCounter').innerHTML = `Tentativa automática em <strong>${countdown}</strong> segundos`;
}

// Iniciar automaticamente quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
  setTimeout(() => {
    toggleAutoRefresh();
  }, 1000);
});
</script>

<?php include_once 'app/views/partials/footer.php'; ?>
