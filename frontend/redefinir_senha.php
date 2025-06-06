<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/redefinir_senha.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-2">
                <i class="fas fa-key"></i> Redefinição de Senha
            </h1>
        </div>
    </div>

    <div class="container" style="max-width: 500px;">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">
                    <i class="fas fa-lock"></i> Redefinir Senha
                </h3>
            </div>
            <div class="card-body">
                <?php
                // Exibir mensagens de erro
                if (isset($_SESSION['erros'])) {
                    foreach ($_SESSION['erros'] as $erro) {
                        echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i> $erro</div>";
                    }
                    unset($_SESSION['erros']);
                }

                // Exibir mensagem de sucesso
                if (isset($_SESSION['sucesso'])) {
                    echo "<div class='alert alert-success'><i class='fas fa-check-circle'></i> {$_SESSION['sucesso']}</div>";
                    unset($_SESSION['sucesso']);
                }

                // Se os dados foram validados, mostrar formulário de nova senha
                if (isset($_SESSION['dados_validos']) && $_SESSION['dados_validos'] === true) {
                    ?>
                    <form action="../backend/redefinir_senha.php" method="POST">
                        <input type="hidden" name="action" value="reset">
                        
                        <div class="mb-3">
                            <label for="nova_senha" class="form-label">
                                <i class="fas fa-lock"></i> Nova Senha
                            </label>
                            <input type="password" class="form-control" id="nova_senha" name="nova_senha" required minlength="6">
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> A senha deve ter pelo menos 6 caracteres.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="confirmar_senha" class="form-label">
                                <i class="fas fa-lock"></i> Confirmar Nova Senha
                            </label>
                            <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required minlength="6">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Alterar Senha
                            </button>
                            <a href="login.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar para Login
                            </a>
                        </div>
                    </form>
                    <?php
                } else {
                    // Formulário inicial de verificação
                    ?>
                    <form action="../backend/redefinir_senha.php" method="POST">
                        <div class="mb-3">
                            <label for="cpf" class="form-label">
                                <i class="fas fa-id-card"></i> CPF
                            </label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required 
                                   value="<?php echo isset($_SESSION['cpf']) ? htmlspecialchars($_SESSION['cpf']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> E-mail
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required
                                   value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Verificar Dados
                            </button>
                            <a href="login.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar para Login
                            </a>
                        </div>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="assets/js/redefinir_senha.js"></script>
</body>
</html>
