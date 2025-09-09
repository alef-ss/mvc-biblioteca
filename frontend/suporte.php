<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Suporte - Sistema de Gestão de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="icon" href="favicon/favicon-32x32.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/suporte.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="mb-2">
                <i class="fas fa-headset"></i> Suporte
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-envelope"></i> Formulário de Suporte
                </h4>
            </div>
            <div class="card-body">
                <form action="https://formsubmit.co/alefsouzasobrinho51@gmail.com" method="POST">
                    <input type="hidden" name="_captcha" value="false" />
                    <div class="mb-4">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i> Nome Completo
                        </label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome completo" required />
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required />
                    </div>
                    <div class="mb-4">
                        <label for="subject" class="form-label">
                            <i class="fas fa-tag"></i> Assunto
                        </label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Assunto da mensagem" required />
                    </div>
                    <div class="mb-4">
                        <label for="message" class="form-label">
                            <i class="fas fa-comment"></i> Mensagem
                        </label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Digite sua mensagem" required></textarea>
                        <input type="hidden" name="_next" value="http://localhost:8081/mvc-biblioteca/includes/agradecimentos.html">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane"></i> Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="footer"></div>
    <link rel="stylesheet" href="./frontend/_css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/suporte.js"></script>
    <link rel="stylesheet" href="_css/footer.css">
</body>
</html>
