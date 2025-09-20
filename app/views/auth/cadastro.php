<div class="container my-5">
  <div class="col-md-6 mx-auto">
    <div class="card shadow p-4">
      <h2 class="text-center text-danger mb-4">Crie sua Conta</h2>

      <?php if (!empty($erro)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <?= $erro ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <form method="POST" action="?route=auth/cadastro">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="nome" placeholder="Nome completo" required>
          <label>Nome</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <label>Email</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" name="senha" placeholder="Senha" required minlength="8">
          <label>Senha</label>
        </div>
        <div class="mb-3">
          <label class="form-label">Tipo de Usuário</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipo" id="aluno" value="aluno" required>
            <label class="form-check-label" for="aluno">Aluno</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipo" id="professor" value="professor" required>
            <label class="form-check-label" for="professor">Professor</label>
          </div>
        </div>

        <!-- Campo extra só para aluno -->
        <div class="mb-3" id="nivelEscolarGroup" style="display:none;">
          <label for="nivel_escolar" class="form-label">Nível Escolar</label>
          <select class="form-select" name="nivel_escolar" id="nivel_escolar">
            <option value="">Selecione</option>
            <option value="fundamental">Fundamental</option>
            <option value="medio">Médio</option>
            <option value="superior">Superior</option>
          </select>
        </div>

        <button type="submit" class="btn btn-danger w-100">Cadastrar</button>
        <p class="text-center mt-3">
          Já tem conta? <a href="?route=auth/login">Entrar</a>
        </p>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById('aluno').addEventListener('change', () => {
  document.getElementById('nivelEscolarGroup').style.display = 'block';
});
document.getElementById('professor').addEventListener('change', () => {
  document.getElementById('nivelEscolarGroup').style.display = 'none';
});
</script>