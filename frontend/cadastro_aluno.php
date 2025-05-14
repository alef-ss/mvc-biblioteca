<?php
include('../backend/cadastro_aluno.php')
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
   
</head>
<style>
:root {
  /* Light Theme (default) */
  --primary-color: #4a6fa5;
  --primary-hover: #3a5a8a;
  --primary-light: #e1e8f5;
  --secondary-color: #f8f9fa;
  --text-color: #2d3748;
  --text-light: #718096;
  --background-color: #f5f7fa;
  --card-bg: #ffffff;
  --border-color: #e2e8f0;
  --shadow-color: rgba(0, 0, 0, 0.1);
  --alert-bg: #ffffff;
  --success-color: #38a169;
  --warning-color: #dd6b20;
  --error-color: #e53e3e;
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  
  /* Gradientes */
  --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
  --card-gradient: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
  
  /* Sombras */
  --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  --button-shadow: 0 2px 4px var(--shadow-color);
}

[data-theme="dark"] {
  /* Dark Theme */
  --primary-color: #5b8cff;
  --primary-hover: #4a7dff;
  --primary-light: #2d3748;
  --secondary-color: #1a202c;
  --text-color: #e2e8f0;
  --text-light: #a0aec0;
  --background-color: #121212;
  --card-bg: #1e1e1e;
  --border-color: #2d3748;
  --shadow-color: rgba(0, 0, 0, 0.3);
  --alert-bg: #2d3748;
  
  /* Gradientes escuros */
  --bg-gradient: linear-gradient(135deg, #121212 0%, #1a202c 100%);
  --card-gradient: linear-gradient(to bottom, #1e1e1e 0%, #2d3748 100%);
}

/* Estilos Base */
body {
  background: var(--bg-gradient);
  color: var(--text-color);
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  line-height: 1.6;
  transition: var(--transition);
  min-height: 100vh;
  margin: 0;
  padding: 0;
}

/* Tipografia */
h1, h2, h3, h4, h5, h6 {
  color: var(--text-color);
  margin-top: 0;
  font-weight: 600;
}

p {
  color: var(--text-light);
  margin-bottom: 1rem;
}

/* Container Principal */
.container {
  max-width: 1200px;
  padding: 2rem 1rem;
}

/* Cards */
.card {
  background: var(--card-gradient);
  border: 1px solid var(--border-color);
  border-radius: 12px;
  box-shadow: var(--card-shadow);
  transition: var(--transition);
  margin-bottom: 2rem;
  overflow: hidden;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card-header {
  background-color: var(--primary-color);
  color: white;
  border-bottom: 1px solid var(--border-color);
  padding: 1.25rem 1.5rem;
  font-weight: 600;
}

.card-body {
  padding: 1.5rem;
}

/* Formulário */
.form-label {
  font-weight: 500;
  color: var(--text-color);
  margin-bottom: 0.5rem;
}

.form-control {
  background-color: var(--card-bg);
  border: 1px solid var(--border-color);
  color: var(--text-color);
  padding: 0.75rem 1rem;
  border-radius: 8px;
  transition: var(--transition);
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.2);
  outline: none;
}

/* Botões */
.btn {
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-weight: 600;
  transition: var(--transition);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.btn-primary {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
}

.btn-primary:hover {
  background-color: var(--primary-hover);
  border-color: var(--primary-hover);
  transform: translateY(-2px);
}

.btn-danger {
  background-color: var(--error-color);
  border-color: var(--error-color);
}

.btn-danger:hover {
  background-color: #c53030;
  border-color: #c53030;
  transform: translateY(-2px);
}

/* Lista de Professores */
.list-group-item {
  background-color: var(--card-bg);
  border-color: var(--border-color);
  color: var(--text-color);
  padding: 1rem 1.5rem;
  transition: var(--transition);
}

.list-group-item:hover {
  background-color: var(--primary-light);
}

/* Botão Voltar */
#voltaDashboardId {
  background-color: var(--primary-color);
  color: white;
  padding: 0.8rem 2rem;
  border-radius: 10px;
  border: none;
  transition: var(--transition);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  text-decoration: none;
  margin-top: 1rem;
}

#voltaDashboardId:hover {
  background-color: var(--primary-hover);
  transform: translateY(-2px);
}

/* Toggle de Tema */
.theme-toggle {
  position: fixed;
  bottom: 30px;
  right: 30px;
  z-index: 1000;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background-color: var(--primary-color);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 4px 20px var(--shadow-color);
  transition: var(--transition);
  border: none;
  outline: none;
}

.theme-toggle:hover {
  transform: scale(1.1) rotate(15deg);
  background-color: var(--primary-hover);
}

.theme-toggle i {
  font-size: 1.5rem;
  transition: transform 0.3s ease;
}

/* Animação de Tema */
.theme-animation {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: var(--bg-gradient);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.5s ease;
}

.theme-animation.active {
  opacity: 1;
}

.sun-moon-container {
  width: 100px;
  height: 100px;
  position: relative;
  perspective: 1000px;
}

.sun-moon {
  width: 100%;
  height: 100%;
  position: relative;
  transform-style: preserve-3d;
  transition: transform 1s ease;
}

.sun, .moon {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
}

.moon {
  transform: rotateY(180deg);
}

/* Estrelas */
.stars {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: -1;
  transition: opacity 0.5s ease;
  opacity: 0;
}

.star {
  position: absolute;
  background-color: white;
  border-radius: 50%;
  animation: twinkle var(--duration, 5s) infinite ease-in-out;
}

@keyframes twinkle {
  0%, 100% { opacity: 0.2; }
  50% { opacity: 1; }
}

/* Responsividade */
@media (max-width: 992px) {
  .container {
    padding: 1.5rem;
  }
}

@media (max-width: 768px) {
  .card {
    margin-bottom: 1.5rem;
  }
  
  .card-header, .card-body {
    padding: 1rem;
  }
  
  .btn {
    padding: 0.65rem 1.25rem;
  }
}

@media (max-width: 576px) {
  .container {
    padding: 1rem;
  }
  
  .card-header h4 {
    font-size: 1.25rem;
  }
  
  .form-control {
    padding: 0.65rem 0.9rem;
  }
  
  .theme-toggle {
    width: 50px;
    height: 50px;
    bottom: 20px;
    right: 20px;
  }
  
  .theme-toggle i {
    font-size: 1.25rem;
  }
}

/* Animações */
.animate__animated {
  --animate-duration: 0.5s;
}

/* Efeito de foco para inputs */
.input-group {
  position: relative;
  margin-bottom: 1.5rem;
}

.input-group label {
  position: absolute;
  top: -10px;
  left: 10px;
  background: var(--card-bg);
  padding: 0 5px;
  font-size: 0.85rem;
  color: var(--primary-color);
}

/* Ícones nos inputs */
.input-icon {
  position: relative;
}

.input-icon i {
  position: absolute;
  top: 50%;
  left: 15px;
  transform: translateY(-50%);
  color: var(--text-light);
}

.input-icon input {
  padding-left: 40px;
}

/* Mensagens de feedback */
.alert {
  padding: 0.75rem 1.25rem;
  border-radius: 8px;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.alert-success {
  background-color: rgba(56, 161, 105, 0.1);
  border-left: 4px solid var(--success-color);
  color: var(--success-color);
}

.alert-danger {
  background-color: rgba(229, 62, 62, 0.1);
  border-left: 4px solid var(--error-color);
  color: var(--error-color);
}

/* Tooltip personalizado */
.tooltip-custom {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.tooltip-custom .tooltip-text {
  visibility: hidden;
  width: 200px;
  background-color: var(--card-bg);
  color: var(--text-color);
  text-align: center;
  border-radius: 6px;
  padding: 0.5rem;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  transition: opacity 0.3s;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid var(--border-color);
}

.tooltip-custom:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}
</style>
<body>
    <!-- Theme Animation Overlay -->
<div class="theme-animation" id="themeAnimation">
    <div class="sun-moon-container">
        <div class="sun-moon" id="sunMoon">
            <div class="sun animate__animated animate__fadeIn"><i class="fas fa-sun"></i></div>
            <div class="moon animate__animated animate__fadeIn"><i class="fas fa-moon"></i></div>
        </div>
    </div>
</div>

<!-- Stars for Dark Theme -->
<div class="stars" id="stars"></div>

<!-- Theme Toggle Button -->
<button class="theme-toggle" id="themeToggle">
    <i class="fas fa-moon" id="themeIcon"></i>
</button>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h4><i class="fas fa-user-plus"></i> Cadastro de Aluno</h4>
                    <a href="lista_alunos.php" class="btn btn-primary btn-sm">
                        <i class="fas fa-list"></i> Ver Lista de Alunos
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="serie" class="form-label">Série</label>
                        <input type="text" class="form-control" name="serie" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" name="senha">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Cadastrar
                    </button>
                </form>
            </div>
        </div>
        <br>
                <a href="dashboard.php" class="btn btn-primary w-100" id="voltaDashboardId">Voltar para o Painel</a>
                <br>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // GERENCIAMENTO DE TEMA
    // =============================================
    
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const html = document.documentElement;
    const themeAnimation = document.getElementById('themeAnimation');
    const sunMoon = document.getElementById('sunMoon');
    const starsContainer = document.getElementById('stars');
    
    // Verificar tema preferido
    const getPreferredTheme = () => {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme) return storedTheme;
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    };
    
    // Aplicar tema
    const setTheme = (theme) => {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        updateThemeIcon(theme);
        updateStarsVisibility(theme);
    };
    
    // Atualizar ícone do tema
    const updateThemeIcon = (theme) => {
        themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        themeIcon.style.transform = theme === 'dark' ? 'rotate(360deg)' : 'rotate(0deg)';
    };
    
    // Mostrar/ocultar estrelas
    const updateStarsVisibility = (theme) => {
        starsContainer.style.opacity = theme === 'dark' ? '1' : '0';
    };
    
    // Animação de transição de tema
    const showThemeAnimation = (newTheme) => {
        themeAnimation.classList.add('active');
        sunMoon.style.transform = newTheme === 'dark' ? 'rotateY(180deg)' : 'rotateY(0deg)';
        
        setTimeout(() => {
            themeAnimation.classList.remove('active');
        }, 1000);
    };
    
    // Criar estrelas
    const createStars = () => {
        const starCount = 150;
        const fragment = document.createDocumentFragment();
        
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            
            // Posição e tamanho aleatórios
            const size = Math.random() * 3;
            const duration = Math.random() * 5 + 3;
            
            star.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                animation-duration: ${duration}s;
                animation-delay: ${Math.random() * 2}s;
                opacity: ${Math.random() * 0.7 + 0.3};
            `;
            
            fragment.appendChild(star);
        }
        
        starsContainer.appendChild(fragment);
    };
    
    // Inicializar tema
    const initTheme = () => {
        const preferredTheme = getPreferredTheme();
        setTheme(preferredTheme);
        createStars();
        
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            showThemeAnimation(newTheme);
            setTimeout(() => setTheme(newTheme), 500);
        });
    };
    
    initTheme();
    
    // =============================================
    // MELHORIAS DE USABILIDADE
    // =============================================
    
    // Máscara para CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 3) {
                value = value.replace(/^(\d{3})/, '$1.');
            }
            if (value.length > 7) {
                value = value.replace(/^(\d{3})\.(\d{3})/, '$1.$2.');
            }
            if (value.length > 11) {
                value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})/, '$1.$2.$3-');
            }
            
            e.target.value = value.substring(0, 14);
        });
    }
    
    // Validação de senha
    const senhaInput = document.getElementById('senha');
    if (senhaInput) {
        senhaInput.addEventListener('input', function() {
            if (this.value.length < 8 && this.value.length > 0) {
                this.setCustomValidity('A senha deve ter pelo menos 8 caracteres');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Efeito hover nos cards
    const cards = document.querySelectorAll('.card, .list-group-item');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('animate__animated', 'animate__pulse');
        });
        
        card.addEventListener('mouseleave', () => {
            card.classList.remove('animate__animated', 'animate__pulse');
        });
    });
    
    // Feedback visual ao enviar formulário
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processando...';
                submitButton.disabled = true;
            }
        });
    });
});
</script>
</body>
</html>
