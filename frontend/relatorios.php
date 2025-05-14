<?php
include('../backend/relatorios.php')
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Empréstimos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="_css/relatorios.css">
</head>
<body>
    <div class="container mt-5">
        <div class="page-header">
            <h1 class="text-center mb-0">
                <i class="fas fa-file-alt"></i> Relatórios de Empréstimos
            </h1>
        </div>

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-users"></i> Alunos que Mais Pegaram Livros</h2>
            </div>
            <div class="card-body">
                <?php if ($result_alunos->num_rows > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Total de Empréstimos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result_alunos->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['nome']; ?></td>
                                    <td><?php echo $row['total_emprestimos']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Nenhum empréstimo registrado.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-school"></i> Sala que Mais Pegou Livros</h2>
            </div>
            <div class="card-body">
                <?php if ($result_salas->num_rows > 0): ?>
                    <?php $row = $result_salas->fetch_assoc(); ?>
                    <p><strong><?php echo $row['serie']; ?></strong> com <?php echo $row['total_emprestimos']; ?> empréstimos.</p>
                <?php else: ?>
                    <p class="text-center">Nenhuma sala registrada.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-book"></i> Livros Mais Emprestados</h2>
            </div>
            <div class="card-body">
                <canvas id="livrosChart"></canvas>
            </div>
        </div>

        <a href="dashboard.php" class="btn btn-primary w-100 mb-4">
            <i class="fas fa-arrow-left"></i> Voltar para o Painel
        </a>
    </div>

    <script>
        var ctx = document.getElementById('livrosChart').getContext('2d');
        var livrosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    $result_livros->data_seek(0);
                    while($row = $result_livros->fetch_assoc()) {
                        echo '"' . $row['titulo'] . '",';
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
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
