<?php
include('../backend/cadastro_emprestimos.php')
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empréstimo | Sistema Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --text-color: #5a5c69;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: var(--text-color);
        }
        
        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .card-header h4 {
            margin: 0;
            font-weight: 600;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d3e2;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            z-index: 1000;
            text-decoration: none;
        }
        
        .floating-btn:hover {
            transform: scale(1.1) translateY(-5px);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
        
        .alert {
            border-radius: 8px;
            padding: 1rem;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .alert-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #17a673 100%);
            color: white;
            border: none;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #c03427 100%);
            color: white;
            border: none;
        }
        
        .book-icon {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .student-icon {
            color: var(--accent-color);
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .date-icon {
            color: var(--warning-color);
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .form-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
        }
        
        .form-group .form-control, 
        .form-group .form-select {
            padding-left: 45px;
        }
        
        .animated-input:focus {
            animation: inputFocus 0.5s ease;
        }
        
        @keyframes inputFocus {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(78, 115, 223, 0); }
            100% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0); }
        }
        
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background-color: var(--primary-color);
            opacity: 0;
            z-index: 999;
            animation: confetti 3s ease-out;
        }
        
        @keyframes confetti {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-book-open me-2"></i>Biblioteca Digital
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-sm-block">Olá, Professor!</span>
                <a href="dashboard.php" class="btn btn-outline-primary">
                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container mb-5 animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if(isset($success_message)): ?>
                    <div class="alert alert-success animate__animated animate__bounceIn mb-4">
                        <i class="fas fa-check-circle me-2"></i> <?php echo $success_message; ?>
                    </div>
                    <script>
                        // Adiciona confetti quando o empréstimo é bem-sucedido
                        document.addEventListener('DOMContentLoaded', function() {
                            for(let i = 0; i < 50; i++) {
                                createConfetti();
                            }
                        });
                        
                        function createConfetti() {
                            const confetti = document.createElement('div');
                            confetti.className = 'confetti';
                            confetti.style.left = Math.random() * 100 + 'vw';
                            confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
                            confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                            document.body.appendChild(confetti);
                            
                            setTimeout(() => {
                                confetti.remove();
                            }, 3000);
                        }
                    </script>
                <?php endif; ?>
                
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger animate__animated animate__shakeX mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-hand-holding me-2"></i> Novo Empréstimo</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="" id="emprestimoForm">
                            <div class="form-group">
                                <i class="fas fa-user-graduate student-icon"></i>
                                <label for="aluno_id" class="form-label">Aluno</label>
                                <select class="form-select animated-input" name="aluno_id" required id="alunoSelect">
                                    <option value="">Selecione o aluno</option>
                                    <?php while ($aluno = $alunos_result->fetch_assoc()) { ?>
                                        <option value="<?= $aluno['id'] ?>"><?= $aluno['nome'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-book book-icon"></i>
                                <label for="livro_id" class="form-label">Livro</label>
                                <select class="form-select animated-input" name="livro_id" required id="livroSelect">
                                    <option value="">Selecione o livro</option>
                                    <?php while ($livro = $livros_result->fetch_assoc()) { ?>
                                        <option value="<?= $livro['id'] ?>"><?= $livro['titulo'] ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-muted d-block mt-1">A disponibilidade será verificada ao enviar</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="far fa-calendar-alt date-icon"></i>
                                        <label for="data_emprestimo" class="form-label">Data de Empréstimo</label>
                                        <input type="date" class="form-control animated-input" name="data_emprestimo" required id="dataEmprestimo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="far fa-calendar-check date-icon"></i>
                                        <label for="data_devolucao" class="form-label">Data de Devolução</label>
                                        <input type="date" class="form-control animated-input" name="data_devolucao" required id="dataDevolucao">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg pulse" id="submitBtn">
                                    <i class="fas fa-save me-2"></i> Registrar Empréstimo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="dashboard.php" class="floating-btn animate__animated animate__bounceInUp">
        <i class="fas fa-home"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animação ao focar nos campos
            $('.animated-input').focus(function() {
                $(this).addClass('animate__animated animate__pulse');
            }).blur(function() {
                $(this).removeClass('animate__animated animate__pulse');
            });
            
            // Validação das datas
            $('#emprestimoForm').submit(function(e) {
                const emprestimo = new Date($('#dataEmprestimo').val());
                const devolucao = new Date($('#dataDevolucao').val());
                
                if (devolucao <= emprestimo) {
                    alert('A data de devolução deve ser posterior à data de empréstimo!');
                    e.preventDefault();
                    $('#dataDevolucao').addClass('animate__animated animate__shakeX');
                    setTimeout(() => {
                        $('#dataDevolucao').removeClass('animate__animated animate__shakeX');
                    }, 1000);
                }
            });
            
            // Efeito ao passar o mouse no botão de submit
            $('#submitBtn').hover(
                function() {
                    $(this).addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).removeClass('animate__animated animate__pulse');
                }
            );
            
            // Definir data de empréstimo como hoje por padrão
            const today = new Date().toISOString().split('T')[0];
            $('#dataEmprestimo').val(today);
            
            // Calcular data de devolução padrão (7 dias após o empréstimo)
            $('#dataEmprestimo').change(function() {
                const emprestimoDate = new Date($(this).val());
                if (!isNaN(emprestimoDate.getTime())) {
                    const devolucaoDate = new Date(emprestimoDate);
                    devolucaoDate.setDate(devolucaoDate.getDate() + 7);
                    $('#dataDevolucao').val(devolucaoDate.toISOString().split('T')[0]);
                }
            });
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>