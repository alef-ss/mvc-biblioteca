<?php
include('../backend/dashboard.php');
// Chama as funções para obter os dados necessários
$livrosMaisEmprestados = obterLivrosMaisEmprestados($conn);
$generosMaisLidos = obterGenerosMaisLidos($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Livros Mais Emprestados e Gêneros</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      // Carrega o pacote corechart do Google Charts
      google.charts.load("current", { packages: ["corechart"] });
      google.charts.setOnLoadCallback(drawCharts);

      // Função para desenhar os gráficos
      function drawCharts() {
        // Dados dos livros mais emprestados passados do PHP para o JavaScript
        var livrosData = <?php echo json_encode($livrosMaisEmprestados); ?>;
        // Dados dos gêneros mais lidos passados do PHP para o JavaScript
        var generosData = <?php echo json_encode($generosMaisLidos); ?>;

        // Prepara os dados para o gráfico de colunas (livros)
        var livrosArray = [["Livro", "Quantidade de Empréstimos"]];
        livrosData.forEach(function (livro) {
          livrosArray.push([livro.titulo, parseInt(livro.total_emprestimos)]);
        });
        var livrosChartData = google.visualization.arrayToDataTable(livrosArray);

        // Prepara os dados para o gráfico de pizza (gêneros)
        var generosArray = [["Gênero", "Quantidade de Empréstimos"]];
        generosData.forEach(function (genero) {
          generosArray.push([genero.genero, parseInt(genero.total_emprestimos)]);
        });
        var generosChartData = google.visualization.arrayToDataTable(generosArray);

        // Opções do gráfico de colunas
        var livrosOptions = {
          title: "Top 10 Livros Mais Emprestados",
          legend: { position: "right" },
          chartArea: { width: "70%", height: "70%" },
          width: document.getElementById("livrosChart").offsetWidth,
          height: document.getElementById("livrosChart").offsetHeight,
          responsive: true,
        };

        // Opções do gráfico de pizza
        var generosOptions = {
          title: "Gêneros Mais Lidos",
          legend: { position: "right" },
          chartArea: { width: "70%", height: "70%" },
          width: document.getElementById("generosChart").offsetWidth,
          height: document.getElementById("generosChart").offsetHeight,
          responsive: true,
        };

        // Cria e desenha o gráfico de colunas
        var livrosChart = new google.visualization.ColumnChart(
          document.getElementById("livrosChart")
        );
        livrosChart.draw(livrosChartData, livrosOptions);

        // Cria e desenha o gráfico de pizza
        var generosChart = new google.visualization.PieChart(
          document.getElementById("generosChart")
        );
        generosChart.draw(generosChartData, generosOptions);
      }
    </script>
  </head>
  <body>
    <!-- Barra superior com informações -->
    <div class="info-bar">
      <div class="ultimo-emprestimo">
        <i class="bi bi-clock-history"></i> Último empréstimo há 2 horas
      </div>
      <div class="voce-sabia">
        <i class="bi bi-bell-fill"></i> Você sabia? “Dom Casmurro” tem mais de 150 adaptações teatrais registradas!
      </div>
    </div>

    <!-- Navegação dos botões principais -->
    <nav class="container-botoes">
      <ul>
        <li class="botao">
          <button>
            <span class="icone"><i class="bi bi-journal-text"></i></span>
            <span class="txt">Gerar Relatório</span>
          </button>
        </li>
        <li class="botao">
          <button>
            <span class="icone"><i class="bi bi-download"></i></span>
            <span class="txt">Baixar Gráfico</span>
          </button>
        </li>
        <li class="botao">
          <button>
            <span class="icone"><i class="bi bi-question-lg"></i></span>
            <span class="txt">?</span>
          </button>
        </li>
      </ul>
    </nav>

    <!-- Área dos gráficos lado a lado -->
    <div class="charts-container">
      <div id="livrosChart" style="width: 45%; height: 400px;"></div>
      <div id="generosChart" style="width: 45%; height: 400px;"></div>
    </div>

    <!-- Caixa "Você sabia?" abaixo dos gráficos -->
    <div class="voce-sabia-box">
      <h3>Você sabia?</h3>
      <p>“Dom Casmurro” Leo mais Jeff'</p>
    </div>

    <!-- Nova seção inferior com Tendência, tema sazonal, curiosidade e easter egg -->
    <div class="lower-section">
      <!-- Box Tendência -->
      <div class="tendencia-box">
        <h4>Tendência: <span class="arrow up">⬆️</span></h4>
        <p>+10% livros emprestados esta semana</p>
      </div>

      <!-- Elemento visual temático sazonal -->
      <div class="seasonal-theme" title="Tema sazonal">
        <!-- Exemplo: ícone de floco de neve para inverno -->
        <i class="bi bi-snow"></i>
      </div>

      <!-- Seção divertida "Você sabia?" -->
      <div class="fun-fact-box">
        <h4>Você sabia?</h4>
        <p>“Dom Casmurro” tem mais de 150 adaptações teatrais registradas!</p>
      </div>

      <!-- Easter egg escondido -->
      <div class="easter-egg" title="Clique para surpresa!">
        <img src="assets/img/pixel-cat.png" alt="Easter Egg" />
      </div>
    </div>

    <!-- Menu lateral -->
    <nav class="menu-lateral">
      <div class="botao-expandir">
        <i class="bi bi-list" id="botao-expandir"></i>
      </div>

      <ul>
        <li class="item selecionado">
          <a href="#">
            <span class="icone"><i class="bi bi-house-fill"></i></span>
            <span class="txt-link">Início</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <span class="icone"><i class="bi bi-journal-plus"></i></span>
            <span class="txt-link">Livros</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <span class="icone"><i class="bi bi-person-plus-fill"></i></span>
            <span class="txt-link">Alunos</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <span class="icone"><i class="bi bi-person-badge-fill"></i></span>
            <span class="txt-link">Professores</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <span class="icone"><i class="bi bi-arrow-left-right"></i></span>
            <span class="txt-link">Empréstimos</span>
          </a>
        </li>
      </ul>
    </nav>

    <script>
      // Seleciona todos os itens do menu
      var itemMenu = document.querySelectorAll(".item");

      // Função para marcar o item clicado como selecionado
      function linkSelecionado() {
        itemMenu.forEach((item) => item.classList.remove("selecionado"));
        this.classList.add("selecionado");
      }

      // Adiciona o evento de clique para cada item do menu
      itemMenu.forEach((item) => item.addEventListener("click", linkSelecionado));

      // Seleciona o botão que expande o menu pelo ID
      var botaoExpandir = document.querySelector("#botao-expandir");
      // Seleciona o elemento <nav> com a classe 'menu-lateral' para expandir/recolher o menu
      var menuLateral = document.querySelector("nav.menu-lateral");

      // Adiciona o evento de clique no botão para alternar a classe 'expandir' no menu
      botaoExpandir.addEventListener("click", function () {
        menuLateral.classList.toggle("expandir");
      });
    </script>
  </body>
</html>
