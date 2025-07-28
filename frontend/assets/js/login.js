// Theme Toggle Functionality
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const html = document.documentElement;

// Check for saved theme preference
const savedTheme = localStorage.getItem('theme') ||
    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

// Apply saved theme
html.setAttribute('data-theme', savedTheme);
updateThemeIcon(savedTheme);

themeToggle.addEventListener('click', () => {
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';

    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon(newTheme);
});

function updateThemeIcon(theme) {
    themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}

// Impede o clique direito do mouse
// document.addEventListener("contextmenu", (event) => event.preventDefault());

// Bloqueia atalhos para abrir o DevTools
document.addEventListener("keydown", (event) => {
    if (
        event.key === "F12" ||
        (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "J" || event.key === "C")) ||
        (event.ctrlKey && event.key === "U")
        // (event.altKey && event.key === "ArrowLeft")
    ) {
        event.preventDefault();
        bloquearAcesso();
    }
});

// Função para bloquear completamente o acesso
function bloquearAcesso() {
    document.body.innerHTML = "";
    document.body.style.backgroundColor = "black";
    document.title = "Acesso Bloqueado!";
    window.location.href = "data:text/html,<h1 style='color: red; text-align: center;'>ACESSO BLOQUEADO!</h1>";
}

// Protege o campo de senha contra mudanças no HTML
document.addEventListener("DOMContentLoaded", () => {
    let senhaInput = document.querySelector('input[name="senha"]');
    if (senhaInput) {
        senhaInput.setAttribute("readonly", true);
        senhaInput.addEventListener("focus", () => {
            senhaInput.removeAttribute("readonly");
        });
    }
});

// Função para mostrar mensagens
function mostrarMensagem(tipo, titulo, mensagem) {
    const html = `
        <div class="alert alert-${tipo}">
            <div class="alert-title">
                <i class="fas fa-${tipo === 'danger' ? 'exclamation-circle' : 'check-circle'}"></i>${titulo}
            </div>
            <p class="alert-message">${mensagem}</p>
        </div>`;

    $('#mensagens').html(html);
}

// Validação e envio do formulário
$('#loginForm').on('submit', function (event) {
    event.preventDefault();
    let form = this;
    let isValid = true;

    // Validar email
    let emailInput = form.querySelector('#email');
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value)) {
        emailInput.classList.add('is-invalid');
        isValid = false;
    } else {
        emailInput.classList.remove('is-invalid');
    }

    // Validar senha
    let senhaInput = form.querySelector('#senha');
    if (senhaInput.value.length < 6) {
        senhaInput.classList.add('is-invalid');
        isValid = false;
    } else {
        senhaInput.classList.remove('is-invalid');
    }

    if (isValid) {
        // Desabilitar o botão durante o envio
        const btnLogin = $('#btnLogin');
        const btnTextoOriginal = btnLogin.html();
        btnLogin.html('<i class="fas fa-spinner fa-spin"></i> Entrando...').prop('disabled', true);

        // Enviar formulário via Ajax
        $.ajax({
            url: '../backend/login.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.sucesso) {
                    mostrarMensagem('success', 'Sucesso!', response.mensagem);
                    // Redirecionar após 2 segundos
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 2000);
                } else {
                    mostrarMensagem('danger', 'Erro no Login', response.mensagem);
                    btnLogin.html(btnTextoOriginal).prop('disabled', false);
                }
            },
            error: function () {
                mostrarMensagem('danger', 'Erro no Login', 'Ocorreu um erro ao tentar fazer login. Por favor, tente novamente.');
                btnLogin.html(btnTextoOriginal).prop('disabled', false);
            }
        });
    }
});

// Remover classe is-invalid ao digitar
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('input', function () {
        this.classList.remove('is-invalid');
        // Limpar mensagens de erro quando o usuário começa a digitar
        $('#mensagens').empty();
    });
});
