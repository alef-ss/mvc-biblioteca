<?php
require_once '../includes/conn.php';

// Construir a query base
$query = "SELECT id, nome, serie FROM alunos WHERE 1=1";
$params = array();

// Aplicar filtro por nome
if (!empty($_GET['nome'])) {
    $query .= " AND nome LIKE ?";
    $params[] = "%" . $_GET['nome'] . "%";
}

// Aplicar filtro por série
if (!empty($_GET['serie'])) {
    $query .= " AND serie = ?";
    $params[] = $_GET['serie'];
}

// Ordenar por nome
$query .= " ORDER BY nome ASC";

// Preparar e executar a query
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Opção padrão
echo '<option value="">Selecione o aluno</option>';

// Gerar as opções
if ($result->num_rows > 0) {
    while ($aluno = $result->fetch_assoc()) {
        echo sprintf(
            '<option value="%s">%s (%s)</option>',
            $aluno['id'],
            htmlspecialchars($aluno['nome']),
            htmlspecialchars($aluno['serie'])
        );
    }
}

$stmt->close();
$conn->close();
?> 