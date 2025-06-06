<?php
include('../backend/editar_livro.php')
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/editar_livro.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-0">
                <i class="fas fa-book"></i> Editar Livro
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-edit"></i> Editar Informações do Livro
                </h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">
                            <i class="fas fa-heading"></i> Título
                        </label>
                        <input type="text" class="form-control" name="titulo" value="<?php echo $livro['titulo']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">
                            <i class="fas fa-user-edit"></i> Autor
                        </label>
                        <input type="text" class="form-control" name="autor" value="<?php echo $livro['autor']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ano_publicacao" class="form-label">
                            <i class="fas fa-calendar-alt"></i> Ano de Publicação
                        </label>
                        <input type="text" class="form-control" name="ano_publicacao" value="<?php echo $livro['ano_publicacao']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">
                            <i class="fas fa-bookmark"></i> Gênero
                        </label>
                        <input type="text" class="form-control" name="genero" value="<?php echo $livro['genero']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">
                            <i class="fas fa-barcode"></i> ISBN
                        </label>
                        <input type="text" class="form-control" name="isbn" value="<?php echo $livro['isbn']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">
                            <i class="fas fa-cubes"></i> Quantidade Disponível
                        </label>
                        <input type="number" class="form-control" name="quantidade" value="<?php echo $livro['quantidade']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Atualizar Livro
                    </button>
                </form>
            </div>
        </div>
        <a href="visualizar_livros.php" class="btn btn-secondary w-100">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
        <div class="" id="footer"></div>
        <link rel="stylesheet" href="_css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
    </script>
</body>
</html>

<?php
$conn->close();
?>
