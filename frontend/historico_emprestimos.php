<?php
include('../backend/historico_emprestimos.php')
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Empréstimos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="_css/historico_emprestimos.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-history"></i> Histórico de Empréstimos</h4>
            </div>
            <div class="card-body">
                <!-- Formulário de Pesquisa -->
                <form method="GET" action="historico_emprestimos.php" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="aluno" placeholder="Aluno" value="<?php echo htmlspecialchars($_GET['aluno'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="livro" placeholder="Livro" value="<?php echo htmlspecialchars($_GET['livro'] ?? ''); ?>">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="estado">
                                <option value="">Estado do Livro</option>
                                <option value="0" <?php if (isset($_GET['estado']) && $_GET['estado'] == '0') echo 'selected'; ?>>Não Devolvido</option>
                                <option value="1" <?php if (isset($_GET['estado']) && $_GET['estado'] == '1') echo 'selected'; ?>>Devolvido</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="data_inicio" value="<?php echo htmlspecialchars($_GET['data_inicio'] ?? ''); ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="data_fim" value="<?php echo htmlspecialchars($_GET['data_fim'] ?? ''); ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Buscar</button>
                        </div>
                    </div>
                </form>

                <!-- Tabela de Histórico -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Aluno</th>
                            <th>Data de Empréstimo</th>
                            <th>Data de Devolução</th>
                            <th>Estado do Livro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['livro']; ?></td>
                                    <td><?php echo $row['aluno']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['data_emprestimo'])); ?></td>
                                    <td><?php echo $row['data_devolucao'] ? date('d/m/Y', strtotime($row['data_devolucao'])) : 'Não devolvido'; ?></td>
                                    <td><?php echo $row['devolvido'] == '0' ? 'Não Devolvido' : 'Devolvido'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Botões de Exportação -->
                <div class="text-center">
                    <a href="exportar_csv.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success">Exportar para CSV</a>
                    <a href="exportar_pdf.php?<?php echo http_build_query($_GET); ?>" class="btn btn-danger">Exportar para PDF</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>