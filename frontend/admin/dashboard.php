<?php
session_start();
// Verifica se é admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: ../../frontend/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Painel do Administrador</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <!-- <header>
        <h1>Sistema de Gestão de Biblioteca</h1>
        <h2>Bem-vindo, <?= $_SESSION['nome'] ?>!</h2>
    </header> -->

    <main>
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
                            <h2><i class="fas fa-user"></i> Bem-vindo, <?= $_SESSION['nome']; ?>!</h2>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item animate-fade-in" style="animation-delay: 0.2s">
                                    <a href="../cadastro_professor_principal.php">
                                        <i class="fas fa-chalkboard-teacher icon"></i> CADASTRAR PROFESSOR
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 0.3s">
                                    <a href="../cadastro_aluno.php">
                                        <i class="fas fa-user-graduate icon"></i> CADASTRAR ALUNO
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in position-relative" style="animation-delay: 0.4s">
                                    <a href="../enviar_mensagem.php">
                                        <i class="fas fa-envelope icon"></i> MENSAGEM
                                        <span class="notification-badge">3</span>
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 0.5s">
                                    <a href="../cadastro_livro.php">
                                        <i class="fas fa-book icon"></i> BUSCAR E CADASTRAR LIVROS
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 0.6s">
                                    <a href="../cadastro_emprestimos.php">
                                        <i class="fas fa-exchange-alt icon"></i> CRIAR EMPRÉSTIMOS
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 0.7s">
                                    <a href="../gerenciar_emprestimos.php">
                                        <i class="fas fa-tasks icon"></i> GERENCIAR EMPRÉSTIMOS
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 0.8s">
                                    <a href="../lista_emprestimos.php">
                                        <i class="fas fa-list icon"></i> EMPRÉSTIMOS REGISTRADOS
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 0.9s">
                                    <a href="../editar_livro.php">
                                        <i class="fas fa-edit icon"></i> EDITAR LIVRO
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 1.0s">
                                    <a href="../visualizar_livros.php">
                                        <i class="fas fa-eye icon"></i> VISUALIZAR LIVROS
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 1.1s">
                                    <a href="../relatorios.php">
                                        <i class="fas fa-file-alt icon"></i> RELATÓRIOS
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 1.2s">
                                    <a href="../historico_emprestimos.php">
                                        <i class="fas fa-history icon"></i> HISTÓRICO
                                    </a>
                                </li>
                                <li class="list-group-item animate-fade-in" style="animation-delay: 1.3s">
                                    <a href="../../backend/logout.php" class="btn btn-danger">
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
                                    <div class="stats-number">120</div>
                                    <div class="stats-label">Alunos Cadastrados</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 animate-fade-in" style="animation-delay: 0.3s">
                            <div class="stats-card">
                                <div class="text-center">
                                    <i class="fas fa-book stats-icon"></i>
                                    <div class="stats-number">15</div>
                                    <div class="stats-label">Livros no Acervo</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 animate-fade-in" style="animation-delay: 0.4s">
                            <div class="stats-card">
                                <div class="text-center">
                                    <i class="fas fa-exchange-alt stats-icon"></i>
                                    <div class="stats-number">3</div>
                                    <div class="stats-label">Empréstimos Ativos</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 animate-fade-in" style="animation-delay: 0.5s">
                            <div class="stats-card">
                                <div class="text-center">
                                    <i class="fas fa-clock stats-icon"></i>
                                    <div class="stats-number">3</div>
                                    <div class="stats-label">Devoluções Pendentes</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="quick-actions animate-fade-in" style="animation-delay: 0.6s">
                        <a href="../cadastro_emprestimos.php" class="quick-action-btn">
                            <i class="fas fa-plus-circle"></i> Novo Empréstimo
                        </a>
                        <a href="../buscar_livros.php" class="quick-action-btn">
                            <i class="fas fa-search"></i> Buscar Livro
                        </a>
                        <a href="../relatorios.php" class="quick-action-btn">
                            <i class="fas fa-chart-bar"></i> Relatório Rápido
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de Status Rápidos -->
        <!-- <section class="status-rapidos">
            <div class="alunos-cadastrados"> -->
                <!-- <h3>Alunos Cadastrados</h3> -->
                <!-- (Número dinâmico pode ser adicionado via PHP) -->
                <!-- <p>Total: 120</p>
            </div>

            <div class="livros-acervo">
                <h3>Livros no Acervo</h3>
                <ul>
                    <li><strong>Empréstimos Ativos</strong>: 15</li>
                    <li><strong>Devoluções Pendentes</strong>: 3</li>
                </ul>
            </div>
        </section> -->

        <!-- Ações Rápidas -->
        <!-- <section class="acoes-rapidas">
            <h3>Ações Rápidas</h3>
            <ul>
                <li><a href="../cadastro_emprestimos.php">Novo Empréstimo</a></li>
                <li><a href="../buscar_livros.php">Buscar Livro</a></li>
                <li><a href="../relatorios.php">Relatório Rápido</a></li>
            </ul>
        </section>
    </main> -->

    <!-- Menu Admin (específico para administradores) -->
    <!-- <aside class="menu-admin">
        <h3>Administração</h3>
        <ul>
            <li><a href="listar_professores.php">Listar Professores</a></li>
            <li><a href="alterar_codigo_secreto.php">Alterar Código Secreto</a></li>
            <li><a href="../../backend/logout.php">Sair</a></li>
        </ul>
    </aside> -->
    <!-- Theme Animation Overlay -->
    <div class="theme-animation" id="themeAnimation">
        <div class="sun-moon-container">
            <div class="sun-moon" id="sunMoon">
                <div class="sun"></div>
                <div class="moon"></div>
            </div>
        </div>
    </div>

    <!-- Stars for Dark Theme -->
    <div class="stars" id="stars"></div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

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
            
            // Show animation
            showThemeAnimation(newTheme);
            
            // Change theme after animation
            setTimeout(() => {
                html.setAttribute('data-theme', newTheme);
                updateThemeIcon(newTheme);
                localStorage.setItem('theme', newTheme);
            }, 800);
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
        
        function showThemeAnimation(theme) {
            themeAnimation.classList.add('active');
            
            if (theme === 'dark') {
                sunMoon.style.transform = 'rotateY(180deg)';
            } else {
                sunMoon.style.transform = 'rotateY(0deg)';
            }
            
            setTimeout(() => {
                themeAnimation.classList.remove('active');
            }, 1500);
        }
        
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
        document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1 + 0.2}s`;
        });
        
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
