fetch('../includes/footer.html')
    .then(res => res.text())
    .then(data => {
        document.getElementById('footer').innerHTML = data;
    });

function toggleDetails(capaHash, event) {
    event.preventDefault();
    event.stopPropagation();

    const detailsElement = document.getElementById(`details-${capaHash}`);
    const button = event.currentTarget;

    if (!detailsElement || !button) {
        console.error('Elementos não encontrados para:', capaHash);
        return;
    }

    // Alternar visibilidade
    const isShowing = detailsElement.style.display === 'block';
    detailsElement.style.display = isShowing ? 'none' : 'block';

    // Atualizar ícone e acessibilidade
    if (isShowing) {
        button.innerHTML = '<i class="fas fa-info-circle"></i> Ver Edições';
        button.setAttribute('aria-expanded', 'false');
        button.classList.remove('active');
    } else {
        button.innerHTML = '<i class="fas fa-times-circle"></i> Fechar Edições';
        button.setAttribute('aria-expanded', 'true');
        button.classList.add('active');
    }
}

// 2. Variáveis globais
// Mantendo suas outras funções globais
let deleteModal;
let confirmButton;

window.confirmarExclusao = function (bookId, event) {
    event.preventDefault();
    event.stopPropagation();

    if (!deleteModal || !confirmButton) {
        console.error("Modal não inicializado. Verifique:");
        console.error("- O Bootstrap está carregado?");
        console.error("- O modal existe no DOM?");
        return;
    }

    confirmButton.href = `excluir_livro.php?id=${bookId}`;
    deleteModal.show();
}

document.addEventListener('DOMContentLoaded', function () {
    const deleteModalElement = document.getElementById('deleteModal');

    if (deleteModalElement) {
        deleteModal = new bootstrap.Modal(deleteModalElement);
        confirmButton = document.getElementById('confirmDelete');

        deleteModalElement.addEventListener('hidden.bs.modal', () => {
            if (confirmButton) confirmButton.href = '#';
        });
    }
});

// Adicione esta função junto com as outras no seu JavaScript
function toggleDetails(bookId, event) {
    event.preventDefault();

    // Encontra os elementos relevantes
    const detailsElement = document.getElementById(`details-${bookId}`);
    const button = event.currentTarget;

    // Verifica se os elementos existem
    if (!detailsElement || !button) {
        console.error('Elementos não encontrados para:', bookId);
        return;
    }

    // Alterna a visibilidade
    if (detailsElement.style.display === 'none' || !detailsElement.style.display) {
        detailsElement.style.display = 'block';
        button.innerHTML = '<i class="fas fa-times-circle"></i> Fechar';
    } else {
        detailsElement.style.display = 'none';
        button.innerHTML = '<i class="fas fa-info-circle"></i> Detalhes';
    }
}


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
    });
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

// Add animation delays for stats cards
document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
    el.style.animationDelay = `${index * 0.1 + 0.2}s`;
});

// Add click animation to stats cards
document.querySelectorAll('.stat-card').forEach(card => {
    card.addEventListener('click', function () {
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = '';
        }, 200);
    });
});
