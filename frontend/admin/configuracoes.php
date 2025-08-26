<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

// Buscar configurações atuais
$stmt = $conn->prepare("SELECT * FROM configuracoes WHERE id = 1");
$stmt->execute();
$config = $stmt->get_result()->fetch_assoc();

// Se não existir, criar configurações padrão
if (!$config) {
    $conn->query("
        INSERT INTO configuracoes (
            dias_emprestimo,
            max_livros_aluno,
            max_renovacoes,
            multa_dia_atraso,
            backup_automatico,
            email_notificacao,
            tema_padrao
        ) VALUES (
            7,
            3,
            2,
            0.50,
            1,
            'biblioteca@escola.com',
            'light'
        )
    ");

    $stmt->execute();
    $config = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações | Sistema Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                <li>
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
                <li class="active">
                    <a href="configuracoes.php">
                        <i class="fas fa-cog"></i>
                        <span>Configurações</span>
                    </a>
                </li>
                <li>
                    <a href="../logout.php">
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
                <h1>Configurações do Sistema</h1>
            </div>
        </header>

        <!-- Settings Form -->
        <div class="card">
            <div class="card-body">
                <form id="configForm">
                    <div class="row">
                        <!-- Empréstimos -->
                        <div class="col-md-6">
                            <h5 class="mb-4">Configurações de Empréstimo</h5>

                            <div class="mb-3">
                                <label class="form-label">Dias de Empréstimo</label>
                                <input type="number" class="form-control" name="dias_emprestimo"
                                       value="<?php echo $config['dias_emprestimo']; ?>" min="1" max="30">
                                <small class="text-muted">Quantidade padrão de dias para devolução</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Máximo de Livros por Aluno</label>
                                <input type="number" class="form-control" name="max_livros_aluno"
                                       value="<?php echo $config['max_livros_aluno']; ?>" min="1" max="10">
                                <small class="text-muted">Quantidade máxima de livros que um aluno pode emprestar</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Máximo de Renovações</label>
                                <input type="number" class="form-control" name="max_renovacoes"
                                       value="<?php echo $config['max_renovacoes']; ?>" min="0" max="5">
                                <small class="text-muted">Quantidade máxima de vezes que um empréstimo pode ser renovado</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Multa por Dia de Atraso (R$)</label>
                                <input type="number" class="form-control" name="multa_dia_atraso"
                                       value="<?php echo $config['multa_dia_atraso']; ?>" step="0.01" min="0">
                                <small class="text-muted">Valor da multa por dia de atraso na devolução</small>
                            </div>
                        </div>

                        <!-- Sistema -->
                        <div class="col-md-6">
                            <h5 class="mb-4">Configurações do Sistema</h5>

                            <div class="mb-3">
                                <label class="form-label">Email para Notificações</label>
                                <input type="email" class="form-control" name="email_notificacao"
                                       value="<?php echo $config['email_notificacao']; ?>">
                                <small class="text-muted">Email que receberá as notificações do sistema</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tema Padrão</label>
                                <select class="form-select" name="tema_padrao">
                                    <option value="light" <?php echo $config['tema_padrao'] == 'light' ? 'selected' : ''; ?>>Claro</option>
                                    <option value="dark" <?php echo $config['tema_padrao'] == 'dark' ? 'selected' : ''; ?>>Escuro</option>
                                </select>
                                <small class="text-muted">Tema padrão do sistema para novos usuários</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="backup_automatico"
                                           <?php echo $config['backup_automatico'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Backup Automático</label>
                                </div>
                                <small class="text-muted">Realizar backup automático diário do sistema</small>
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-info" onclick="realizarBackup()">
                                    <i class="fas fa-database"></i> Realizar Backup Agora
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-primary" onclick="salvarConfiguracoes()">
                            <i class="fas fa-save"></i> Salvar Configurações
                        </button>
                    </div>
                </form>
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

        // Salvar Configurações
        function salvarConfiguracoes() {
            const formData = new FormData(document.getElementById('configForm'));

            $.ajax({
                url: '../../backend/admin/salvar_configuracoes.php',
                type: 'POST',
                data: Object.fromEntries(formData),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Configurações salvas com sucesso!'
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
                        text: 'Ocorreu um erro ao salvar as configurações.'
                    });
                }
            });
        }

        // Realizar Backup
        function realizarBackup() {
            Swal.fire({
                title: 'Realizando backup...',
                text: 'Por favor, aguarde...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '../../backend/admin/realizar_backup.php',
                type: 'POST',
                dataType: 'json', // <-- Adicione esta linha!
                success: function(response) {
                    if (response.success && response.file) {
                        // Inicia o download automaticamente
                        window.location.href = '../../backend/admin/download_backup.php?file=' + encodeURIComponent(response.file.split('/').pop());
                        Swal.fire('Sucesso!', 'Backup realizado e download iniciado.', 'success');
                    } else {
                        Swal.fire('Erro!', response.message || 'Falha ao realizar backup.', 'error');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao realizar o backup.'
                    });
                }
            });
        }
    </script>
</body>
</html>
