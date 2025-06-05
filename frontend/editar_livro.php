<?php
include('../backend/editar_livro.php')
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro - Sistema de Gestão de Biblioteca</title>
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
        }

        .dashboard-header {
            background: var(--header-bg);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 10px 30px var(--shadow-color);
            transition: all 0.4s ease;
            background-color: var(--card-bg);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px var(--shadow-color);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }

        .card-header h2 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            color: white;
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
            background-color: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
        }

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

        @media (max-width: 768px) {
            .card-header h2 {
                font-size: 1.2rem;
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
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-0">
                <i class="fas fa-book"></i> Editar Livro
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-edit"></i> Editar Informações do Livro
                </h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">
                            <i class="fas fa-heading"></i> Título
                        </label>
                        <input type="text" class="form-control" name="titulo" value="<?php echo $livro['titulo']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">
                            <i class="fas fa-user-edit"></i> Autor
                        </label>
                        <input type="text" class="form-control" name="autor" value="<?php echo $livro['autor']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ano_publicacao" class="form-label">
                            <i class="fas fa-calendar-alt"></i> Ano de Publicação
                        </label>
                        <input type="text" class="form-control" name="ano_publicacao" value="<?php echo $livro['ano_publicacao']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">
                            <i class="fas fa-bookmark"></i> Gênero
                        </label>
                        <input type="text" class="form-control" name="genero" value="<?php echo $livro['genero']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">
                            <i class="fas fa-barcode"></i> ISBN
                        </label>
                        <input type="text" class="form-control" name="isbn" value="<?php echo $livro['isbn']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">
                            <i class="fas fa-cubes"></i> Quantidade Disponível
                        </label>
                        <input type="number" class="form-control" name="quantidade" value="<?php echo $livro['quantidade']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Atualizar Livro
                    </button>
                </form>
            </div>
        </div>
        <a href="visualizar_livros.php" class="btn btn-secondary w-100">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
        <div class="" id="footer"></div>
        <link rel="stylesheet" href="_css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        fetch('../includes/footer.html')
        .then(res => res.text())
        .then(data => {
        document.getElementById('footer').innerHTML = data;
        });
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
    </script>
</body>
</html>

<?php
$conn->close();
?>
