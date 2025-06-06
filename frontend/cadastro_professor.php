<?php
include('../backend/cadastro_professor.php')
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professor - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/cadastro_professor.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-2">
                <i class="fas fa-chalkboard-teacher"></i> Cadastro de Professor
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-user-plus"></i> Novo Professor
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="nome" class="form-label">
                            <i class="fas fa-user"></i> Nome Completo
                        </label>
                        <input type="text" class="form-control" name="nome" id="nome" required 
                               placeholder="Digite o nome completo">
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" name="email" id="email" required 
                               placeholder="exemplo@escola.com">
                    </div>
                    
                    <div class="mb-4">
                        <label for="cpf" class="form-label">
                            <i class="fas fa-id-card"></i> CPF
                        </label>
                        <input type="text" class="form-control" name="cpf" id="cpf" required 
                               placeholder="000.000.000-00">
                    </div>
                    
                    <div class="mb-4">
                        <label for="senha" class="form-label">
                            <i class="fas fa-lock"></i> Senha
                        </label>
                        <input type="password" class="form-control" name="senha" id="senha" required 
                               placeholder="Digite a senha">
                        <div class="form-text" style="color: var(--primary-color);">
                            <i class="fas fa-info-circle"></i> A senha deve ter no mínimo 8 caracteres
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Cadastrar Professor
                    </button>
                </form>

                <div class="mt-5">
                    <h5 class="mb-3" style="color: var(--text-color);">
                        <i class="fas fa-list"></i> Professores Cadastrados
                    </h5>
                    
                    <?php if(isset($_GET['success'])): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <?php echo htmlspecialchars($_GET['success']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="list-group">
                        <?php
                        require '../includes/conn.php';

                        $sql = "SELECT id, nome, email FROM professores ORDER BY nome ASC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<div class="list-group-item">';
                                echo '<div class="d-flex justify-content-between align-items-center">';
                                echo '<div>';
                                echo '<strong>' . htmlspecialchars($row['nome']) . '</strong>';
                                echo '<div class="small"  style="color: var(--text-color);">' . htmlspecialchars($row['email']) . '</div>';
                                echo '</div>';
                                echo '<form method="POST" class="d-inline-block" onsubmit="return confirm(\'Tem certeza que deseja deletar este professor?\')">';
                                echo '<input type="hidden" name="professor_id" value="' . $row['id'] . '">';
                                echo '<button type="submit" name="delete" class="btn btn-danger btn-sm">';
                                echo '<i class="fas fa-trash-alt"></i> Deletar';
                                echo '</button>';
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="list-group-item text-center text-muted">';
                            echo '<i class="fas fa-user-slash fa-2x mb-2"></i>';
                            echo '<p class="mb-0">Nenhum professor cadastrado</p>';
                            echo '</div>';
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <a href="dashboard.php" class="btn btn-primary w-100" id="voltaDashboardId">
            <i class="fas fa-arrow-left"></i> Voltar para o Painel
        </a>
    </div>
    <div id="footer"></div>
    <link rel="stylesheet" href="_css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/cadastro_professor.js"></script>
</body>
</html>