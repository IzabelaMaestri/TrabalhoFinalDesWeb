// =====================
// Helpers
// =====================
function showError(input, message) {
  input.classList.add("is-invalid");
  let feedback = input.parentNode.querySelector(".invalid-feedback");
  if (!feedback) {
    feedback = document.createElement("div");
    feedback.className = "invalid-feedback";
    input.parentNode.appendChild(feedback);
  }
  feedback.textContent = message;
}

function clearError(input) {
  input.classList.remove("is-invalid");
  const feedback = input.parentNode.querySelector(".invalid-feedback");
  if (feedback) feedback.textContent = "";
}

// =====================
// Validações de Formulários
// =====================

// Cadastro de Usuário
function validateCadastroUsuario(event) {
  let valid = true;
  const form = event.target;

  const nome = form.querySelector("#inputNome");
  const email = form.querySelector("#inputEmail");
  const senha = form.querySelector("#inputPassword");
  const confirmar = form.querySelector("#inputConfirmPassword");

  clearError(nome);
  clearError(email);
  clearError(senha);
  clearError(confirmar);

  if (nome.value.trim().length < 3) {
    showError(nome, "O nome deve ter pelo menos 3 caracteres.");
    valid = false;
  }

  if (!email.value.includes("@")) {
    showError(email, "Digite um email válido.");
    valid = false;
  }

  if (senha.value.length < 8) {
    showError(senha, "A senha deve ter pelo menos 8 caracteres.");
    valid = false;
  }

  if (senha.value !== confirmar.value) {
    showError(confirmar, "As senhas não coincidem.");
    valid = false;
  }

  if (!valid) event.preventDefault();
  return valid;
}

// Login
function validateLogin(event) {
  let valid = true;
  const form = event.target;

  const email = form.querySelector("#inputEmail");
  const senha = form.querySelector("#inputPassword");

  clearError(email);
  clearError(senha);

  if (email.value.trim() === "" || !email.value.includes("@")) {
    showError(email, "Digite um email válido.");
    valid = false;
  }

  if (senha.value.trim().length < 8) {
    showError(senha, "A senha deve ter pelo menos 8 caracteres.");
    valid = false;
  }

  if (!valid) event.preventDefault();
  return valid;
}

// Cadastro de Material
function validateCadastroMaterial(event) {
  let valid = true;
  const form = event.target;

  const titulo = form.querySelector("#materialTitulo");
  const descricao = form.querySelector("#materialDescricao");
  const tipo = form.querySelector("#materialTipo");
  const disciplina = form.querySelector("#materialDisciplina");
  const nivel = form.querySelector("#materialNivel");
  const link = form.querySelector("#materialLink");

  [titulo, descricao, tipo, disciplina, nivel, link].forEach(clearError);

  if (titulo.value.trim().length < 5) {
    showError(titulo, "O título deve ter pelo menos 5 caracteres.");
    valid = false;
  }

  if (descricao.value.trim().length < 10) {
    showError(descricao, "A descrição deve ter pelo menos 10 caracteres.");
    valid = false;
  }

  if (!tipo.value) {
    showError(tipo, "Selecione um tipo de material.");
    valid = false;
  }

  if (disciplina.value.trim() === "") {
    showError(disciplina, "Informe a disciplina.");
    valid = false;
  }

  if (nivel.value.trim() === "") {
    showError(nivel, "Informe o nível/série.");
    valid = false;
  }

  if (link.value.trim() === "") {
    showError(link, "Informe o link ou conteúdo do material.");
    valid = false;
  }

  if (!valid) event.preventDefault();
  return valid;
}

// Perfil
function validatePerfil(event) {
  let valid = true;
  const form = event.target;

  const nome = form.querySelector("#profileName");
  clearError(nome);

  if (nome.value.trim().length < 3) {
    showError(nome, "O nome deve ter pelo menos 3 caracteres.");
    valid = false;
  }

  if (!valid) event.preventDefault();
  return valid;
}

// =====================
// Ativação automática
// =====================
document.addEventListener("DOMContentLoaded", () => {
  const cadastroForm = document.querySelector("form[action*='cadastrar_usuario.php']");
  if (cadastroForm) cadastroForm.addEventListener("submit", validateCadastroUsuario);

  const loginForm = document.querySelector("form[action*='login.php']");
  if (loginForm) loginForm.addEventListener("submit", validateLogin);

  const materialForm = document.querySelector("form[action*='cadastrar_material.php']");
  if (materialForm) materialForm.addEventListener("submit", validateCadastroMaterial);

  const perfilForm = document.querySelector("form[action*='atualizar_perfil.php']");
  if (perfilForm) perfilForm.addEventListener("submit", validatePerfil);
});
