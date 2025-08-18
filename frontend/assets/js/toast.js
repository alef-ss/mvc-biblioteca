// Inicializa os toasts do Bootstrap para exibir as mensagens
document.addEventListener("DOMContentLoaded", function () {
  const toastElList = [].slice.call(document.querySelectorAll(".toast"));
  toastElList.forEach(function (toastEl) {
    const toast = new bootstrap.Toast(toastEl, {
      delay: 3000,
    });
    toast.show();
  });
});
