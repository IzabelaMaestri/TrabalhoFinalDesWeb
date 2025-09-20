<?php
// Se o usuário já estiver logado → manda para o dashboard
if (isset($_SESSION['usuario_id'])) {
    $tipo = $_SESSION['usuario_tipo'] ?? 'aluno';
    header("Location: ?route=dashboard/$tipo");
    exit;
}

// Verificar mensagens da URL
$mensagem = $_GET['msg'] ?? null;
?>
<?php if ($mensagem === 'logout_success'): ?>
<div class="alert alert-success alert-dismissible fade show m-0" role="alert">
    <div class="container">
        <i class="bi bi-check-circle me-2"></i>
        <strong>Logout realizado com sucesso!</strong> Obrigado por usar o Saber Conecta.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php elseif ($mensagem === 'conta_excluida'): ?>
<div class="alert alert-info alert-dismissible fade show m-0" role="alert">
    <div class="container">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Conta excluída!</strong> Sua conta foi removida com sucesso.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<!-- HERO CLEAN -->
<section class="hero-home d-flex align-items-center text-center text-white">
  <div class="container">
    <h1 class="display-3 fw-bold mb-3">Saber Conecta</h1>
    <p class="lead mb-0">Educação de qualidade acessível e colaborativa para todos.</p>
  </div>
</section>

<!-- CARDS: ALUNO E PROFESSOR -->
<section class="container mb-5">
  <h2 class="text-center fw-bold mb-5">Faça Parte do Saber Conecta</h2>
  <div class="row g-4">

    <!-- Aluno -->
    <div class="col-md-6">
      <div class="card shadow card-hover border-0 text-center h-100">
        <div class="card-body p-4 d-flex flex-column">
          <i class="bi bi-mortarboard-fill fs-1 text-primary"></i>
          <h4 class="mt-3">Sou Aluno</h4>
          <p class="mb-2">
            Tenha acesso a resumos claros, exercícios resolvidos e materiais interativos para reforçar seus estudos.
          </p>
          <p class="mb-3">
            Aqui você encontra apoio em diferentes matérias, organizados para facilitar a sua rotina e melhorar o seu desempenho escolar.
          </p>
          <a href="?route=auth/cadastro" class="btn btn-primary btn-card mt-auto mx-auto">Quero Aprender</a>
        </div>
      </div>
    </div>

    <!-- Professor -->
    <div class="col-md-6">
      <div class="card shadow card-hover border-0 text-center h-100">
        <div class="card-body p-4 d-flex flex-column">
          <i class="bi bi-person-workspace fs-1 text-success"></i>
          <h4 class="mt-3">Sou Professor</h4>
          <p class="mb-2">
            Compartilhe suas apostilas, listas de exercícios e vídeos educativos em uma plataforma acessível a todos.
          </p>
          <p class="mb-3">
            No Saber Conecta você contribui para democratizar o conhecimento e ainda acompanha como seus materiais impactam os estudantes.
          </p>
          <a href="?route=auth/cadastro" class="btn btn-success btn-card mt-auto mx-auto">Quero Contribuir</a>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- BENEFÍCIOS -->
<section class="beneficios py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-5">Por que usar o Saber Conecta?</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <i class="bi bi-book fs-1 text-danger"></i>
        <h5 class="mt-2">Materiais Gratuitos</h5>
        <p>Acesso sem custo a conteúdos de qualidade.</p>
      </div>
      <div class="col-md-4">
        <i class="bi bi-laptop fs-1 text-primary"></i>
        <h5 class="mt-2">Acesse de Qualquer Lugar</h5>
        <p>Plataforma 100% online e responsiva.</p>
      </div>
      <div class="col-md-4">
        <i class="bi bi-people fs-1 text-success"></i>
        <h5 class="mt-2">Para Todos</h5>
        <p>Estudantes e professores conectados em rede colaborativa.</p>
      </div>
    </div>
  </div>
</section>

<!-- DEPOIMENTOS -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">O que dizem nossos usuários</h2>
    <div class="row g-4">

      <!-- Depoimento 1 -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 border-0 text-center">
          <div class="card-body">
            <i class="bi bi-quote fs-1 text-danger"></i>
            <p class="fst-italic">
              "Antes eu tinha dificuldade em matemática, mas com os resumos e exercícios do Saber Conecta consegui entender melhor a matéria. 
              Hoje estudo sozinha em casa e consigo acompanhar a turma com mais confiança."
            </p>
            <img src="public/assets/images/ensinomedio.jpg" alt="Aluno" class="rounded-circle mt-3" width="70" height="70">
            <h6 class="mt-2 mb-0">Maria Clara</h6>
            <small class="text-muted">Estudante do Ensino Médio</small>
          </div>
        </div>
      </div>

      <!-- Depoimento 2 -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 border-0 text-center">
          <div class="card-body">
            <i class="bi bi-quote fs-1 text-danger"></i>
            <p class="fst-italic">
              "Como professor, sempre busquei formas de compartilhar meus materiais além da sala de aula. 
              No Saber Conecta consegui disponibilizar apostilas e listas de exercícios para vários alunos, e recebi feedbacks muito positivos."
            </p>
            <img src="public/assets/images/professor.jpg" alt="Professor" class="rounded-circle mt-3" width="70" height="70">
            <h6 class="mt-2 mb-0">João Pedro</h6>
            <small class="text-muted">Professor de História</small>
          </div>
        </div>
      </div>

      <!-- Depoimento 3 -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 border-0 text-center">
          <div class="card-body">
            <i class="bi bi-quote fs-1 text-danger"></i>
            <p class="fst-italic">
              "Sempre tive dificuldade em organizar os estudos, mas no Saber Conecta encontrei materiais bem estruturados e fáceis de entender. 
              Agora consigo revisar conteúdos importantes antes das provas e me sinto muito mais preparada."
            </p>
            <img src="public/assets/images/fundamental.jpg" alt="Aluno" class="rounded-circle mt-3" width="70" height="70">
            <h6 class="mt-2 mb-0">Ana Luiza</h6>
            <small class="text-muted">Estudante do 9º ano</small>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ODS -->
<section class="container mb-5">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h2 class="fw-bold mb-3">Nosso Compromisso</h2>
      <p>Estamos alinhados ao 
        <a href="https://brasil.un.org/pt-br/sdgs/4" target="_blank" class="text-danger fw-bold">
          ODS 4: Educação de Qualidade
        </a>, promovendo aprendizado inclusivo e contínuo.
      </p>
    </div>
    <div class="col-md-6 text-center">
      <div class="p-4 bg-primary bg-opacity-10 rounded">
        <i class="bi bi-mortarboard-fill fs-1 text-primary mb-3"></i>
        <h4 class="text-primary">ODS 4</h4>
        <h5>Educação de Qualidade</h5>
        <p class="text-muted mb-0">Assegurar a educação inclusiva e equitativa e de qualidade, e promover oportunidades de aprendizagem ao longo da vida para todos.</p>
      </div>
    </div>
  </div>
</section>
<!-- CTA FINAL -->
<section class="cta text-center text-white py-5">
  <div class="container">
    <h2 class="fw-bold mb-3">Junte-se a Nós</h2>
    <p class="lead mb-4">Seja como estudante ou educador, você pode fazer parte desta comunidade de aprendizado colaborativo.</p>
  </div>
</section>
