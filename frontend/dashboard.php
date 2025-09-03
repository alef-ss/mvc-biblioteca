<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel do Professor - MVC Biblioteca</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<style>
/* ===== Reset básico ===== */
* { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

body {
  background-image: url(./assets/img/images.webp);
  background-size: cover;
  background-position: center;
  backdrop-filter: blur(5px);
  -webkit-backdrop-filter: blur(10px); /* Compatibilidade Safari */
  color: #333;
  min-height: 100vh;
  transition: background 0.3s, color 0.3s;
  overflow-x: hidden;
}

/* ===== Fundo dinâmico ===== */
body::before {
  content:'';
  position:fixed;
  top:0; left:0;
  width:100%; height:100%;
  background: radial-gradient(circle at 20% 20%, rgba(255,200,0,0.2), transparent 50%),
              radial-gradient(circle at 80% 80%, rgba(0,150,255,0.15), transparent 50%);
  animation: floatBackground 20s linear infinite;
  z-index:-1;
}
@keyframes floatBackground {0%{transform:translate(0,0);}50%{transform:translate(50px,-50px);}100%{transform:translate(0,0);}}

/* ===== Cabeçalho ===== */
header {
  text-align:center;
  padding:2rem 1rem;
  background: linear-gradient(90deg, #6a11cb, blue);
    background: rgba(0,0,205, 0.25); /* Transparência leve */
  backdrop-filter: blur(10px); /* Efeito de blur no fundo */
  -webkit-backdrop-filter: blur(10px); /* Compatibilidade Safari */
  color:white;
  border-bottom-left-radius:20px;
  border-bottom-right-radius:20px;
  box-shadow:0 10px 25px rgba(0,0,0,0.1);
  position: relative;
}
header h1 { font-size:2.5rem; font-weight:700; }
header p { font-size:1.1rem; opacity:0.9; margin-top:0.5rem; }

/* ===== Botão de menu lateral ===== */
.menu-toggle {
  position:absolute;
  top:1.5rem;
  left:1.5rem;
  background: rgba(255,255,255,0.25);
  backdrop-filter: blur(10px);
  border:none;
  padding:0.8rem 1rem;
  border-radius:12px;
  cursor:pointer;
  font-size:1.2rem;
  transition: background 0.3s;
}
.menu-toggle:hover {
  background: rgba(255,255,255,0.35);
}

/* ===== Menu lateral ===== */
.sidebar {
  position: fixed;
  top:0;
  left:-250px;
  width:250px;
  height:100%;
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  padding:2rem 1rem;
  box-shadow: 5px 0 25px rgba(0,0,0,0.1);
  border-right:1px solid rgba(255,255,255,0.3);
  border-radius:0 20px 20px 0;
  transition: left 0.4s ease;
  display:flex;
  flex-direction:column;
  gap:1rem;
  z-index:1000;
}
.sidebar.show { left:0; }

.sidebar h2 {
  font-size:1.3rem;
  color:#2575fc;
  text-align:center;
  margin-bottom:1rem;
}

.menu-item {
  padding:0.8rem 1rem;
  border-radius:12px;
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  text-decoration:none;
  color:#333;
  font-weight:500;
  display:flex;
  align-items:center;
  gap:0.5rem;
  transition: transform 0.3s, box-shadow 0.3s;
}
.menu-item:hover {
  transform: translateX(5px);
  box-shadow: 0 8px 20px rgba(37,117,252,0.3);
}

/* ===== Conteúdo principal ===== */
.dashboard {
  display:grid;
  grid-template-columns:1fr;
  gap:2rem;
  padding:2rem;
  margin-left:0;
  transition: margin-left 0.4s ease;
}
.dashboard.shift { margin-left:250px; }

.content {
  display:grid;
  grid-template-columns: repeat(auto-fit,minmax(180px,1fr));
  gap:1.5rem;
}

/* ===== Cards glassmorphism ===== */
.card {
  background: rgba(255,255,255,0.25);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-radius:20px;
  padding:1.5rem;
  text-align:center;
  box-shadow:0 10px 25px rgba(0,0,0,0.08);
  transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
  cursor:pointer;
  border:1px solid rgba(255,255,255,0.3);
}
.card:hover {
  transform: translateY(-5px);
  box-shadow:0 15px 35px rgba(0,0,0,0.12);
}
.card i { font-size:2rem; color:#2575fc; margin-bottom:0.5rem; }
.card h3 { font-size:1.2rem; margin:0.5rem 0; font-weight:600; }
.card p { font-size:0.9rem; color:#666; }

/* ===== Botão flutuante ===== */
.floating-btn {
  position:fixed;
  bottom:30px;
  right:30px;
  background: linear-gradient(135deg, #6a11cb, #2575fc);
  color:white;
  padding:1rem 1.2rem;
  border-radius:50px;
  text-decoration:none;
  font-weight:600;
  box-shadow:0 10px 25px rgba(0,0,0,0.2);
  transition: transform 0.3s, box-shadow 0.3s;
}
.floating-btn:hover {
  transform: translateY(-5px);
  box-shadow:0 15px 35px rgba(0,0,0,0.25);
}
</style>
</head>
<body>

<header>
  <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
  <h1>Painel do Professor</h1>
  <p>Bem-vindo ao seu painel de controle da biblioteca</p>
</header>

<div class="sidebar" id="sidebar">
  <h2>Menu</h2>
  <a href="#" class="menu-item"><i class="fas fa-chalkboard-teacher"></i> Professores</a>
  <a href="#" class="menu-item"><i class="fas fa-user-graduate"></i> Alunos</a>
  <a href="#" class="menu-item"><i class="fas fa-book"></i> Livros</a>
  <a href="#" class="menu-item"><i class="fas fa-exchange-alt"></i> Empréstimos</a>
  <a href="#" class="menu-item"><i class="fas fa-file-alt"></i> Relatórios</a>
</div>

<div class="dashboard" id="dashboard">
  <div class="content">
    <div class="card">
      <i class="fas fa-users"></i>
      <h3>150</h3>
      <p>Alunos Cadastrados</p>
    </div>
    <div class="card">
      <i class="fas fa-book"></i>
      <h3>320</h3>
      <p>Livros no Acervo</p>
    </div>
    <div class="card">
      <i class="fas fa-exchange-alt"></i>
      <h3>24</h3>
      <p>Empréstimos Ativos</p>
    </div>
    <div class="card">
      <i class="fas fa-clock"></i>
      <h3>7</h3>
      <p>Devoluções Pendentes</p>
    </div>
  </div>
</div>

<a href="#" class="floating-btn"><i class="fas fa-plus-circle"></i> Novo Registro</a>

<script>
const toggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');
const dashboard = document.getElementById('dashboard');

toggle.addEventListener('click', () => {
  sidebar.classList.toggle('show');
  dashboard.classList.toggle('shift');
});
</script>

</body>
</html>
