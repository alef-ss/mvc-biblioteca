<?php
include('../backend/gerenciar_emprestimos.php')
?>
<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empréstimo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/gerenciar_emprestimos.css">
</head>
<body>
    <!-- Theme Animation Overlay -->
    <div class="theme-animation" id="themeAnimation">
        <div class="sun-moon-container">
            <div class="sun-moon" id="sunMoon">
                <div class="sun"></div>
                <div class="moon"></div>
            </div>
        </div>
    </div>
    
    <!-- Floating Stars -->
    <div class="stars" id="stars"></div>
    
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="container">
        <h2 class="text-center">Registrar Empréstimo</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Série</label>
                <select class="form-select" id="filtro_serie">
                    <option value="">Todas</option>
                    <?php while ($classe = $classes->fetch_assoc()) {
                        echo "<option value='" . $classe['serie'] . "'>" . $classe['serie'] . "</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Pesquisar Aluno</label>
                <input type="text" id="pesquisar_aluno" class="form-control" placeholder="Digite o nome do aluno">
            </div>
            <div class="mb-3">
                <label class="form-label">Aluno</label>
                <select class="form-select" name="aluno_id" id="lista_alunos" required>
                    <?php
                    $alunos = $conn->query("SELECT id, nome, serie FROM alunos");
                    while ($aluno = $alunos->fetch_assoc()) {
                        echo "<option value='" . $aluno['id'] . "' data-serie='" . $aluno['serie'] . "'>" . $aluno['nome'] . " - " . $aluno['serie'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Livro</label>
                <select class="form-select" name="livro_id" required>
                    <?php
                    $livros = $conn->query("SELECT id, titulo FROM livros WHERE quantidade > 0");
                    while ($livro = $livros->fetch_assoc()) {
                        echo "<option value='" . $livro['id'] . "'>" . $livro['titulo'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar Empréstimo</button>
            <a href="dashboard.php" class="btn btn-primary w-100" style="margin-top: 10px;">Voltar para o Painel do Professor</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/gerenciar_emprestimos.js"></script>
</body>
</html>
<?php $conn->close(); ?>
