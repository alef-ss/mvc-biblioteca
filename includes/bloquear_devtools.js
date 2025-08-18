// Bloqueia o botão direito do mouse
document.addEventListener("contextmenu", function (event) {
    event.preventDefault();
});

// Bloqueia atalhos conhecidos para abrir DevTools
document.addEventListener("keydown", function (event) {
    if (
        event.key === "F12" ||
        (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "J" || event.key === "C")) ||
        (event.ctrlKey && event.key === "U") ||
        (event.altKey && event.key === "ArrowLeft") // Bloqueia "ALT + seta para esquerda"
    ) {
        event.preventDefault();
        window.location.href = "bloqueado.html"; // Redireciona
    }
});

// Detecta se o DevTools está aberto e fecha a aba automaticamente
let devtoolsOpen = false;
const element = new Image();
Object.defineProperty(element, 'id', {
    get: function () {
        devtoolsOpen = true;
        window.open('', '_self').close(); // Fecha a aba
        window.location.href = "bloqueado.html"; // Redireciona
    }
});

// Detecta mudanças no tamanho da tela (indica DevTools aberto)
let prevWidth = window.innerWidth;
let prevHeight = window.innerHeight;

window.addEventListener("resize", function () {
    if (window.innerWidth !== prevWidth || window.innerHeight !== prevHeight) {
        if (window.innerWidth < prevWidth || window.innerHeight < prevHeight) {
            window.open('', '_self').close(); // Fecha a aba
            window.location.href = "bloqueado.html";
        }
    }
    prevWidth = window.innerWidth;
    prevHeight = window.innerHeight;
});

// Monitora constantemente se o DevTools está aberto
setInterval(function () {
    devtoolsOpen = false;
    console.log(element);
    if (devtoolsOpen) {
        window.open('', '_self').close(); // Fecha a aba
        window.location.href = "bloqueado.html";
    }
}, 1000);

// Impede que o usuário volte para a página anterior
window.history.pushState(null, "", window.location.href);
window.addEventListener("popstate", function () {
    window.history.pushState(null, "", window.location.href);
    window.location.href = "bloqueado.html"; // Redireciona caso tentem voltar
});

// Proteção extra no campo de senha
document.addEventListener("DOMContentLoaded", function () {
    let senhaInput = document.querySelector('input[name="senha"]');
    if (senhaInput) {
        senhaInput.setAttribute("readonly", true); // Impede edição direta
        senhaInput.addEventListener("focus", function () {
            senhaInput.removeAttribute("readonly"); // Permite digitação normal
        });
    }
});
