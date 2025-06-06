fetch('../includes/footer.html')
    .then(res => res.text())
    .then(data => {
        document.getElementById('footer').innerHTML = data;
    });
// Theme Toggle Functionality
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const html = document.documentElement;
const starsContainer = document.getElementById('stars');
const floatingBooksContainer = document.getElementById('floatingBooks');

// Set RGB values for primary color
document.documentElement.style.setProperty('--primary-color-rgb', '67, 97, 238');

// Check for saved theme preference or use preferred color scheme
const savedTheme = localStorage.getItem('theme') ||
    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

// Apply saved theme
html.setAttribute('data-theme', savedTheme);
updateThemeIcon(savedTheme);

// Create stars and floating books
createStars();
createFloatingBooks();

themeToggle.addEventListener('click', () => {
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';

    // Play toggle animation
    anime({
        targets: themeToggle,
        rotate: 360,
        duration: 500,
        easing: 'easeInOutSine'
    });

    // Change theme immediately
    html.setAttribute('data-theme', newTheme);
    updateThemeIcon(newTheme);
    localStorage.setItem('theme', newTheme);

    // Update RGB values for primary color
    if (newTheme === 'dark') {
        document.documentElement.style.setProperty('--primary-color-rgb', '76, 201, 240');
    } else {
        document.documentElement.style.setProperty('--primary-color-rgb', '67, 97, 238');
    }
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

function createStars() {
    const starCount = 150;
    starsContainer.innerHTML = '';

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

function createFloatingBooks() {
    const bookIcons = ['fa-book', 'fa-book-open', 'fa-bookmark', 'fa-book-medical'];
    const bookCount = 15;

    for (let i = 0; i < bookCount; i++) {
        const book = document.createElement('div');
        book.classList.add('floating-book');

        // Random book icon
        const randomIcon = bookIcons[Math.floor(Math.random() * bookIcons.length)];
        book.innerHTML = `<i class="fas ${randomIcon}"></i>`;

        // Random position and delay
        book.style.left = `${Math.random() * 100}%`;
        book.style.animationDelay = `${Math.random() * 15}s`;
        book.style.fontSize = `${Math.random() * 1 + 1}rem`;

        floatingBooksContainer.appendChild(book);
    }
}

// Add hover animations to cards
document.querySelectorAll('.stats-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        anime({
            targets: card,
            scale: 1.03,
            duration: 300,
            easing: 'easeInOutQuad'
        });

        const icon = card.querySelector('.stats-icon');
        anime({
            targets: icon,
            rotate: [0, 10, -5, 0],
            duration: 800,
            easing: 'easeInOutElastic(1, .5)'
        });
    });

    card.addEventListener('mouseleave', () => {
        anime({
            targets: card,
            scale: 1,
            duration: 300,
            easing: 'easeInOutQuad'
        });
    });

    card.addEventListener('click', function () {
        anime({
            targets: this,
            scale: 0.95,
            duration: 200,
            easing: 'easeInOutQuad',
            complete: () => {
                anime({
                    targets: this,
                    scale: 1,
                    duration: 200,
                    easing: 'easeInOutQuad'
                });
            }
        });
    });
});

// Add hover animations to quick action buttons
document.querySelectorAll('.quick-action-btn').forEach(btn => {
    btn.addEventListener('mouseenter', function () {
        anime({
            targets: this.querySelector('i'),
            scale: [1, 1.2],
            rotate: [0, 10],
            duration: 300,
            easing: 'easeInOutQuad'
        });
    });

    btn.addEventListener('mouseleave', function () {
        anime({
            targets: this.querySelector('i'),
            scale: 1,
            rotate: 0,
            duration: 300,
            easing: 'easeInOutQuad'
        });
    });
});

// Add hover animations to menu items
document.querySelectorAll('.list-group-item').forEach(item => {
    item.addEventListener('mouseenter', function () {
        const icon = this.querySelector('.icon');
        anime({
            targets: icon,
            translateX: [0, 5],
            duration: 300,
            easing: 'easeInOutQuad'
        });
    });

    item.addEventListener('mouseleave', function () {
        const icon = this.querySelector('.icon');
        anime({
            targets: icon,
            translateX: 0,
            duration: 300,
            easing: 'easeInOutQuad'
        });
    });
});

// Animate elements on page load
document.addEventListener('DOMContentLoaded', () => {
    // Animate cards with staggered delay
    anime({
        targets: '.card, .stats-card',
        opacity: [0, 1],
        translateY: [30, 0],
        scale: [0.95, 1],
        delay: anime.stagger(100, { start: 100 }),
        duration: 600,
        easing: 'easeOutExpo'
    });

    // Animate quick actions
    anime({
        targets: '.quick-actions',
        opacity: [0, 1],
        translateY: [20, 0],
        delay: 600,
        duration: 500,
        easing: 'easeOutExpo'
    });

    // Animate welcome message
    anime({
        targets: '.dashboard-header h1',
        opacity: [0, 1],
        translateY: [-20, 0],
        duration: 800,
        easing: 'easeOutExpo'
    });

    anime({
        targets: '.dashboard-header .subtitle',
        opacity: [0, 0.9],
        delay: 300,
        duration: 800,
        easing: 'easeOutExpo'
    });
});