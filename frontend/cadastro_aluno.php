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
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #f0f4f8;
            --text-color: #212121;
            --card-bg: #ffffff;
            --body-bg: linear-gradient(135deg, #f8f9fa, #e9ecef);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --icon-color: #4361ee;
            --danger-color: #ef233c;
            --danger-hover: #d90429;
            --header-bg: linear-gradient(135deg, #4361ee, #3a0ca3);
            --stats-card-bg: #ffffff;
            --quick-action-bg: #edf2fb;
            --notification-badge: #f72585;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
        }

        [data-theme="dark"] {
            --primary-color: #4cc9f0;
            --primary-hover: #4895ef;
            --secondary-color: #121212;
            --text-color: #e0e0e0;
            --card-bg: #1e1e1e;
            --body-bg: linear-gradient(135deg, #0f0f0f, #1a1a2e);
            --shadow-color: rgba(0, 0, 0, 0.3);
            --icon-color: #4cc9f0;
            --danger-color: #f72585;
            --danger-hover: #b5179e;
            --header-bg: linear-gradient(135deg, #1a1a2e, #16213e);
            --stats-card-bg: #252525;
            --quick-action-bg: #2b2d42;
            --notification-badge: #f72585;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
        }

        body {
            background: var(--body-bg);
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            transition: all 0.5s ease;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .dashboard-header {
            background: var(--header-bg);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
        }

        .dashboard-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeInDown 0.8s ease;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 10px 30px var(--shadow-color);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background-color: var(--card-bg);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
            transform: translateY(0);
            animation: cardEntrance 0.6s ease-out both;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px var(--shadow-color);
        }

        .card-header {
            border-radius: 16px 16px 0 0;
            background: var(--primary-color);
            color: white;
            padding: 1.5rem;
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .card-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        }

        .card-header h4 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            color: white;
        }

        .card-body {
            padding: 2rem;
            background-color: var(--card-bg);
            transition: all 0.5s ease;
        }

        .form-control {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            padding: 0.8rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .form-label {
            color: var(--text-color);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border: none;
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background-color: var(--border-color);
            transform: translateY(-2px);
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            outline: none;
        }

        .theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .theme-toggle i {
            font-size: 1.5rem;
            transition: all 0.5s ease;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInDown {
            from { 
                opacity: 0;
                transform: translateY(-20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-header h1 {
                font-size: 1.8rem;
            }
            
            .theme-toggle {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
            }
            
            .card-body {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .dashboard-header h1 {
                font-size: 1.5rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .alert-danger {
            background-color: rgba(239, 35, 60, 0.1);
            color: var(--danger-color);
        }

        .d-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        #voltaDashboardId {
            margin-top: 1rem;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        #voltaDashboardId:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
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
                        <div class="form-text text-muted">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        // Form validation and feedback
        const form = document.querySelector('form');
        const senhaInput = document.getElementById('senha');

        senhaInput.addEventListener('input', function() {
            if (this.value.length < 6) {
                this.setCustomValidity('A senha deve ter no mínimo 6 caracteres');
            } else {
                this.setCustomValidity('');
            }
        });

        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
            submitButton.disabled = true;
        });
    </script>
</body>
</html>
