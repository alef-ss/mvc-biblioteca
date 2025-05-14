<?php
include('../backend/editar_livro.php')
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    
    <link rel="stylesheet" href="_css/editar_livro.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-book"></i> Editar Livro</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" value="<?php echo $livro['titulo']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" name="autor" value="<?php echo $livro['autor']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
                        <input type="text" class="form-control" name="ano_publicacao" value="<?php echo $livro['ano_publicacao']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Gênero</label>
                        <input type="text" class="form-control" name="genero" value="<?php echo $livro['genero']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" name="isbn" value="<?php echo $livro['isbn']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade Disponível</label>
                        <input type="number" class="form-control" name="quantidade" value="<?php echo $livro['quantidade']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Atualizar Livro</button>
                </form>
            </div>
        </div>
        <a href="visualizar_livros.php" class="btn btn-secondary mt-3 w-100">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
