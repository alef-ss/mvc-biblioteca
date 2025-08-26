<?php
include('../backend/visualizar_livros.php');
// include('../backend/buscar_livros.php');
?>

<?php
// DEBUG: Verificar capas únicas
$result->data_seek(0);
$capas = [];
while ($row = $result->fetch_assoc()) {
  $capas[] = $row['capa_url'] ?: 'default-cover.jpg';
}
echo "<!-- Total de livros: " . $result->num_rows . " -->";
echo "<!-- Capas únicas encontradas: " . count(array_unique($capas)) . " -->";
$result->data_seek(0); // Resetar novamente para o loop principal
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visualizar Livros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
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
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--text-color);
      transition: all 0.8s ease;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .page-header {
      background-color: var(--primary-color);
      color: white;
      padding: 1.5rem 0;
      margin-bottom: 2rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: all 0.8s ease;
    }

    .page-header h1 {
      font-weight: 600;
      font-size: 2rem;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    .card {
      border-radius: 12px;
      box-shadow: 0 8px 24px var(--shadow-color);
      transition: all 0.5s ease;
      background-color: var(--card-bg);
      border: none;
      margin-bottom: 2rem;
      overflow: hidden;
    }

    .card-header {
      border-radius: 12px 12px 0 0;
      background-color: var(--primary-color);
      color: white;
      padding: 1.5rem;
      transition: all 0.5s ease;
    }

    .card-header h2 {
      font-size: 1.5rem;
      font-weight: 600;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .card-body {
      padding: 1.5rem;
      background-color: var(--card-bg);
      transition: all 0.5s ease;
    }

    .stats-container {
      display: flex;
      justify-content: space-between;
      margin-bottom: 2rem;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .stat-card {
      background-color: var(--stats-card-bg);
      border-radius: 12px;
      padding: 1.5rem;
      flex: 1;
      min-width: 200px;
      box-shadow: 0 4px 12px var(--shadow-color);
      transition: all 0.4s ease;
      cursor: pointer;
      text-align: center;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 24px var(--shadow-color);
    }

    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      color: var(--primary-color);
      margin: 0.5rem 0;
    }

    .stat-label {
      font-size: 1rem;
      color: var(--text-color);
      opacity: 0.8;
    }

    .book-card {
      background-color: var(--card-bg);
      border-radius: 8px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 12px var(--shadow-color);
      transition: all 0.3s ease;
    }

    .book-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 16px var(--shadow-color);
    }

    .book-cover {
      width: 120px;
      height: 180px;
      object-fit: cover;
      border-radius: 4px;
      margin-right: 1.5rem;
      box-shadow: 0 2px 8px var(--shadow-color);
    }

    .book-info {
      flex: 1;
    }

    .book-title {
      color: var(--primary-color);
      margin-bottom: 0.5rem;
    }

    .book-meta {
      color: var(--text-color);
      opacity: 0.9;
      margin-bottom: 0.5rem;
    }

    .book-actions {
      margin-top: 1rem;
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .btn-action {
      transition: all 0.3s ease;
    }

    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px var(--shadow-color);
    }

    .book-details {
      margin-top: 1rem;
      padding: 1rem;
      background-color: var(--secondary-color);
      border-radius: 6px;
      display: none;
    }

    .search-container {
      margin-bottom: 1.5rem;
    }

    .search-input {
      border-radius: 6px;
      border: 1px solid var(--primary-color);
    }

    .pagination {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 2rem;
      flex-wrap: wrap;
    }

    .btn-back {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-back:hover {
      color: var(--primary-hover);
      transform: translateX(-3px);
    }

    /* Theme Toggle */
    .theme-toggle {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 1000;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: var(--primary-color);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      transition: all 0.5s ease;
      border: none;
      outline: none;
    }

    .theme-toggle:hover {
      transform: scale(1.1) rotate(15deg);
    }

    /* Floating Stars (for dark theme) */
    .stars {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: -1;
      opacity: 0;
      transition: opacity 1s ease;
    }

    [data-theme="dark"] .stars {
      opacity: 1;
    }

    .star {
      position: absolute;
      background-color: white;
      border-radius: 50%;
      animation: twinkle var(--duration) infinite ease-in-out;
    }

    @keyframes twinkle {

      0%,
      100% {
        opacity: 0.2;
      }

      50% {
        opacity: 1;
      }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .page-header h1 {
        font-size: 1.8rem;
      }

      .stats-container {
        flex-direction: column;
      }

      .stat-card {
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .container {
        padding-bottom: 100px;
      }

      .theme-toggle {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
      }

      .book-card {
        flex-direction: column;
      }

      .book-cover {
        width: 100%;
        height: auto;
        max-height: 300px;
        margin-right: 0;
        margin-bottom: 1rem;
      }

      .book-actions {
        flex-direction: column;
      }

      .btn-action {
        width: 100%;
      }
    }


    #voltar-painel {
      /* position: fixed; */
      /* bottom: 20px;
            left: 20px; */
      /* z-index: 1000; */
      width: 100%;
      background-color: var(--primary-color);
      color: white;
      padding: 0.75rem 1.25rem;
      border-radius: 5px;
      box-shadow: 0 4px 12px var(--shadow-color);
      transition: all 0.3s ease;
    }
  </style>
</head>

<body>


  <?php
  if (isset($_SESSION['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $_SESSION['sucesso']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['sucesso']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['erro'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $_SESSION['erro']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['erro']); ?>
  <?php endif; ?>


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

  <div class="page-header">
    <div class="container">
      <h1 class="text-center mb-0">
        <i class="fas fa-book"></i> Acervo de Livros
      </h1>
    </div>
  </div>

  <div class="container">
    <?php if (isset($_SESSION['msg'])): ?>
      <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['msg']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <div class="stats-container">
      <div class="stat-card animate-fade-in">
        <div class="stat-number"><?php echo $total_books; ?></div>
        <div class="stat-label">Total de Livros</div>
      </div>
      <div class="stat-card animate-fade-in">
        <div class="stat-number"><?php echo $result->num_rows; ?></div>
        <div class="stat-label">Livros nesta página</div>
      </div>
      <div class="stat-card animate-fade-in">
        <div class="stat-number"><?php echo $total_pages; ?></div>
        <div class="stat-label">Total de Páginas</div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h2 class="mb-0"><i class="fas fa-book"></i> Catálogo de Livros</h2>
      </div>
      <div class="card-body">
        <form method="GET" action="visualizar_livros.php" class="search-container">
          <div class="input-group">
            <input type="text"
              name="search"
              class="form-control search-input"
              placeholder="Pesquisar por título ou ISBN..."
              value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-search"></i> Buscar
            </button>
          </div>
        </form>

        <div id="book-list">
          <?php if ($result->num_rows > 0): ?>
            <?php
            // Criar um array para armazenar capas únicas
            $capasExibidas = [];

            // Resetar o ponteiro do resultado para processar novamente
            $result->data_seek(0);

            while ($row = $result->fetch_assoc()):
              $capa = $row['capa_url'] ?: 'default-cover.jpg';

              // Verificar se esta capa já foi processada
              if (!in_array($capa, $capasExibidas)):
                $capasExibidas[] = $capa;

                // Buscar TODAS as edições com esta capa (incluindo a atual)
                $sql_edicoes = "SELECT * FROM livros WHERE capa_url = ?";
                $stmt = $conn->prepare($sql_edicoes);
                $stmt->bind_param("s", $capa);
                $stmt->execute();
                $result_edicoes = $stmt->get_result();
                $total_edicoes = $result_edicoes->num_rows;
            ?>
                <div class="book-card d-flex">
                  <img src="<?php echo htmlspecialchars($capa); ?>"
                    alt="Capa do Livro"
                    class="book-cover"
                    loading="lazy">

                  <div class="book-info">
                    <h3 class="book-title"><?php echo htmlspecialchars($row['titulo']); ?></h3>
                    <p class="book-meta">
                      <i class="fas fa-user-edit"></i> <?php echo htmlspecialchars($row['autor']); ?>
                    </p>

                    <div class="book-actions">
                      <?php if (!empty($row['preview_link'])): ?>
                        <a href="<?= htmlspecialchars($row['preview_link']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary" style="background-color: var(--primary-color);">Visualizar Livro</a>
                      <?php else: ?>
                        <span class="text-muted">Sem visualização</span>
                      <?php endif; ?>

                      <a href="editar_livro.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-action">
                        <i class="fas fa-edit"></i> Editar
                      </a>
                      <button onclick="confirmarExclusao(<?= $row['id']; ?>, event)" class="btn btn-danger">
                        Excluir Livro
                      </button>
                    </div>



                    <div class="book-details" id="details-<?php echo md5($capa); ?>" style="display:none;">
                      <?php while ($edicao = $result_edicoes->fetch_assoc()): ?>
                        <div class="book-edition">
                          <h4><?php echo htmlspecialchars($edicao['titulo']); ?></h4>
                          <p><i class="fas fa-barcode"></i> <strong>ISBN:</strong> <?php echo htmlspecialchars($edicao['isbn']); ?></p>
                          <p><i class="fas fa-calendar"></i> <strong>Ano:</strong> <?php echo htmlspecialchars($edicao['ano_publicacao']); ?></p>
                          <p><i class="fas fa-bookmark"></i> <strong>Gênero:</strong> <?php echo htmlspecialchars($edicao['genero']); ?></p>
                          <p><i class="fas fa-align-left"></i> <strong>Descrição:</strong> <?php echo $edicao['descricao'] ? nl2br(htmlspecialchars($edicao['descricao'])) : 'Nenhuma descrição disponível.'; ?></p>
                          <p><i class="fas fa-tag"></i> <strong>Categoria:</strong> <?php echo htmlspecialchars($edicao['categoria'] ?: 'Não especificada'); ?></p>
                          <p><i class="fas fa-boxes"></i> <strong>Quantidade:</strong> <?php echo htmlspecialchars($edicao['quantidade']); ?></p>

                          <div class="edition-actions">
                            <a href="editar_livro.php?id=<?php echo $edicao['id']; ?>" class="btn btn-sm btn-warning">
                              <i class="fas fa-edit"></i> Editar esta edição
                            </a>
                            <button onclick="confirmarExclusao(<?php echo $edicao['id']; ?>, event)" class="btn btn-sm btn-danger">
                              Excluir esta edição
                            </button>
                          </div>
                          <hr>
                        </div>
                      <?php endwhile; ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="alert alert-info text-center">
              <i class="fas fa-info-circle"></i> Nenhum livro encontrado.
            </div>
          <?php endif; ?>
        </div>

        <?php if ($total_pages > 1): ?>
          <nav class="pagination">
            <?php if ($page > 1): ?>
              <a href="?page=1&search=<?php echo $search; ?>" class="btn btn-outline-primary">
                <i class="fas fa-angle-double-left"></i>
              </a>
              <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>" class="btn btn-outline-primary">
                <i class="fas fa-angle-left"></i>
              </a>
            <?php endif; ?>

            <?php
            $start_page = max(1, $page - 2);
            $end_page = min($total_pages, $page + 2);

            if ($start_page > 1) {
              echo '<span class="btn btn-outline-secondary disabled">...</span>';
            }

            for ($i = $start_page; $i <= $end_page; $i++): ?>
              <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"
                class="btn <?php echo ($i == $page) ? 'btn-primary' : 'btn-outline-primary'; ?>">
                <?php echo $i; ?>
              </a>
            <?php endfor;

            if ($end_page < $total_pages) {
              echo '<span class="btn btn-outline-secondary disabled">...</span>';
            }
            ?>

            <?php if ($page < $total_pages): ?>
              <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>" class="btn btn-outline-primary">
                <i class="fas fa-angle-right"></i>
              </a>
              <a href="?page=<?php echo $total_pages; ?>&search=<?php echo $search; ?>" class="btn btn-outline-primary">
                <i class="fas fa-angle-double-right"></i>
              </a>
            <?php endif; ?>
          </nav>
        <?php endif; ?>


      </div>
      <a href="dashboard.php" class="btn-back mb-4" id="voltar-painel">
        <i class="fas fa-arrow-left"></i> Voltar para o Painel do Professor
      </a>
      <!-- Modal de Confirmação de Exclusão -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirmar Exclusão</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Tem certeza que deseja excluir este livro?</p>
              <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <a href="#" id="confirmDelete" class="btn btn-danger">Confirmar Exclusão</a>
            </div>
          </div>
        </div>
      </div>

      <div id="footer"></div>
      <link rel="stylesheet" href="_css/footer.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="assets/js/visualizar_livros.js"></script>
      <script>

      </script>
</body>

</html>
<?php $conn->close(); ?>
