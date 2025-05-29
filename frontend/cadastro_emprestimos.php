<?php
include('../backend/cadastro_emprestimos.php');
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empréstimo | Sistema Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        .card {
            border-radius: 16px;
            box-shadow: 0 10px 30px var(--shadow-color);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background-color: var(--card-bg);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 1.5rem;
            border-bottom: none;
            font-weight: 600;
        }

        .form-control, .form-select {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            padding: 0.8rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
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

        .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
        }

        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .alert-danger {
            background-color: rgba(239, 35, 60, 0.1);
            color: var(--danger-color);
        }

        .select2-container .select2-selection--single {
            height: 38px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            color: var(--text-color);
        }

        .select2-dropdown {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        .select2-container--default .select2-results__option {
            color: var(--text-color);
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Botão Voltar -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="dashboard.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar ao Painel
                </a>
            </div>
        </div>

        <!-- Theme Toggle Button -->
        <button class="theme-toggle" id="themeToggle">
            <i class="fas fa-moon" id="themeIcon"></i>
        </button>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Filtros -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
                    </div>
                    <div class="card-body">
                        <form id="filtroForm" method="GET">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_aluno" class="form-label">Nome do Aluno</label>
                                    <input type="text" class="form-control" name="filtro_aluno" id="filtro_aluno" 
                                           placeholder="Digite o nome do aluno">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_serie" class="form-label">Série</label>
                                    <select class="form-select" name="filtro_serie" id="filtro_serie">
                                        <option value="">Todas as séries</option>
                                        <?php while ($serie = $series_result->fetch_assoc()) { ?>
                                            <option value="<?= $serie['serie'] ?>">
                                                <?= $serie['serie'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_livro" class="form-label">Título ou ISBN do Livro</label>
                                    <input type="text" class="form-control" name="filtro_livro" id="filtro_livro" 
                                           placeholder="Digite o título ou ISBN">
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-danger" id="limparFiltros">
                                        <i class="fas fa-times me-2"></i>Limpar Filtros
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Formulário de Empréstimo -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Novo Empréstimo</h5>
                    </div>
                    <div class="card-body">
                        <?php if(isset($success_message)): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="" id="emprestimoForm">
                            <div class="mb-3">
                                <label for="aluno_id" class="form-label">
                                    <i class="fas fa-user-graduate me-2"></i>Aluno
                                </label>
                                <select class="form-select" name="aluno_id" required id="alunoSelect">
                                    <option value="">Selecione o aluno</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="livro_id" class="form-label">
                                    <i class="fas fa-book me-2"></i>Livro
                                </label>
                                <select class="form-select" name="livro_id" required id="livroSelect">
                                    <option value="">Selecione o livro</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="data_emprestimo" class="form-label">
                                        <i class="far fa-calendar-alt me-2"></i>Data de Empréstimo
                                    </label>
                                    <input type="date" class="form-control" name="data_emprestimo" required id="dataEmprestimo">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="data_devolucao" class="form-label">
                                        <i class="far fa-calendar-check me-2"></i>Data de Devolução
                                    </label>
                                    <input type="date" class="form-control" name="data_devolucao" required id="dataDevolucao">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Registrar Empréstimo
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer"></div>
    <link rel="stylesheet" href="_css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        $(document).ready(function() {
            // Inicializar Select2
            $('#alunoSelect').select2({
                placeholder: "Selecione um aluno",
                allowClear: true
            });

            $('#livroSelect').select2({
                placeholder: "Selecione um livro",
                allowClear: true
            });

            // Função para carregar alunos filtrados
            function carregarAlunos() {
                const filtroAluno = $('#filtro_aluno').val();
                const filtroSerie = $('#filtro_serie').val();

                $.ajax({
                    url: '../backend/filtrar_alunos.php',
                    type: 'GET',
                    data: {
                        nome: filtroAluno,
                        serie: filtroSerie
                    },
                    success: function(response) {
                        $('#alunoSelect').html(response).trigger('change');
                    }
                });
            }

            // Função para carregar livros filtrados
            function carregarLivros() {
                const filtroLivro = $('#filtro_livro').val();

                $.ajax({
                    url: '../backend/filtrar_livros.php',
                    type: 'GET',
                    data: {
                        busca: filtroLivro
                    },
                    success: function(response) {
                        $('#livroSelect').html(response).trigger('change');
                    }
                });
            }

            // Event listeners para os filtros
            $('#filtro_aluno, #filtro_serie').on('input change', function() {
                carregarAlunos();
            });

            $('#filtro_livro').on('input', function() {
                carregarLivros();
            });

            // Limpar filtros
            $('#limparFiltros').click(function() {
                $('#filtroForm')[0].reset();
                $('#filtro_serie').val('').trigger('change');
                carregarAlunos();
                carregarLivros();
            });

            // Definir data de empréstimo como hoje por padrão
            const today = new Date().toISOString().split('T')[0];
            $('#dataEmprestimo').val(today);

            // Calcular data de devolução
            $('#dataEmprestimo').change(function() {
                const emprestimoDate = new Date($(this).val());
                if (!isNaN(emprestimoDate.getTime())) {
                    const devolucaoDate = new Date(emprestimoDate);
                    devolucaoDate.setDate(devolucaoDate.getDate() + 7);
                    $('#dataDevolucao').val(devolucaoDate.toISOString().split('T')[0]);
                }
            }).trigger('change');

            // Carregar dados iniciais
            carregarAlunos();
            carregarLivros();
        });
    </script>
</body>
</html>