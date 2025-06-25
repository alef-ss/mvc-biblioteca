<?php
include('../backend/dashboard.php');
// Chama as funções para obter os dados necessários
$livrosMaisEmprestados = obterLivrosMaisEmprestados($conn);
$generosMaisLidos = obterGenerosMaisLidos($conn);
$tendenciaEmprestimos = obterTendenciaEmprestimos($conn);
$tempoUltimoEmprestimo = obterTempoUltimoEmprestimo($conn);
?>
<!--
  tenho que baixar algum gif pra colocar como easter egg, talvez um vídeo ou um monte que vai alternando
  sempre que for aberto, igual as frases
-->
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


      <!-- Modal escondido -->
<div id="easterModal" class="modal-custom">
  <div class="modal-content-custom">
    <span class="close-btn" id="fecharModal">&times;</span>
    <h2>🐣 Você encontrou o easter egg!</h2>
    <div class="tenor-gif-embed" data-postid="24923789" data-share-method="host" data-aspect-ratio="1.77778" data-width="100%"><a href="https://tenor.com/view/reading-stan-marsh-south-park-studying-read-a-book-gif-24923789">Reading Stan Marsh GIF</a>from <a href="https://tenor.com/search/reading-gifs">Reading GIFs</a></div> <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
  </div>
</div>

    
    <!-- Barra superior com informações -->
    <div class="info-bar">
      <div class="ultimo-emprestimo">
        <i class="bi bi-clock-history"></i>
        Último empréstimo há
        <?php
          if ($tempoUltimoEmprestimo === null) {
            echo "sem registros";
          } else {
            echo $tempoUltimoEmprestimo;
          }
        ?>
      </div>
      <div class="voce-sabia">
        <i class="bi bi-bell-fill icone">Você sabia?</i> <div id="curiosidades-cabecalho"></div>
      </div>
    </div>

    <!-- Navegação dos botões principais -->
    <nav class="container-botoes">
      <ul>
        <li class="botao">
          <button>
            <span class="icone"><i class="bi bi-download"></i></span>
            <span class="txt">Baixar Gráfico</span>
          </button>
        </li>
        <li class="botao">
          <button>
            <span class="icone"><i class="bi bi-cloud-arrow-down"></i></span>
            <span class="txt">Backup</span>
          </button>
        </li>
        <li class="botao">
           <button class="txt"><i class="bi bi-file-earmark-bar-graph icone"></i>Relatórios Detalhados</button>
        </li>
      </ul>
    </nav>

    <!-- Área dos gráficos lado a lado -->
    <div class="charts-container">
      <div id="livrosChart" style="width: 45%; height: 400px;"></div>
      <div id="generosChart" style="width: 45%; height: 400px;"></div>
    </div>

    <!-- Caixa "Você sabia?" abaixo dos gráficos com curiosidades aleatórias de literatura-->
    <div class="voce-sabia-box">
      <h3>Você sabia?</h3>
      <div id="curiosidade">
        <!-- as frasees vão ser 'inseridas' nessa div-->
      </div> <br>
      <button class="nova-curiosidade" onclick="novaCuriosidade()">Quer uma nova curiosidade aleatória sobre literatura? Clique aqui!</button>
    </div>

    <!-- Nova seção inferior com Tendência, tema sazonal, curiosidade e easter egg -->
    <div class="lower-section">
      <!-- Box Tendência -->
      <div class="tendencia-box">
        <h4>Tendência: <span class="arrow up">⬆️</span></h4>
        <p>
          <?php
            if ($tendenciaEmprestimos === null) {
              echo "Dados insuficientes para calcular a tendência.";
            } else if ($tendenciaEmprestimos > 0) {
              echo "+{$tendenciaEmprestimos}% livros emprestados esta semana";
            } else if ($tendenciaEmprestimos < 0) {
              echo "{$tendenciaEmprestimos}% livros emprestados esta semana";
            } else {
              echo "Sem variação nos empréstimos esta semana";
            }
          ?>
        </p>
      </div>

          <!-- Curiosidade - easter egg -->
      <div class="fun-fact-box voce-sabia">
        <span class="icone"><i class="bi bi-patch-question-fill"> </i>Curiosidades</span>
        <p>Pode haver alguma surpresa no Painel</p>
      </div>

      <!-- Easter egg escondido -->
      <div class="space-invader-img" title="Clique" id="easter-egg">
        <img src="assets/img/spaceInvader8Bit.jpg" alt="img"/>
      </div>
    </div>

    <!-- Menu lateral -->
    <nav class="menu-lateral">
      <div class="botao-expandir">
        <i class="bi bi-list" id="botao-expandir"></i>
      </div>

      <ul>
        <li class="item selecionado">
          <a href="dashboard.php">
            <span class="icone"><i class="bi bi-house-fill"></i></span>
            <span class="txt-link">Início</span>
          </a>
        </li>
        <li class="item">
          <a href="buscar_livros.php">
            <span class="icone"><i class="bi bi-journal-plus"></i></span>
            <span class="txt-link">Livros</span>
          </a>
        </li>
        <li class="item">
          <a href="">
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

      // lsita com as frases
      const curiosidade = [
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.',
        'O livro mais vendido de todos os tempos é a Bíblia, com mais de 6 bilhões de exemplares vendidos',
        'O autor com mais livros publicados no mundo é José Carlos Ryoki de Alpoim Inoue, com mais de mil livros desde 1986, conforme o Guinness Book',
        'A frase "Elementar, meu caro Watson", não existe nos livros de Sherlock Holmes, embora seja frequentemente associada ao personagem, de acordo com um site de curiosidades',
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.',
        'Monteiro Lobato foi o primeiro editor brasileiro de livros infantis.',
        '“O Pequeno Príncipe” é o livro mais traduzido depois da Bíblia.',
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.',
        'Harry Potter já foi rejeitado por 12 editoras antes de ser publicado.',
        'O primeiro livro publicado em português foi a "Prosopopeia", de Bento Teixeira, em 1601',
        'Nísia Floresta foi a primeira mulher a publicar um livro no Brasil, com "Direitos das mulheres e injustiça dos homens", em 1832. Ela também foi uma pioneira no feminismo no país',
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.',
        'Agatha Christie é a autora mais traduzida em todo o mundo, com mais de 6.598 traduções de suas obras',
        'a famosa "Carta de Pero Vaz de Caminha" foi escrita para relatar o descobrimento do Brasil à coroa portuguesa, e não como um documento oficial',
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.'
      ]

      const curiosidadeCabecalho = [
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.',
        'O livro mais vendido de todos os tempos é a Bíblia, com mais de 6 bilhões de exemplares vendidos',
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.',
        'Monteiro Lobato foi o primeiro editor brasileiro de livros infantis.',
        '“O Pequeno Príncipe” é o livro mais traduzido depois da Bíblia.',
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.',
        'Harry Potter já foi rejeitado por 12 editoras antes de ser publicado.',
        'O primeiro livro publicado em português foi a "Prosopopeia", de Bento Teixeira, em 1601',
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.',
        'Agatha Christie é a autora mais traduzida em todo o mundo, com mais de 6.598 traduções de suas obras',
        'A Carta de Pero Vaz de Caminha foi escrita para relatar o descobrimento do Brasil à coroa portuguesa, não como documento oficial.',
        'Oda Eiichirō chegou ao Top 10 autores com exemplares mais vendidos da história, mesmo sendo um mangá.'
      ]

      // escolher uma frase aleatória da lsita
      const indice = Math.floor(Math.random() * curiosidade.length);
      const frase = curiosidade[indice];

      // randomiza as curiosidades para aparecer no cabeçalho
      const indiceCabecalho = Math.floor(Math.random() * curiosidadeCabecalho.length);
      const fraseCabecalho = curiosidadeCabecalho[indiceCabecalho]

      // mostra a frase escolhida
      document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("curiosidade").innerHTML = `<p>${frase}</p>`
      });

      // mostra a frase escolhida no cabeçalho
      document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("curiosidades-cabecalho").innerHTML = `<p>${fraseCabecalho}</p>`
      });


      function novaCuriosidade() {
        const indice = Math.floor(Math.random() * curiosidade.length);
        const frase = curiosidade[indice];
        document.getElementById("curiosidade").innerHTML = `<p>${frase}</p>`
      }


      document.addEventListener("DOMContentLoaded", () => {
        const easterEgg = document.getElementById("easter-egg");
        const modal = document.getElementById("easterModal");
        const fechar = document.getElementById("fecharModal");

        if (easterEgg && modal && fechar) {
          easterEgg.addEventListener("click", () => {
          modal.style.display = "block";
        });

        fechar.addEventListener("click", () => {
          modal.style.display = "none";
        });

        window.addEventListener("click", (event) => {
          if (event.target === modal) {
            modal.style.display = "none";
          }
        });
      } else {
        console.warn("Algum elemento não foi encontrado no DOM.");
      }
    });
    </script>
  </body>
</html>
