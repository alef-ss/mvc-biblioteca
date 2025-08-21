<?php
include('../backend/login.php')
?>

<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistema de Gestão de Biblioteca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
  <!-- Botão pra trocar o tema -->
  <button class="theme-toggle" id="themeToggle">
    <i class="fas fa-moon" id="themeIcon"></i>
  </button>

  <!-- <img src="assets/img/gif/animacao-pra-pag-de-login.gif" alt=""> -->

  <div class="dashboard-header text-center">
    <div class="container">
      <h1 class="mb-2">
        <i class="fas fa-book"></i> MVC Biblioteca
      </h1>
    </div>
  </div>

  <div class="login-container">
    <div class="card">
      <div class="card-header">
        <h2 class="text-center mb-0">
          <i class="fas fa-user"></i> Login de Professores
        </h2>
      </div>
      <div class="card-body">
        <div id="mensagens">
          <!-- As mensagens de erro e sucesso serão inseridas aqui via JavaScript -->
        </div>

        <form method="POST" id="loginForm" novalidate>
          <div class="mb-4">
            <label for="email" class="form-label">
              <i class="fas fa-envelope"></i> Email
            </label>
            <input type="email" class="form-control" name="email" id="email" required
              placeholder="Digite seu email">
            <div class="invalid-feedback">
              Por favor, insira um email válido.
            </div>
          </div>
          <div class="mb-4">
            <label for="senha" class="form-label">
              <i class="fas fa-lock"></i> Senha
            </label>
            <input type="password" class="form-control" name="senha" id="senha" required
              placeholder="Digite sua senha" minlength="6">
            <div class="invalid-feedback">
              A senha deve ter pelo menos 6 caracteres.
            </div>
          </div>
          <button type="submit" class="btn btn-primary mb-3" id="btnLogin">
            <i class="fas fa-sign-in-alt"></i> Entrar
          </button>
          <div class="text-center">
            <a href="redefinir_senha.php" class="forgot-password">
              <i class="fas fa-key"></i> Esqueceu a senha?
            </a>
          </div>
        </form>
        <!-- <h1 class="mb-3 text-primary">MVC Biblioteca</h1> -->
        <p class="lead mb-4 form-label" style="font-size: medium;">
          Facilitando acesso ao conhecimento com um sistema simples e eficiente.
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/login.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.addEventListener("contextmenu", function(e) {
        e.preventDefault(); // impede o menu padrão
        window.location.href("../includes/pagina-da-anim.html")
      });
    });
  </script>
</body>

</html>
