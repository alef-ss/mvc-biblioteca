<?php
include('../backend/lista_emprestimos.php')
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empréstimos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="_css/listar_emprestimos.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-book"></i> Lista de Empréstimos</h4>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Aluno</th>
                            <th>Data Empréstimo</th>
                            <th>Data Devolução</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['titulo']; ?></td>
                                <td><?= $row['nome']; ?></td>
                                <td><?= $row['data_emprestimo']; ?></td>
                                <td><?= $row['data_devolucao']; ?></td>
                                <td>
                                    <a href="?devolver_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">
                                        <i class="fas fa-undo-alt"></i> Devolver
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="dashboard.php" class="btn btn-primary w-100">Voltar para o Painel</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
