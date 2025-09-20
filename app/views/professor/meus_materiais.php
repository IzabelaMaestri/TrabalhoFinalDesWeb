<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-danger">Meus Materiais</h2>
    <a href="?route=material/form" class="btn btn-danger">+ Novo Material</a>
  </div>

  <?php if (!empty($materiais)): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Matéria</th>
            <th>Arquivo</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($materiais as $mat): ?>
            <tr>
              <td><?= htmlspecialchars($mat['titulo']) ?></td>
              <td><?= htmlspecialchars($mat['descricao']) ?></td>
              <td><?= htmlspecialchars($mat['materia_nome'] ?? '') ?></td>
              <td>
                <?php if (!empty($mat['arquivo'])): ?>
                  <a href="uploads/<?= $mat['arquivo'] ?>" target="_blank">Ver arquivo</a>
                <?php else: ?>
                  <em>Sem arquivo</em>
                <?php endif; ?>
              </td>
              <td>
                <a href="?route=material/visualizar&id=<?= $mat['id'] ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                <a href="?route=material/form&id=<?= $mat['id'] ?>" class="btn btn-sm btn-outline-warning">Editar</a>
                <a href="?route=material/excluir&id=<?= $mat['id'] ?>" 
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Tem certeza que deseja excluir este material?')">
                  Excluir
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Nenhum material cadastrado.</div>
  <?php endif; ?>
</div>
