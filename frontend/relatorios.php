<?php
include('../backend/functions.php'); // ou onde você salvou a função
include('../backend/relatorios.php');
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Empréstimos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <link rel="stylesheet" href="_css/relatorios.css">
    <style>
        :root {
    --primary-color: #4361ee; /* Azul primário */
    --primary-hover: #3a56d4; /* Azul escuro para hover */
    --secondary-color: #f0f4f8; /* Cor de fundo suave */
    --text-color: #212121; /* Cor do texto */
    --text-muted: #6c757d; /* Cor para texto desativado */
    --card-bg: #ffffff; /* Cor de fundo dos cards */
    --body-bg: linear-gradient(135deg, #f8f9fa, #e9ecef); /* Fundo suave */
    --shadow-color: rgba(0, 0, 0, 0.1); /* Cor de sombra leve */
    --icon-color: #4361ee; /* Cor dos ícones */
    --danger-color: #ef233c; /* Cor para erros */
    --danger-hover: #d90429; /* Cor de hover para erros */
    --header-bg: linear-gradient(135deg, #4361ee, #3a0ca3); /* Cabeçalho com gradiente de azul */
    --stats-card-bg: #ffffff; /* Fundo de cards de estatísticas */
    --quick-action-bg: #edf2fb; /* Cor de fundo de ações rápidas */
    --notification-badge: #f72585; /* Cor de badge de notificação */
    --success-color: #4cc9f0; /* Cor para sucesso */
    --warning-color: #f8961e; /* Cor de alerta */
    --placeholder-color: #a0a0a0; /* Cor dos placeholders */
}

[data-theme="dark"] {
    --primary-color: #4cc9f0; /* Azul mais claro para o tema escuro */
    --primary-hover: #4895ef; /* Azul escuro para hover no tema escuro */
    --secondary-color: #121212; /* Cor de fundo escura */
    --text-color: #fcf7f7; /* Texto claro para o tema escuro */
    --text-muted: #a0a0a0; /* Texto desativado claro */
    --card-bg: #1e1e1e; /* Cor de fundo dos cards no tema escuro */
    --body-bg: linear-gradient(135deg, #0f0f0f, #1a1a2e); /* Fundo escuro com gradiente */
    --shadow-color: rgba(0, 0, 0, 0.3); /* Sombra mais forte para o tema escuro */
    --icon-color: #4cc9f0; /* Ícones com a cor azul mais clara */
    --danger-color: #f72585; /* Cor de erro em tema escuro */
    --danger-hover: #b5179e; /* Hover de erro em tema escuro */
    --header-bg: linear-gradient(135deg, #1a1a2e, #16213e); /* Cabeçalho escuro com gradiente */
    --stats-card-bg: #252525; /* Fundo de cards de estatísticas no tema escuro */
    --quick-action-bg: #2b2d42; /* Ações rápidas com fundo escuro */
    --notification-badge: #f72585; /* Badge de notificação em tema escuro */
    --success-color: #4cc9f0; /* Cor de sucesso no tema escuro */
    --warning-color: #f8961e; /* Cor de alerta no tema escuro */
    --placeholder-color: #777777; /* Cor de placeholder no tema escuro */
}


/* Apply theme to all elements */
body {
    background: var(--body-bg);
    color: var(--text-color);
    transition: background 0.3s ease, color 0.3s ease;
}

.container-link {
    border-radius: 5px;
}

.titulo {
    --primary-color;
}

/* Tables */
table {
    background-color: var(--table-bg);
    color: var(--table-text);
    border-color: var(--table-border);
}

table th,
table td {
    border-color: var(--table-border);
}

        /* body {
            background: var(--body-bg);
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-color);
            transition: all 0.8s ease;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        } */

        .container {
            max-width: 1200px;
        }
        
        .page-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
            padding: 15px 0;
            border-bottom: 2px solid var(--primary-color);
            margin-bottom: 30px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            background-color: var(--card-bg);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px var(--shadow-color);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), #224abe);
            color: white;
            border-bottom: none;
            padding: 15px 25px;
            border-radius: 15px 15px 0 0 !important;
            transition: all 0.5s ease;
        }
        
        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
        
        .card-header i {
            margin-right: 10px;
        }
        
        .chart-container {
            position: relative;
            margin: auto;
            height: 500px;
            width: 100%;
            background: var(--card-bg);
            border-radius: 10px;
            padding: 20px;
            transition: all 0.5s ease;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            background-color: var(--secondary-color);
            color: var(--text-color);
            font-weight: 700;
            border-top: none;
            transition: all 0.5s ease;
        }
        
        .table td {
            vertical-align: middle;
            color: var(--text-color);
            transition: all 0.5s ease;
        }
        
        .badge-count {
            background-color: var(--notification-badge);
            color: white;
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 50px;
            transition: all 0.5s ease;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #224abe;
            transform: translateY(-2px);
        }
        
        .sala-card {
            border-left: 5px solid var(--primary-color);
            margin-bottom: 15px;
            transition: all 0.5s ease;
        }
        
        .sala-card .card-body {
            padding: 15px;
        }
        
        .sala-card h3 {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .aluno-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--secondary-color);
            transition: all 0.5s ease;
        }
        
        .aluno-row:last-child {
            border-bottom: none;
        }
        
        .aluno-info {
            display: flex;
            align-items: center;
        }
        
        .aluno-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: var(--primary-color);
            font-weight: bold;
            transition: all 0.5s ease;
        }
        
        .animate-bounce {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(78, 115, 223, 0); }
            100% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0); }
        }
        
        .top-sala {
            position: relative;
            overflow: hidden;
        }
        
        .top-sala::after {
            content: "TOP";
            position: absolute;
            top: 10px;
            right: -25px;
            background-color: var(--accent-color);
            color: white;
            width: 100px;
            text-align: center;
            transform: rotate(45deg);
            font-weight: bold;
            font-size: 0.8rem;
        }

        /* Text elements */
.text-muted {
    color: var(--text-muted) !important;
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

.theme-toggle i {
    font-size: 1.5rem;
    transition: all 0.5s ease;
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
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
        <div class="page-header" id="container-titulo">
            <h1 class="text-center mb-0">
                <i class="fas fa-file-alt animate-bounce" class="titulo"></i> Relatórios de Empréstimos
            </h1>
        </div>
<!-- ======= -->
<body>
    <div class="stars" id="stars"></div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- <div class="container mt-4 mb-5">
        <div class="page-header">
            <h1 class="text-center mb-0">
                <i class="fas fa-file-alt animate-bounce"></i> Relatórios de Empréstimos
            </h1>
        </div>
    <div class="container mt-4 mb-5">
        <div class="page-header">
            <h1 class="text-center mb-0">
                <i class="fas fa-file-alt animate-bounce"></i> Relatórios de Empréstimos
            </h1>
        </div> -->

        <!-- Seção de Alunos Destaque -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-trophy"></i> Alunos Destaque</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    // Supondo que temos uma função que retorna os top 3 alunos por sala
                    $top_alunos_por_sala = getTopAlunosPorSala(3); // Implemente esta função no backend
                    
                    if (!empty($top_alunos_por_sala)): 
                        foreach ($top_alunos_por_sala as $sala => $alunos): ?>
                            <div class="col-md-4">
                                <div class="card sala-card <?php echo $sala === array_key_first($top_alunos_por_sala) ? 'top-sala pulse' : ''; ?>">
                                    <div class="card-body">
                                        <h3><i class="fas fa-door-open"></i> <?php echo htmlspecialchars($sala); ?></h3>
                                        <?php foreach ($alunos as $aluno): ?>
                                            <div class="aluno-row">
                                                <div class="aluno-info">
                                                    <div class="aluno-avatar"><?php echo substr($aluno['nome'], 0, 1); ?></div>
                                                    <div>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($aluno['nome']); ?></div>
                                                        <small class="text-muted"><?php echo $aluno['total_emprestimos']; ?> empréstimos</small>
                                                    </div>
                                                </div>
                                                <span class="badge-count"><?php echo $aluno['posicao']; ?>º</span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; 
                    else: ?>
                        <p class="text-center">Nenhum empréstimo registrado.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Seção de Salas Destaque -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-school"></i> Salas Destaque</h2>
            </div>
            <div class="card-body">
                <?php if ($result_salas->num_rows > 0): ?>
                    <div class="row">
                        <?php 
                        $result_salas->data_seek(0);
                        $counter = 0;
                        while($row = $result_salas->fetch_assoc()): 
                            $counter++;
                            if ($counter > 3) break;
                            ?>
                            <div class="col-md-4">
                                <div class="card sala-card <?php echo $counter === 1 ? 'top-sala pulse' : ''; ?>">
                                    <div class="card-body text-center">
                                        <h3><i class="fas fa-door-open"></i> <?php echo htmlspecialchars($row['serie']); ?></h3>
                                        <div class="display-4 fw-bold text-primary"><?php echo $row['total_emprestimos']; ?></div>
                                        <p>empréstimos realizados</p>
                                        <div class="d-flex justify-content-center">
                                            <span class="badge bg-<?php echo $counter === 1 ? 'warning' : ($counter === 2 ? 'secondary' : 'info'); ?>">
                                                <?php echo $counter === 1 ? '1ª colocada' : ($counter === 2 ? '2ª colocada' : '3ª colocada'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center">Nenhuma sala registrada.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Seção de Livros Mais Emprestados -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-book"></i> Livros Mais Emprestados</h2>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="livrosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Seção de Alunos que Mais Pegaram Livros -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user-graduate"></i> Top 10 Alunos</h2>
            </div>
            <div class="card-body">
                <?php if ($result_alunos->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Posição</th>
                                    <th>Aluno</th>
                                    <th>Sala</th>
                                    <th>Total de Empréstimos</th>
                                    <!-- <th>Detalhes</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $result_alunos->data_seek(0);
                                $posicao = 1;
                                while($row = $result_alunos->fetch_assoc()): 
                                    if ($posicao > 10) break;
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $posicao === 1 ? 'warning' : 
                                                    ($posicao === 2 ? 'secondary' : 
                                                    ($posicao === 3 ? 'info' : 'light')); 
                                            ?> text-<?php echo $posicao <= 3 ? 'white' : 'dark'; ?>">
                                                <?php echo $posicao; ?>º
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                                        <td><?php echo htmlspecialchars($row['serie'] ?? 'N/A'); ?></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" 
                                                     role="progressbar" 
                                                     style="width: <?php echo min(100, ($row['total_emprestimos'] / 20) * 100); ?>%" 
                                                     aria-valuenow="<?php echo $row['total_emprestimos']; ?>" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="20">
                                                    <?php echo $row['total_emprestimos']; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-info-circle"></i> Detalhes
                                            </button>
                                        </td> -->
                                    </tr>
                                    <?php 
                                    $posicao++;
                                endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center">Nenhum empréstimo registrado.</p>
                <?php endif; ?>
            </div>
        </div>

        <a href="dashboard.php" class="btn btn-primary w-100 mb-4 mt-3">
            <i class="fas fa-arrow-left"></i> Voltar para o Painel
        </a>
    </div>

    <script>
        // Função para gerar cores dinâmicas para o gráfico
        function generateColors(count) {
            const baseColors = [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                '#858796', '#6f42c1', '#fd7e14', '#20c997', '#17a2b8'
            ];
            let colors = [];
            for (let i = 0; i < count; i++) {
                // Mistura as cores para criar variações
                const color = baseColors[i % baseColors.length];
                colors.push(color);
            }
            return colors;
        }

        // Configuração do gráfico de livros
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('livrosChart').getContext('2d');
            var livrosChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                        <?php
                        $result_livros->data_seek(0);
                        while($row = $result_livros->fetch_assoc()) {
                            echo '"' . addslashes($row['titulo']) . '",';
                        }
                        ?>
                    ],
                    datasets: [{
                        label: 'Total de Empréstimos',
                        data: [
                            <?php
                            $result_livros->data_seek(0);
                            while($row = $result_livros->fetch_assoc()) {
                                echo $row['total_emprestimos'] . ',';
                            }
                            ?>
                        ],
                        backgroundColor: generateColors(<?php echo $result_livros->num_rows; ?>),
                        borderColor: '#fff',
                        borderWidth: 3,
                        hoverOffset: 20,
                        hoverBorderWidth: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right',
                            align: 'center',
                            labels: {
                                font: {
                                    size: 12,
                                    family: "'Nunito', sans-serif",
                                    weight: 'bold'
                                },
                                color: '#5a5c69',
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 10
                            },
                            onClick: function(e, legendItem, legend) {
                                const index = legendItem.index;
                                const ci = legend.chart;
                                const meta = ci.getDatasetMeta(0);
                                
                                // Toggle visibility
                                meta.data[index].hidden = !meta.data[index].hidden;
                                
                                // Fade in/out effect
                                if (meta.data[index].hidden) {
                                    meta.data[index].transition({ opacity: 0 }).update();
                                } else {
                                    meta.data[index].transition({ opacity: 1 }).update();
                                }
                                
                                ci.update();
                            }
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(0,0,0,0.85)',
                            titleFont: { 
                                size: 14, 
                                weight: 'bold',
                                family: "'Nunito', sans-serif"
                            },
                            bodyFont: { 
                                size: 13,
                                family: "'Nunito', sans-serif"
                            },
                            footerFont: {
                                family: "'Nunito', sans-serif"
                            },
                            cornerRadius: 10,
                            padding: 15,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} empréstimos (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 12,
                                family: "'Nunito', sans-serif"
                            },
                            formatter: function(value, context) {
                                const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return value > 0 ? `${percentage}%` : '';
                            },
                            anchor: 'center',
                            align: 'center',
                            offset: 0,
                            clip: false
                        }
                    },
                    onHover: (event, chartElement) => {
                        const target = event.native ? event.native.target : event.target;
                        target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    },
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const label = livrosChart.data.labels[index];
                            const value = livrosChart.data.datasets[0].data[index];
                            alert(`Livro: ${label}\nEmpréstimos: ${value}`);
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
            
            // Efeito de hover nos cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px)';
                    card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.15)';
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = '';
                    card.style.boxShadow = '';
                });
            });
        });

        // Theme Toggle Functionality
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;
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
            
            // Immediate theme change (no delay)
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
    </script>
</body>
</html>

<?php
$conn->close();
?>
