<?php
include('../backend/cadastro_aluno.php')
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
</head>
<body>
    <!-- Theme Toggle Button -->
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

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h4>
                        <i class="fas fa-user-plus"></i> Novo Aluno
                    </h4>
                    <a href="lista_alunos.php" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Ver Lista de Alunos
                    </a>
                </div>
            </div>
            <div class="card-body">
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
                    <div class="mb-3">
                        <label for="senha" class="form-label">
                            <i class="fas fa-lock"></i> Senha
                        </label>
                        <input type="password" class="form-control" name="senha" id="senha" required 
                               placeholder="Digite a senha">
                        <div class="form-text"  style="color: var(--text-color);">
                            <i class="fas fa-info-circle"></i> A senha deve ter no mínimo 6 caracteres
                        </div>
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
</body>
</html>
