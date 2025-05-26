<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

// Buscar estatísticas gerais
$stmt = $conn->prepare("
    SELECT 
        (SELECT COUNT(*) FROM emprestimos WHERE YEAR(data_emprestimo) = YEAR(CURRENT_DATE())) as emprestimos_ano,
        (SELECT COUNT(*) FROM emprestimos WHERE devolvido = 0) as emprestimos_pendentes,
        (SELECT COUNT(*) FROM emprestimos WHERE data_devolucao < CURRENT_DATE() AND devolvido = 0) as emprestimos_atrasados,
        (SELECT COUNT(*) FROM livros) as total_livros
    FROM dual
");
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios | Sistema Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-book-reader"></i>
            <span>Biblioteca Admin</span>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="dashboard.php">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="professores.php">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Professores</span>
                    </a>
                </li>
                <li class="active">
                    <a href="relatorios.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>Relatórios</span>
                    </a>
                </li>
                <li>
                    <a href="configuracoes.php">
                        <i class="fas fa-cog"></i>
                        <span>Configurações</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="content-header">
            <div class="header-left">
                <button id="sidebarToggle" class="btn btn-link">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>Relatórios</h1>
            </div>
            <div class="header-right">
                <div class="btn-group">
                    <button class="btn btn-success" onclick="exportarRelatorio('excel')">
                        <i class="fas fa-file-excel"></i> Exportar Excel
                    </button>
                    <button class="btn btn-danger" onclick="exportarRelatorio('pdf')">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </button>
                </div>
            </div>
        </header>

        <!-- Stats Overview -->
        <div class="row stats-cards">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div class="stats-info">
                        <h3><?php echo $stats['emprestimos_ano']; ?></h3>
                        <p>Empréstimos no Ano</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-info">
                        <h3><?php echo $stats['emprestimos_pendentes']; ?></h3>
                        <p>Empréstimos Pendentes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stats-info">
                        <h3><?php echo $stats['emprestimos_atrasados']; ?></h3>
                        <p>Empréstimos Atrasados</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-books"></i>
                    </div>
                    <div class="stats-info">
                        <h3><?php echo $stats['total_livros']; ?></h3>
                        <p>Total de Livros</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="filtrosForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tipo de Relatório</label>
                                <select class="form-select" id="tipoRelatorio">
                                    <option value="emprestimos">Empréstimos</option>
                                    <option value="livros">Livros</option>
                                    <option value="alunos">Alunos</option>
                                    <option value="professores">Professores</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Data Inicial</label>
                                <input type="date" class="form-control" id="dataInicial">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Data Final</label>
                                <input type="date" class="form-control" id="dataFinal">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="status">
                                    <option value="">Todos</option>
                                    <option value="pendente">Pendentes</option>
                                    <option value="devolvido">Devolvidos</option>
                                    <option value="atrasado">Atrasados</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Gerar Relatório
                    </button>
                </form>
            </div>
        </div>

        <!-- Report Content -->
        <div class="card">
            <div class="card-body">
                <div id="relatorioContent">
                    <!-- O conteúdo do relatório será carregado aqui -->
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        const savedTheme = localStorage.getItem('theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
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

        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });

        // Relatório Functions
        let relatorioGerado = false;

        function gerarRelatorio() {
            const tipo = $('#tipoRelatorio').val();
            const dataInicial = $('#dataInicial').val();
            const dataFinal = $('#dataFinal').val();
            const status = $('#status').val();

            $.ajax({
                url: '../../backend/admin/gerar_relatorio.php',
                type: 'POST',
                data: {
                    tipo: tipo,
                    data_inicial: dataInicial,
                    data_final: dataFinal,
                    status: status
                },
                success: function(response) {
                    $('#relatorioContent').html(response);
                    relatorioGerado = true;
                },
                error: function() {
                    alert('Erro ao gerar relatório');
                    relatorioGerado = false;
                }
            });
        }

        function exportarRelatorio(formato) {
            if (!relatorioGerado) {
                alert('Por favor, gere o relatório primeiro antes de exportar.');
                return;
            }

            const tipo = $('#tipoRelatorio').val();
            const dataInicial = $('#dataInicial').val();
            const dataFinal = $('#dataFinal').val();
            const status = $('#status').val();

            window.location.href = `../../backend/admin/exportar_relatorio.php?formato=${formato}&tipo=${tipo}&data_inicial=${dataInicial}&data_final=${dataFinal}&status=${status}`;
        }

        // Event Listeners
        $(document).ready(function() {
            // Inicializar com relatório padrão
            gerarRelatorio();

            // Adicionar listener para mudanças nos filtros
            $('#tipoRelatorio, #dataInicial, #dataFinal, #status').on('change', function() {
                relatorioGerado = false;
            });

            // Listener para o botão de gerar relatório
            $('#filtrosForm').on('submit', function(e) {
                e.preventDefault();
                gerarRelatorio();
            });
        });
    </script>
</body>
</html> 