-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/09/2025 às 13:08
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mvc_biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL,
  `secret_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `professor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `serie`, `email`, `senha`, `professor_id`) VALUES
(1, 'Ana Silva', '3A', 'ana.silva@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(2, 'marcos', '3a', 'marcosaluno@gmail.com', '33a55ce3bd6606437c71a69a15cee2c6', NULL),
(3, 'Carla Ferreira', '1C', 'carla.ferreira@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(4, 'Daniel Lima', '3A', 'daniel.lima@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(5, 'Eduarda Costa', '2B', 'eduarda.costa@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(6, 'Felipe Martins', '1C', 'felipe.martins@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(7, 'Gabriela Rocha', '3A', 'gabriela.rocha@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(8, 'Hugo Almeida', '2B', 'hugo.almeida@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(9, 'Isabela Ramos', '1C', 'isabela.ramos@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(10, 'João Mendes', '3A', 'joao.mendes@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL),
(11, 'João', '6°A', 'alice@gmail.com', '$2y$10$QJOZgpfBujBUvbt9Yt4OqOgOH7xUM6GvTVXKI75oS3Q4Z7BnCv.BK', NULL),
(12, 'João', '2A', 'alefteste100@gmail.com', '$2y$10$ICYHzsnt7JuRxIONbbZ58eMFjqd4RcPp69Ov/RDYJxs8VmMrZGj2.', NULL),
(13, 'João', '2D', 'joao@gmail.com', '$2y$10$Q9XOpB2o4V.n3MFKl/UWo.W/JtCDwl3bXJlqRF2H0g76RC5rB7Vp2', NULL),
(16, 'teste 56', '3D', 'teste56@gmail.com', '', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `backup_log`
--

CREATE TABLE `backup_log` (
  `id` int(11) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `data_backup` datetime NOT NULL,
  `tamanho` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `automatico` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `backup_log`
--

INSERT INTO `backup_log` (`id`, `arquivo`, `data_backup`, `tamanho`, `usuario_id`, `automatico`) VALUES
(1, 'backup_completo_2025-08-21_16-35-31.zip', '2025-08-21 11:35:36', 4403083, 5, 0),
(2, 'backup_2025-08-21_16-39-49.sql', '2025-08-21 11:39:50', 24589, 5, 0),
(3, 'backup_2025-08-21_16-40-38.sql', '2025-08-21 11:40:38', 24658, 5, 0),
(4, 'backup_2025-08-21_16-44-16.sql', '2025-08-21 11:44:17', 24727, 5, 0),
(5, 'backup_2025-08-21_16-44-30.sql', '2025-08-21 11:44:31', 24796, 5, 0),
(6, 'backup_2025-08-21_16-45-01.sql', '2025-08-21 11:45:01', 24865, 5, 0),
(7, 'backup_2025-08-21_16-46-02.sql', '2025-08-21 11:46:02', 24934, 5, 0),
(8, 'backup_2025-08-21_16-49-26.sql', '2025-08-21 11:49:27', 25003, 5, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

CREATE TABLE `configuracoes` (
  `id` int(11) NOT NULL,
  `dias_emprestimo` int(11) NOT NULL DEFAULT 7,
  `max_livros_aluno` int(11) NOT NULL DEFAULT 3,
  `max_renovacoes` int(11) NOT NULL DEFAULT 2,
  `multa_dia_atraso` decimal(10,2) NOT NULL DEFAULT 0.50,
  `backup_automatico` tinyint(1) NOT NULL DEFAULT 1,
  `email_notificacao` varchar(255) NOT NULL,
  `tema_padrao` enum('light','dark') NOT NULL DEFAULT 'light',
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `configuracoes`
--

INSERT INTO `configuracoes` (`id`, `dias_emprestimo`, `max_livros_aluno`, `max_renovacoes`, `multa_dia_atraso`, `backup_automatico`, `email_notificacao`, `tema_padrao`, `data_atualizacao`) VALUES
(1, 7, 10, 5, 0.00, 1, 'alefsouzasobrinho51@gmail.com', 'light', '2025-05-27 13:55:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `emprestimos`
--

CREATE TABLE `emprestimos` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `livro_id` int(11) DEFAULT NULL,
  `data_emprestimo` date NOT NULL,
  `data_devolucao` date DEFAULT NULL,
  `devolvido` varchar(50) NOT NULL,
  `professor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `emprestimos`
--

INSERT INTO `emprestimos` (`id`, `aluno_id`, `livro_id`, `data_emprestimo`, `data_devolucao`, `devolvido`, `professor_id`) VALUES
(15, 3, 16, '0000-00-00', '2025-05-27', 'Sim', 4),
(16, 1, 16, '0000-00-00', '2025-05-27', 'Nao', 4),
(17, 8, 15, '0000-00-00', '2025-05-27', 'Sim', 4),
(18, 9, 15, '0000-00-00', '2025-08-21', 'Sim', 4),
(19, 9, 13, '0000-00-00', '2025-08-21', 'Sim', 4),
(20, 4, 13, '0000-00-00', '2025-08-21', 'Sim', 4),
(21, 7, 5, '0000-00-00', '2025-08-21', 'Sim', 4),
(22, 6, 19, '0000-00-00', '2025-08-26', 'Sim', 4),
(23, 4, 19, '0000-00-00', '2025-06-03', '0', 4),
(24, 7, 19, '0000-00-00', '2025-09-03', 'Sim', 4),
(25, 8, 28, '2025-06-25', '2025-07-02', '0', 4),
(26, 1, 26, '2025-06-25', '2025-07-02', '0', 4),
(27, 1, 26, '2025-06-25', '2025-07-02', '0', 4),
(28, 7, 5, '2025-06-25', '2025-08-21', 'Sim', 4),
(29, 9, 31, '2025-08-21', '2025-08-21', 'Sim', 4),
(30, 1, 27, '2025-08-21', '2025-08-21', 'Sim', 4),
(31, 3, 13, '2025-08-21', '2025-08-28', '0', 4),
(32, 16, 36, '2025-09-03', '2025-09-03', 'Sim', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `capa_url` varchar(700) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `ano_publicacao` varchar(4) NOT NULL,
  `genero` varchar(100) NOT NULL,
  `quantidade` int(100) NOT NULL,
  `preview_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `autor`, `isbn`, `capa_url`, `descricao`, `categoria`, `ano_publicacao`, `genero`, `quantidade`, `preview_link`) VALUES
(3, 'Os Heróis da Fé De acordo com Hebreus 11', 'Domenico Barbera', '1507196539', NULL, 'SE assumimos a missão de escrever a respeito do décimo primeiro capítulo da carta aos Hebreus, não fizemos com o objetivo de fornecer ao leitor outro comentário, embora certas coisas vos escrevemos, além de não estar em comentários públicos, poderiam ser consideradas como tal, especialmente pelo conteúdo diferente que possui; mas apenas para enfatizar o valor da fé e sua eficácia, especialmente no exercício da vida cotidiana. Embora a respeito da fé, muitos livros foram escritos ao longo dos anos, acreditamos que é apropriado realizar uma pesquisa bastante completa sobre os homens e mulheres listados no capítulo 11 da Epístola aos Hebreus com o único propósito de descobrir os vários momentos e várias situações que caracterizaram a vida dessas pessoas. Sem dúvida, a maneira pela qual lidamos com este trabalho, embora nos envolveu muito, especialmente em termos do texto bíblico, acreditamos que vale a pena fazê-lo, pelo inevitável benefício que trará, a fim de compreender e avaliar os personagens tratados , especialmente no que diz respeito à sua fé.<br>', NULL, '', '', 0, NULL),
(4, 'Jesus', 'Charles Swindoll', '857325906X', NULL, 'Filho de Deus, o Salvador: o maior herói. Passados mais de 2.000 anos, a figura de Jesus continua em evidência. Se não bastassem os bilhões de seguidores enfileirados nos variados ramos do cristianismo que reconhecem sua santidade, pesquisadores nos diversos campos das ciências sociais continuam a discutir o verdadeiro papel de Jesus. Enquanto alguns exaltam sua liderança popular, há os que simplesmente o consideram uma farsa. Após desfilar alguns dos principais personagens da galeria de heróis bíblicos, Charles Swindoll encerra a série Heróis da fé com o ser mais importante da história. Distante de controvérsias, Swindoll ressalta a figura do Salvador da humanidade e sua história singular. Um carpinteiro, vindo das regiões mais desvalorizadas e esquecidas da Palestina, revela o amor de Deus e sua paixão pelos mais pobres, cidadãos de segunda classe alçados à condição de cidadãos do Reino de Deus. Acompanhe Charles Swindoll na inspiradora trajetória de Jesus de Nazaré e compreenda por que sua vida e seus ensinamentos são determinantes para quem deseja conhecer a Deus.', NULL, '', '', 0, NULL),
(5, 'One Piece - vol. 16', 'Eiichiro Oda', '6555121912', 'http://books.google.com/books/publisher/content?id=SmbjDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73cXT_lf7dG2iIRaU_pH5t99MxgZo8ES65IfvqtJsq5THhRl7pF8SHCtsYUzDSzQCrZ6Aln3HbnPnJtc9Kpbk0DvIYSM4xF7K53byZhx0gWDSbjv26PjOgMpYsRBcoTKwCIrx5h&source=gbs_api', 'No Reino de Drum, Luffy e Sanji enfrentam uma perigosa escalada ao Castelo de Drum para levar Nami a uma famosa médica e seu peculiar assistente. Mas Wapol, o antigo rei do local, pretende retomar o poder e passar por cima de quem estiver em seu caminho!', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 3, NULL),
(13, 'One Piece - vol. 8', 'Eiichiro Oda', '8542621301', 'http://books.google.com/books/publisher/content?id=sxCeDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE716ViXRVR9Qs5fmts_1VDrA-4qAhh3CGvSx5kpdIkzdNE_O3wwXD8g5CX7Izc2JgSMOwHi2GBJPBemmMoBLHLPuugyC2yaGypESMnLrcQ_hKFbfPhAlOC6s3RYOSIldEEA3Giac&source=gbs_api', 'O gás tóxico do MH5 tem como principal vítima Gin, único a sofrer todo o ataque sem uma máscara. Luffy parte para cima de Don Krieg com tudo, que volta a disparar dardos contra ele. Sem se importar, o garoto enfim se aproxima de Don Krieg, que usa um manto de espinhos para se proteger. Mesmo assim, Luffy não se importa e desfere um poderoso soco no oponente, atingindo os espinhos no processo. Zeff manda Sanji prestar atenção na luta de Luffy e perceber sua determinação.', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 3, NULL),
(15, 'One Piece - vol. 9', 'Eiichiro Oda', '854262131X', 'http://books.google.com/books/publisher/content?id=E_idDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71HECbk52anMmXB7aVWhUBOH1vceK0bhTHRDfefdFPMpQHWwbfJGVXB6RhKW5rZT_MlfL--5ubjm7uAiKHBeSkQhQ6sahgshhZGka1NoRaA3LMfKE1y_LGWsuUAkb2fcAQfNyBa&source=gbs_api', 'Luffy e sua tripulação devem enfrentar Arlong e seus piratas homens-peixe, especializados em usar táticas de intimidação para extorquir inocentes moradores da vila. E algo bombástico sobre o passado de Nami vem à tona!', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 4, NULL),
(16, 'Dom Casmurro', 'Machado de Assis, Edições Câmara', '8540205416', 'http://books.google.com/books/publisher/content?id=I-fUDAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71rqzsY-wOOgyBlXGUkuRKUzKphOCdnu2oLUsjXYg5QvLYUXrgPH8BSdmWKT6zRwLn5kP12krhI7LUm-2eAF_3SCvDCAH8Yxp12cs9m6Zc5A4gE0Hc62yRsfQJS-ITbl98hO5s6&source=gbs_api', '<p>Romance publicado pela primeira vez em 1899, <i>Dom Casmurro</i>, novo título da série Prazer de Ler da Edições Câmara, apresenta um olhar crítico sobre a sociedade brasileira do século XIX e  integra a trilogia realista de Machado de Assis ao lado de <i>Memórias Póstumas de Brás Cubas</i> e <i>Quincas Borba</i>.</p><p></p>', 'Fiction / Romance / General', '2016', 'Fiction / Romance / General', 10, NULL),
(19, 'O Otelo brasileiro de Machado de Assis', 'Helen Caldwell', '8574800937', 'http://books.google.com/books/content?id=Q6kETzYptRMC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73coqBVKsPvi34o-B07drI77tYTxPNLR2egKVNUGTTm5MHvM2cwrh__dAWwrUJcy4khpK-XxCWm3T8FzAb8lrh-ALooAI-N09jkpAs7chNus4OiyZHWo8jSaRqia7-klhCsYOsG&source=gbs_api', 'Por muito tempo, prevaleceu nas leituras críticas de Dom Casmurro o tom malicioso sobre a personalidade de Capitu. Helena Caldwell analisa a obra-prima de Machado de Assis afastando-se dessas interpretações machistas e revelando o nexo que o escritor estabelece com Otelo, de Shakespeare. Publicado em 1960, este clássico dos estudos machadianos só foi traduzido para o português mais de quarenta anos depois, chegando agora ao leitor interessado num dos maiores artistas que o Brasil já teve.', 'Literary Criticism / Books & Reading', '2002', 'Literary Criticism / Books & Reading', 6, NULL),
(27, 'Diário de um Banana 3', 'Jeff Kinney', '8576835207', 'http://books.google.com/books/publisher/content?id=L7kqAgAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71EiR3LrMjRZfOu9Fg13FGkmVSQZ9lpcBlbujhcy75UCC9ld_XZ-XAb_R6YY9KcFT-x0lYl4lMo65L3zbNfZjCOO6eNa2lCPbxTYn2f2sldaswt39hJOWry-tiQZgylvlpyocei&source=gbs_api', 'Greg não toma jeito mesmo. E a cada dia se envolve em mais confusão. O difícil é fazer seu pai engolir esse talento de Greg para se meter em situações embaraçosas. Ele já está por aqui com o garoto. E para botar algum juízo na cabeça dele, Frank Heffley tenta de tudo um pouco. É claro que Greg sempre encontra uma maneira de estragar tudo. Até que seu pai faz uma grande ameaça e as coisas mudam de figura. Qual será a gota d\'água que vai fazer a paciência de Frank transbordar de vez? Destaque: Não é fácil ser criança. E ninguém sabe disso melhor do que Greg Heffley, que se vê mergulhado no mundo do ensino fundamental, onde fracotes são obrigados a dividir os corredores com garotos mais altos, mais malvados e que já se barbeiam. Com uma linguagem universal e própria dos pré-adolescentes, essa coleção já vendeu mais de 40 milhões de exemplares em todo o mundo. É uma das séries infantis de maior sucesso de todos os tempos.', 'Juvenile Fiction / Family / General', '2013', 'Juvenile Fiction / Family / General', -1, 'http://books.google.com.br/books?id=L7kqAgAAQBAJ&hl=&source=gbs_api'),
(28, 'O Diário de um Banana 1', 'Jeff Kinney', '9896237336', 'http://books.google.com/books/publisher/content?id=t_6VEAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE710QCmk_6uQfMnzlacT4i6SXbkGgUpTvXHJpzlfQN5feiDb5uiWW0AJW9MMJ8t49R57Xn9POKPNILBkyODf86227wTu0M3xNFtN6Smg3sQgRMW_dU89rCbPtarsz2g2thAABDYz&source=gbs_api', '<p>Como o Greg diz no seu diário: Não esperem que eu me ponha para aqui com \"Querido Diário\" isto e \"Querido Diário\" aquilo. Felizmente para nós, o que o Greg diz e o que realmente faz são duas coisas muito diferentes.</p> <p>«Não é fácil ser criança. E ninguém sabe isso melhor do que o Greg Heffley, que se vê aprisionado na escola preparatória, onde fracotes minorcas pidem os corredores com miúdos mais altos e malvados que já fazem a barba. Em <b> <i>O Diário de um Banana</i> </b>, o autor e ilustrador Jeff Kinney apresenta-nos um herói improvável.</p> <p>Como o Greg diz no seu diário: Não esperem que eu me ponha para aqui com \"Querido Diário\" isto e \"Querido Diário\" aquilo. Felizmente para nós, o que o Greg diz e o que realmente faz são duas coisas muito diferentes.»</p> <p>«O mundo está louco pela coleção O Diário de um Banana e pelo Jeff Kinney!» <b>The Sun</b> </p> <p>«Jeff Kinney está no topo, juntamente com J. K. Rowling, dos autores infantojuvenis mais bem-sucedidos do mundo.» <b>The Independent</b> </p>', 'Juvenile Fiction / Comics & Graphic Novels / Humorous', '2022', 'Juvenile Fiction / Comics & Graphic Novels / Humorous', 0, 'http://books.google.com.br/books?id=t_6VEAAAQBAJ&hl=&source=gbs_api'),
(30, 'Vidas Secas - Edição especial', 'Graciliano Ramos', '6585279042', 'http://books.google.com/books/publisher/content?id=_j79EAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73JMRfMVhXcDBt4NvWKlNkc3lWEhjZtltQWgsLeCH6YGK547LiTUcrN_jrZB9cN3asVFOMIUcppkRsDSvaF0UdDewog-eEhjSPmxQLkI-zvtTioX1voJ-BEMqc4gGkECQ9hG0Ds&source=gbs_api', '<p> <b>Descubra \"Vidas Secas\" em uma Edição Especial pela Editora Tabuleta V</b> </p> <p>Descubra \"Vidas Secas\", de Graciliano Ramos, numa edição revitalizada pela editora Tabuleta V, e mergulhe na saga emocionante de uma família de retirantes em sua luta incansável pela sobrevivência no sertão nordestino. Esta edição não só reacende a chama de uma das obras mais significativas da literatura brasileira, mas também a enriquece com conteúdos exclusivos que prometem intensificar sua experiência de leitura.</p> <p>Inicie sua jornada com uma carta íntima ao leitor, preparando o cenário para a profunda narrativa que se segue. Antes mesmo de virar a primeira página, familiarize-se com Fabiano, Sinhá Vitória, seus filhos e a inesquecível cadela Baleia através de perfis detalhados, construindo uma conexão íntima que perdurará por toda a história.</p> <p>Navegue pela essência de \"Vidas Secas\" com uma análise meticulosa que revela o rico contexto histórico e social do Nordeste brasileiro das décadas de 1920 e 1930, trazendo à tona a realidade árida e desafiadora do sertão, assim como as lutas sociais e políticas de uma época. Esta seção destila a magia da prosa de Ramos, destacando sua habilidade em retratar a dignidade humana frente às adversidades, oferecendo uma visão aprofundada que transcende o ato de leitura.</p> <p>Aprofunde-se na vida e legado de Graciliano Ramos com uma seção dedicada a um dos pilares do modernismo literário brasileiro, capturando a essência de sua obra e o impacto duradouro em nossa cultura.</p> <p>Para estudantes e aficionados por literatura, a edição traz uma análise aprofundada de temas, símbolos e estrutura de \"Vidas Secas\", complementada por questões de vestibular que enriquecem o entendimento e a apreciação do texto.</p> <p>Além disso, a Tabuleta V se orgulha em apresentar esta obra-prima na fonte Open Dyslexic Alt, tornando-a acessível a leitores com dislexia e reafirmando o compromisso com a democratização da cultura e educação.</p> <p> <i> <b>\"Vidas Secas\" não é apenas uma leitura obrigatória, mas uma experiência imersiva que ressoa com questões de humanidade, resistência e esperança. Garanta sua cópia hoje e seja parte da jornada inesquecível de uma família pelo coração do Brasil.</b> </i> </p>', 'Fiction / Literary', '2024', 'Fiction / Literary', 1, 'http://books.google.com.br/books?id=_j79EAAAQBAJ&hl=&source=gbs_api'),
(31, 'One Piece, Vol. 107', 'Eiichiro Oda', '1974749797', 'http://books.google.com/books/content?id=JYSO0AEACAAJ&printsec=frontcover&img=1&zoom=1&imgtk=AFLRE71PJTsA1XZ1OrqOl4N7NRrUULz8JpmejXgyrTXc20RwLKsC1dFvHeTC9hAtlBoMw4-6IKvaVxyjkbomPXkPMpcA88dxPYINWf7RupeOA0614kQw4Uayr7tW83nz2CHFQWBRg9-x&source=gbs_api', '<b>Join Monkey D. Luffy and his swashbuckling crew in their search for the ultimate treasure, One Piece!</b><br><br>As a child, Monkey D. Luffy dreamed of becoming King of the Pirates. But his life changed when he accidentally gained the power to stretch like rubber...at the cost of never being able to swim again! Years later, Luffy sets off in search of the One Piece, said to be the greatest treasure in the world...<br><br>Having learned too much of the world’s history, Dr. Vegapunk is now the target of the CP0 assassins. Vegapunk’s only hope may be to ask for help from Luffy and the Straw Hat crew, but where are they? Chaos erupts on Egghead Island as the world government sends some powerful reinforcements.', 'Comics & Graphic Novels / Manga / General', '2024', 'Comics & Graphic Novels / Manga / General', 1, 'http://books.google.com.br/books?id=JYSO0AEACAAJ&hl=&source=gbs_api'),
(34, 'Dom Casmurro', 'Machado de Assis, Edições Câmara', '343143124132', NULL, NULL, NULL, '2010', 'Comics & Graphic Novels / Manga / General', 0, NULL),
(35, 'fafda', 'dfafdas', '8394729884', NULL, NULL, NULL, '2343', 'fdasfdsa', 0, NULL),
(36, 'Orgulho e Preconceito', 'Jane Austen', '6587435025', 'http://books.google.com/books/publisher/content?id=FggVEAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE72LCpBinB66WZSLYKUsJDHsD-P9dTYWqLDoSIzWgpvCuoCU0lg7FLvUg5jXSC0UeOT01xnnNoW1bQpHEnFR4kqX7XzudH7Xue70bC6-stN7QRrw9ND1CgqFS_j-60GTULiGvq6I&source=gbs_api', '<p>Jane Austen explorou como poucos a expressão de nossos vícios e virtudes no ambiente doméstico, expondo em cada gesto, olhar e palavra a alma de seus personagens. Seu olhar aguçado sobre a índole humana aliado a uma percepção crua e irônica dos costumes de sua época atinge o auge em Orgulho e Preconceito, uma história de amor repleta de desencontros e desentendimentos como só as histórias humanas são capazes. Por meio de Elizabeth Bennet e Fitzwilliam Darcy – incontestavelmente, o casal mais afiado da história da literatura - somos conduzidos à sociedade inglesa da virada do século XIX, cujos orgulhos e preconceitos das mais diversas naturezas ecoam ainda em nosso presente.</p><p><br></p><p>Sobre a autora:</p><p>JANE AUSTEN (1775-1817) foi uma escritora inglesa consagrada pelos romances marcadamente irônicos e incisivos sobre a cidade rural da Inglaterra entre o final do século XVIII e início do século XIX. Além do clássico Orgulho e Preconceito, sua obra ainda inclui títulos de renome mundial como Razão e Sensibilidade, Emma e Persuasão.</p><p><br></p>', 'Fiction / Romance / Historical / General', '2021', 'Fiction / Romance / Historical / General', 1, 'http://books.google.com.br/books?id=FggVEAAAQBAJ&hl=&source=gbs_api'),
(37, 'Orgulho e preconceito: edição comentada', 'Jane Austen', '6584952134', 'http://books.google.com/books/publisher/content?id=BPLEEAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE70npkylW1tbPn0KV_qCPVe2B0g90LtVIbwMnMvKHWSl6GoWcnu7oz_3ra4nqRvrcblwyXsfpd3Znrylut95SVrbilZwMrhJjK7fBAramJUfL8oZ-k9bZvUE6uCE22xN36t3LbVC&source=gbs_api', '<p> <b>Com seu talento único para costurar uma narrativa cativante e repleta de diálogos brilhantes, Jane Austen retrata de modo magistral o universo que conhece como ninguém: a vida e a formação das mulheres no mundo patriarcal, rígido e cheio de formalidades da classe média inglesa provinciana. </b> </p> <p>Segunda das cinco filhas dos Bennet, Elizabeth é sagaz e de espírito independente, mas, assim como as jovens da época, vê no casamento com um bom partido o caminho natural para uma vida aceitável. Ao conhecer o sr. Darcy, cobiçado solteiro que se muda para o seu condado, é repelida pela arrogância do cavalheiro, que por sua vez parece indiferente aos encantos da moça. <br>Publicado em 1813, <i>Orgulho e preconceito</i> segue fascinando leitoras e leitores de todas as idades. Apaixonante e divertidíssima história de amor, com todas as amizades, fofocas e rivalidades esnobes da vida provinciana, o romance de Jane Austen é também uma jornada de autoconhecimento na qual Elizabeth e Darcy devem amadurecer para se tornarem pessoas melhores e conseguirem seu final feliz.</p>', 'Fiction / Classics', '2023', 'Fiction / Classics', 1, 'http://books.google.com.br/books?id=BPLEEAAAQBAJ&hl=&source=gbs_api'),
(38, 'Orgulho e Preconceito de Jane Austen (Análise do livro)', 'Mélanie Kuta', '2808692218', 'http://books.google.com/books/publisher/content?id=S-a-EAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE718g_3nx4mfxPSO3ThGkQ1f2rNqSoXZt4YGfuG45jEwz_nRY6jbY2HarYmrxwv69VffzptYpCSNypQtz4BjEjlLCA185iyRarBdRa5Fx4DlYiZXhBQvyMIG3PXP_XGUJ9ylhhTg&source=gbs_api', 'O que devemos aprender com Orgulho e Preconceito, o romance essencial da literatura inglesa? Este livro é o primeiro do seu género no mundo a ser publicado nos Estados Unidos. <br><br><br> Encontrará neste livrinho : <br>- Um resumo completo <br>- Uma apresentação das personagens principais, como Elizabeth Bennet, Darcy e Jane Bennet <br>- Uma análise das especificidades da obra: a arte do diálogo, um romance epistolar e a importância do casamento <br><br><br> Uma análise de referência para compreender rapidamente o significado da obra.<br>', 'Fiction / Literary', '2023', 'Fiction / Literary', 1, 'http://books.google.com.br/books?id=S-a-EAAAQBAJ&hl=&source=gbs_api');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `ultimo_login` datetime DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professores`
--

INSERT INTO `professores` (`id`, `nome`, `email`, `cpf`, `senha`, `data_cadastro`, `ultimo_login`, `ativo`, `admin`) VALUES
(4, 'alefteste1', 'alefteste1@gmail.com', '72316609082', '$2y$10$YuNDRe6vCVqyjfo/6soKHOyNUI2f2U2RYtJAj6kcAkdvF4H5zHxCG', '2025-04-26 18:36:20', '2025-09-03 08:01:23', 1, 0),
(5, 'Alef Admin', 'alefsouzasobrinho51@gmail.com', '70319891089', '$2a$10$LbMCM.FD51ejQ79mBy8aV.RII9ZSxWiU25IeKL2ZWe6lGoFdWDCpq', '2025-05-26 07:43:41', '2025-08-21 11:35:25', 1, 1),
(6, 'Fernando Franciolli', 'ffranciolliprofessor@gmail.com', '63070137024', '25d55ad283aa400af464c76d713c07ad', '2025-06-27 08:10:44', NULL, 1, 0),
(7, 'Fernando2', 'fernando@gmail.com', '06042303031', '25d55ad283aa400af464c76d713c07ad', '2025-06-27 08:25:00', NULL, 1, 0),
(8, 'Alice', 'alice@gmail.com', '12345678901', '$2y$10$FAvpmuOZr1VYPyFR7tIiP.rU1ka2.v9V3renliB5kjxX/xqagt5Lu', '2025-06-27 08:47:41', NULL, 1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Índices de tabela `backup_log`
--
ALTER TABLE `backup_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `livro_id` (`livro_id`);

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Índices de tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `backup_log`
--
ALTER TABLE `backup_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professores` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `backup_log`
--
ALTER TABLE `backup_log`
  ADD CONSTRAINT `backup_log_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `professores` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
