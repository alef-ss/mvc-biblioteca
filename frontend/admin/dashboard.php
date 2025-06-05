<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

// Buscar estatísticas
$stmt = $conn->prepare("
    SELECT 
        (SELECT COUNT(*) FROM professores) as total_professores,
        (SELECT COUNT(*) FROM emprestimos WHERE MONTH(data_emprestimo) = MONTH(CURRENT_DATE())) as emprestimos_mes,
        (SELECT COUNT(*) FROM emprestimos WHERE data_devolucao < CURRENT_DATE() AND devolvido = 0) as emprestimos_atrasados,
        (SELECT COUNT(*) FROM alunos) as total_alunos
");
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

// Buscar empréstimos recentes
$stmt = $conn->prepare("
    SELECT e.*, a.nome as aluno_nome, l.titulo as livro_titulo, p.nome as professor_nome
    FROM emprestimos e
    JOIN alunos a ON e.aluno_id = a.id
    JOIN livros l ON e.livro_id = l.id
    JOIN professores p ON e.professor_id = p.id
    ORDER BY e.data_emprestimo DESC
    LIMIT 5
");
$stmt->execute();
$emprestimos_recentes = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo | Sistema Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.css">
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
                <li class="active">
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
                <li>
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
                    <a href="../logout.php">
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
                <h1>Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="admin-info">
                    <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['professor_nome']); ?></span>
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['professor_nome']); ?>&background=random" alt="Admin" class="admin-avatar">
                </div>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="row stats-cards">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-info">
                        <h3><?php echo $stats['total_professores']; ?></h3>
                        <p>Professores</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stats-info">
                        <h3><?php echo $stats['emprestimos_mes']; ?></h3>
                        <p>Empréstimos este mês</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-danger">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-info">
                        <h3><?php echo $stats['emprestimos_atrasados']; ?></h3>
                        <p>Empréstimos atrasados</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-info">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stats-info">
                        <h3><?php echo $stats['total_alunos']; ?></h3>
                        <p>Alunos cadastrados</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ações Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="cadastrar_professor.php" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i>
                                Novo Professor
                            </a>
                            <a href="relatorios.php?type=emprestimos" class="btn btn-success">
                                <i class="fas fa-file-export"></i>
                                Exportar Relatório
                            </a>
                            <a href="emprestimos_atrasados.php" class="btn btn-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                Ver Atrasos
                            </a>
                            <a href="backup.php" class="btn btn-info">
                                <i class="fas fa-database"></i>
                                Backup do Sistema
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Empréstimos Recentes</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Aluno</th>
                                        <th>Livro</th>
                                        <th>Professor</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($emp = $emprestimos_recentes->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($emp['aluno_nome']); ?></td>
                                            <td><?php echo htmlspecialchars($emp['livro_titulo']); ?></td>
                                            <td><?php echo htmlspecialchars($emp['professor_nome']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($emp['data_emprestimo'])); ?></td>
                                            <td>
                                                <?php if ($emp['devolvido']): ?>
                                                    <span class="badge bg-success">Devolvido</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Pendente</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Estatísticas de Empréstimos</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="emprestimosChart"></canvas>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Check for saved theme
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

        // Chart
        const ctx = document.getElementById('emprestimosChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Em dia', 'Atrasados', 'Devolvidos'],
                datasets: [{
                    data: [
                        <?php echo $stats['emprestimos_mes'] - $stats['emprestimos_atrasados']; ?>,
                        <?php echo $stats['emprestimos_atrasados']; ?>,
                        <?php echo $stats['emprestimos_mes']; ?>
                    ],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#17a2b8'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
