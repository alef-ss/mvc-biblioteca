<?php
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php'; // Conexão com o banco

// Função para buscar livros na API do Google
function buscarLivrosGoogle($termo, $tipo = 'nome') {
    $query = $tipo === 'isbn' ? 'isbn:' . urlencode($termo) : urlencode($termo);
    $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $query;
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return $data['items'] ?? [];
}

// Se for uma busca de livros
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    $termo_busca = trim($_POST['termo_busca']);
    $tipo_busca = $_POST['tipo_busca'] ?? 'nome';
    $livros_encontrados = buscarLivrosGoogle($termo_busca, $tipo_busca);
}

// Se for um cadastro de livros
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    if (!empty($_POST['livros'])) {
        foreach ($_POST['livros'] as $livro_id) {
            $livro_info = buscarLivrosGoogle($livro_id, 'isbn');
            $livro = $livro_info[0] ?? null;
            
            if ($livro) {
                $titulo = $livro['volumeInfo']['title'] ?? 'Sem título';
                $autor = implode(', ', $livro['volumeInfo']['authors'] ?? ['Desconhecido']);
                $descricao = $livro['volumeInfo']['description'] ?? 'Sem descrição';
                $isbn = $livro['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? 'Não informado';
                $quantidade = 1;

                // Verifica se já existe no banco
                $sql_check = "SELECT id FROM livros WHERE isbn = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("s", $isbn);
                $stmt_check->execute();
                $stmt_check->store_result();
                
                if ($stmt_check->num_rows == 0) {
                    // Insere no banco
                    $sql = "INSERT INTO livros (titulo, autor, descricao, isbn, quantidade) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssi", $titulo, $autor, $descricao, $isbn, $quantidade);
                    $stmt->execute();
                }
                $stmt_check->close();
            }
        }
    }
}
?>