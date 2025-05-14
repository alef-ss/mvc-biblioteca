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
    <style>
        :root {
            --primary-color: #00796b;
            --primary-hover: #00695c;
            --secondary-color: #f0f4f8;
            --text-color: #212121;
            --card-bg: #ffffff;
            --body-bg: linear-gradient(135deg, #f0f4f8, #e0e7ff);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --icon-color: #00796b;
            --danger-color: #dc3545;
            --danger-hover: #c82333;
            --header-bg: #00796b;
            --stats-card-bg: #ffffff;
            --quick-action-bg: #e3f2fd;
            --notification-badge: #ff5722;
        }

        [data-theme="dark"] {
            --primary-color: #4db6ac;
            --primary-hover: #26a69a;
            --secondary-color: #121212;
            --text-color: #e0e0e0;
            --card-bg: #1e1e1e;
            --body-bg: linear-gradient(135deg, #121212, #0d0d1a);
            --shadow-color: rgba(0, 0, 0, 0.3);
            --icon-color: #4db6ac;
            --danger-color: #f44336;
            --danger-hover: #d32f2f;
            --header-bg: #004d40;
            --stats-card-bg: #1e1e1e;
            --quick-action-bg: #263238;
            --notification-badge: #ff7043;
        }

        body {
            background: var(--body-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            transition: all 0.8s ease;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .dashboard-header {
            background-color: var(--header-bg);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.8s ease;
        }

        .dashboard-header h1 {
            font-weight: 600;
            font-size: 2rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 8px 24px var(--shadow-color);
            transition: all 0.5s ease;
            background-color: var(--card-bg);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            border-radius: 12px 12px 0 0;
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
            transition: all 0.5s ease;
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 1.5rem;
            background-color: var(--card-bg);
            transition: all 0.5s ease;
        }

        .list-group {
            border-radius: 8px;
            overflow: hidden;
        }

        .list-group-item {
            transition: all 0.4s ease;
            cursor: pointer;
            background-color: var(--card-bg);
            border: none;
            color: var(--primary-color);
            margin-bottom: 6px;
            border-radius: 6px !important;
            padding: 12px 15px;
            position: relative;
        }

        .list-group-item:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 4px 12px var(--shadow-color);
        }

        .list-group-item a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            font-size: 1rem;
            font-weight: 500;
            width: 100%;
        }

        .icon {
            margin-right: 12px;
            color: var(--icon-color);
            font-size: 1.2rem;
            transition: all 0.3s ease;
            width: 24px;
            text-align: center;
        }

        .list-group-item:hover .icon {
            color: white;
            transform: scale(1.1);
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 500;
            width: 100%;
            text-align: left;
        }

        .btn-danger:hover {
            background-color: var(--danger-hover);
            box-shadow: 0 4px 12px var(--shadow-color);
            transform: translateX(5px);
        }

        .stats-card {
            background-color: var(--stats-card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px var(--shadow-color);
            transition: all 0.4s ease;
            cursor: pointer;
            text-align: center;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px var(--shadow-color);
        }

        .stats-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-icon {
            transform: scale(1.1);
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0.5rem 0;
        }

        .stats-label {
            font-size: 1rem;
            color: var(--text-color);
            opacity: 0.8;
        }

        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .quick-action-btn {
            background-color: var(--quick-action-bg);
            color: var(--primary-color);
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            flex: 1;
            min-width: 120px;
            text-align: center;
            box-shadow: 0 2px 8px var(--shadow-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .quick-action-btn:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 4px 16px var(--shadow-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--notification-badge);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }

        /* Animations */
        /* .animate-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.6s forwards;
        } */

        /* @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        } */

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
            border: none;
            outline: none;
        }

        .theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
        }

        .theme-toggle i {
            font-size: 1.5rem;
            transition: all 0.5s ease;
        }

        /* Theme Animation Overlay */
        /* .theme-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.8s ease;
        }

        .theme-animation.active {
            opacity: 1;
        } */

        /* .sun-moon-container {
            width: 200px;
            height: 200px;
            position: relative;
            perspective: 1000px;
        }

        .sun-moon {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 1.5s ease;
        }

        .sun, .moon {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sun {
            background: radial-gradient(circle, #ffeb3b, #ffc107);
            box-shadow: 0 0 80px #ffeb3b;
            transform: rotateY(0deg);
        }

        .sun::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, transparent 60%, rgba(255, 235, 59, 0.3) 100%);
            border-radius: 50%;
            animation: pulse 2s infinite alternate;
        }

        .moon {
            background: radial-gradient(circle, #e0e0e0, #9e9e9e);
            box-shadow: 0 0 80px #e0e0e0;
            transform: rotateY(180deg);
        }

        .moon::before {
            content: '';
            position: absolute;
            background-color: #424242;
            border-radius: 50%;
            width: 30%;
            height: 30%;
            top: 20%;
            left: 20%;
            box-shadow: 
                40px -20px 0 -5px #424242,
                60px 30px 0 -10px #424242,
                20px 60px 0 -7px #424242,
                40px 70px 0 -12px #424242;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.3; }
            100% { transform: scale(1.1); opacity: 0.6; }
        } */

        /* Floating Stars (for dark theme) */
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

        @keyframes twinkle {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 1; }
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
                font-size: 1.8rem;
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
            
            .theme-toggle {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
            }
            
            .stats-card {
                padding: 1rem;
            }
            
            .stats-number {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Theme Animation Overlay -->
    <!-- <div class="theme-animation" id="themeAnimation">
        <div class="sun-moon-container">
            <div class="sun-moon" id="sunMoon">
                <div class="sun"></div>
                <div class="moon"></div>
            </div>
        </div>
    </div> -->

    <!-- Stars for Dark Theme -->
    <div class="stars" id="stars"></div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header">
        <div class="container">
            <h1 class="text-center mb-0">Sistema de Gestão de Biblioteca</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card animate-fade-in" style="animation-delay: 0.1s">
                    <div class="card-header">
                        <h2><i class="fas fa-user"></i> Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item animate-fade-in" style="animation-delay: 0.2s">
                                <a href="cadastro_professor.php">
                                    <i class="fas fa-chalkboard-teacher icon"></i> CADASTRAR PROFESSOR
                                </a>
                            </li>
                            <li class="list-group-item animate-fade-in" style="animation-delay: 0.3s">
                                <a href="cadastro_aluno.php">
                                    <i class="fas fa-user-graduate icon"></i> CADASTRAR ALUNO
                                </a>
                            </li>
                            <!-- <li class="list-group-item animate-fade-in position-relative" style="animation-delay: 0.4s">
                                <a href="enviar_mensagen.php">
                                    <i class="fas fa-envelope icon"></i> MENSAGEM
                                    <span class="notification-badge">3</span>
                                </a>
                            </li>-->
                            <li class="list-group-item animate-fade-in" style="animation-delay: 0.5s">
                                <a href="buscar_livros.php">
                                    <i class="fas fa-book icon"></i> BUSCAR E CADASTRAR LIVROS
                                </a>
                            </li>
                            <!-- <li class="list-group-item animate-fade-in" style="animation-delay: 0.6s">
                                <a href="cadastro_emprestimos.php">
                                    <i class="fas fa-exchange-alt icon"></i> CRIAR EMPRÉSTIMOS
                                </a>
                            </li> -->
                            <li class="list-group-item animate-fade-in" style="animation-delay: 0.7s">
                                <a href="gerenciar_emprestimos.php">
                                    <i class="fas fa-tasks icon"></i> CRIAR EMPRÉSTIMOS
                                </a>
                            </li>
                            <li class="list-group-item animate-fade-in" style="animation-delay: 0.8s">
                                <a href="listar_emprestimos.php">
                                    <i class="fas fa-list icon"></i> EMPRÉSTIMOS REGISTRADOS
                                </a>
                            </li>
                            <li class="list-group-item animate-fade-in" style="animation-delay: 0.9s">
                                <a href="editar_livro.php">
                                    <i class="fas fa-edit icon"></i> EDITAR LIVRO
                                </a>
                            </li>
                            <li class="list-group-item animate-fade-in" style="animation-delay: 1.0s">
                                <a href="visualizar_livros.php">
                                    <i class="fas fa-eye icon"></i> VISUALIZAR LIVROS
                                </a>
                            </li>
                            <li class="list-group-item animate-fade-in" style="animation-delay: 1.1s">
                                <a href="relatorios.php">
                                    <i class="fas fa-file-alt icon"></i> RELATÓRIOS
                                </a>
                            </li>
                            <li class="list-group-item animate-fade-in" style="animation-delay: 1.2s">
                                <a href="historico_emprestimos.php">
                                    <i class="fas fa-history icon"></i> HISTÓRICO
                                </a>
                            </li>
                            <li class="list-group-item animate-fade-in" style="animation-delay: 1.3s">
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
                    <div class="col-md-6 animate-fade-in" style="animation-delay: 0.2s">
                        <div class="stats-card">
                            <div class="text-center">
                                <i class="fas fa-users stats-icon"></i>
                                <div class="stats-number"><?php echo $total_students; ?></div>
                                <div class="stats-label">Alunos Cadastrados</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 animate-fade-in" style="animation-delay: 0.3s">
                        <div class="stats-card">
                            <div class="text-center">
                                <i class="fas fa-book stats-icon"></i>
                                <div class="stats-number"><?php echo $total_books; ?></div>
                                <div class="stats-label">Livros no Acervo</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 animate-fade-in" style="animation-delay: 0.4s">
                        <div class="stats-card">
                            <div class="text-center">
                                <i class="fas fa-exchange-alt stats-icon"></i>
                                <div class="stats-number"><?php echo $total_loans; ?></div>
                                <div class="stats-label">Empréstimos Ativos</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 animate-fade-in" style="animation-delay: 0.5s">
                        <div class="stats-card">
                            <div class="text-center">
                                <i class="fas fa-clock stats-icon"></i>
                                <div class="stats-number"><?php echo $total_pending_returns; ?></div>
                                <div class="stats-label">Devoluções Pendentes</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions animate-fade-in" style="animation-delay: 0.6s">
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
    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;
        const themeAnimation = document.getElementById('themeAnimation');
        const sunMoon = document.getElementById('sunMoon');
        const starsContainer = document.getElementById('stars');
        
        // Check for saved theme preference or use preferred color scheme
        const savedTheme = localStorage.getItem('theme') || 
                          (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
        // Apply saved theme
        html.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);
        
        // Create stars for dark theme
        createStars();
        
        themeToggle.addEventListener('click', () => {
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    // Mudança imediata do tema (sem delay)
    html.setAttribute('data-theme', newTheme);
    updateThemeIcon(newTheme);
    localStorage.setItem('theme', newTheme);
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
        
        // function showThemeAnimation(theme) {
        //     themeAnimation.classList.add('active');
            
        //     if (theme === 'dark') {
        //         sunMoon.style.transform = 'rotateY(180deg)';
        //     } else {
        //         sunMoon.style.transform = 'rotateY(0deg)';
        //     }
            
        //     setTimeout(() => {
        //         themeAnimation.classList.remove('active');
        //     }, 1500);
        // }
        
        function createStars() {
            const starCount = 100;
            
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
        
        // Add animation delays for stats cards
        // document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
        //     el.style.animationDelay = `${index * 0.1 + 0.2}s`;
        // });
        
        // Add click animation to stats cards
        document.querySelectorAll('.stats-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });
        
        // Add hover effect to quick action buttons
        document.querySelectorAll('.quick-action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.querySelector('i').style.transform = 'scale(1.2)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.querySelector('i').style.transform = '';
            });
        });
    </script>
</body>
</html>