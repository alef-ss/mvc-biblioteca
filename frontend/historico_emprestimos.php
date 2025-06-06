<?php
include('../backend/historico_emprestimos.php')
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Empréstimos - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/historico_emprestimos.css">
</head>

<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-0">
                <i class="fas fa-history"></i> Histórico de Empréstimos
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-search"></i> Filtrar Histórico
                </h4>
            </div>
            <div class="card-body">
                <!-- Formulário de Pesquisa -->
                <form method="GET" action="historico_emprestimos.php" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="aluno" placeholder="Nome do Aluno" value="<?php echo htmlspecialchars($_GET['aluno'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="livro" placeholder="Título do Livro" value="<?php echo htmlspecialchars($_GET['livro'] ?? ''); ?>">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="estado">
                                <option value="">Estado do Livro</option>
                                <option value="0" <?php if (isset($_GET['estado']) && $_GET['estado'] == '0') echo 'selected'; ?>>Não Devolvido</option>
                                <option value="1" <?php if (isset($_GET['estado']) && $_GET['estado'] == '1') echo 'selected'; ?>>Devolvido</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="data_inicio" value="<?php echo htmlspecialchars($_GET['data_inicio'] ?? ''); ?>" placeholder="Data Início">
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="data_fim" value="<?php echo htmlspecialchars($_GET['data_fim'] ?? ''); ?>" placeholder="Data Fim">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Tabela de Histórico -->
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                        <td>
                                            <span class="badge <?php echo $row['devolvido'] == '0' ? 'bg-danger' : 'bg-success'; ?>">
                                                <?php echo $row['devolvido'] == '0' ? 'Não Devolvido' : 'Devolvido'; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Botões de Exportação -->
                <div class="d-flex justify-content-center gap-3">
                    <a href="exportar_csv.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success">
                        <i class="fas fa-file-csv"></i> Exportar para CSV
                    </a>
                    <a href="exportar_pdf.php?<?php echo http_build_query($_GET); ?>" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Exportar para PDF
                    </a>
                </div>

                <a href="dashboard.php" class="btn btn-primary w-100 mt-3">
                    <i class="fas fa-arrow-left"></i> Voltar para o Painel
                </a>
            </div>
        </div>
    </div>
    <div id="footer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/historico_emprestimos.js"></script>
    <link rel="stylesheet" href="_css/footer.css">
</body>

</html>

<?php
$conn->close();
?>