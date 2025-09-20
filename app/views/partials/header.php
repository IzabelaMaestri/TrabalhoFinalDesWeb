<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Saber Conecta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="public/assets/css/estilo.css">
</head>
<body>
<header class="main-header">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="?route=site/home">
        <img src="public/assets/images/logo.jpeg" alt="Logo" width="40" class="me-2"> Saber Conecta
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <?php if (!isset($_SESSION['usuario_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="?route=site/home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="?route=site/sobre">Sobre</a></li>
            <li class="nav-item"><a class="nav-link" href="?route=auth/login">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="?route=auth/cadastro">Cadastro</a></li>

          <?php elseif ($_SESSION['usuario_tipo'] === "aluno"): ?>
            <li class="nav-item"><a class="nav-link" href="?route=aluno/dashboard">Dashboard</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                Matérias
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?route=aluno/meusMateriais"><i class="bi bi-journal-text"></i> Minhas Matérias</a></li>
                <li><a class="dropdown-item" href="?route=aluno/favoritos"><i class="bi bi-star"></i> Favoritos</a></li>
                <li><a class="dropdown-item" href="?route=aluno/recomendados"><i class="bi bi-lightbulb"></i> Recomendados</a></li>
                <li><a class="dropdown-item" href="?route=aluno/escolherMaterias"><i class="bi bi-check2-square"></i> Escolher Matérias</a></li>
              </ul>
            </li>

          <?php elseif ($_SESSION['usuario_tipo'] === "professor"): ?>
            <li class="nav-item"><a class="nav-link" href="?route=professor/dashboard">Dashboard</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                Materiais
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?route=professor/meusMateriais"><i class="bi bi-journal-text"></i> Meus Materiais</a></li>
                <li><a class="dropdown-item" href="?route=professor/materialForm"><i class="bi bi-plus-circle"></i> Cadastrar Material</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="?route=professor/gerenciarAlunos"><i class="bi bi-people"></i> Gerenciar Alunos</a></li>
            <li class="nav-item"><a class="nav-link" href="?route=professor/graficos"><i class="bi bi-bar-chart"></i> Gráficos</a></li>
          <?php endif; ?>

          <?php if (isset($_SESSION['usuario_id'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i> Conta
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="?route=auth/perfil"><i class="bi bi-person"></i> Perfil</a></li>
                <li><a class="dropdown-item" href="?route=auth/logout"><i class="bi bi-box-arrow-right"></i> Sair</a></li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
