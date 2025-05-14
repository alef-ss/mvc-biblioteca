<?php if (isset($_SESSION['sucesso_codigo'])): ?>
    <div class="alert alert-success"><?= $_SESSION['sucesso_codigo'] ?></div>
    <?php unset($_SESSION['sucesso_codigo']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['erro_codigo'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['erro_codigo'] ?></div>
    <?php unset($_SESSION['erro_codigo']); ?>
<?php endif; ?>

<form method="POST" action="../backend/alterar_codigo_secreto.php">
    <div class="form-group">
        <label for="novo_codigo">Novo Código Secreto</label>
        <input type="text" name="novo_codigo" id="novo_codigo" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-warning">Alterar Código</button>
</form>