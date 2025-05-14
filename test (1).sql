-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 27/04/2025 às 23:31
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `test`
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
(2, 'marcos', '3a', 'marcosaluno@gmail.com', '33a55ce3bd6606437c71a69a15cee2c6', NULL);

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
(3, 1, 2, '2025-03-06', '2025-04-06', '0', NULL),
(4, 1, 3, '2025-04-24', '2025-05-09', '', 3);

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
  `quantidade` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `autor`, `isbn`, `capa_url`, `descricao`, `categoria`, `ano_publicacao`, `genero`, `quantidade`) VALUES
(2, 'Heróis da fé', 'Orlando Boyer', '8526311956', NULL, 'Mais de 300.000 livros vendidos! Um dos maiores clássicos da literatura evangélica. Homens extraordinários que incendiaram o mundo. A cada capítulo uma história diferente, uma nova biografia. As verdadeiras histórias de alguns dos maiores vultos da Igreja de Cristo. Heróis como: Lutero, Finney, Wesley e Moody, dentre outros que resolveram viver uma vida de plenitude do evangelho. \"O soluço de um bilhão de almas na terra me soa aos ouvidos e comove o coração: esforço-me, pelo auxílio de Deus, para avaliar, ao menos em parte, as densas trevas, a extrema miséria e o indescritível desespero desses mil milhões de almas sem Cristo. Medita, irmão, sobre o amor do Mestre, amor profundo como o mar, contempla o horripilante espetáculo do desespero dos povos perdidos, até não poderes censurar, até não poderes descansar, até não poderes dormir.\" (Carlos Inwood). Esta obra contém as biografias de grandes servos de Jesus. Conheça a vida de pessoas verdadeiramente transformadas por Deus e que, por isso, servem-nos como exemplos de vida. Um estímulo para também buscarmos ser reconhecidos como verdadeiros Heróis da Fé. Um produto CPAD.', NULL, '', '', 0),
(3, 'Os Heróis da Fé De acordo com Hebreus 11', 'Domenico Barbera', '1507196539', NULL, 'SE assumimos a missão de escrever a respeito do décimo primeiro capítulo da carta aos Hebreus, não fizemos com o objetivo de fornecer ao leitor outro comentário, embora certas coisas vos escrevemos, além de não estar em comentários públicos, poderiam ser consideradas como tal, especialmente pelo conteúdo diferente que possui; mas apenas para enfatizar o valor da fé e sua eficácia, especialmente no exercício da vida cotidiana. Embora a respeito da fé, muitos livros foram escritos ao longo dos anos, acreditamos que é apropriado realizar uma pesquisa bastante completa sobre os homens e mulheres listados no capítulo 11 da Epístola aos Hebreus com o único propósito de descobrir os vários momentos e várias situações que caracterizaram a vida dessas pessoas. Sem dúvida, a maneira pela qual lidamos com este trabalho, embora nos envolveu muito, especialmente em termos do texto bíblico, acreditamos que vale a pena fazê-lo, pelo inevitável benefício que trará, a fim de compreender e avaliar os personagens tratados , especialmente no que diz respeito à sua fé.<br>', NULL, '', '', 0),
(4, 'Jesus', 'Charles Swindoll', '857325906X', NULL, 'Filho de Deus, o Salvador: o maior herói. Passados mais de 2.000 anos, a figura de Jesus continua em evidência. Se não bastassem os bilhões de seguidores enfileirados nos variados ramos do cristianismo que reconhecem sua santidade, pesquisadores nos diversos campos das ciências sociais continuam a discutir o verdadeiro papel de Jesus. Enquanto alguns exaltam sua liderança popular, há os que simplesmente o consideram uma farsa. Após desfilar alguns dos principais personagens da galeria de heróis bíblicos, Charles Swindoll encerra a série Heróis da fé com o ser mais importante da história. Distante de controvérsias, Swindoll ressalta a figura do Salvador da humanidade e sua história singular. Um carpinteiro, vindo das regiões mais desvalorizadas e esquecidas da Palestina, revela o amor de Deus e sua paixão pelos mais pobres, cidadãos de segunda classe alçados à condição de cidadãos do Reino de Deus. Acompanhe Charles Swindoll na inspiradora trajetória de Jesus de Nazaré e compreenda por que sua vida e seus ensinamentos são determinantes para quem deseja conhecer a Deus.', NULL, '', '', 1),
(5, 'One Piece - vol. 16', 'Eiichiro Oda', '6555121912', 'http://books.google.com/books/publisher/content?id=SmbjDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73cXT_lf7dG2iIRaU_pH5t99MxgZo8ES65IfvqtJsq5THhRl7pF8SHCtsYUzDSzQCrZ6Aln3HbnPnJtc9Kpbk0DvIYSM4xF7K53byZhx0gWDSbjv26PjOgMpYsRBcoTKwCIrx5h&source=gbs_api', 'No Reino de Drum, Luffy e Sanji enfrentam uma perigosa escalada ao Castelo de Drum para levar Nami a uma famosa médica e seu peculiar assistente. Mas Wapol, o antigo rei do local, pretende retomar o poder e passar por cima de quem estiver em seu caminho!', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 1),
(13, 'One Piece - vol. 8', 'Eiichiro Oda', '8542621301', 'http://books.google.com/books/publisher/content?id=sxCeDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE716ViXRVR9Qs5fmts_1VDrA-4qAhh3CGvSx5kpdIkzdNE_O3wwXD8g5CX7Izc2JgSMOwHi2GBJPBemmMoBLHLPuugyC2yaGypESMnLrcQ_hKFbfPhAlOC6s3RYOSIldEEA3Giac&source=gbs_api', 'O gás tóxico do MH5 tem como principal vítima Gin, único a sofrer todo o ataque sem uma máscara. Luffy parte para cima de Don Krieg com tudo, que volta a disparar dardos contra ele. Sem se importar, o garoto enfim se aproxima de Don Krieg, que usa um manto de espinhos para se proteger. Mesmo assim, Luffy não se importa e desfere um poderoso soco no oponente, atingindo os espinhos no processo. Zeff manda Sanji prestar atenção na luta de Luffy e perceber sua determinação.', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 1),
(15, 'One Piece - vol. 9', 'Eiichiro Oda', '854262131X', 'http://books.google.com/books/publisher/content?id=E_idDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71HECbk52anMmXB7aVWhUBOH1vceK0bhTHRDfefdFPMpQHWwbfJGVXB6RhKW5rZT_MlfL--5ubjm7uAiKHBeSkQhQ6sahgshhZGka1NoRaA3LMfKE1y_LGWsuUAkb2fcAQfNyBa&source=gbs_api', 'Luffy e sua tripulação devem enfrentar Arlong e seus piratas homens-peixe, especializados em usar táticas de intimidação para extorquir inocentes moradores da vila. E algo bombástico sobre o passado de Nami vem à tona!', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 1),
(16, 'Dom Casmurro', 'Machado de Assis, Edições Câmara', '8540205416', 'http://books.google.com/books/publisher/content?id=I-fUDAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71rqzsY-wOOgyBlXGUkuRKUzKphOCdnu2oLUsjXYg5QvLYUXrgPH8BSdmWKT6zRwLn5kP12krhI7LUm-2eAF_3SCvDCAH8Yxp12cs9m6Zc5A4gE0Hc62yRsfQJS-ITbl98hO5s6&source=gbs_api', '<p>Romance publicado pela primeira vez em 1899, <i>Dom Casmurro</i>, novo título da série Prazer de Ler da Edições Câmara, apresenta um olhar crítico sobre a sociedade brasileira do século XIX e  integra a trilogia realista de Machado de Assis ao lado de <i>Memórias Póstumas de Brás Cubas</i> e <i>Quincas Borba</i>.</p><p></p>', 'Fiction / Romance / General', '2016', 'Fiction / Romance / General', 1),
(17, 'Casa Velha', 'Machado de Assis', 'ISBN Desconhecido', 'http://books.google.com/books/publisher/content?id=OZNcAAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE7393dBULkj9JzlRVFATGhdA8jFV6moaC3y1Dys7t6yQgj3JbeXXoNjAYQZREW_xhLOvhF5g1LhwxE-iCWOx6vQq62UJ7WHJay00mcGjbsrHag586KDQ1w6slOIcuSa-XnezvOOd&source=gbs_api', NULL, 'Fiction / Romance / General', '2013', 'Fiction / Romance / General', 1),
(19, 'O Otelo brasileiro de Machado de Assis', 'Helen Caldwell', '8574800937', 'http://books.google.com/books/content?id=Q6kETzYptRMC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73coqBVKsPvi34o-B07drI77tYTxPNLR2egKVNUGTTm5MHvM2cwrh__dAWwrUJcy4khpK-XxCWm3T8FzAb8lrh-ALooAI-N09jkpAs7chNus4OiyZHWo8jSaRqia7-klhCsYOsG&source=gbs_api', 'Por muito tempo, prevaleceu nas leituras críticas de Dom Casmurro o tom malicioso sobre a personalidade de Capitu. Helena Caldwell analisa a obra-prima de Machado de Assis afastando-se dessas interpretações machistas e revelando o nexo que o escritor estabelece com Otelo, de Shakespeare. Publicado em 1960, este clássico dos estudos machadianos só foi traduzido para o português mais de quarenta anos depois, chegando agora ao leitor interessado num dos maiores artistas que o Brasil já teve.', 'Literary Criticism / Books & Reading', '2002', 'Literary Criticism / Books & Reading', 1);

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
(1, 'Fernando', 'franciolliProfessor@gmail.com', '991199922', '756d66730dc2220bfb275cc759311c91', '2025-04-24 09:04:24', NULL, 1, 0),
(2, 'Marques', 'marquesteste1@gmail.com', '12345678901', '61a5470a80e29d48f6a48a18a6e3d6ee', '2025-04-24 09:04:24', NULL, 1, 0),
(3, 'marcos', 'marcosm@gmail.com', '724.940.940-97', '$2y$10$VXto/X13XvtQjNMAAJIv3u3ewpxFJrrz4NJ8JTo4sH2T9yw/SlwZi', '2025-04-24 09:04:24', '2025-04-24 09:04:52', 1, 0),
(4, 'alefteste1', 'alefteste1@gmail.com', '723.166.090-82', '$2y$10$aFqWlbgNXdygZipCYGJfye/ecsiwrRO0qbcjZPvGv.8B.5P7uxghS', '2025-04-26 18:36:20', NULL, 1, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professores` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD CONSTRAINT `emprestimos_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emprestimos_ibfk_2` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
