<?php
require_once '../includes/conn.php';

// Construir a query base
$query = "SELECT id, titulo, isbn FROM livros WHERE 1=1";
$params = array();

// Aplicar filtro por título ou ISBN
if (!empty($_GET['busca'])) {
    $query .= " AND (titulo LIKE ? OR isbn LIKE ?)";
    $params[] = "%" . $_GET['busca'] . "%";
    $params[] = "%" . $_GET['busca'] . "%";
}

// Ordenar por título
$query .= " ORDER BY titulo ASC";

// Preparar e executar a query
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Opção padrão
echo '<option value="">Selecione o livro</option>';

// Gerar as opções
if ($result->num_rows > 0) {
    while ($livro = $result->fetch_assoc()) {
        echo sprintf(
            '<option value="%s">%s (ISBN: %s)</option>',
            $livro['id'],
            htmlspecialchars($livro['titulo']),
            htmlspecialchars($livro['isbn'])
        );
    }
}

$stmt->close();
$conn->close();
?> 