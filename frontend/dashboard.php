<?php
include('../backend/dashboard.php');
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Sistema de Gestão de Biblioteca</title>
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

        .dashboard-header .subtitle {
            font-weight: 300;
            opacity: 0.9;
            font-size: 1.1rem;
            animation: fadeIn 1s ease 0.3s both;
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

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .card-body {
            padding: 2rem;
            background-color: var(--card-bg);
            transition: all 0.5s ease;
        }

        .list-group {
            border-radius: 12px;
            overflow: hidden;
        }

        .list-group-item {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            cursor: pointer;
            background-color: var(--card-bg);
            border: none;
            color: var(--text-color);
            margin-bottom: 8px;
            border-radius: 8px !important;
            padding: 15px 20px;
            position: relative;
            overflow: hidden;
            border-left: 4px solid transparent;
        }

        .list-group-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-color);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.3s ease;
        }

        .list-group-item:hover {
            background-color: rgba(var(--primary-color-rgb), 0.1);
            transform: translateX(8px);
            box-shadow: 0 5px 15px var(--shadow-color);
        }

        .list-group-item:hover::before {
            transform: scaleY(1);
        }

        .list-group-item a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            font-size: 1rem;
            font-weight: 500;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .icon {
            margin-right: 15px;
            color: var(--icon-color);
            font-size: 1.3rem;
            transition: all 0.3s ease;
            width: 24px;
            text-align: center;
        }

        .list-group-item:hover .icon {
            color: var(--primary-color);
            transform: scale(1.2);
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
            padding: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            width: 100%;
            text-align: left;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .btn-danger::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .btn-danger:hover {
            background-color: var(--danger-hover);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(5px);
        }

        .btn-danger:hover::after {
            transform: translateX(0);
        }

        .stats-card {
            background-color: var(--stats-card-bg);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px var(--shadow-color);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(var(--primary-color-rgb), 0.1);
            animation: fadeInUp 0.6s ease both;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px var(--shadow-color);
        }

        .stats-card:hover::before {
            transform: scaleX(1);
        }

        .stats-icon {
            font-size: 2.8rem;
            color: var(--primary-color);
            margin-bottom: 1.2rem;
            transition: all 0.3s ease;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stats-card:hover .stats-icon {
            transform: scale(1.15) rotate(5deg);
            color: var(--primary-hover);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0.8rem 0;
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-number {
            color: var(--primary-hover);
        }

        .stats-label {
            font-size: 1.1rem;
            color: var(--text-color);
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-label {
            opacity: 1;
        }

        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1.2rem;
            margin-top: 2rem;
        }

        .quick-action-btn {
            background-color: var(--quick-action-bg);
            color: var(--primary-color);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            flex: 1;
            min-width: 150px;
            text-align: center;
            box-shadow: 0 4px 15px var(--shadow-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 1px solid rgba(var(--primary-color-rgb), 0.1);
            position: relative;
            overflow: hidden;
        }

        .quick-action-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
            transform: translateX(-100%);
            transition: transform 0.4s ease;
        }

        .quick-action-btn:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 8px 25px var(--shadow-color);
        }

        .quick-action-btn:hover::after {
            transform: translateX(0);
        }

        .quick-action-btn i {
            transition: all 0.3s ease;
        }

        .quick-action-btn:hover i {
            transform: scale(1.2);
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--notification-badge);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            animation: pulse 1.5s infinite;
        }

        /* Floating Books Animation */
        .floating-books {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.1;
        }

        .floating-book {
            position: absolute;
            font-size: 1.5rem;
            color: var(--primary-color);
            opacity: 0;
            animation: floatBook 15s linear infinite;
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

        /* Stars for Dark Theme */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            opacity: 0;
            transition: opacity 1s ease;
        }

        [data-theme="dark"] .stars {
            opacity: 1;
        }

        .star {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            animation: twinkle var(--duration) infinite ease-in-out;
        }

        /* Book Pulse Animation */
        .book-pulse {
            position: relative;
        }

        .book-pulse::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(var(--primary-color-rgb), 0.1);
            animation: pulse 2s infinite;
            z-index: -1;
            opacity: 0;
        }

        /* Welcome Animation */
        .welcome-animation {
            position: relative;
            overflow: hidden;
        }

        .welcome-animation::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
            transform: translateX(-100%);
            animation: shine 3s infinite;
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

        @keyframes fadeInUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
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

        @keyframes twinkle {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 1; }
        }

        @keyframes pulse {
            0% { 
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0;
            }
            50% { 
                opacity: 0.4;
            }
            100% { 
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0;
            }
        }

        @keyframes floatBook {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.3;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            20% { transform: translateX(100%); }
            100% { transform: translateX(100%); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--secondary-color);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .dashboard-header h1 {
                font-size: 2rem;
            }
            
            .quick-actions {
                flex-direction: column;
            }
            
            .quick-action-btn {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding-bottom: 100px;
            }
            
            .dashboard-header h1 {
                font-size: 1.8rem;
            }
            
            .theme-toggle {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
            }
            
            .stats-card {
                padding: 1.5rem;
            }
            
            .stats-number {
                font-size: 2rem;
            }
            
            .card-body {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .dashboard-header h1 {
                font-size: 1.5rem;
            }
            
            .stats-card {
                padding: 1.2rem;
            }
            
            .stats-number {
                font-size: 1.8rem;
            }
            
            .list-group-item {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Books Background -->
    <div class="floating-books" id="floatingBooks"></div>

    <!-- Stars for Dark Theme -->
    <div class="stars" id="stars"></div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-2">Sistema de Gestão de Biblioteca</h1>
            <div class="subtitle">Bem-vindo ao seu painel de controle</div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card" style="animation-delay: 0.1s">
                    <div class="card-header">
                        <h2><i class="fas fa-user"></i> Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" style="animation-delay: 0.2s">
                                <a href="cadastro_professor.php">
                                    <i class="fas fa-chalkboard-teacher icon"></i> CADASTRAR PROFESSOR
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 0.3s">
                                <a href="cadastro_aluno.php">
                                    <i class="fas fa-user-graduate icon"></i> CADASTRAR ALUNO
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 0.4s">
                                <a href="buscar_livros.php">
                                    <i class="fas fa-book icon book-pulse"></i> BUSCAR E CADASTRAR LIVROS
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 0.5s">
                                <a href="cadastro_emprestimos.php">
                                    <i class="fas fa-exchange-alt icon"></i> CRIAR EMPRÉSTIMOS
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 0.6s">
                                <a href="listar_emprestimos.php">
                                    <i class="fas fa-list icon"></i> EMPRÉSTIMOS REGISTRADOS
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 0.7s">
                                <a href="editar_livro.php">
                                    <i class="fas fa-edit icon"></i> EDITAR LIVRO
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 0.8s">
                                <a href="visualizar_livros.php">
                                    <i class="fas fa-eye icon"></i> VISUALIZAR LIVROS
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 0.9s">
                                <a href="relatorios.php">
                                    <i class="fas fa-file-alt icon"></i> RELATÓRIOS
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 1.0s">
                                <a href="historico_emprestimos.php">
                                    <i class="fas fa-history icon"></i> HISTÓRICO
                                </a>
                            </li>
                            <li class="list-group-item" style="animation-delay: 1.1s">
                                <a href="../backend/logout.php" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt icon"></i> SAIR
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6" style="animation-delay: 0.2s">
                        <div class="stats-card">
                            <div class="text-center">
                                <i class="fas fa-users stats-icon"></i>
                                <div class="stats-number"><?php echo $total_students; ?></div>
                                <div class="stats-label">Alunos Cadastrados</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="animation-delay: 0.3s">
                        <div class="stats-card">
                            <div class="text-center">
                                <i class="fas fa-book stats-icon"></i>
                                <div class="stats-number"><?php echo $total_books; ?></div>
                                <div class="stats-label">Livros no Acervo</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="animation-delay: 0.4s">
                        <div class="stats-card">
                            <div class="text-center">
                                <i class="fas fa-exchange-alt stats-icon"></i>
                                <div class="stats-number"><?php echo $total_loans; ?></div>
                                <div class="stats-label">Empréstimos Ativos</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="animation-delay: 0.5s">
                        <div class="stats-card">
                            <div class="text-center">
                                <i class="fas fa-clock stats-icon"></i>
                                <div class="stats-number"><?php echo $total_pending_returns; ?></div>
                                <div class="stats-label">Devoluções Pendentes</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions" style="animation-delay: 0.6s">
                    <a href="cadastro_emprestimos.php" class="quick-action-btn">
                        <i class="fas fa-plus-circle"></i> Novo Empréstimo
                    </a>
                    <a href="buscar_livros.php" class="quick-action-btn">
                        <i class="fas fa-search"></i> Buscar Livro
                    </a>
                    <a href="relatorios.php" class="quick-action-btn">
                        <i class="fas fa-chart-bar"></i> Relatório Rápido
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;
        const starsContainer = document.getElementById('stars');
        const floatingBooksContainer = document.getElementById('floatingBooks');
        
        // Set RGB values for primary color
        document.documentElement.style.setProperty('--primary-color-rgb', '67, 97, 238');
        
        // Check for saved theme preference or use preferred color scheme
        const savedTheme = localStorage.getItem('theme') || 
                          (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
        // Apply saved theme
        html.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);
        
        // Create stars and floating books
        createStars();
        createFloatingBooks();
        
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            // Play toggle animation
            anime({
                targets: themeToggle,
                rotate: 360,
                duration: 500,
                easing: 'easeInOutSine'
            });
            
            // Change theme immediately
            html.setAttribute('data-theme', newTheme);
            updateThemeIcon(newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update RGB values for primary color
            if (newTheme === 'dark') {
                document.documentElement.style.setProperty('--primary-color-rgb', '76, 201, 240');
            } else {
                document.documentElement.style.setProperty('--primary-color-rgb', '67, 97, 238');
            }
        });
        
        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }
        
        function createStars() {
            const starCount = 150;
            starsContainer.innerHTML = '';
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.classList.add('star');
                
                // Random size between 1 and 3px
                const size = Math.random() * 2 + 1;
                star.style.width = `${size}px`;
                star.style.height = `${size}px`;
                
                // Random position
                star.style.left = `${Math.random() * 100}%`;
                star.style.top = `${Math.random() * 100}%`;
                
                // Random animation duration and delay
                const duration = Math.random() * 5 + 3;
                star.style.setProperty('--duration', `${duration}s`);
                
                starsContainer.appendChild(star);
            }
        }
        
        function createFloatingBooks() {
            const bookIcons = ['fa-book', 'fa-book-open', 'fa-bookmark', 'fa-book-medical'];
            const bookCount = 15;
            
            for (let i = 0; i < bookCount; i++) {
                const book = document.createElement('div');
                book.classList.add('floating-book');
                
                // Random book icon
                const randomIcon = bookIcons[Math.floor(Math.random() * bookIcons.length)];
                book.innerHTML = `<i class="fas ${randomIcon}"></i>`;
                
                // Random position and delay
                book.style.left = `${Math.random() * 100}%`;
                book.style.animationDelay = `${Math.random() * 15}s`;
                book.style.fontSize = `${Math.random() * 1 + 1}rem`;
                
                floatingBooksContainer.appendChild(book);
            }
        }
        
        // Add hover animations to cards
        document.querySelectorAll('.stats-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                anime({
                    targets: card,
                    scale: 1.03,
                    duration: 300,
                    easing: 'easeInOutQuad'
                });
                
                const icon = card.querySelector('.stats-icon');
                anime({
                    targets: icon,
                    rotate: [0, 10, -5, 0],
                    duration: 800,
                    easing: 'easeInOutElastic(1, .5)'
                });
            });
            
            card.addEventListener('mouseleave', () => {
                anime({
                    targets: card,
                    scale: 1,
                    duration: 300,
                    easing: 'easeInOutQuad'
                });
            });
            
            card.addEventListener('click', function() {
                anime({
                    targets: this,
                    scale: 0.95,
                    duration: 200,
                    easing: 'easeInOutQuad',
                    complete: () => {
                        anime({
                            targets: this,
                            scale: 1,
                            duration: 200,
                            easing: 'easeInOutQuad'
                        });
                    }
                });
            });
        });
        
        // Add hover animations to quick action buttons
        document.querySelectorAll('.quick-action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                anime({
                    targets: this.querySelector('i'),
                    scale: [1, 1.2],
                    rotate: [0, 10],
                    duration: 300,
                    easing: 'easeInOutQuad'
                });
            });
            
            btn.addEventListener('mouseleave', function() {
                anime({
                    targets: this.querySelector('i'),
                    scale: 1,
                    rotate: 0,
                    duration: 300,
                    easing: 'easeInOutQuad'
                });
            });
        });
        
        // Add hover animations to menu items
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.icon');
                anime({
                    targets: icon,
                    translateX: [0, 5],
                    duration: 300,
                    easing: 'easeInOutQuad'
                });
            });
            
            item.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.icon');
                anime({
                    targets: icon,
                    translateX: 0,
                    duration: 300,
                    easing: 'easeInOutQuad'
                });
            });
        });
        
        // Animate elements on page load
        document.addEventListener('DOMContentLoaded', () => {
            // Animate cards with staggered delay
            anime({
                targets: '.card, .stats-card',
                opacity: [0, 1],
                translateY: [30, 0],
                scale: [0.95, 1],
                delay: anime.stagger(100, {start: 100}),
                duration: 600,
                easing: 'easeOutExpo'
            });
            
            // Animate quick actions
            anime({
                targets: '.quick-actions',
                opacity: [0, 1],
                translateY: [20, 0],
                delay: 600,
                duration: 500,
                easing: 'easeOutExpo'
            });
            
            // Animate welcome message
            anime({
                targets: '.dashboard-header h1',
                opacity: [0, 1],
                translateY: [-20, 0],
                duration: 800,
                easing: 'easeOutExpo'
            });
            
            anime({
                targets: '.dashboard-header .subtitle',
                opacity: [0, 0.9],
                delay: 300,
                duration: 800,
                easing: 'easeOutExpo'
            });
        });
    </script>
</body>
</html>