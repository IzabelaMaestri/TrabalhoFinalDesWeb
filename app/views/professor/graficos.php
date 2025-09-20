<?php include_once 'app/views/partials/header.php'; ?>

<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <h2><i class="bi bi-bar-chart"></i> Relatórios e Gráficos</h2>
            <p class="text-muted">Visualize estatísticas detalhadas sobre seus materiais e alunos.</p>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Acessos por Mês -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-calendar3"></i> Acessos por Mês</h5>
                </div>
                <div class="card-body">
                    <canvas id="acessosMesChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Materiais por Disciplina -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-book"></i> Materiais por Disciplina</h5>
                </div>
                <div class="card-body">
                    <canvas id="disciplinasChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Tipos de Material -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-pie-chart"></i> Acessos por Tipo de Material</h5>
                </div>
                <div class="card-body">
                    <canvas id="tiposChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <!-- Resumo de Estatísticas -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-graph-up"></i> Resumo</h5>
                </div>
                <div class="card-body">
                    <?php
                    $totalAcessos = array_sum(array_column($acessosPorMes ?? [], 'total_acessos'));
                    $totalMateriais = array_sum(array_column($materiaisPorDisciplina ?? [], 'total_materiais'));
                    $totalAlunos = array_sum(array_column($materiaisPorDisciplina ?? [], 'alunos_unicos'));
                    ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total de Acessos:</span>
                        <strong><?= $totalAcessos ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total de Materiais:</span>
                        <strong><?= $totalMateriais ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Alunos Únicos:</span>
                        <strong><?= $totalAlunos ?></strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Média Acessos/Material:</span>
                        <strong><?= $totalMateriais > 0 ? round($totalAcessos / $totalMateriais, 1) : 0 ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <a href="?route=professor/dashboard" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Dados para os gráficos
const acessosMesData = <?= json_encode($acessosPorMes ?? []) ?>;
const disciplinasData = <?= json_encode($materiaisPorDisciplina ?? []) ?>;
const tiposData = <?= json_encode($acessosPorTipo ?? []) ?>;

// Gráfico de Acessos por Mês
const ctxMes = document.getElementById('acessosMesChart').getContext('2d');
new Chart(ctxMes, {
    type: 'line',
    data: {
        labels: acessosMesData.map(item => `Mês ${item.mes}`),
        datasets: [{
            label: 'Acessos',
            data: acessosMesData.map(item => item.total_acessos),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de Materiais por Disciplina
const ctxDisciplinas = document.getElementById('disciplinasChart').getContext('2d');
new Chart(ctxDisciplinas, {
    type: 'bar',
    data: {
        labels: disciplinasData.map(item => item.disciplina),
        datasets: [{
            label: 'Materiais',
            data: disciplinasData.map(item => item.total_materiais),
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de Tipos de Material
const ctxTipos = document.getElementById('tiposChart').getContext('2d');
new Chart(ctxTipos, {
    type: 'doughnut',
    data: {
        labels: tiposData.map(item => item.tipo.charAt(0).toUpperCase() + item.tipo.slice(1)),
        datasets: [{
            data: tiposData.map(item => item.total_acessos),
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<?php include_once 'app/views/partials/footer.php'; ?>