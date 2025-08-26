<?php
include('../backend/lista_emprestimos.php');
// echo "Sessão: " . $_SESSION['professor_id'] . "\n";
// var_dump($professor_id);
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empréstimos - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/listar_emprestimos.css?v=1">
</head>

<body>
    <!-- Modal de Confirmação -->
    <div class="modal fade" id="modalConfirmar" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header primary-color text-white">
                    <h5 class="modal-title" id="modalLabel">Confirmar devolução</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja marcar este empréstimo como devolvido?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btnConfirmarDevolucao" href="#" class="btn primary-color">Confirmar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>
    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-0">
                <i class="fas fa-book"></i> Lista de Empréstimos
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-list"></i> Empréstimos Ativos
                </h4>
            </div>
            <div class="card-body">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
                    </div>
                    <div class="card-body">
                        <form id="filtroForm" method="GET">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_aluno" class="form-label">Nome do Aluno</label>
                                    <input type="text" class="form-control" name="filtro_aluno" id="filtro_aluno"
                                        placeholder="Digite o nome do aluno">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_serie" class="form-label">Série</label>
                                    <select class="form-select" name="filtro_serie" id="filtro_serie">
                                        <option value="">Todas as séries</option>
                                        <?php while ($serie = $series_result->fetch_assoc()) { ?>
                                            <option value="<?= $serie['serie'] ?>">
                                                <?= $serie['serie'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_livro" class="form-label">Título ou ISBN do Livro</label>
                                    <input type="text" class="form-control" name="filtro_livro" id="filtro_livro"
                                        placeholder="Digite o título ou ISBN">
                                </div>

                                <!-- Filtrar por empréstimos devolvidos ou não -->
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_emprestimo" class="form-label">Status do empréstimo</label>
                                    <select class="form-control" id="filtro_emprestimo" name="filtro_emprestimo">
                                        <option value="">Todos</option>
                                        <option value="Sim">Devolvidos</option>
                                        <option value="0">Não devolvidos</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search me-1"></i>Aplicar Filtros
                                    </button>
                                    <button type="button" class="btn btn-danger" id="limparFiltros">
                                        <i class="fas fa-times me-2"></i>Limpar Filtros
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-hover" id="tabelaEmprestimos">
                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Aluno</th>
                            <th>Data Empréstimo</th>
                            <th>Data Devolução</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['titulo']); ?></td>
                                    <td><?= htmlspecialchars($row['nome']); ?></td>
                                    <td><?= htmlspecialchars($row['data_emprestimo']); ?></td>
                                    <td><?= htmlspecialchars($row['data_devolucao']); ?></td>
                                    <td>
                                        <?php if ($row['devolvido'] === 'Sim') { ?>
                                            <button class="btn btn-success btn-sm" disabled>
                                                <i class="fas fa-check"></i> Devolvido
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-danger btn-sm btn-confirmar-devolucao"
                                                data-id="<?= (int)$row['id']; ?>">
                                                <i class="fas fa-undo-alt"></i> Devolver
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhum empréstimo encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <a href="dashboard.php" class="btn btn-primary w-100 mt-3">
                    <i class="fas fa-arrow-left"></i> Voltar para o Painel
                </a>
            </div>
        </div>
    </div>
    <div id="footer"></div>
    <link rel="stylesheet" href="_css/footer.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/lista_emprestimos.js"></script>
</body>
</html>
