<?php include_once 'app/views/partials/header.php'; ?>

<div class="error-page d-flex align-items-center justify-content-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-6">
        <div class="text-center">
          <!-- Ícone específico para erro de banco -->
          <div class="error-icon mb-4">
            <i class="bi bi-database-exclamation text-danger" style="font-size: 6rem; animation: pulse 2s infinite;"></i>
          </div>
          
          <!-- Código do erro -->
          <div class="error-code mb-4">
            <h1 class="display-3 fw-bold text-danger">DB ERROR</h1>
            <div class="error-divider bg-danger mx-auto mb-4"></div>
          </div>
          
          <!-- Conteúdo do erro -->
          <div class="error-content">
            <h2 class="h3 mb-3 text-dark"><?= htmlspecialchars($error['title']) ?></h2>
            <p class="lead mb-4 text-muted"><?= htmlspecialchars($error['message']) ?></p>
            
            <div class="alert alert-danger border-0 mb-4">
              <i class="bi bi-exclamation-triangle me-2"></i>
              <?= htmlspecialchars($error['suggestion']) ?>
            </div>
          </div>
          
          <!-- Status da conexão -->
          <div class="connection-status mb-4">
            <div class="card border-danger">
              <div class="card-header bg-danger text-white">
                <i class="bi bi-database me-2"></i>Status da Base de Dados
              </div>
              <div class="card-body">
                <div class="row g-3 text-start">
                  <div class="col-md-6">
                    <small class="text-muted d-block">Servidor:</small>
                    <span class="fw-bold"><?= htmlspecialchars($error['server'] ?? 'Não disponível') ?></span>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block">Base de Dados:</small>
                    <span class="fw-bold"><?= htmlspecialchars($error['database'] ?? 'Não disponível') ?></span>
                  </div>
                  <div class="col-12">
                    <small class="text-muted d-block">Último Teste:</small>
                    <span class="fw-bold"><?= date('d/m/Y H:i:s') ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Ações específicas para erro de DB -->
          <div class="error-actions">
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <button onclick="testConnection()" class="btn btn-danger" id="testBtn">
                <i class="bi bi-database-check me-2"></i>Testar Conexão
              </button>
              <a href="?route=site/home" class="btn btn-outline-danger">
                <i class="bi bi-house me-2"></i>Página Inicial
              </a>
              <button onclick="contactSupport()" class="btn btn-outline-secondary">
                <i class="bi bi-headset me-2"></i>Contactar Suporte
              </button>
            </div>
          </div>
          
          <!-- Informações técnicas (apenas para administradores) -->
          <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>
          <div class="technical-info mt-5">
            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#technicalDetails">
              <i class="bi bi-gear me-2"></i>Informações Técnicas
            </button>
            <div class="collapse mt-3" id="technicalDetails">
              <div class="card text-start">
                <div class="card-header">
                  <strong>Detalhes da Conexão</strong>
                </div>
                <div class="card-body">
                  <pre class="text-danger small"><?= htmlspecialchars($error['technical'] ?? 'Nenhuma informação técnica disponível') ?></pre>
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
  background: linear-gradient(135deg, #f8d7da 0%, #fdeaea 100%);
  min-height: calc(100vh - 120px);
}
.error-divider {
  width: 100px;
  height: 4px;
  border-radius: 2px;
}
@keyframes pulse {
  0% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.05); opacity: 0.8; }
  100% { transform: scale(1); opacity: 1; }
}
.connection-status .card {
  transition: all 0.3s ease;
}
.connection-status .card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
}
</style>

<script>
function testConnection() {
  const btn = document.getElementById('testBtn');
  const originalContent = btn.innerHTML;
  
  // Mostrar estado de carregamento
  btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Testando...';
  btn.disabled = true;
  
  // Simular teste de conexão (em produção, fazer requisição AJAX real)
  setTimeout(() => {
    // Simular falha (em produção, verificar resposta real)
    btn.innerHTML = '<i class="bi bi-x-circle me-2"></i>Conexão Falhada';
    btn.classList.remove('btn-danger');
    btn.classList.add('btn-outline-danger');
    
    setTimeout(() => {
      btn.innerHTML = originalContent;
      btn.classList.remove('btn-outline-danger');
      btn.classList.add('btn-danger');
      btn.disabled = false;
    }, 2000);
  }, 3000);
}

function contactSupport() {
  const errorDetails = {
    type: 'Database Connection Error',
    time: new Date().toLocaleString(),
    page: window.location.href,
    userAgent: navigator.userAgent
  };
  
  const message = `Erro de Base de Dados Detectado\n\n` +
                 `Tipo: ${errorDetails.type}\n` +
                 `Hora: ${errorDetails.time}\n` +
                 `Página: ${errorDetails.page}\n\n` +
                 `Por favor, verifique a conexão com a base de dados.`;
  
  alert(message);
}

// Auto-teste de conexão a cada 30 segundos
setInterval(() => {
  console.log('Verificação automática de conexão...');
  // Em produção, fazer verificação real da conexão
}, 30000);
</script>

<?php include_once 'app/views/partials/footer.php'; ?>
