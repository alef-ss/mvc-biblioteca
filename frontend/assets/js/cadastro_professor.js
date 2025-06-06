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

// CPF Mask
const cpfInput = document.getElementById('cpf');
cpfInput.addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');

    if (value.length > 3) value = value.replace(/^(\d{3})/, '$1.');
    if (value.length > 7) value = value.replace(/^(\d{3})\.(\d{3})/, '$1.$2.');
    if (value.length > 11) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})/, '$1.$2.$3-');

    e.target.value = value.substring(0, 14);
});

// Password Validation
const senhaInput = document.getElementById('senha');
senhaInput.addEventListener('input', function () {
    if (this.value.length < 8) {
        this.setCustomValidity('A senha deve ter pelo menos 8 caracteres');
    } else {
        this.setCustomValidity('');
    }
});

// Form Submission
const form = document.querySelector('form');
form.addEventListener('submit', function (e) {
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
    submitButton.disabled = true;
});