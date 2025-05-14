<?php
header("HTTP/1.0 404 Not Found");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página não encontrada - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="/frontend/_css/seu-estilo.css">
</head>
<body>
    <!-- <?php include('frontend/tema.html'); // Seu cabeçalho ?> -->
    
    <div class="container">
        <h1>404 - Página não encontrada</h1>
        <p>A página que você está tentando acessar não existe ou foi movida.</p>
        <p><a href="../frontend/dashboard.php">Voltar para a página inicial</a></p>
    </div>
    
    <?php include('footer.html'); // Seu rodapé, se existir ?>
</body>
</html>