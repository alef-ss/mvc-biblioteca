<?php
session_start();
include '../../includes/conn.php';

// Verifica se é admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: ../../frontend/login.php");
    exit();
}

$sql = "SELECT id, nome, email, cpf, ativo, admin FROM professores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Lista de Professores</title>
</head>
<body>
    <h1>Professores Cadastrados</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Status</th>
            <th>Admin</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nome'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['cpf'] ?></td>
            <td><?= $row['ativo'] ? 'Ativo' : 'Inativo' ?></td>
            <td><?= $row['admin'] ? 'Sim' : 'Não' ?></td>
            <td>
                <a href="ativar_desativar.php?id=<?= $row['id'] ?>&acao=<?= $row['ativo'] ? 'desativar' : 'ativar' ?>">
                    <?= $row['ativo'] ? 'Desativar' : 'Ativar' ?>
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Voltar</a>
</body>
</html>