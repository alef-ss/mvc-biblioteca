<?php
include('../backend/dashboard.php');
// Chama a função para obter os 10 livros mais emprestados
$livrosMaisEmprestados = obterLivrosMaisEmprestados($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var totalLivros = <?php echo $totalLivros ?>;
      var totalEmprestimos = <?php echo $totalEmprestimos ?>;
      var totalAtrasados = <?php echo $totalDevolucoesPendentes ?>;

      var data = google.visualization.arrayToDataTable([
        ['Livros mais emprestados', 'Total'],
        ['Work', 11],
        ['Eat', 2],
        ['Commute', 2],
        ['Watch TV', 2],
        ['Sleep', 7]
      ]);

      var options = {
        title: 'My Daily Activities'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>
</head>

<body>
  <!-- Div pra carregar o gráfico -->
  <!-- <div id="piechart" style="width: 900px; height: 500px"></div> -->

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
    var itemMenu = document.querySelectorAll('.item');

    function linkSelecionado() {
      itemMenu.forEach((item) =>
        item.classList.remove('selecionado'));
      this.classList.add('selecionado');
    }

    itemMenu.forEach((item) =>
      item.addEventListener('click', linkSelecionado)
    );

    // expandir o menu
    var botaoExpandir = document.querySelector('#botao-expandir');
    var menuLateral = document.querySelector('.menu-lateral');

    botaoExpandir.addEventListener('click', function(){
      menuLateral.classList.toggle('expandir')
    });
  </script>
</body>

</html>
