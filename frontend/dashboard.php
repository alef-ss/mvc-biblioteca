<?php
include('../backend/dashboard.php');
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel - Sistema de Gestão de Biblioteca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/dashboard.css">
  <!-- <link rel="stylesheet" href="assets/css/global_colors.css"> -->
</head>
<body>

  <!-- Floating Books Background -->
  <div class="floating-books" id="floatingBooks"></div>

  <!-- Stars for Dark Theme -->
  <div class="stars" id="stars"></div>

  <!-- Theme Toggle Button -->
  <button class="theme-toggle" id="themeToggle">
    <i class="fas fa-moon" id="themeIcon"></i>
  </button>

  <div class="dashboard-header text-center">
    <div class="container">
      <h1 class="mb-2">MVC Biblioteca</h1>
      <div class="subtitle">Bem-vindo ao seu painel de controle</div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card" style="animation-delay: 0.1s">
          <div class="card-header">
            <h2><i class="fas fa-user"></i> Bem-vindo, <?php echo $_SESSION['professor_nome']; ?>!</h2>
          </div>
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item" style="animation-delay: 0.2s">
                <a href="cadastro_professor.php">
                  <i class="fas fa-chalkboard-teacher icon"></i> CADASTRAR PROFESSOR
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 0.3s">
                <a href="cadastro_aluno.php">
                  <i class="fas fa-user-graduate icon"></i> CADASTRAR ALUNO
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 0.4s">
                <a href="buscar_livros.php">
                  <i class="fas fa-book icon book-pulse"></i> BUSCAR E CADASTRAR LIVROS
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 0.5s">
                <a href="cadastro_emprestimos.php">
                  <i class="fas fa-exchange-alt icon"></i> CRIAR EMPRÉSTIMOS
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 0.6s">
                <a href="listar_emprestimos.php">
                  <i class="fas fa-list icon"></i> EMPRÉSTIMOS REGISTRADOS
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 0.7s">
                <a href="editar_livro.php">
                  <i class="fas fa-edit icon"></i> EDITAR LIVRO
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 0.8s">
                <a href="visualizar_livros.php">
                  <i class="fas fa-eye icon"></i> VISUALIZAR LIVROS
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 0.9s">
                <a href="relatorios.php">
                  <i class="fas fa-file-alt icon"></i> RELATÓRIOS
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 1.0s">
                <a href="historico_emprestimos.php">
                  <i class="fas fa-history icon"></i> HISTÓRICO
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 1.0s">
                <a href="suporte.php">
                  <i class="fas fa-tools icon"></i> SUPORTE
                </a>
              </li>
              <li class="list-group-item" style="animation-delay: 1.1s">
                <a href="../backend/logout.php" class="btn btn-danger">
                  <i class="fas fa-sign-out-alt icon"></i> SAIR
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="row">
          <div class="col-md-6" style="animation-delay: 0.2s">
            <div class="stats-card">
              <div class="text-center">
                <i class="fas fa-users stats-icon"></i>
                <div class="stats-number"><?php echo $totalAlunos; ?></div>
                <div class="stats-label">Alunos Cadastrados</div>
              </div>
            </div>
          </div>
          <div class="col-md-6" style="animation-delay: 0.3s">
            <div class="stats-card">
              <div class="text-center">
                <i class="fas fa-book stats-icon"></i>
                <div class="stats-number"><?php echo $totalLivros; ?></div>
                <div class="stats-label">Livros no Acervo</div>
              </div>
            </div>
          </div>
          <div class="col-md-6" style="animation-delay: 0.4s">
            <div class="stats-card">
              <div class="text-center">
                <i class="fas fa-exchange-alt stats-icon"></i>
                <div class="stats-number"><?php echo $totalEmprestimos; ?></div>
                <div class="stats-label">Empréstimos Ativos</div>
              </div>
            </div>
          </div>
          <div class="col-md-6" style="animation-delay: 0.5s">
            <div class="stats-card">
              <div class="text-center">
                <i class="fas fa-clock stats-icon"></i>
                <div class="stats-number"><?php echo $totalDevolucoesPendentes; ?></div>
                <div class="stats-label">Devoluções Pendentes</div>
              </div>
            </div>
          </div>
        </div>

        <div class="quick-actions" style="animation-delay: 0.6s">
          <a href="cadastro_emprestimos.php" class="quick-action-btn">
            <i class="fas fa-plus-circle"></i> Novo Empréstimo
          </a>
          <a href="buscar_livros.php" class="quick-action-btn">
            <i class="fas fa-search"></i> Buscar Livro
          </a>
          <a href="relatorios.php" class="quick-action-btn">
            <i class="fas fa-chart-bar"></i> Relatório Rápido
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="" id="footer"></div>
  <link rel="stylesheet" href="assets/css/footer.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
</body>
</html>
