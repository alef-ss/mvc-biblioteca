<?php
session_start();

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php';

function fetchPreviewLinkByISBN($isbn) {
    $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . urlencode($isbn);
    $response = file_get_contents($url);
    if ($response === false) {
        return null;
    }
    $data = json_decode($response, true);
    if (isset($data['items'][0]['volumeInfo']['previewLink'])) {
        return $data['items'][0]['volumeInfo']['previewLink'];
    }
    return null;
}

$sql = "SELECT id, isbn FROM livros WHERE preview_link IS NULL OR preview_link = ''";
$result = $conn->query($sql);

if (!$result) {
    die("Erro ao consultar livros: " . $conn->error);
}

$updatedCount = 0;

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $isbn = $row['isbn'];

    $previewLink = fetchPreviewLinkByISBN($isbn);

    if ($previewLink) {
        $stmt = $conn->prepare("UPDATE livros SET preview_link = ? WHERE id = ?");
        $stmt->bind_param("si", $previewLink, $id);
        if ($stmt->execute()) {
            $updatedCount++;
        }
        $stmt->close();
    }
}

echo "Atualização concluída. Total de livros atualizados: $updatedCount";

$conn->close();
?>
