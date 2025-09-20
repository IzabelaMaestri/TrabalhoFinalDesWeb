<div class="container mt-4">
    <h2><?= isset($material) ? 'Editar Material' : 'Cadastrar Novo Material' ?></h2>

    <form method="post" enctype="multipart/form-data" 
          action="<?= isset($material) ? '?route=professor/editarMaterial&id=' . $material['id'] : '?route=professor/materialForm' ?>">

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" 
                   value="<?= $material['titulo'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" required><?= $material['descricao'] ?? '' ?></textarea>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="pdf" <?= (isset($material) && $material['tipo'] === 'pdf') ? 'selected' : '' ?>>PDF</option>
                <option value="video" <?= (isset($material) && $material['tipo'] === 'video') ? 'selected' : '' ?>>Vídeo</option>
                <option value="link" <?= (isset($material) && $material['tipo'] === 'link') ? 'selected' : '' ?>>Link</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="materia_id" class="form-label">Matéria</label>
            <select class="form-select" id="materia_id" name="materia_id" required>
                <option value="">Selecione</option>
                <?php foreach ($materias as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= (isset($material) && $material['materia_id'] == $m['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nivel_dificuldade" class="form-label">Nível de Dificuldade</label>
            <select class="form-select" id="nivel_dificuldade" name="nivel_dificuldade" required>
                <option value="facil" <?= (isset($material) && $material['nivel_dificuldade'] === 'facil') ? 'selected' : '' ?>>Fácil</option>
                <option value="medio" <?= (isset($material) && $material['nivel_dificuldade'] === 'medio') ? 'selected' : '' ?>>Médio</option>
                <option value="dificil" <?= (isset($material) && $material['nivel_dificuldade'] === 'dificil') ? 'selected' : '' ?>>Difícil</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="url_externa" class="form-label">Link Externo</label>
            <input type="url" class="form-control" id="url_externa" name="url_externa" 
                   value="<?= $material['url_externa'] ?? '' ?>">
        </div>

        <div class="mb-3">
            <label for="arquivo" class="form-label">Arquivo</label>
            <input type="file" class="form-control" id="arquivo" name="arquivo">
            <?php if (isset($material) && !empty($material['caminho_arquivo'])): ?>
                <p>Arquivo atual: <a href="<?= $material['caminho_arquivo'] ?>" target="_blank">Baixar</a></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="?route=professor/meusMateriais" class="btn btn-secondary">Cancelar</a>
    </form>
</div>