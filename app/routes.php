<?php
// Arquivo de rotas: retorna um array associativo path => Controller@method
$ROUTES = [
  // Públicas
  ''       => 'SiteController@home',
  'home'   => 'SiteController@home',
  'sobre'  => 'SiteController@sobre',

  // Auth
  'auth/login'    => 'AuthController@login',
  'auth/logout'   => 'AuthController@logout',
  'auth/cadastro' => 'AuthController@cadastro',

  // Usuário
  'usuario/perfil'       => 'UsuarioController@perfil',
  'usuario/excluirConta' => 'UsuarioController@excluirConta',

  // Dashboards
  'dashboard/aluno'     => 'DashboardController@aluno',
  'dashboard/professor' => 'DashboardController@professor',

  // Aluno
  'aluno/materiasDisponiveis' => 'AlunoController@materiasDisponiveis',
  'aluno/escolherMaterias'    => 'AlunoController@escolherMaterias',
  'aluno/salvarMaterias'      => 'AlunoController@salvarMaterias',
  'aluno/favoritos'           => 'AlunoController@favoritos',
  'aluno/recomendados'        => 'AlunoController@recomendados',
  'aluno/acessarMaterial'     => 'AlunoController@acessarMaterial',
  'aluno/dashboard'           => 'AlunoController@dashboard',
  'aluno/meusMateriais'       => 'MaterialController@meusAluno',

  // Materiais (centralizado no MaterialController)
  'material/meusProfessor' => 'MaterialController@meusProfessor',
  'material/form'          => 'MaterialController@form',
  'material/salvar'        => 'MaterialController@salvar',
  'material/excluir'       => 'MaterialController@excluir',
  'material/visualizar'    => 'MaterialController@visualizar',

  // Professor - apenas o que não for material
  'professor/gerenciarAlunos'        => 'ProfessorController@gerenciarAlunos',
  'professor/adicionarDisciplinaAluno' => 'ProfessorController@adicionarDisciplinaAluno',

  // Erros
  'erro/404' => 'ErrorController@notFound',
  'erro/403' => 'ErrorController@forbidden',
  'erro/500' => 'ErrorController@internalError',
  'erro/503' => 'ErrorController@maintenance',
];

return $ROUTES;
