fetch('../includes/footer.html')
    .then(res => res.text())
    .then(data => {
        document.getElementById('footer').innerHTML = data;
    });
// Theme Toggle Functionality
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const html = document.documentElement;

// Check for saved theme preference
const savedTheme = localStorage.getItem('theme') ||
    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

// Apply saved theme
html.setAttribute('data-theme', savedTheme);
updateThemeIcon(savedTheme);

themeToggle.addEventListener('click', () => {
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';

    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon(newTheme);
});

function updateThemeIcon(theme) {
    themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}

// Form functionality
function verificarSelecao() {
    const checkboxes = document.querySelectorAll('input[name="livros[]"]');
    const btnCadastrar = document.getElementById('btnCadastrar');
    const selecionados = Array.from(checkboxes).some(cb => cb.checked);
    btnCadastrar.disabled = !selecionados;
}

// Loading spinner
const form = document.querySelector('form[action="buscar_livros.php"]');
const loading = document.getElementById('loading');

if (form) {
    form.addEventListener('submit', () => {
        loading.style.display = 'block';
    });
}

// Confirm cadastro
const btnConfirmar = document.getElementById('confirmarCadastro');
const formCadastro = document.getElementById('formCadastro');

if (btnConfirmar && formCadastro) {
    btnConfirmar.addEventListener('click', function () {
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
        this.disabled = true;
        setTimeout(() => formCadastro.submit(), 500);
    });
}