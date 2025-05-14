<?php
include('../backend/gerenciar_emprestimos.php')
?>
<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empréstimo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            --form-bg: #ffffff;
            --input-bg: #f8f9fa;
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
            --form-bg: #2d2d2d;
            --input-bg: #3d3d3d;
        }

        body {
            background: var(--body-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            transition: all 0.8s ease;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .container {
            max-width: 800px;
            margin-top: 3rem;
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-weight: 600;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        form {
            background-color: var(--form-bg);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px var(--shadow-color);
            transition: all 0.5s ease;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--primary-color);
            color: var(--text-color);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--input-bg);
            color: var(--text-color);
            border-color: var(--primary-hover);
            box-shadow: 0 0 0 0.25rem rgba(0, 121, 107, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--shadow-color);
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

        /* Theme Animation Overlay */
        .theme-animation {
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
        }

        .sun-moon-container {
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
        }

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

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                margin-top: 1.5rem;
            }
            
            form {
                padding: 1.5rem;
            }
            
            .theme-toggle {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <!-- Theme Animation Overlay -->
    <div class="theme-animation" id="themeAnimation">
        <div class="sun-moon-container">
            <div class="sun-moon" id="sunMoon">
                <div class="sun"></div>
                <div class="moon"></div>
            </div>
        </div>
    </div>
    
    <!-- Floating Stars -->
    <div class="stars" id="stars"></div>
    
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="container">
        <h2 class="text-center">Registrar Empréstimo</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Série</label>
                <select class="form-select" id="filtro_serie">
                    <option value="">Todas</option>
                    <?php while ($classe = $classes->fetch_assoc()) {
                        echo "<option value='" . $classe['serie'] . "'>" . $classe['serie'] . "</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Pesquisar Aluno</label>
                <input type="text" id="pesquisar_aluno" class="form-control" placeholder="Digite o nome do aluno">
            </div>
            <div class="mb-3">
                <label class="form-label">Aluno</label>
                <select class="form-select" name="aluno_id" id="lista_alunos" required>
                    <?php
                    $alunos = $conn->query("SELECT id, nome, serie FROM alunos");
                    while ($aluno = $alunos->fetch_assoc()) {
                        echo "<option value='" . $aluno['id'] . "' data-serie='" . $aluno['serie'] . "'>" . $aluno['nome'] . " - " . $aluno['serie'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Livro</label>
                <select class="form-select" name="livro_id" required>
                    <?php
                    $livros = $conn->query("SELECT id, titulo FROM livros WHERE quantidade > 0");
                    while ($livro = $livros->fetch_assoc()) {
                        echo "<option value='" . $livro['id'] . "'>" . $livro['titulo'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar Empréstimo</button>
            <a href="dashboard.php" class="btn btn-primary w-100" style="margin-top: 10px;">Voltar para o Painel do Professor</a>
        </form>
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

        // Filtro de alunos
        document.getElementById("filtro_serie").addEventListener("change", function() {
            let serieSelecionada = this.value;
            let alunos = document.querySelectorAll("#lista_alunos option");
            alunos.forEach(op => {
                if (serieSelecionada === "" || op.getAttribute("data-serie") === serieSelecionada) {
                    op.style.display = "block";
                } else {
                    op.style.display = "none";
                }
            });
        });

        // Pesquisa de alunos
        document.getElementById("pesquisar_aluno").addEventListener("input", function() {
            let termo = this.value.toLowerCase();
            let alunos = document.querySelectorAll("#lista_alunos option");
            alunos.forEach(op => {
                if (op.textContent.toLowerCase().includes(termo)) {
                    op.style.display = "block";
                } else {
                    op.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>
