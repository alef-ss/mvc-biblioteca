<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

// Buscar todos os professores
$stmt = $conn->prepare("
    SELECT
        p.*,
        COUNT(e.id) as total_emprestimos,
        MAX(e.data_emprestimo) as ultimo_emprestimo
    FROM professores p
    LEFT JOIN emprestimos e ON p.id = e.professor_id
    GROUP BY p.id
    ORDER BY p.nome ASC
");
$stmt->execute();
$professores = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Professores | Sistema Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-book-reader"></i>
            <span>Biblioteca Admin</span>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="dashboard.php">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="professores.php">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Professores</span>
                    </a>
                </li>
                <li>
                    <a href="relatorios.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>Relatórios</span>
                    </a>
                </li>
                <li>
                    <a href="configuracoes.php">
                        <i class="fas fa-cog"></i>
                        <span>Configurações</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="content-header">
            <div class="header-left">
                <button id="sidebarToggle" class="btn btn-link">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>Gerenciar Professores</h1>
            </div>
            <div class="header-right">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novoProfessorModal">
                    <i class="fas fa-user-plus"></i> Novo Professor
                </button>
            </div>
        </header>

        <!-- Search and Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchProfessor" placeholder="Buscar professor...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="filterStatus">
                            <option value="">Todos os Status</option>
                            <option value="1">Ativos</option>
                            <option value="0">Inativos</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professors Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Total Empréstimos</th>
                                <th>Último Empréstimo</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($prof = $professores->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($prof['nome']); ?>&background=random"
                                                 alt="<?php echo htmlspecialchars($prof['nome']); ?>"
                                                 class="rounded-circle me-2"
                                                 style="width: 32px; height: 32px;">
                                            <?php echo htmlspecialchars($prof['nome']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($prof['email']); ?></td>
                                    <td><?php echo $prof['total_emprestimos']; ?></td>
                                    <td>
                                        <?php
                                        echo $prof['ultimo_emprestimo']
                                            ? date('d/m/Y', strtotime($prof['ultimo_emprestimo']))
                                            : 'Vazio';
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($prof['ativo']): ?>
                                            <span class="badge bg-success">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-primary" onclick="editarProfessor(<?php echo $prof['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-<?php echo $prof['ativo'] ? 'danger' : 'success'; ?>"
                                                    onclick="alterarStatus(<?php echo $prof['id']; ?>, <?php echo $prof['ativo']; ?>)">
                                                <i class="fas fa-<?php echo $prof['ativo'] ? 'ban' : 'check'; ?>"></i>
                                            </button>
                                            <button class="btn btn-sm btn-info" onclick="verHistorico(<?php echo $prof['id']; ?>)">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Novo Professor Modal -->
    <div class="modal fade" id="novoProfessorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Professor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formNovoProfessor">
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" class="form-control" name="senha" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="admin" id="adminCheck">
                                <label class="form-check-label" for="adminCheck">Administrador</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="salvarProfessor()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        const savedTheme = localStorage.getItem('theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        html.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        }

        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });

        // Search and Filter
        $('#searchProfessor').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        $('#filterStatus').on('change', function() {
            const value = $(this).val();
            if (value === '') {
                $('tbody tr').show();
            } else {
                $('tbody tr').each(function() {
                    const isAtivo = $(this).find('.badge').hasClass('bg-success');
                    $(this).toggle(value === '1' ? isAtivo : !isAtivo);
                });
            }
        });

        // Professor Functions
        function salvarProfessor() {
            const form = $('#formNovoProfessor');
            const data = {
                nome: form.find('[name="nome"]').val(),
                email: form.find('[name="email"]').val(),
                senha: form.find('[name="senha"]').val(),
                admin: form.find('[name="admin"]').is(':checked') ? 1 : 0
            };

            $.ajax({
                url: '../../backend/admin/salvar_professor.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Professor cadastrado com sucesso!'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao salvar o professor.'
                    });
                }
            });
        }

        function alterarStatus(id, statusAtual) {
            const novoStatus = !statusAtual;
            const mensagem = novoStatus ? 'ativar' : 'desativar';

            Swal.fire({
                title: `Deseja ${mensagem} este professor?`,
                text: `O professor será ${mensagem}do no sistema.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../../backend/admin/alterar_status_professor.php',
                        type: 'POST',
                        data: { id, status: novoStatus ? 1 : 0 },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    text: response.message
                                });
                            }
                        }
                    });
                }
            });
        }

        function editarProfessor(id) {
            // Implementar edição
        }

        function verHistorico(id) {
            // Implementar visualização de histórico
        }
    </script>
</body>
</html>
