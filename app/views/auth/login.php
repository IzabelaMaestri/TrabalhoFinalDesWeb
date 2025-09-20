<div class="container my-5">
  <div class="col-md-6 mx-auto">
    <div class="card shadow p-4">
      <h2 class="text-center text-danger mb-4">Acesse sua Conta</h2>
      
      <?php 
      $mensagem = $_GET['msg'] ?? null;
      if ($mensagem === 'cadastro_sucesso'): 
      ?>
        <div class="alert alert-success alert-dismissible fade show">
          <i class="bi bi-check-circle me-2"></i>
          <strong>Cadastro realizado com sucesso!</strong> Agora você pode fazer login.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      
      <?php if (!empty($erro)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <?= $erro ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      
      <form method="POST" action="?route=auth/login">
        <div class="form-floating mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <label>Email</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" name="senha" placeholder="Senha" required minlength="8">
          <label>Senha</label>
        </div>
        <button type="submit" class="btn btn-danger w-100">Entrar</button>
        <p class="text-center mt-3">Não tem conta? <a href="?route=auth/cadastro">Cadastre-se</a></p>
      </form>
    </div>
  </div>
</div>
