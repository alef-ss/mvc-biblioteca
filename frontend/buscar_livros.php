<?php
include('../backend/buscar_livros.php')
?>
<!-- Substitua a parte de exibição de status por: -->
<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-<?php 
        echo match($_GET['status']) {
            'success' => 'success',
            'partial' => 'warning',
            'duplicate' => 'info',
            default => 'danger'
        }; 
    ?> alert-dismissible fade show" role="alert"> <!-- Adicionei classes aqui -->
        
        <!-- Botão de fechar (X) -->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="d-flex align-items-start">
                <i class="fas fa-check-circle me-2 mt-1"></i>
                <div>
                    <?= $_SESSION['mensagem'] ?? 'Livros cadastrados com sucesso!' ?>
                    <?php if ($_SESSION['sucessos'] ?? 0 > 1): ?>
                        <div class="small text-muted mt-1">
                            <i class="fas fa-info-circle"></i> Todos os <?= $_SESSION['sucessos'] ?> livros foram cadastrados.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php unset($_SESSION['mensagem'], $_SESSION['sucessos']); ?>
            
        <?php elseif (in_array($_GET['status'], ['partial', 'duplicate']) && isset($_SESSION['erros'])): ?>
            <div class="d-flex align-items-start">
                <i class="fas <?= $_GET['status'] == 'duplicate' ? 'fa-info-circle' : 'fa-exclamation-triangle' ?> me-2 mt-1"></i>
                <div>
                    <strong><?= $_GET['status'] == 'duplicate' ? 'Livro já cadastrado' : 'Resultado parcial' ?>:</strong>
                    <?= $_SESSION['sucessos'] ?? 0 ?> livro(s) cadastrado(s) com sucesso,
                    mas <?= count($_SESSION['erros']) ?> não puderam ser cadastrados.
                    
                    <?php if ($_GET['status'] == 'duplicate'): ?>
                        <div class="small mt-1">
                            <i class="fas fa-book"></i> O livro já existe em sua biblioteca.
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-2">
                        <button class="btn btn-sm btn-outline-<?= $_GET['status'] == 'duplicate' ? 'info' : 'warning' ?> d-flex align-items-center" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#detalhesErros"
                                aria-expanded="false">
                            <i class="fas fa-chevron-down me-1"></i>
                            <span>Detalhes dos erros</span>
                        </button>
                        
                        <div class="collapse mt-2" id="detalhesErros">
                            <div class="card card-body bg-light">
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($_SESSION['erros'] as $erro): ?>
                                        <li class="py-2 border-bottom">
                                            <i class="fas fa-exclamation-circle text-<?= $_GET['status'] == 'duplicate' ? 'info' : 'warning' ?> me-2"></i>
                                            <?= htmlspecialchars($erro) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['erros'], $_SESSION['sucessos'], $_SESSION['livros_com_erro']); ?>
            
        <?php else: ?>
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                <div>
                    <?php if ($_GET['status'] == 'fail'): ?>
                        Nenhum livro selecionado para cadastro.
                    <?php else: ?>
                        Ocorreu um erro durante o processamento.
                        <?php if (isset($_SESSION['erro_inesperado'])): ?>
                            <div class="small text-muted mt-1">
                                <?= htmlspecialchars($_SESSION['erro_inesperado']) ?>
                            </div>
                            <?php unset($_SESSION['erro_inesperado']); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Livros - Google Books</title>
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../frontend/_css/buscar_livros.css">
</head>
<style>
    :root {
  /* Light Theme (default) - Tema Claro */
  --primary-color: #00796b;           /* Verde principal */
  --primary-hover: #004d40;           /* Verde mais escuro para hover */
  --primary-light: #b2dfdb;           /* Verde claro para detalhes */
  --secondary-color: #f8f9fa;         /* Cor secundária */
  --text-color: #263238;              /* Texto escuro */
  --text-light: #546e7a;              /* Texto secundário */
  --background-color: #f5f7fa;        /* Fundo da página */
  --card-bg: #ffffff;                 /* Fundo de cards */
  --border-color: #cfd8dc;            /* Cor das bordas */
  --shadow-color: rgba(0, 0, 0, 0.1); /* Cor das sombras */
  --alert-bg: #ffffff;                /* Fundo de alertas */
  --success-color: #2e7d32;           /* Cor para sucesso */
  --warning-color: #ff8f00;           /* Cor para avisos */
  --error-color: #c62828;             /* Cor para erros */
  --transition: all 0.3s ease;        /* Transições suaves */
  
  /* Gradientes */
  --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
  --card-gradient: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
  
  /* Sombras */
  --card-shadow: 0 4px 12px var(--shadow-color);
  --button-shadow: 0 2px 4px var(--shadow-color);
}

[data-theme="dark"] {
  /* Dark Theme - Tema Escuro */
  --primary-color: #004d40;           /* Verde mais escuro */
  --primary-hover: #00796b;           /* Verde principal para hover */
  --primary-light: #00695c;           /* Verde médio para detalhes */
  --secondary-color: #121212;         /* Cor secundária */
  --text-color: #e0e0e0;              /* Texto claro */
  --text-light: #b0bec5;              /* Texto secundário claro */
  --background-color: #121212;        /* Fundo escuro */
  --card-bg: #1e1e1e;                /* Fundo de cards escuro */
  --border-color: #424242;            /* Bordas escuras */
  --shadow-color: rgba(0, 0, 0, 0.3); /* Sombras mais escuras */
  --alert-bg: #2d2d2d;               /* Fundo de alertas escuro */
  
  /* Gradientes escuros */
  --bg-gradient: linear-gradient(135deg, #121212 0%, #1e1e1e 100%);
  --card-gradient: linear-gradient(to bottom, #1e1e1e 0%, #121212 100%);
}

/* Estilos Base */
body {
  background: var(--bg-gradient);
  color: var(--text-color);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  line-height: 1.6;
  transition: var(--transition);
  min-height: 100vh;
  margin: 0;
  padding: 0;
}

/* Tipografia */
h1, h2, h3, h4, h5, h6 {
  color: var(--text-color);
  margin-top: 0;
  font-weight: 600;
}

p {
  color: var(--text-light);
  margin-bottom: 1rem;
}

/* Cards */
.card {
  background: var(--card-gradient);
  border: 1px solid var(--border-color);
  border-radius: 8px;
  box-shadow: var(--card-shadow);
  transition: var(--transition);
  margin-bottom: 1.5rem;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px var(--shadow-color);
}

.card-header {
  background-color: var(--primary-color);
  color: white;
  border-bottom: 1px solid var(--border-color);
  padding: 1rem 1.5rem;
}

.card-body {
  padding: 1.5rem;
}

/* Botões */
.btn {
  border: none;
  border-radius: 6px;
  padding: 0.6rem 1.2rem;
  font-weight: 500;
  transition: var(--transition);
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.btn-search, .btn-success {
  background-color: var(--primary-color);
  color: white;
  box-shadow: var(--button-shadow);
}

.btn-search:hover, .btn-success:hover {
  background-color: var(--primary-hover);
  transform: translateY(-1px);
}

.btn-secondary {
  background-color: var(--secondary-color);
  color: var(--text-color);
}

.btn-secondary:hover {
  background-color: var(--border-color);
}

/* Formulários */
.form-control, .search-form {
  background-color: var(--card-bg);
  border: 1px solid var(--border-color);
  color: var(--text-color);
  padding: 0.6rem 1rem;
  border-radius: 6px;
  transition: var(--transition);
}

.form-label {
  color: var(--text-color);
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.form-label:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 2px var(--primary-light);
}

/* Alertas */
.alert-custom, .alert {
  background-color: var(--alert-bg);
  border: 1px solid var(--border-color);
  border-radius: 6px;
  padding: 1rem;
  margin-bottom: 1rem;
}

.alert-success {
  background-color: rgba(46, 125, 50, 0.1);
  border-color: var(--success-color);
  color: var(--success-color);
}

.alert-danger {
  background-color: rgba(198, 40, 40, 0.1);
  border-color: var(--error-color);
  color: var(--error-color);
}

.alert-warning {
  background-color: rgba(255, 143, 0, 0.1);
  border-color: var(--warning-color);
  color: var(--warning-color);
}

/* Cards de Livro */
.livro-card {
  display: flex;
  background-color: var(--card-bg);
  border: 1px solid var(--border-color);
  border-radius: 8px;
  padding: 1rem;
  margin-bottom: 1rem;
  transition: var(--transition);
}

.livro-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--card-shadow);
}

.livro-capa {
  width: 100px;
  height: 150px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 1.5rem;
}

.livro-info {
  flex: 1;
}

.livro-titulo {
  color: var(--text-color);
  margin-bottom: 0.5rem;
}

.livro-autor, .livro-isbn {
  color: var(--text-light);
  margin-bottom: 0.3rem;
}

/* Botão Voltar */
#voltar-painel {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  background-color: var(--primary-color);
  color: white;
  padding: 0.8rem 2rem;
  border-radius: 10px;
  border: none;
  transition: var(--transition);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  max-width: 90%;
  text-decoration: none;
}

#voltar-painel:hover {
  background-color: var(--primary-hover);
  transform: translateX(-50%) translateY(-2px);
}

/* Toggle de Tema */
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
  box-shadow: 0 4px 20px var(--shadow-color);
  transition: var(--transition);
  border: none;
  outline: none;
}

.theme-toggle:hover {
  transform: scale(1.1);
  background-color: var(--primary-hover);
}

.theme-toggle i {
  font-size: 1.5rem;
  transition: transform 0.3s ease;
}

.theme-toggle:hover i {
  transform: rotate(15deg);
}

/* Responsividade */
@media (max-width: 768px) {
  .livro-card {
    flex-direction: column;
  }
  
  .livro-capa {
    width: 100%;
    height: auto;
    margin-right: 0;
    margin-bottom: 1rem;
  }
  
  #voltar-painel {
    width: 90%;
    padding: 0.7rem 1.5rem;
  }
}

@media (max-width: 576px) {
  .card-body {
    padding: 1rem;
  }
  
  #voltar-painel {
    width: 100%;
    padding: 0.6rem 1rem;
  }
}

/* Adicione estas regras ao seu CSS existente */

/* Estilos para Alertas Notificações */
.alert {
  border-left: 4px solid transparent;
  padding: 1rem;
  margin-bottom: 1.5rem;
  border-radius: 8px;
  display: flex;
  align-items: flex-start;
  transition: var(--transition);
}

.alert i {
  margin-right: 0.75rem;
  margin-top: 0.2rem;
  font-size: 1.25rem;
}

.alert-content {
  flex: 1;
}

/* Cores específicas para cada tipo de alerta */
.alert-success {
  background-color: rgba(46, 125, 50, 0.1);
  border-color: var(--success-color);
  color: var(--success-color);
}

.alert-warning {
  background-color: rgba(255, 143, 0, 0.1);
  border-color: var(--warning-color);
  color: var(--warning-color);
}

.alert-info {
  background-color: rgba(0, 105, 92, 0.1);
  border-color: var(--primary-light);
  color: var(--primary-color);
}

.alert-danger {
  background-color: rgba(198, 40, 40, 0.1);
  border-color: var(--error-color);
  color: var(--error-color);
}

/* Estilo para o botão de detalhes */
.btn-detalhes {
  background: none;
  border: none;
  color: inherit;
  padding: 0;
  font: inherit;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  margin-top: 0.5rem;
  transition: var(--transition);
}

.btn-detalhes:hover {
  opacity: 0.8;
}

.btn-detalhes i {
  margin-right: 0.5rem;
  transition: transform 0.3s ease;
}

.btn-detalhes[aria-expanded="true"] i {
  transform: rotate(180deg);
}

/* Lista de erros */
.lista-erros {
  margin-top: 1rem;
  border-radius: 6px;
  overflow: hidden;
  background-color: var(--card-bg);
  border: 1px solid var(--border-color);
}

.lista-erros ul {
  list-style: none;
  padding: 0;
  margin: 0;
  max-height: 200px;
  overflow-y: auto;
}

.lista-erros li {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid var(--border-color);
  display: flex;
  align-items: flex-start;
}

.lista-erros li:last-child {
  border-bottom: none;
}

.lista-erros li i {
  margin-right: 0.5rem;
  color: inherit;
}

/* Adaptações para tema escuro */
[data-theme="dark"] .alert {
  background-color: rgba(255, 255, 255, 0.05);
}

[data-theme="dark"] .alert-success {
  background-color: rgba(46, 125, 50, 0.2);
}

[data-theme="dark"] .alert-warning {
  background-color: rgba(255, 143, 0, 0.2);
}

[data-theme="dark"] .alert-info {
  background-color: rgba(0, 105, 92, 0.2);
}

[data-theme="dark"] .alert-danger {
  background-color: rgba(198, 40, 40, 0.2);
}

[data-theme="dark"] .lista-erros {
  background-color: rgba(255, 255, 255, 0.03);
}

/* Estilo para o botão de fechar */
.btn-close {
    position: absolute;
    top: 0.75rem;
    right: 1rem;
    padding: 0.5rem;
    opacity: 0.5;
    transition: var(--transition);
}

.btn-close:hover {
    opacity: 1;
}

/* Ajuste para tema escuro */
[data-theme="dark"] .btn-close {
    filter: invert(1);
}

/* Posicionamento relativo para o alerta */
.alert {
    position: relative;
    padding-right: 2.5rem; /* Espaço para o botão X */
}

/* Ajuste para o conteúdo do alerta */
.alert > div:not(.btn-close) {
    padding-right: 1rem; /* Evita sobreposição com o botão X */
}
</style>

   


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

    <!-- Stars for Dark Theme -->
    <div class="stars" id="stars"></div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>


    <div class="page-header">
        <div class="container">
            <h1 class="text-center mb-0">
                <i class="fas fa-book"></i> Sistema de Busca e Cadastro de Livros
            </h1>
        </div>
    </div>

    <div class="container">
        <?php if (isset($_GET['status'])): ?>
            <div class="alert-custom <?php echo $_GET['status'] == 'success' ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $_GET['status'] == 'success' ?
                    '<i class="fas fa-check-circle"></i> Livros cadastrados com sucesso!' :
                    '<i class="fas fa-exclamation-circle"></i> Erro ao cadastrar livros.'; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-0">
                    <i class="fas fa-search"></i> Buscar Livros
                </h2>
            </div>
            <div class="card-body">
                <form method="GET" action="buscar_livros.php" class="search-form">
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="resultado">Resultados da Pesquisa</h3>
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
                            <div class="livro-card">
                                <img src="<?php echo $capa_url; ?>" alt="Capa do livro <?php echo htmlspecialchars($titulo); ?>"
                                    class="livro-capa">
                                <div class="livro-info">
                                    <h4 class="livro-titulo"><?php echo htmlspecialchars($titulo); ?></h4>
                                    <p class="livro-autor">
                                        <i class="fas fa-user-edit"></i> <?php echo htmlspecialchars($autores); ?>
                                    </p>
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
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle"></i> Nenhum livro encontrado.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!--link pra voltar pro painel-->
    <div class="centralizar">
        <div class="col-md-3">
            <button id="voltar-painel" onclick="window.location.href='dashboard.php';">
                <i class="fas fa-arrow-left"></i> Voltar para o Painel
            </button>
        </div>
    </div>




    <!-- modal de confirmação -->
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
                        <i class="fas fa-info-circle"></i>
                        Esta ação não pode ser desfeita.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success btn-modal" id="confirmarCadastro">
                        <i class="fas fa-check"></i> Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // GERENCIAMENTO DE TEMA
    // =============================================
    
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const html = document.documentElement;
    const themeAnimation = document.getElementById('themeAnimation');
    const sunMoon = document.getElementById('sunMoon');
    const starsContainer = document.getElementById('stars');
    
    // Verificar tema preferido
    const getPreferredTheme = () => {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme) return storedTheme;
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    };
    
    // Aplicar tema
    const setTheme = (theme) => {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        updateThemeIcon(theme);
        updateStarsVisibility(theme);
    };
    
    // Atualizar ícone do tema
    const updateThemeIcon = (theme) => {
        themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    };
    
    // Mostrar/ocultar estrelas
    const updateStarsVisibility = (theme) => {
        starsContainer.style.opacity = theme === 'dark' ? '1' : '0';
    };
    
    // Animação de transição de tema
    const showThemeAnimation = (newTheme) => {
        themeAnimation.classList.add('active');
        sunMoon.style.transform = newTheme === 'dark' ? 'rotateY(180deg)' : 'rotateY(0deg)';
        
        setTimeout(() => {
            themeAnimation.classList.remove('active');
        }, 1500);
    };
    
    // Criar estrelas
    const createStars = () => {
        const starCount = 100;
        const fragment = document.createDocumentFragment();
        
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            
            star.style.cssText = `
                width: ${Math.random() * 2 + 1}px;
                height: ${Math.random() * 2 + 1}px;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                animation-duration: ${Math.random() * 5 + 3}s;
                animation-delay: ${Math.random() * 2}s;
            `;
            
            fragment.appendChild(star);
        }
        
        starsContainer.appendChild(fragment);
    };
    
    // Inicializar tema
    const initTheme = () => {
        const preferredTheme = getPreferredTheme();
        setTheme(preferredTheme);
        createStars();
        
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            showThemeAnimation(newTheme);
            setTimeout(() => setTheme(newTheme), 800);
        });
    };

    // =============================================
    // GERENCIAMENTO DE LIVROS
    // =============================================
    
    // Verificar seleção de livros
    const verificarSelecao = () => {
        const checkboxes = document.querySelectorAll('input[name="livros[]"]');
        const btnCadastrar = document.getElementById('btnCadastrar');
        const selecionados = Array.from(checkboxes).some(cb => cb.checked);
        
        btnCadastrar.disabled = !selecionados;
        
        if (selecionados) {
            btnCadastrar.classList.add('btn-pulse');
            setTimeout(() => btnCadastrar.classList.remove('btn-pulse'), 500);
        }
    };

    // Configurar eventos para checkboxes
    const configurarCheckboxes = () => {
        const checkboxes = document.querySelectorAll('input[name="livros[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', verificarSelecao);
        });
    };

    // Configurar formulário de busca
    const configurarFormBusca = () => {
        const formBusca = document.querySelector('form[action="buscar_livros.php"]');
        if (formBusca) {
            formBusca.addEventListener('submit', () => {
                const loadingElement = document.getElementById('loading');
                if (loadingElement) loadingElement.style.display = 'block';
            });
        }
    };

    // Configurar botão de confirmação
    const configurarBotaoConfirmar = () => {
        const btnConfirmar = document.getElementById('confirmarCadastro');
        if (btnConfirmar) {
            btnConfirmar.addEventListener('click', function() {
                const formCadastro = document.getElementById('formCadastro');
                if (formCadastro) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cadastrando...';
                    setTimeout(() => formCadastro.submit(), 500);
                }
            });
        }
    };

    // =============================================
    // INICIALIZAÇÃO
    // =============================================
    
    const init = () => {
        initTheme();
        verificarSelecao();
        configurarCheckboxes();
        configurarFormBusca();
        configurarBotaoConfirmar();
    };

    init();
});
    </script>
</body>

</html>