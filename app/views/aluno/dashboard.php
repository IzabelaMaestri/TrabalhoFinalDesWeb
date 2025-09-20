<div class="container mt-4">
    <h2>Dashboard do Aluno</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body text-center">
                    <h4><?= $totalMaterias ?? 0 ?></h4>
                    <small>Matérias Vinculadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-body text-center">
                    <h4><?= $totalFavoritos ?? 0 ?></h4>
                    <small>Materiais Favoritos</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white mb-3">
                <div class="card-body text-center">
                    <h4><?= $totalAcessos ?? 0 ?></h4>
                    <small>Acessos Recentes</small>
                </div>
            </div>
        </div>
    </div>
</div>