<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro Manual de Livros</title>
</head>
<body>
  <form action="../backend/cadastro_livro_manual.php" method="POST">
    <label for="titulo">Título</label>
    <input type="text" id="titulo" name="titulo" required>

    <label for="autor">Autor</label>
    <input type="text" id="autor" name="autor">

    <label for="isbn">ISBN</label>
    <input type="text" id="isbn" name="isbn">

    <label for="genero">Gênero</label>
    <input type="text" id="genero" name="genero">

    <label for="ano_publicacao">Ano de Publicação</label>
    <input type="text" id="ano_publicacao" name="ano_publicacao">

    <button type="submit">Cadastrar Livro</button>
  </form>
</body>
</html>
