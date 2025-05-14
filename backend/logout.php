<?php
session_start();
session_destroy();  // Destrói a sessão
header("Location: ../frontend/login.php");  // Redireciona para a página de login
exit();
?>
