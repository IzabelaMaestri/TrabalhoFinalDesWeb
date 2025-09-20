function handleLogin(event) {
    event.preventDefault();

    const email = document.getElementById('inputEmail').value;
    const password = document.getElementById('inputPassword').value;

    if (email === 'estudante@saberconecta.com' && password === '12345') {
        alert('Login de Estudante bem-sucedido! Redirecionando para a área do estudante.');
        sessionStorage.setItem('loggedInUserType', 'estudante');
        window.location.href = 'materiais_estudante.html';
    } else if (email === 'educador@saberconecta.com' && password === '12345') {
        alert('Login de Educador bem-sucedido! Redirecionando para a área do educador.');
        sessionStorage.setItem('loggedInUserType', 'educador');
        window.location.href = 'meus_materiais.html'; 
    } else {
        alert('Email ou senha incorretos. Tente novamente.');
    }
}

function handleRegister(event) {
    event.preventDefault();

    const nome = document.getElementById('inputNome').value;
    const email = document.getElementById('inputEmail').value;
    const password = document.getElementById('inputPassword').value;
    const confirmPassword = document.getElementById('inputConfirmPassword').value;
    const userType = document.querySelector('input[name="userType"]:checked');

    if (nome.length < 3) {
        alert('O nome deve ter pelo menos 3 caracteres.');
        return;
    }
    if (!email.includes('@') || !email.includes('.')) {
        alert('Por favor, insira um email válido.');
        return;
    }
    if (password.length < 6) {
        alert('A senha deve ter pelo menos 6 caracteres.');
        return;
    }
    if (password !== confirmPassword) {
        alert('As senhas não coincidem.');
        return;
    }
    if (!userType) {
        alert('Selecione o tipo de usuário (Estudante ou Educador).');
        return;
    }

    alert(`Usuário ${nome} (${userType.value}) cadastrado com sucesso! Redirecionando para o login.`);
    window.location.href = 'login.html';
}

function handleLogout(event) {
    event.preventDefault();
    sessionStorage.removeItem('loggedInUserType');
    alert('Você foi desconectado. Redirecionando para a página inicial.');
    window.location.href = 'index.html';
}

function validateGenericForm(event) {
    const form = event.target;
    if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    form.classList.add('was-validated');
    return form.checkValidity();
}

function filterMaterials() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const materialCards = document.querySelectorAll('.card-material');

    materialCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const description = card.querySelector('.card-text').textContent.toLowerCase();

        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('.login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }

    const registerForm = document.querySelector('.register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', handleRegister);
    }

    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', handleLogout);
    }

    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function (event) {
            validateGenericForm(event);
        }, false);
    });

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', filterMaterials);
    }

    const loggedInUserType = sessionStorage.getItem('loggedInUserType');
    const publicNavItems = document.querySelectorAll('.nav-link[data-access="public"]');
    const studentNavItems = document.querySelectorAll('.nav-link[data-access="student"]');
    const educatorNavItems = document.querySelectorAll('.nav-link[data-access="educator"]');
    const loginNavItem = document.getElementById('navLogin');
    const registerNavItem = document.getElementById('navRegister');
    const logoutNavItem = document.getElementById('navLogout');

    studentNavItems.forEach(item => item.style.display = 'none');
    educatorNavItems.forEach(item => item.style.display = 'none');
    if (logoutNavItem) logoutNavItem.style.display = 'none';

    if (loggedInUserType === 'estudante') {
        publicNavItems.forEach(item => item.style.display = 'block');
        studentNavItems.forEach(item => item.style.display = 'block');
        if (loginNavItem) loginNavItem.style.display = 'none';
        if (registerNavItem) registerNavItem.style.display = 'none';
        if (logoutNavItem) logoutNavItem.style.display = 'block';
    } else if (loggedInUserType === 'educador') {
        publicNavItems.forEach(item => item.style.display = 'block');
        educatorNavItems.forEach(item => item.style.display = 'block');
        if (loginNavItem) loginNavItem.style.display = 'none';
        if (registerNavItem) registerNavItem.style.display = 'none';
        if (logoutNavItem) logoutNavItem.style.display = 'block';
    } else {
        publicNavItems.forEach(item => item.style.display = 'block');
        if (loginNavItem) loginNavItem.style.display = 'block';
        if (registerNavItem) registerNavItem.style.display = 'block';
    }

    const currentPath = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    if (document.getElementById('materiaisList')) {
        const materiais = [
            { id: 1, titulo: "Matemática: Frações para Iniciantes", tipo: "Vídeo", disciplina: "Matemática", nivel: "Fundamental I" },
            { id: 2, titulo: "História: A Revolução Industrial", tipo: "Texto", disciplina: "História", nivel: "Fundamental II" },
            { id: 3, titulo: "Ciências: O Ciclo da Água", tipo: "Vídeo", disciplina: "Ciências", nivel: "Fundamental I" },
            { id: 4, titulo: "Português: Regras de Acentuação", tipo: "Texto", disciplina: "Português", nivel: "Fundamental II" },
            { id: 5, titulo: "Física: Leis de Newton Descomplicadas", tipo: "Vídeo", disciplina: "Física", nivel: "Ensino Médio" },
            { id: 6, titulo: "Química: Tabela Periódica em 5 Minutos", tipo: "Texto", disciplina: "Química", nivel: "Ensino Médio" }
        ];

        const materiaisList = document.getElementById('materiaisList');
        materiais.forEach(material => {
            const cardHtml = `
                <div class="col-md-4 mb-4">
                    <div class="card h-100 card-material">
                        <div class="card-body">
                            <h5 class="card-title">${material.titulo}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">${material.tipo} - ${material.disciplina}</h6>
                            <p class="card-text">Nível: ${material.nivel}</p>
                            <a href="#" class="btn btn-primary btn-sm">Ver Material</a>
                        </div>
                    </div>
                </div>
            `;
            materiaisList.innerHTML += cardHtml;
        });
    }

    if (document.getElementById('meusMateriaisList')) {
        const meusMateriais = [
            { id: 101, titulo: "Meu Vídeo sobre Equações", tipo: "Vídeo", disciplina: "Matemática", nivel: "Fundamental II" },
            { id: 102, titulo: "Meu Resumo de Biologia", tipo: "Texto", disciplina: "Biologia", nivel: "Ensino Médio" }
        ];
        const meusMateriaisList = document.getElementById('meusMateriaisList');
        meusMateriais.forEach(material => {
            const listItemHtml = `
                <li class="list-group-item">
                    <span>${material.titulo} (${material.tipo}) - ${material.disciplina}</span>
                    <div class="actions">
                        <button class="btn btn-sm btn-info me-2">Editar</button>
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </div>
                </li>
            `;
            meusMateriaisList.innerHTML += listItemHtml;
        });
    }

    if (document.getElementById('usuariosList')) {
        const usuarios = [
            { id: 201, nome: "Ana Silva", email: "ana.silva@saber.com", tipo: "Estudante" },
            { id: 202, nome: "Bruno Souza", email: "bruno.souza@saber.com", tipo: "Estudante" },
            { id: 203, nome: "Carlos Lima", email: "carlos.lima@saber.com", tipo: "Educador" }
        ];
        const usuariosList = document.getElementById('usuariosList');
        usuarios.forEach(usuario => {
            const listItemHtml = `
                <li class="list-group-item">
                    <span>${usuario.nome} (${usuario.tipo}) - ${usuario.email}</span>
                    <div class="actions">
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </div>
                </li>
            `;
            usuariosList.innerHTML += listItemHtml;
        });
    }

    if (document.getElementById('profileForm')) {
        const loggedInUserType = sessionStorage.getItem('loggedInUserType');
        if (loggedInUserType === 'estudante') {
            document.getElementById('profileName').value = 'Estudante Exemplo';
            document.getElementById('profileEmail').value = 'estudante@saberconecta.com';
            document.getElementById('profileType').value = 'Estudante';
            document.getElementById('profileDescription').value = 'Interessado em matemática e ciências.';
        } else if (loggedInUserType === 'educador') {
            document.getElementById('profileName').value = 'Professor Exemplo';
            document.getElementById('profileEmail').value = 'educador@saberconecta.com';
            document.getElementById('profileType').value = 'Educador';
            document.getElementById('profileDescription').value = 'Professor de física e química.';
        }
    }
});