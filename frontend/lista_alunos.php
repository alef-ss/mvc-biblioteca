<?php
include('../backend/lista_alunos.php')
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/lista_alunos.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-users"></i> Lista de Alunos</h4>
                    <a href="cadastro_aluno.php" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Cadastrar Aluno
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php
                // Exibindo a lista de alunos cadastrados
                require '../includes/conn.php';
                $sql = "SELECT id, nome, serie, email FROM alunos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Série</th>
                                    <th>Email</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['nome'] . "</td>
                                <td>" . $row['serie'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>
                                    <a href='?deletar=" . $row['id'] . "' class='btn btn-danger btn-sm'>
                                        <i class='fas fa-trash-alt'></i> Deletar
                                    </a>
                                </td>
                            </tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p>Nenhum aluno cadastrado.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
        <br>
                <a href="dashboard.php" class="btn btn-primary w-100" id="voltaDashboardId">Voltar para o Painel</a>
                <br>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
