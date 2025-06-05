<?php
include('../backend/lista_emprestimos.php');
echo "Sessão: " . $_SESSION['professor_id'] . "\n";
var_dump($professor_id);
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
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #f0f4f8;
            --text-color: #212121;
            --card-bg: #ffffff;
            --body-bg: linear-gradient(135deg, #f8f9fa, #e9ecef);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --icon-color: #4361ee;
            --danger-color: #ef233c;
            --danger-hover: #d90429;
            --header-bg: linear-gradient(135deg, #4361ee, #3a0ca3);
            --stats-card-bg: #ffffff;
            --quick-action-bg: #edf2fb;
            --notification-badge: #f72585;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
        }

        [data-theme="dark"] {
            --primary-color: #4cc9f0;
            --primary-hover: #4895ef;
            --secondary-color: #121212;
            --text-color: #e0e0e0;
            --card-bg: #1e1e1e;
            --body-bg: linear-gradient(135deg, #0f0f0f, #1a1a2e);
            --shadow-color: rgba(0, 0, 0, 0.3);
            --icon-color: #4cc9f0;
            --danger-color: #f72585;
            --danger-hover: #b5179e;
            --header-bg: linear-gradient(135deg, #1a1a2e, #16213e);
            --stats-card-bg: #252525;
            --quick-action-bg: #2b2d42;
            --notification-badge: #f72585;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
        }

        body {
            background: var(--body-bg);
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            transition: all 0.5s ease;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .primary-color {
            background-color: var(--primary-color);
        }

        .dashboard-header {
            background: var(--header-bg);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 10px 30px var(--shadow-color);
            transition: all 0.4s ease;
            background-color: var(--card-bg);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px var(--shadow-color);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .table {
            color: var(--text-color);
        }

        .table th {
            font-weight: 600;
            border-bottom-width: 1px;
            padding: 1rem;
            background-color: var(--secondary-color);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-danger {
            background-color: var(--danger-color);
            border: none;
            color: white;
        }

        .btn-danger:hover {
            background-color: var(--danger-hover);
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .theme-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            outline: none;
        }

        .theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .theme-toggle i {
            font-size: 1.5rem;
            transition: all 0.5s ease;
        }

        @media (max-width: 768px) {
            .card-header h4 {
                font-size: 1.2rem;
            }

            .table {
                display: block;
                overflow-x: auto;
            }

            .theme-toggle {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
            }
        }
    </style>
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
                                            <button class="btn btn-danger btn-sm btn-confirmar-devolucao" data-id="<?= (int)$row['id']; ?>" data-bs-toggle="modal" data-bs-target="#modalConfirmar">
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
    <script>
        document.getElementById('filtroForm').addEventListener('submit', function(e) {
            e.preventDefault(); // impede recarregamento da página

            const formData = new FormData(this);
            const params = new URLSearchParams(formData).toString();

            fetch('../backend/tabela_emprestimos.php?' + params)
                .then(res => res.text())
                .then(data => {
                    document.querySelector('#tabelaEmprestimos tbody').innerHTML = data;
                });
        });

        // Gatilho para o botão "Aplicar Filtros"
        document.querySelector('button[type="submit"]').addEventListener('click', function() {
            document.getElementById('filtroForm').requestSubmit();
        });

        // Botão "Limpar Filtros"
        document.getElementById('limparFiltros').addEventListener('click', function() {
            document.getElementById('filtro_aluno').value = '';
            document.getElementById('filtro_serie').value = '';
            document.getElementById('filtro_livro').value = '';
            document.getElementById('filtroForm').requestSubmit();
        });


        document.addEventListener('DOMContentLoaded', function() {
            const btnConfirmar = document.getElementById('btnConfirmarDevolucao');

            document.addEventListener('click', function(event) {
                const button = event.target.closest('.btn-confirmar-devolucao');
                if (button) {
                    const id = button.getAttribute('data-id');
                    btnConfirmar.href = '?devolver_id=' + id;
                }
            });
        });
    </script>

</body>

</html>