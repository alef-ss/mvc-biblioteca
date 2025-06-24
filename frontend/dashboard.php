<?php
include('../backend/dashboard.php');
// Chama a função para obter os 10 livros mais emprestados
$livrosMaisEmprestados = obterLivrosMaisEmprestados($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Livros Mais Emprestados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      // Carrega o pacote corechart do Google Charts
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      // Função para desenhar o gráfico
      function drawChart() {
        // Dados dos livros mais emprestados passados do PHP para o JavaScript
        var livrosData = <?php echo json_encode($livrosMaisEmprestados); ?>;

        // Cria o array de dados para o Google Charts
        // O primeiro elemento é o cabeçalho das colunas: título do livro e quantidade de empréstimos
        var dataArray = [['Livro', 'Quantidade de Empréstimos']];

        // Preenche o array com os dados dos livros
        livrosData.forEach(function(livro) {
          dataArray.push([livro.titulo, parseInt(livro.total_emprestimos)]);
        });

        // Converte o array para o formato aceito pelo Google Charts
        var data = google.visualization.arrayToDataTable(dataArray);

      // Opções do gráfico
      var options = {
        title: 'Top 10 Livros Mais Emprestados',
        legend: { position: 'right' },
        chartArea: { width: '70%', height: '70%' },
        width: document.getElementById('piechart').offsetWidth,
        height: document.getElementById('piechart').offsetHeight,
        responsive: true
      };

      // Cria o gráfico de colunas e desenha no elemento com id 'piechart'
      var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));
      chart.draw(data, options);
      }
    </script>
  </head>
<body>
  <nav class="container-botoes">
        <ul>
          <li class="botao">
            <button>
              <span class="icone"><i></i></span>
              <span class="txt">Gerar Relatório</span>
            </button>
          </li>
          <li class="botao">
            <button>
              <span class="icone"><i></i></span>
              <span class="txt">Backup</span>
            </button>
          </li>
          <li class="botao">
            <button>
              <span class="icone"><i></i></span>
              <span class="txt">Baixar Relatório</span>
            </button>
          </li>
        </ul>
  </nav>

    <!-- Div onde o gráfico será renderizado -->
    <div id="piechart" style="width: 900px; height: 500px;"></div>

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
    var itemMenu = document.querySelectorAll('.item');

    // Função para marcar o item clicado como selecionado
    function linkSelecionado() {
      itemMenu.forEach((item) =>
        item.classList.remove('selecionado'));
      this.classList.add('selecionado');
    }

    // Adiciona o evento de clique para cada item do menu
    itemMenu.forEach((item) =>
      item.addEventListener('click', linkSelecionado)
    );

    // Seleciona o botão que expande o menu pelo ID
    var botaoExpandir = document.querySelector('#botao-expandir');
    // Seleciona o elemento <nav> com a classe 'menu-lateral' para expandir/recolher o menu
    var menuLateral = document.querySelector('nav.menu-lateral');

    // Adiciona o evento de clique no botão para alternar a classe 'expandir' no menu
    botaoExpandir.addEventListener('click', function(){
      menuLateral.classList.toggle('expandir');
    });
  </script>
</body>
</html>