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
    <link rel="stylesheet" href="assets/css/relatorios.css">
</head>

<body>
    <div class="container mt-4 mb-5">
        <!-- <div class="page-header" id="container-titulo">
            <h1 class="text-center mb-0">
                <i class="fas fa-file-alt animate-bounce" class="fundo-titulo"></i> Relatórios de Empréstimos
            </h1>
        </div> -->


        <body>
            <div class="stars" id="stars"></div>

            <!-- Theme Toggle Button -->
            <button class="theme-toggle" id="themeToggle">
                <i class="fas fa-moon" id="themeIcon"></i>
            </button>


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
                            while ($row = $result_salas->fetch_assoc()):
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
                                    while ($row = $result_alunos->fetch_assoc()):
                                        if ($posicao > 10) break;
                                    ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-<?php
                                                                        echo $posicao === 1 ? 'warning' : ($posicao === 2 ? 'secondary' : ($posicao === 3 ? 'info' : 'light'));
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
    <div id="footer"></div>
    <link rel="stylesheet" href="_css/footer.css">
    <script src="assets/js/relatorios.js"></script>
    <script>
        fetch('../includes/footer.html')
            .then(res => res.text())
            .then(data => {
                document.getElementById('footer').innerHTML = data;
            });
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
                        while ($row = $result_livros->fetch_assoc()) {
                            echo '"' . addslashes($row['titulo']) . '",';
                        }
                        ?>
                    ],
                    datasets: [{
                        label: 'Total de Empréstimos',
                        data: [
                            <?php
                            $result_livros->data_seek(0);
                            while ($row = $result_livros->fetch_assoc()) {
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
                                    meta.data[index].transition({
                                        opacity: 0
                                    }).update();
                                } else {
                                    meta.data[index].transition({
                                        opacity: 1
                                    }).update();
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
    </script>
</body>

</html>
<?php
$conn->close();
?>