<?php
include('../backend/buscar_livros.php')
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Livros - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/buscar_livros.css">
</head>

<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-2">
                <i class="fas fa-book"></i> Buscar e Cadastrar Livros
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-0">
                    <i class="fas fa-search"></i> Buscar Livros
                </h2>
            </div>
            <div class="card-body">
                <form method="GET" action="buscar_livros.php" class="mb-4">
                    <div class="row align-items-end">
                        <div class="col-md-9">
                            <label for="termo_busca" class="form-label">
                                <i class="fas fa-keyboard"></i> Digite o ISBN ou Título do livro
                            </label>
                            <input type="text" class="form-control" name="termo_busca" id="termo_busca"
                                placeholder="Ex: 9788535902775 ou Dom Casmurro" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-search w-100">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>

                <div id="loading" class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2">Buscando livros...</p>
                </div>

                <?php if (isset($livros) && isset($livros['items'])): ?>
                    <form id="formCadastro" method="POST" action="buscar_livros.php">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>Resultados da Pesquisa</h3>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#confirmacaoModal" id="btnCadastrar" disabled>
                                <i class="fas fa-plus-circle"></i> Cadastrar Selecionados
                            </button>
                        </div>

                        <?php foreach ($livros['items'] as $livro): ?>
                            <?php
                            $id = $livro['id'];
                            $titulo = $livro['volumeInfo']['title'] ?? 'Título Desconhecido';
                            $autores = isset($livro['volumeInfo']['authors']) ? implode(', ', $livro['volumeInfo']['authors']) : 'Autor Desconhecido';
                            $isbn = isset($livro['volumeInfo']['industryIdentifiers'][0]['identifier']) ? $livro['volumeInfo']['industryIdentifiers'][0]['identifier'] : 'ISBN Desconhecido';
                            $capa_url = $livro['volumeInfo']['imageLinks']['thumbnail'] ?? 'img/sem_capa.png';
                            ?>
                            <div class="livro-card" style="color: var(--text-color);">
                                <img src="<?php echo $capa_url; ?>" alt="Capa do livro <?php echo htmlspecialchars($titulo); ?>"
                                    class="livro-capa">
                                <div class="livro-info">
                                    <h4 class="livro-titulo"><?php echo htmlspecialchars($titulo); ?></h4>
                                    <p class="livro-autor">
                                        <i class="fas fa-user-edit"></i> <?php echo htmlspecialchars($autores); ?>
                                    </p>
                                    <?php if (!empty($livro['volumeInfo']['previewLink'])): ?>
                                        <a href="<?= htmlspecialchars($livro['volumeInfo']['previewLink']) ?>" target="_blank" class="btn btn-sm btn-primary" style="background-color: var(--primary-color);">Visualizar Livro</a>
                                    <?php else: ?>
                                        <span class="text-muted">Sem visualização</span>
                                    <?php endif; ?>
                                    <p class="livro-isbn">
                                        <i class="fas fa-barcode"></i> ISBN: <?php echo htmlspecialchars($isbn); ?>
                                    </p>
                                    <div class="checkbox-wrapper">
                                        <input type="checkbox" name="livros[]" value="<?php echo $id; ?>"
                                            class="custom-checkbox" onchange="verificarSelecao()">
                                        <label class="ms-2">Selecionar para cadastro</label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                <?php elseif (isset($livros)): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Nenhum livro encontrado.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <a href="dashboard.php" class="btn btn-primary" id="voltar-painel">
            <i class="fas fa-arrow-left"></i> Voltar para o Painel
        </a>
    </div>

    <!-- Modal de confirmação -->
    <div class="modal fade" id="confirmacaoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle"></i> Confirmar Cadastro
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja cadastrar os livros selecionados?</p>
                    <p class="text-muted">
                        <i class="fas fa-info-circle"></i> Esta ação não pode ser desfeita.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" id="confirmarCadastro">
                        <i class="fas fa-check"></i> Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="footer"></div>
    <link rel="stylesheet" href="_css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/buscar_livros.js"></script>
</body>

</html>