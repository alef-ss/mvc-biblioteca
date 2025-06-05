<?php
// Verificar se o usuário está logado e é administrador
if (!isset($_SESSION['professor_id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: ../login.php");
    exit();
}
?> 