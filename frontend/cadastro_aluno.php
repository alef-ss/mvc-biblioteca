<?php
// Inclui o arquivo backend para processar o cadastro
include('../backend/cadastro_aluno.php');

// Inicia a sessão para acessar mensagens de toast
// session_start();

// Verifica se existe mensagem de toast na sessão e a armazena em $toast, depois remove da sessão
$toast = null;
if (isset($_SESSION['toast'])) {
    $toast = $_SESSION['toast'];
    unset($_SESSION['toast']);
}
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/cadastro_aluno.css">
    <link rel="stylesheet" href="assets/css/toast.css">
</head>

<body>
    <!-- Botão para alternar tema claro/escuro -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-2">
                <i class="fas fa-user-graduate"></i> Cadastro de Aluno
            </h1>
        </div>
    </div>

    <?php if ($toast): ?>
        <!-- Exibe mensagem toast com base no tipo (success ou error) -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
            <div class="toast align-items-center text-bg-<?php echo $toast['type'] === 'success' ? 'success' : 'danger'; ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo htmlspecialchars($toast['message']); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
                </div>
                <div class="toast-progress"></div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h4>
                        <i class="fas fa-user-plus"></i> Novo Aluno
                    </h4>
                    <a href="lista_alunos.php" class="btn btn-secondary" style="cursor: pointer; z-index: 10;">
                        <i class="fas fa-list"></i> Ver Lista de Alunos
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Formulário para cadastro de aluno -->
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nome" class="form-label">
                            <i class="fas fa-user"></i> Nome Completo
                        </label>
                        <input type="text" class="form-control" name="nome" id="nome" required
                            placeholder="Digite o nome completo">
                    </div>
                    <div class="mb-3">
                        <label for="serie" class="form-label">
                            <i class="fas fa-graduation-cap"></i> Série
                        </label>
                        <input type="text" class="form-control" name="serie" id="serie" required
                            placeholder="Digite a série">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" name="email" id="email" required
                            placeholder="Digite o email">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Cadastrar Aluno
                    </button>
                </form>
            </div>
        </div>

        <a href="dashboard.php" class="btn btn-primary w-100" id="voltaDashboardId">
            <i class="fas fa-arrow-left"></i> Voltar para o Painel
        </a>
    </div>
    <div id="footer"></div>
    <link rel="stylesheet" href="_css/footer.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/cadastro_aluno.js"></script>
    <script src="assets/js/toast.js"></script>
</body>

</html>
