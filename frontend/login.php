<?php
include('../backend/login.php')
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="_css/login.css">
    <style>
        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .alert-danger {
            background-color: rgba(var(--bs-danger-rgb), 0.1);
            color: var(--bs-danger);
        }

        .alert-danger::before {
            background-color: var(--bs-danger);
        }

        .alert-success {
            background-color: rgba(var(--bs-success-rgb), 0.1);
            color: var(--bs-success);
        }

        .alert-success::before {
            background-color: var(--bs-success);
        }

        .alert i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .alert-message {
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .invalid-feedback {
            font-size: 0.875rem;
            color: var(--bs-danger);
            display: none;
            margin-top: 0.25rem;
        }

        .form-control.is-invalid {
            border-color: var(--bs-danger);
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
</head>

<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-2">
                <i class="fas fa-book"></i> Sistema de Gestão de Biblioteca
            </h1>
        </div>
    </div>

    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-0">
                    <i class="fas fa-user"></i> Login de Professores
                </h2>
            </div>
            <div class="card-body">
                <div id="mensagens">
                    <!-- As mensagens de erro e sucesso serão inseridas aqui via JavaScript -->
                </div>

                <form method="POST" id="loginForm" novalidate>
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" name="email" id="email" required
                            placeholder="Digite seu email">
                        <div class="invalid-feedback">
                            Por favor, insira um email válido.
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="senha" class="form-label">
                            <i class="fas fa-lock"></i> Senha
                        </label>
                        <input type="password" class="form-control" name="senha" id="senha" required
                            placeholder="Digite sua senha" minlength="6">
                        <div class="invalid-feedback">
                            A senha deve ter pelo menos 6 caracteres.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3" id="btnLogin">
                        <i class="fas fa-sign-in-alt"></i> Entrar
                    </button>
                    <div class="text-center">
                        <a href="redefinir_senha.php" class="forgot-password">
                            <i class="fas fa-key"></i> Esqueceu a senha?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
        document.addEventListener("contextmenu", (event) => event.preventDefault());

        // Bloqueia atalhos para abrir o DevTools
        document.addEventListener("keydown", (event) => {
            if (
                event.key === "F12" ||
                (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "J" || event.key === "C")) ||
                (event.ctrlKey && event.key === "U") ||
                (event.altKey && event.key === "ArrowLeft")
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
        $('#loginForm').on('submit', function(event) {
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
                    success: function(response) {
                        if (response.sucesso) {
                            mostrarMensagem('success', 'Sucesso!', response.mensagem);
                            // Redirecionar após 2 segundos
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 2000);
                        } else {
                            mostrarMensagem('danger', 'Erro no Login', response.mensagem);
                            btnLogin.html(btnTextoOriginal).prop('disabled', false);
                        }
                    },
                    error: function() {
                        mostrarMensagem('danger', 'Erro no Login', 'Ocorreu um erro ao tentar fazer login. Por favor, tente novamente.');
                        btnLogin.html(btnTextoOriginal).prop('disabled', false);
                    }
                });
            }
        });

        // Remover classe is-invalid ao digitar
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                // Limpar mensagens de erro quando o usuário começa a digitar
                $('#mensagens').empty();
            });
        });
    </script>
</body>

</html>