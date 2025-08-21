<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

require '../includes/conn.php';

// Configuração de logs
$log_dir = __DIR__ . '/../logs/';
if (!file_exists($log_dir)) {
    mkdir($log_dir, 0755, true);
}
$log_file = $log_dir . 'livros_log_' . date('Y-m-d') . '.txt';

function registrar_log($mensagem, $detalhes = null)
{
    global $log_file;
    $mensagem_completa = date('Y-m-d H:i:s') . " - " . $mensagem;

    if ($detalhes) {
        $mensagem_completa .= " - Detalhes: " . print_r($detalhes, true);
    }

    $mensagem_completa .= PHP_EOL;

    try {
        file_put_contents($log_file, $mensagem_completa, FILE_APPEND | LOCK_EX);
    } catch (Exception $e) {
        error_log("Falha ao escrever no log: " . $e->getMessage());
    }
}

function buscarLivroGoogle($termo)
{
    try {
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($termo);

        // Tenta obter os dados
        $response = @file_get_contents($url);

        if ($response === false) {
            throw new Exception("Não foi possível acessar a API do Google Books.");
        }

        // Decodifica JSON para array associativo
        return json_decode($response, true);

    } catch (Exception $e) {
        // Apenas retorna um array vazio em caso de erro
        // Você pode trocar por echo se quiser exibir o erro
        // echo "Erro ao buscar livros: " . $e->getMessage();
        return [];
    }
}


function buscarDetalhesLivroGoogle($id_livro)
{
    $url = 'https://www.googleapis.com/books/v1/volumes/' . $id_livro;
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function formatarErroBanco($erro)
{
    // Tratamento de erros específicos do MySQL
    if (strpos($erro, "Duplicate entry") !== false) {
        if (strpos($erro, "isbn") !== false) {
            return "Já existe um livro com este ISBN cadastrado.";
        }
        return "Registro duplicado: este livro já existe no sistema.";
    }
    if (strpos($erro, "Data too long") !== false) {
        return "Dados muito longos para algum campo. Verifique especialmente a URL da capa.";
    }
    return "Erro no banco de dados: " . $erro;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['livros']) && !empty($_POST['livros'])) {
        $livros_selecionados = $_POST['livros'];
        $erros = [];
        $sucessos = 0;
        $livros_com_erro = [];

        foreach ($livros_selecionados as $id_livro) {
            try {
                $livro = buscarDetalhesLivroGoogle($id_livro);
                registrar_log("Processando livro", ['id' => $id_livro, 'dados' => $livro]);

                $titulo = $livro['volumeInfo']['title'] ?? 'Título Desconhecido';
                $autor = isset($livro['volumeInfo']['authors']) ? implode(', ', $livro['volumeInfo']['authors']) : 'Autor Desconhecido';
                $isbn = $livro['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? 'ISBN Desconhecido';
                $capa_url = $livro['volumeInfo']['imageLinks']['thumbnail'] ?? 'sem_capa.png';
                $preview_link = $livro['volumeInfo']['previewLink'] ?? NULL;
                $descricao = $livro['volumeInfo']['description'] ?? NULL;
                $categoria = $livro['volumeInfo']['categories'][0] ?? NULL;
                $ano_publicacao = substr($livro['volumeInfo']['publishedDate'], 0, 4) ?? NULL;
                $genero = $livro['volumeInfo']['categories'][0] ?? NULL;
                $quantidade = 1;

                // Validação básica dos dados
                if (empty($isbn)) {
                    throw new Exception("ISBN não encontrado para o livro '$titulo'");
                }

                $sql = "INSERT INTO livros (titulo, autor, isbn, capa_url, descricao, categoria, ano_publicacao, genero, quantidade, preview_link)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar query: " . $conn->error);
                }

                $stmt->bind_param("ssssssssis", $titulo, $autor, $isbn, $capa_url, $descricao, $categoria, $ano_publicacao, $genero, $quantidade, $preview_link);

                if ($stmt->execute()) {
                    $sucessos++;
                } else {
                    $erro_formatado = formatarErroBanco($stmt->error);
                    $erros[] = "$titulo: " . $erro_formatado;
                    $livros_com_erro[] = [
                        'titulo' => $titulo,
                        'isbn' => $isbn,
                        'erro' => $stmt->error
                    ];
                }
            } catch (Exception $e) {
                $erros[] = "Erro ao processar livro: " . $e->getMessage();
                $livros_com_erro[] = [
                    'id' => $id_livro,
                    'erro' => $e->getMessage()
                ];
            }
        }

        if (empty($erros)) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => "$sucessos livro(s) cadastrado(s) com sucesso!"
            ];
            header("Location: buscar_livros.php");
        } else {
            $mensagem = "$sucessos livro(s) cadastrado(s) com sucesso, mas alguns apresentaram erros.";
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => $mensagem
            ];
            $_SESSION['erros'] = $erros;
            $_SESSION['sucessos'] = $sucessos;
            $_SESSION['livros_com_erro'] = $livros_com_erro;
            header("Location: buscar_livros.php");
        }
        exit();
    } else {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => "Nenhum livro selecionado para cadastro."
        ];
        header("Location: buscar_livros.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['termo_busca'])) {
    $termo_busca = $_GET['termo_busca'];
    $livros = buscarLivroGoogle($termo_busca);
}
