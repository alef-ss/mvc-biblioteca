<?php
include('../backend/cadastro_livro.php')
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="_css/cadastro_livro.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h4>Gerenciar Livros</h4>
            </div>
            <div class="card-body">
                <a href="dashboard.php" class="btn btn-warning mb-3">Voltar ao Painel</a>

                <form method="POST">
                    <label class="form-label">Buscar Livro</label>
                    <input type="text" name="termo_busca" class="form-control" placeholder="Digite o ISBN ou nome">
                    <div class="mt-2">
                        <input type="radio" name="tipo_busca" value="isbn" checked> ISBN
                        <input type="radio" name="tipo_busca" value="nome"> Nome
                    </div>
                    <button type="submit" name="buscar" class="btn btn-primary mt-2">Buscar</button>
                </form>

                <?php if (isset($livros_encontrados) && count($livros_encontrados) > 0): ?>
                    <h5 class="mt-4">Resultados da Pesquisa</h5>
                    <form method="POST">
                        <ul class="list-group mt-3">
                            <?php foreach ($livros_encontrados as $livro): ?>
                                <?php
                                $id = $livro['id'];
                                $titulo = $livro['volumeInfo']['title'] ?? 'Título Desconhecido';
                                $autores = isset($livro['volumeInfo']['authors']) ? implode(', ', $livro['volumeInfo']['authors']) : 'Autor Desconhecido';
                                ?>
                                <li class="list-group-item">
                                    <input type="checkbox" name="livros[]" value="<?php echo $id; ?>">
                                    <strong><?php echo htmlspecialchars($titulo); ?></strong>
                                    <p><?php echo htmlspecialchars($autores); ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="submit" name="cadastrar" class="btn btn-success mt-3 w-100">Cadastrar Livros Selecionados</button>
                    </form>
                <?php elseif (isset($livros_encontrados)): ?>
                    <p class="text-warning mt-3">Nenhum livro encontrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>