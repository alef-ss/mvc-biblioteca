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

$(document).ready(function () {
    // Inicializar Select2
    $('#alunoSelect').select2({
        placeholder: "Selecione um aluno",
        allowClear: true
    });

    $('#livroSelect').select2({
        placeholder: "Selecione um livro",
        allowClear: true
    });

    // Função para carregar alunos filtrados
    function carregarAlunos() {
        const filtroAluno = $('#filtro_aluno').val();
        const filtroSerie = $('#filtro_serie').val();

        $.ajax({
            url: '../backend/filtrar_alunos.php',
            type: 'GET',
            data: {
                nome: filtroAluno,
                serie: filtroSerie
            },
            success: function (response) {
                $('#alunoSelect').html(response).trigger('change');
            }
        });
    }

    // Função para carregar livros filtrados
    function carregarLivros() {
        const filtroLivro = $('#filtro_livro').val();

        $.ajax({
            url: '../backend/filtrar_livros.php',
            type: 'GET',
            data: {
                busca: filtroLivro
            },
            success: function (response) {
                $('#livroSelect').html(response).trigger('change');
            }
        });
    }

    // Event listeners para os filtros
    $('#filtro_aluno, #filtro_serie').on('input change', function () {
        carregarAlunos();
    });

    $('#filtro_livro').on('input', function () {
        carregarLivros();
    });

    // Limpar filtros
    $('#limparFiltros').click(function () {
        $('#filtroForm')[0].reset();
        $('#filtro_serie').val('').trigger('change');
        carregarAlunos();
        carregarLivros();
    });

    // Definir data de empréstimo como hoje por padrão
    const today = new Date().toISOString().split('T')[0];
    $('#dataEmprestimo').val(today);

    // Calcular data de devolução
    $('#dataEmprestimo').change(function () {
        const emprestimoDate = new Date($(this).val());
        if (!isNaN(emprestimoDate.getTime())) {
            const devolucaoDate = new Date(emprestimoDate);
            devolucaoDate.setDate(devolucaoDate.getDate() + 7);
            $('#dataDevolucao').val(devolucaoDate.toISOString().split('T')[0]);
        }
    }).trigger('change');

    // Carregar dados iniciais
    carregarAlunos();
    carregarLivros();
});