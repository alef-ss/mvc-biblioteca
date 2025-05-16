<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
            max-width: 90%;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <?php if (isset($_SESSION['erros'])): ?>
                <div class="alert alert-danger">
                    <h5>Ocorreu um erro:</h5>
                    <ul>
                        <?php foreach ($_SESSION['erros'] as $erro): ?>
                            <li><?= htmlspecialchars($erro) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['erros']); ?>
            <?php elseif (isset($_SESSION['sucesso'])): ?>
                <div class="alert alert-success text-center">
                    <h4 class="alert-heading">Sucesso!</h4>
                    <p><?= htmlspecialchars($_SESSION['sucesso']) ?></p>
                    <a href="login.php" class="btn btn-success">Voltar para Login</a>
                </div>
                <?php unset($_SESSION['sucesso']); ?>
            <?php endif; ?>

            <?php if (!isset($_SESSION['dados_validos'])): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Redefinir Senha</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../backend/redefinir_senha.php">
                            <input type="hidden" name="action" value="verify">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome (opcional)</label>
                                <input type="text" class="form-control" name="nome" placeholder="Seu nome completo">
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite seu CPF" required>
                                <small class="form-text text-muted">Apenas números, sem pontos ou traços</small>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="Digite seu e-mail" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Verificar Dados</button>
                                <a href="login.php" class="btn btn-secondary">Voltar para Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['debug_log'])): ?>
<div class="container mt-4">
    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Logs de Depuração</h5>
        </div>
        <div class="card-body">
            <pre style="max-height: 300px; overflow-y: auto;"><?php
                foreach ($_SESSION['debug_log'] as $log) {
                    echo htmlspecialchars($log) . "\n";
                }
                unset($_SESSION['debug_log']);
            ?></pre>
        </div>
    </div>
</div>
<?php endif; ?>

        </div>
    </div>
</div>

<!-- Modal para nova senha -->
<div id="senhaModal" class="modal-overlay" style="<?= isset($_SESSION['dados_validos']) ? 'display: flex;' : '' ?>">
    <div class="modal-content">
        <h3 class="text-center mb-4">Criar Nova Senha</h3>
        <form method="POST" action="../backend/redefinir_senha.php">
            <input type="hidden" name="action" value="reset">
            <div class="mb-3">
                <label for="nova_senha" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" name="nova_senha" required minlength="6">
            </div>
            <div class="mb-3">
                <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                <input type="password" class="form-control" name="confirmar_senha" required minlength="6">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Alterar Senha</button>
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('senhaModal').style.display='none'">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00', {reverse: true});
        
        <?php if (isset($_SESSION['dados_validos'])): ?>
            $('#senhaModal').show();
        <?php endif; ?>
    });
</script>
</body>
</html>
