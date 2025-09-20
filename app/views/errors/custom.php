<?php include_once 'app/views/partials/header.php'; ?>

<div class="error-page d-flex align-items-center justify-content-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-6">
        <div class="text-center">
          <!-- Ícone dinâmico baseado no tipo de erro -->
          <div class="error-icon mb-4">
            <?php
            $iconClass = 'bi-exclamation-circle text-secondary';
            $colorClass = 'secondary';
            
            if (isset($error['severity'])) {
              switch ($error['severity']) {
                case 'high':
                case 'critical':
                  $iconClass = 'bi-x-octagon text-danger';
                  $colorClass = 'danger';
                  break;
                case 'medium':
                case 'warning':
                  $iconClass = 'bi-exclamation-triangle text-warning';
                  $colorClass = 'warning';
                  break;
                case 'low':
                case 'info':
                  $iconClass = 'bi-info-circle text-info';
                  $colorClass = 'info';
                  break;
              }
            }
            ?>
            <i class="bi <?= $iconClass ?>" style="font-size: 6rem; animation: fadeIn 1s ease-in;"></i>
          </div>
          
          <!-- Código/Tipo do erro -->
          <div class="error-code mb-4">
            <h1 class="display-4 fw-bold text-<?= $colorClass ?>">
              <?= htmlspecialchars($error['code'] ?? 'ERRO') ?>
            </h1>
            <div class="error-divider bg-<?= $colorClass ?> mx-auto mb-4"></div>
          </div>
          
          <!-- Conteúdo do erro -->
          <div class="error-content">
            <h2 class="h3 mb-3 text-dark"><?= htmlspecialchars($error['title']) ?></h2>
            <p class="lead mb-4 text-muted"><?= htmlspecialchars($error['message']) ?></p>
            
            <?php if (!empty($error['suggestion'])): ?>
            <div class="alert alert-<?= $colorClass ?> border-0 mb-4">
              <i class="bi bi-lightbulb me-2"></i>
              <?= htmlspecialchars($error['suggestion']) ?>
            </div>
            <?php endif; ?>
          </div>
          
          <!-- Detalhes adicionais -->
          <?php if (!empty($error['details'])): ?>
          <div class="error-details mb-4">
            <div class="card border-<?= $colorClass ?> border-opacity-25">
              <div class="card-body">
                <h6 class="card-title text-<?= $colorClass ?>">
                  <i class="bi bi-info-circle me-2"></i>Detalhes Adicionais
                </h6>
                <p class="card-text small text-muted mb-0">
                  <?= htmlspecialchars($error['details']) ?>
                </p>
              </div>
            </div>
          </div>
          <?php endif; ?>
          
          <!-- Ações customizadas -->
          <div class="error-actions">
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <?php if (!empty($error['actions']) && is_array($error['actions'])): ?>
                <?php foreach ($error['actions'] as $action): ?>
                  <a href="<?= htmlspecialchars($action['url']) ?>" 
                     class="btn btn-<?= $action['style'] ?? 'outline-' . $colorClass ?>">
                    <?php if (!empty($action['icon'])): ?>
                      <i class="bi bi-<?= htmlspecialchars($action['icon']) ?> me-2"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($action['label']) ?>
                  </a>
                <?php endforeach; ?>
              <?php else: ?>
                <!-- Ações padrão -->
                <button onclick="history.back()" class="btn btn-<?= $colorClass ?>">
                  <i class="bi bi-arrow-left me-2"></i>Voltar
                </button>
                <a href="?route=site/home" class="btn btn-outline-<?= $colorClass ?>">
                  <i class="bi bi-house me-2"></i>Página Inicial
                </a>
                <button onclick="location.reload()" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-clockwise me-2"></i>Tentar Novamente
                </button>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Informações de contexto -->
          <?php if (!empty($error['context'])): ?>
          <div class="context-info mt-5">
            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#contextDetails">
              <i class="bi bi-list-ul me-2"></i>Informações de Contexto
            </button>
            <div class="collapse mt-3" id="contextDetails">
              <div class="card text-start">
                <div class="card-body">
                  <h6 class="card-title">Contexto do Erro:</h6>
                  <ul class="list-unstyled small text-muted mb-0">
                    <?php foreach ($error['context'] as $key => $value): ?>
                      <li class="mb-1">
                        <strong><?= htmlspecialchars($key) ?>:</strong> 
                        <?= htmlspecialchars($value) ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
          
          <!-- Timestamp -->
          <div class="error-timestamp mt-4">
            <small class="text-muted">
              <i class="bi bi-clock me-1"></i>
              Erro registado em <?= date('d/m/Y \à\s H:i:s') ?>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.error-page {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  min-height: calc(100vh - 120px);
}
.error-divider {
  width: 80px;
  height: 4px;
  border-radius: 2px;
}
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.8); }
  to { opacity: 1; transform: scale(1); }
}
.error-details .card,
.context-info .card {
  transition: all 0.3s ease;
}
.error-details .card:hover,
.context-info .card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.error-actions .btn {
  transition: all 0.3s ease;
}
.error-actions .btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>

<script>
// Registar erro para análise (em produção)
document.addEventListener('DOMContentLoaded', function() {
  const errorData = {
    type: '<?= htmlspecialchars($error['type'] ?? 'custom') ?>',
    code: '<?= htmlspecialchars($error['code'] ?? 'UNKNOWN') ?>',
    severity: '<?= htmlspecialchars($error['severity'] ?? 'medium') ?>',
    timestamp: new Date().toISOString(),
    userAgent: navigator.userAgent,
    url: window.location.href
  };
  
  console.warn('Erro customizado registado:', errorData);
  
  // Em produção, enviar para sistema de log
  // fetch('/api/log-error', { method: 'POST', body: JSON.stringify(errorData) });
});

// Função para reportar problema
function reportIssue() {
  const errorCode = '<?= htmlspecialchars($error['code'] ?? 'UNKNOWN') ?>';
  const errorType = '<?= htmlspecialchars($error['type'] ?? 'custom') ?>';
  
  const message = `Relatório de Erro\n\n` +
                 `Código: ${errorCode}\n` +
                 `Tipo: ${errorType}\n` +
                 `Hora: ${new Date().toLocaleString()}\n` +
                 `Página: ${window.location.href}\n\n` +
                 `Descrição adicional: (por favor, descreva o que estava a fazer quando o erro ocorreu)`;
  
  alert(message);
}
</script>

<?php include_once 'app/views/partials/footer.php'; ?>
