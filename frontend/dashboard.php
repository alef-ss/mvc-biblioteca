<?php
include('../backend/dashboard.php');
// var_dump($totalAlunos, $totalLivros, $totalEmprestimos, $totalSalas);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var totalLivros = <?php echo $totalLivros ?>;
        var totalEmprestimos = <?php echo $totalEmprestimos ?>;
        var totalAtrasados = <?php echo $totalDevolucoesPendentes ?>;

        var data = google.visualization.arrayToDataTable([
          ['Livros mais emprestados', 'Total'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
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
    <div id="piechart" style="width: 900px; height: 500px"></div>
</body>
</html>