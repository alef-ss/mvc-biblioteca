<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professores - Biblioteca Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --hover-color: #2980b9;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: var(--primary-color);
            font-weight: 700;
        }

        .btn-custom {
            background-color: var(--secondary-color);
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
        }

        .form-control {
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .hover-effect {
            color: var(--secondary-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .hover-effect:hover {
            color: var(--hover-color);
            text-decoration: underline;
        }

        /* Validação */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
        }

        /* Máscara para CPF */
        #cpf {
            padding-left: 40px;
        }

        .input-group-text {
            background-color: #e9ecef;
            border-right: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <?php
            session_start();
            if (isset($_SESSION['erro_cadastro'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ' . $_SESSION['erro_cadastro'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                unset($_SESSION['erro_cadastro']);
            }
            if (isset($_SESSION['sucesso_cadastro'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ' . $_SESSION['sucesso_cadastro'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                unset($_SESSION['sucesso_cadastro']);
            }
            ?>

            <h2 class="text-center mb-4"><i class="fas fa-user-graduate me-2"></i>Cadastro de Professores</h2>
            <form method="POST" action="../backend/cadastro_professor_principal.php" id="cadastroForm" novalidate>
                <div class="mb-4">
                    <label for="nome" class="form-label"><i class="fas fa-user me-2"></i>Nome Completo</label>
                    <input type="text" class="form-control" name="nome" id="nome" required aria-label="Nome" placeholder="Digite seu nome completo">
                    <div class="invalid-feedback">Por favor, insira seu nome completo.</div>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>E-mail Institucional</label>
                    <input type="email" class="form-control" name="email" id="email" required aria-label="Email" placeholder="exemplo@escola.com">
                    <div class="invalid-feedback">Por favor, insira um e-mail válido.</div>
                </div>
                <div class="mb-4">
                    <label for="cpf" class="form-label"><i class="fas fa-id-card me-2"></i>CPF</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                        <input type="text" class="form-control" name="cpf" id="cpf" required aria-label="CPF" placeholder="000.000.000-00" maxlength="14">
                    </div>
                    <div class="invalid-feedback">Por favor, insira um CPF válido.</div>
                </div>
                <div class="mb-4">
                    <label for="senha" class="form-label"><i class="fas fa-lock me-2"></i>Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha" required aria-label="Senha" placeholder="Mínimo 8 caracteres" minlength="8">
                    <div class="invalid-feedback">A senha deve ter pelo menos 8 caracteres.</div>
                    <div class="form-text">Use letras, números e caracteres especiais para maior segurança.</div>
                </div>
                <div class="form-group">
                    <label for="codigo_secreto">Código Secreto (para administradores)</label>
                    <input type="text" name="codigo_secreto" id="codigo_secreto" class="form-control" placeholder="Opcional">
                    <button type="submit" class="btn btn-custom mt-3">
                        <i class="fas fa-user-plus me-2"></i>Cadastrar
                    </button>
                </div>
            </form>
            <p class="text-center mt-4">Já tem uma conta? <a href="login.php" class="hover-effect"><i class="fas fa-sign-in-alt me-1"></i>Faça login aqui</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        // Máscara para CPF
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00', {
                reverse: false
            });

            // Validação do formulário
            (function() {
                'use strict'

                var forms = document.querySelectorAll('.needs-validation')

                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()

            // Validação customizada do CPF
            document.getElementById('cadastroForm').addEventListener('submit', function(event) {
                const cpfInput = document.getElementById('cpf');
                const cpf = cpfInput.value.replace(/[^\d]/g, '');

                if (cpf.length !== 11 || !validarCPF(cpf)) {
                    cpfInput.classList.add('is-invalid');
                    event.preventDefault();
                    event.stopPropagation();
                }
            });

            // Função para validar CPF (simplificada para frontend)
            function validarCPF(cpf) {
                if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

                let soma = 0;
                for (let i = 0; i < 9; i++) {
                    soma += parseInt(cpf.charAt(i)) * (10 - i);
                }
                let resto = 11 - (soma % 11);
                let digito1 = resto >= 10 ? 0 : resto;

                soma = 0;
                for (let i = 0; i < 10; i++) {
                    soma += parseInt(cpf.charAt(i)) * (11 - i);
                }
                resto = 11 - (soma % 11);
                let digito2 = resto >= 10 ? 0 : resto;

                return parseInt(cpf.charAt(9)) === digito1 && parseInt(cpf.charAt(10)) === digito2;
            }
        });
    </script>
</body>

</html>