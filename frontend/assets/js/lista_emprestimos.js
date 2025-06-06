function aplicarListenersDevolucao() {
    const modalElement = document.getElementById('modalConfirmar');
    const btnConfirmar = document.getElementById('btnConfirmarDevolucao');

    // Cria a instância do modal do Bootstrap
    const modal = new bootstrap.Modal(modalElement);

    document.querySelectorAll('.btn-confirmar-devolucao').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Impede comportamento padrão
            const id = this.getAttribute('data-id');
            btnConfirmar.href = '?devolver_id=' + id;
            modal.show(); // Abre o modal manualmente
        });
    });
}


document.getElementById('filtroForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const params = new URLSearchParams(formData).toString();

    fetch('../backend/tabela_emprestimos.php?' + params)
        .then(res => res.text())
        .then(data => {
            document.querySelector('#tabelaEmprestimos tbody').innerHTML = data;
            aplicarListenersDevolucao(); // <- Reaplica os listeners
        });
});

// document.addEventListener('DOMContentLoaded', function() {
//     aplicarListenersDevolucao();
// });


document.querySelector('button[type="submit"]').addEventListener('click', function () {
    document.getElementById('filtroForm').requestSubmit();
});

document.getElementById('limparFiltros').addEventListener('click', function () {
    document.getElementById('filtro_aluno').value = '';
    document.getElementById('filtro_serie').value = '';
    document.getElementById('filtro_livro').value = '';
    document.getElementById('filtroForm').requestSubmit();
});

// Aplica os listeners iniciais no DOM carregado
document.addEventListener('DOMContentLoaded', aplicarListenersDevolucao);