![](media/image1.png){width="5.905555555555556in" height="8.35in"}

**Descrição**

Este sistema de gerenciamento de biblioteca é uma aplicação desenvolvida
para facilitar o controle de acervos, empréstimos, devoluções e
cadastros de usuários e livros em uma biblioteca. Ele é composto por
diferentes módulos que atendem às necessidades de professores,
bibliotecários, alunos e leitores.

**Principais funcionalidades**

Cadastro e gerenciamento de livros: inclusão de novos títulos,
atualização de informações, controle de exemplares disponíveis.

Cadastro de usuários: alunos, professores administradores, com níveis de
acesso diferenciados.

Empréstimo e devolução de livros, registro das movimentações com prazos,
alertas de atraso e controle de disponibilidade.

Consulta ao acervo: pesquisa por título, autor, ISBN, código de barras
ou categoria.

Histórico de empréstimos: visualização de livros já emprestados por cada
usuário.

Relatórios e estatísticas: dados sobre livros mais lidos, atrasos,
quantidade de empréstimos por período etc.

Notificações: Teria alerta por E-mail, se a escola colaborasse.

**Instalação**

| **Componente**           | **Mínimo**                          | **Recomendado**              |
|--------------------------|-------------------------------------|------------------------------|
| Processador              | 2 núcleos (Intel i3 ou equivalente) | 4 núcleos (i5 ou Ryzen 3+)   |
| Memória RAM              | 4GB                                 | 8 GB ou mais                 |
| Armazenamento            | 10 GB livre (HDD ou SSD)            | SSD de 20+ GB (NVMe ou SATA) |
| Rede Local/Wi-Fi         | 10 Mbps (interna)                   | 100 Mbps                     |
| Sistema Operacional (SO) | Windows 10 x64                      | Windows 11 x64               |

**Programas utilizados para fazer o sistema rodar**

XAMPP Versão 3.3.0.

PHP Versão 8.1.25 Opcional, já virá junto com o Xampp.

Visual Studio Code (opcional, para clonar e rodar o projeto).

Se optar pelo VS Code, precisará instalar o Git também.

Um navegador (Chrome, Edge, Firefox, Opera).

**Links de onde baixar cada programa que será utilizado**

Link para baixar o XAMPP:
https://www.apachefriends.org/pt_br/download.html

Link para baixar o Visual Studio Code:
https://code.visualstudio.com/download

Link para baixar o PHP: https://www.php.net/downloads.php

O navegador você com certeza já tem.

**Breve descrição do que cada programa faz**

O que o XAMPP faz?

O XAMPP é um pacote de software de código aberto que cria um ambiente de
desenvolvimento web local em seu computador, permitindo que você execute
e teste sites e aplicações web sem a necessidade de um servidor online.
Ele inclui componentes como o Apache (servidor web), MySQL (banco de
dados), PHP e Perl, facilitando a configuração e o gerenciamento de um
ambiente de desenvolvimento para diversas linguagens de programação e
bancos de dados.

O que o PHP faz?

O PHP é uma linguagem de script de propósito geral, muito utilizada no
desenvolvimento web, especialmente para a criação de páginas dinâmicas e
aplicações web. Ele é executado no lado do servidor e permite gerar
conteúdo interativo que responde a ações do usuário ou outros eventos,
além de manipular dados e interagir com bancos de dados.

O que o Visual Studio Code faz?

O Visual Studio Code (VS Code) é um editor de código-fonte leve, mas
poderoso, desenvolvido pela Microsoft, disponível para Windows, MacOS e
Linux. Ele oferece suporte integrado para várias linguagens de
programação, como Javascript, TypeScript e Node.js, e possui um
ecossistema vasto de extensões que adicionam suporte para outras
linguagens e ambientes de execução. O VS Code é altamente
personalizável, permitindo que os usuários mudem o tema, atalhos de
teclado e outras preferências. Além disso, ele inclui recursos como
depuração, controle de versão Git integrado, realce de sintaxe,
preenchimento inteligente de código e refatoração de código.

O que faz um navegador web?

Um navegador, também conhecido como browser, é um software que permite
aos usuários acessarem e interagir com conteúdo na internet. Ele
funciona como uma ponte entre o usuário e a World Wide Web, exibindo
páginas web, imagens, vídeos e outros recursos online. Em essência, o
navegador interpreta e renderiza o código (HTML, CSS, Javascript etc.)
das páginas web, permitindo que o usuário navegue, interaja com
elementos como links e formulários, e acesse diferentes tipos de
conteúdo online.

**Como posso utilizar?**

Abra o XAMPP Control Panel e inicie o Apache e MySQL.

Abra o VS Code, acesse o terminal e digite "cd C:\xampp\htdocs", logo
após, acesse o repositório <https://github.com/alef-ss/mvc-biblioteca> e
procure por um botão verde escrito "Code" ou "Código" se estiver em
português, você verá o link do repositório, copie ele.

Volte para o VS Code e digite no terminal: "git clone \<link do
repositorio\>", coloque o link que você copiou logo depois do "git
clone".

Depois, digite: "cd mvc-biblioteca" e depois "code .".

Abra o navegador e na URL acesse: "localhost/phpmyadmin" ou
"localhost:8081/phpmyadmin" se o seu Apache estiver usando a porta 8081.

À sua esquerda você verá os bancos de dados, clique em "Novo", nomeie
ele de "mvc_biblioteca" e clique "Criar".

O banco de dados será selecionado automaticamente, procure por
"Importar" na tela, clique, e escolha o arquivo que veio junto com o
repositório quando você o clonou, ele deve estar em
"C:\xampp\htdocs\mvc-biblioteca" na raiz do projeto.

Desça a página e clique "Exportar".

Depois você pode acessar o site normalmente em:
"localhost/mvc-biblioteca" ou "localhost:8081/mvc-biblioteca", na página
de login acesse com as credenciais [alefteste1@gmail.com /
alef1234](mailto:alefteste1@gmail.com%20/%20alef1234), Você já terá
acesso ao sistema, vá na página "Cadastrar Professor" e cadastre seus
dados.

Volte ao Painel do Professor e clique no botão em vermelho "Sair".

Agora basta acessar com os dados que você cadastrou.

![Logotipo, nome da empresa O conteúdo gerado por IA pode estar
incorreto.](media/image2.png){width="5.905555555555556in"
height="8.359027777777778in"}

**Login**

1\. E-mail do usuário.

2\. Senha do usuário.

3\. Se você esqueceu a sua senha, clique no link.

![](media/image3.png){width="5.905555555555556in"
height="5.429166666666666in"}

**Esqueceu a senha?**

1.  Preencha o campo **1** com seu CPF

2.  Preencha o campo **2** com seu endereço de e-mail.

3.  Clique no botão escrito "Verificar Dados"

4.  Aguarde o programa verificar os dados, se estiverem corretos, você
    verá uma tela pedindo a nova senha e a confirmação, depois de
    preencher, basta clicar em "Alterar Senha" e fazer login com sua
    nova senha.

![Interface gráfica do usuário, Aplicativo O conteúdo gerado por IA pode
estar incorreto.](media/image4.png){width="5.905555555555556in"
height="5.575in"}

**Painel do professor**

1.  Página para cadastrar um novo professor.

2.  Página para cadastrar novos alunos.

3.  Buscar e cadastrar livros, é onde você encontrará e cadastrará todos
    os livros que ficarão no acervo.

4.  É onde você cadastrará todos os empréstimos para os alunos.

5.  Uma lista de todos os empréstimos registrados.

6.  Página para editar tudo sobre algum livro, quantidade, título,
    autor, data etc.

7.  Página para ver todos os livros cadastrados.

8.  Relatórios sobre tudo o que já foi feito (empréstimos, melhores
    salas e alunos, livros etc.).

9.  Histórico de livros emprestados, por qual aluno foi emprestado, data
    de empréstimo e devolução.

10. Caso tenha algum problema com o sistema e precise de suporte, acesse
    esta página e envie uma mensagem para mim através do formulário.

11. Clique se quiser encerrar a sessão.

12. Os cards numerados com 12, 13, 14 e 15 são relatórios rápidos, com a
    quantidade de alunos cadastrados, livros no acervo, empréstimos
    ativos e pendentes para devolução.

13. Os botões numerados com 16, 17 e 18 levarão você para as páginas de:
    Criar empréstimos, Buscar e cadastrar livros e Relatórios.

![](media/image5.png){width="5.905555555555556in"
height="2.9611111111111112in"}

**Cadastrar professor**

1.  Nome completo.

2.  Endereço de E-mail (será utilizado no login).

3.  CPF, será utilizado para validar os dados do professor.

4.  Senha (vai ser utilizada para fazer login juntamente com o e-mail

5.  Clique no botão "Cadastrar Professor" após preencher todos os campos
    corretamente.

6.  Esta página também mostra todos os professores cadastrados, com a
    opção de deletar.

![Tela de computador O conteúdo gerado por IA pode estar
incorreto.](media/image6.png){width="5.905555555555556in"
height="2.714583333333333in"}

![](media/image7.png){width="5.905555555555556in"
height="2.002083333333333in"}

**Cadastrar alunos**

1.  Nome completo.

2.  Série.

3.  Endereço de e-mail.

4.  Senha.

5.  Clique no botão após preencher todos os campos corretamente.

6.  Uma lista com todos os alunos cadastrados.

![](media/image8.png){width="5.905555555555556in"
height="2.811111111111111in"}

**Buscar e cadastrar livros**

1.  Informe o título ou ISBN do livro

2.  Depois, clique no botão "Buscar"

![Tela de celular com aplicativo aberto O conteúdo gerado por IA pode
estar incorreto.](media/image9.png){width="5.905555555555556in"
height="2.1in"}

A página vai carregar os resultados e até resultados semelhantes,
mostrando título, autor, ISBN, um link para pré-visualização e caixa
para marcar caso queira cadastrar.

![Interface gráfica do usuário, Texto, Site O conteúdo gerado por IA
pode estar incorreto.](media/image10.png){width="5.905555555555556in"
height="2.977777777777778in"}

**Visualizar livros**

Nos primeiros cards mostrará o total de livros cadastrados, total de
livros na página atual e o total de páginas que tem.

Você verá uma barra de pesquisa, utilize se quiser encontrar algum livro
de maneira mais rápida, desde que ele esteja cadastrado no sistema.

Ele vai puxar as informações do livro: capa, título, altor, link de
visualização, opção de editar e deletar o livro.

![Tela de celular O conteúdo gerado por IA pode estar
incorreto.](media/image11.png){width="5.905555555555556in"
height="2.838888888888889in"}

**Editar livros**

Você poderá alterar todas as informações do livro, com exceção da capa.

![Interface gráfica do usuário, Aplicativo, Email O conteúdo gerado por
IA pode estar incorreto.](media/image12.png){width="5.905555555555556in"
height="3.0833333333333335in"}

**Relatórios**

No primeiro card mostrará os Alunos Destaque de cada sala, com um
ranking do 1° ao 3° lugar com as salas que mais leram.

No segundo mostra as Salas Destaque.

No terceiro mostra um gráfico dos livros mais emprestados.

No quarto card mostra os top 10 alunos.

![Interface gráfica do usuário, Aplicativo, Teams O conteúdo gerado por
IA pode estar incorreto.](media/image13.png){width="5.905555555555556in"
height="3.5076388888888888in"}![Gráfico, Gráfico de explosão solar O
conteúdo gerado por IA pode estar
incorreto.](media/image14.png){width="5.905555555555556in"
height="3.015972222222222in"}![Tabela O conteúdo gerado por IA pode
estar incorreto.](media/image15.png){width="5.905555555555556in"
height="1.8256944444444445in"}

**Histórico**

![Interface gráfica do usuário, Aplicativo, Site O conteúdo gerado por
IA pode estar incorreto.](media/image16.png){width="5.905555555555556in"
height="2.223611111111111in"}

Você pode optar por usar filtros para encontrar o histórico de algum
aluno específico e exportar para PDF. O botão pra exportar pra Excel não
funciona.

**Suporte**

Bem descritivo, basicamente você preenche seu nome completo, email, o
assunto da mensagem e a mensagem, depois disso, basta clicar em "Enviar"
e a mensagem vai ser enviada pra mim, basta esperar pela resposta.

![Tela de computador com texto preto sobre fundo branco O conteúdo
gerado por IA pode estar
incorreto.](media/image17.png){width="5.905555555555556in"
height="3.5055555555555555in"}
