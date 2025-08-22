<?php
include('../backend/cadastro_emprestimos.php');
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empréstimo | Sistema Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/cadastro_emprestimos.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Theme Toggle Button -->
        <button class="theme-toggle" id="themeToggle">
            <i class="fas fa-moon" id="themeIcon"></i>
        </button>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Filtros -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
                    </div>
                    <div class="card-body">
                        <form id="filtroForm" method="GET" style="color: whitesmoke;"></form>
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
                                <div class="col-12">
                                    <button type="button" class="btn btn-danger" id="limparFiltros">
                                        <i class="fas fa-times me-2"></i>Limpar Filtros
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Formulário de Empréstimo -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Novo Empréstimo</h5>
                    </div>
                    <div class="card-body">
                        <?php if(isset($success_message)): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="" id="emprestimoForm">
                            <div class="mb-3">
                                <label for="aluno_id" class="form-label">
                                    <i class="fas fa-user-graduate me-2"></i>Aluno
                                </label>
                                <select class="form-select" name="aluno_id" required id="alunoSelect">
                                    <option value="">Selecione o aluno</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="livro_id" class="form-label">
                                    <i class="fas fa-book me-2"></i>Livro
                                </label>
                                <select class="form-select" name="livro_id" required id="livroSelect">
                                    <option value="">Selecione o livro</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="data_emprestimo" class="form-label">
                                        <i class="far fa-calendar-alt me-2"></i>Data de Empréstimo
                                    </label>
                                    <input type="date" class="form-control" name="data_emprestimo" required id="dataEmprestimo" value="<?= date('Y-m-d') ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="data_devolucao" class="form-label">
                                        <i class="far fa-calendar-check me-2"></i>Data de Devolução
                                    </label>
                                    <input type="date" class="form-control" name="data_devolucao" required id="dataDevolucao">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Registrar Empréstimo
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Botão Voltar -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="dashboard.php" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-arrow-left me-2"></i>Voltar ao Painel
                </a>
            </div>
        </div>
            </div>
        </div>
    </div>
    <div id="footer"></div>
    <link rel="stylesheet" href="_css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="assets/js/cadastro_emprestimos.js"></script>
</body>
</html>
