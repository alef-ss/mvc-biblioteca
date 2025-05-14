<?php
include('../backend/login.php')
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Professores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="_css/login.css"> -->
    <!-- <link rel="stylesheet" href="_css/theme.css"> -->
</head>
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

<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4"><i class="fas fa-user"></i> Login de Professores</h2>
            <?php if (isset($erro)) {
                echo "<div class='alert alert-danger'>$erro</div>";
            } ?>
            <form method="POST">
                <div class="mb-4">
                    <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control" name="email" id="email" required aria-label="Email" placeholder="Digite seu email">
                </div>
                <div class="mb-4">
                    <label for="senha" class="form-label"><i class="fas fa-lock"></i> Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha" required aria-label="Senha" placeholder="Digite sua senha">
                </div>
                <button type="submit" class="btn btn-custom"><i class="fas fa-sign-in-alt"></i> Entrar</button>
            </form>
            <p class="text-center mt-4">Ainda não tem uma conta? <a href="cadastro_professor_principal.php" class="hover-effect">Cadastre-se!</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</body>

</html>



<!-- <script src="bloquear_devtools.js"></script> -->
<script>
    // Impede o clique direito do mouse
    document.addEventListener("contextmenu", (event) => event.preventDefault());

    // Bloqueia atalhos para abrir o DevTools
    document.addEventListener("keydown", (event) => {
        if (
            event.key === "F12" ||
            (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "J" || event.key === "C")) ||
            (event.ctrlKey && event.key === "U") ||
            (event.altKey && event.key === "ArrowLeft") // Bloqueia ALT + Seta para voltar
        ) {
            event.preventDefault();
            bloquearAcesso();
        }
    });

    // Detecta se o DevTools está aberto
    let devtoolsOpen = false;
    const element = new Image();
    Object.defineProperty(element, 'id', {
        get: function() {
            devtoolsOpen = true;
            bloquearAcesso();
        }
    });

    // Detecta mudanças no tamanho da tela (indicando DevTools aberto)
    let prevWidth = window.innerWidth;
    let prevHeight = window.innerHeight;

    window.addEventListener("resize", () => {
        if (window.innerWidth < prevWidth || window.innerHeight < prevHeight) {
            bloquearAcesso();
        }
        prevWidth = window.innerWidth;
        prevHeight = window.innerHeight;
    });

    // Checa a cada 500ms se o DevTools foi aberto
    setInterval(() => {
        devtoolsOpen = false;
        console.log(element); // Isso ativa a detecção do DevTools
        if (devtoolsOpen) {
            bloquearAcesso();
        }
    }, 500);

    // Impede que o usuário volte para a página anterior
    window.history.pushState(null, "", window.location.href);
    window.addEventListener("popstate", () => {
        bloquearAcesso();
    });

    // Função para bloquear completamente o acesso
    function bloquearAcesso() {
        setInterval(() => {
            document.body.innerHTML = ""; // Apaga todo o conteúdo da página
            document.body.style.backgroundColor = "black"; // Tela preta
            document.title = "Acesso Bloqueado!";
        }, 10);

        window.location.href = "data:text/html,<h1 style='color: red; text-align: center;'>ACESSO BLOQUEADO!</h1>";

        while (true) {} // Loop infinito para travar o navegador
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
</script>

</body>

</html>