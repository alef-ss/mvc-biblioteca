<?php
include('../backend/cadastro_emprestimos.php')
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empréstimo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="_css/cadastro_emprestimos.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Cadastro de Empréstimo</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="aluno_id" class="form-label">Aluno</label>
                        <select class="form-select" name="aluno_id" required>
                            <option value="">Selecione o aluno</option>
                            <?php while ($aluno = $alunos_result->fetch_assoc()) { ?>
                                <option value="<?= $aluno['id'] ?>"><?= $aluno['nome'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="livro_id" class="form-label">Livro</label>
                        <select class="form-select" name="livro_id" required>
                            <option value="">Selecione o livro</option>
                            <?php while ($livro = $livros_result->fetch_assoc()) { ?>
                                <option value="<?= $livro['id'] ?>"><?= $livro['titulo'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="data_emprestimo" class="form-label">Data de Empréstimo</label>
                        <input type="date" class="form-control" name="data_emprestimo" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_devolucao" class="form-label">Data de Devolução</label>
                        <input type="date" class="form-control" name="data_devolucao" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Empréstimo</button>
                </form>
            </div>
        </div>
    </div>
    <a href="dashboard.php">dashboard</a>
</body>
</html>
<?php $conn->close(); ?>
