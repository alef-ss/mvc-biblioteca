// Theme Toggle Functionality
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const html = document.documentElement;
const themeAnimation = document.getElementById('themeAnimation');
const sunMoon = document.getElementById('sunMoon');
const starsContainer = document.getElementById('stars');

// Check for saved theme preference or use preferred color scheme
const savedTheme = localStorage.getItem('theme') ||
    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

// Apply saved theme
html.setAttribute('data-theme', savedTheme);
updateThemeIcon(savedTheme);

// Create stars for dark theme
createStars();

themeToggle.addEventListener('click', () => {
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';

    // Show animation
    showThemeAnimation(newTheme);

    // Change theme after animation
    setTimeout(() => {
        html.setAttribute('data-theme', newTheme);
        updateThemeIcon(newTheme);
        localStorage.setItem('theme', newTheme);
    }, 800);
});

function updateThemeIcon(theme) {
    if (theme === 'dark') {
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
    } else {
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
    }
}

function showThemeAnimation(theme) {
    themeAnimation.classList.add('active');

    if (theme === 'dark') {
        sunMoon.style.transform = 'rotateY(180deg)';
    } else {
        sunMoon.style.transform = 'rotateY(0deg)';
    }

    setTimeout(() => {
        themeAnimation.classList.remove('active');
    }, 1500);
}

function createStars() {
    const starCount = 100;

    for (let i = 0; i < starCount; i++) {
        const star = document.createElement('div');
        star.classList.add('star');

        // Random size between 1 and 3px
        const size = Math.random() * 2 + 1;
        star.style.width = `${size}px`;
        star.style.height = `${size}px`;

        // Random position
        star.style.left = `${Math.random() * 100}%`;
        star.style.top = `${Math.random() * 100}%`;

        // Random animation duration and delay
        const duration = Math.random() * 5 + 3;
        star.style.setProperty('--duration', `${duration}s`);

        starsContainer.appendChild(star);
    }
}

// Filtro de alunos
document.getElementById("filtro_serie").addEventListener("change", function () {
    let serieSelecionada = this.value;
    let alunos = document.querySelectorAll("#lista_alunos option");
    alunos.forEach(op => {
        if (serieSelecionada === "" || op.getAttribute("data-serie") === serieSelecionada) {
            op.style.display = "block";
        } else {
            op.style.display = "none";
        }
    });
});

// Pesquisa de alunos
document.getElementById("pesquisar_aluno").addEventListener("input", function () {
    let termo = this.value.toLowerCase();
    let alunos = document.querySelectorAll("#lista_alunos option");
    alunos.forEach(op => {
        if (op.textContent.toLowerCase().includes(termo)) {
            op.style.display = "block";
        } else {
            op.style.display = "none";
        }
    });
});