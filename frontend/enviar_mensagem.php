<?php
include('../backend/enviar_mensagem.php')
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensagem - Professor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="_css/enviar_mensagem.css">
    
</head>
<body>

    <div class="container">
        <h2>Enviar Mensagem</h2>

        <?php if (!empty($erro)) { ?>
            <div class="alert alert-danger" role="alert"><?php echo $erro; ?></div>
        <?php } ?>

        <?php if (!empty($sucesso)) { ?>
            <div class="alert alert-success" role="alert"><?php echo $sucesso; ?></div>
        <?php } ?>

        <form action="enviar_mensagem.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="aluno_id" class="form-label">Selecionar Aluno</label>
                <select class="form-select" id="aluno_id" name="aluno_id" required>
                    <option value="" disabled selected>Escolha um aluno</option>
                    <?php while ($aluno = $result_alunos->fetch_assoc()) { ?>
                        <option value="<?php echo $aluno['id']; ?>"><?php echo $aluno['nome']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea class="form-control" id="mensagem" name="mensagem" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Enviar Imagem (opcional)</label>
                <input class="form-control" type="file" id="imagem" name="imagem">
            </div>
            <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
