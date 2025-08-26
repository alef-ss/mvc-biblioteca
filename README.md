Manual do Usuário – Sistema de Gestão de Biblioteca
1. Introdução
Este sistema permite o gerenciamento completo de uma biblioteca escolar, incluindo controle de empréstimos, cadastro de alunos, professores, livros, relatórios, estatísticas e backups automáticos.

2. Acesso ao Sistema
2.1. Login
Acesse a página inicial do sistema pelo navegador.
Informe seu e-mail e senha cadastrados.
Usuários administradores devem usar:
Email: admin@biblioteca.com
Senha: admin123
Clique em Entrar.
2.2. Recuperação de Senha
Caso esqueça a senha, utilize a opção “Esqueci minha senha” na tela de login.
Siga as instruções para redefinir sua senha.
3. Área Administrativa
3.1. Dashboard
Após o login, você será direcionado ao painel principal (dashboard).
Visualize estatísticas rápidas, notificações e ações rápidas.
3.2. Cadastro de Alunos
No menu lateral, clique em Alunos > Cadastrar Aluno.
Preencha os dados obrigatórios (nome, matrícula, turma, etc.).
Clique em Salvar.
3.3. Cadastro de Professores
Acesse Professores > Cadastrar Professor.
Preencha os dados e defina se o professor será administrador.
Clique em Salvar.
3.4. Cadastro de Livros
Vá em Livros > Cadastrar Livro.
Informe título, autor, ISBN, editora, ano, etc.
Clique em Salvar.
4. Empréstimos de Livros
4.1. Realizar Empréstimo
Acesse Empréstimos > Novo Empréstimo.
Selecione o aluno e o(s) livro(s) desejado(s).
Defina a data de devolução conforme as regras do sistema.
Clique em Confirmar Empréstimo.
4.2. Renovar Empréstimo
Na lista de empréstimos, localize o empréstimo desejado.
Clique em Renovar e confirme a nova data de devolução.
4.3. Devolver Livro
Na lista de empréstimos, clique em Devolver ao lado do livro.
Confirme a devolução.
5. Relatórios
Acesse Relatórios no menu.
Escolha o tipo de relatório (empréstimos, alunos, livros, atrasos, etc.).
Exporte em PDF ou Excel conforme necessário.
6. Configurações do Sistema
Acesse Configurações na área administrativa.
Ajuste:
Dias de empréstimo
Máximo de livros por aluno
Máximo de renovações
Multa por atraso
Email para notificações
Backup automático
Tema claro/escuro
7. Backup Automático
O sistema realiza backups automáticos diariamente.
Os arquivos ficam na pasta backups.
Para restaurar, utilize o arquivo .sql gerado.
8. Segurança
O sistema possui autenticação por perfil (admin/professor).
Dados sensíveis são protegidos contra SQL Injection.
Todas as ações importantes são registradas em logs (logs/).
9. Temas (Claro/Escuro)
No canto inferior direito, clique no botão de alternância de tema.
O sistema mudará entre tema claro e escuro instantaneamente.
10. Dúvidas Frequentes
Não consigo acessar: Verifique se está usando o e-mail e senha corretos.
Erro ao cadastrar: Confira se todos os campos obrigatórios estão preenchidos.
Backup não está funcionando: Verifique permissões da pasta backups e configuração do crontab.
11. Suporte
Para dúvidas ou problemas, consulte o administrador do sistema ou envie e-mail para o suporte cadastrado nas configurações.
12. Observações Finais
Mantenha o sistema e dependências atualizados.
Realize backups regulares.
Não compartilhe sua senha.
