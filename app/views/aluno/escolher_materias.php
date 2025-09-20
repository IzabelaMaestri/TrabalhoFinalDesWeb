<div class="container mt-4">
    <h2>Escolher Minhas Matérias</h2>

    <form method="post" action="?route=aluno/escolherMaterias">
        <?php if (!empty($materias)): ?>
            <?php foreach ($materias as $materia): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="materia_id[]" value="<?= $materia['id'] ?>" 
                           id="materia_<?= $materia['id'] ?>"
                           <?= in_array($materia['id'], $materiasSelecionadas ?? []) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="materia_<?= $materia['id'] ?>">
                        <?= htmlspecialchars($materia['nome']) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Nenhuma matéria disponível.</div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success mt-3">Salvar</button>
    </form>
</div>