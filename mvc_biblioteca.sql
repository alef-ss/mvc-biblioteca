-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/05/2025 às 16:34
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
(10, 'João Mendes', '3A', 'joao.mendes@gmail.com', 'e7d80ffeefa212b7c5c55700e4f7193e', NULL);

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
(18, 9, 15, '0000-00-00', '2025-05-27', '1', 4),
(19, 9, 13, '0000-00-00', '2025-05-27', '0', 4),
(20, 4, 13, '0000-00-00', '2025-05-27', '0', 4),
(21, 7, 5, '0000-00-00', '2025-05-27', '0', 4),
(22, 6, 19, '0000-00-00', '2025-05-27', '0', 4),
(23, 4, 19, '0000-00-00', '2025-06-03', '0', 4),
(24, 7, 19, '0000-00-00', '2025-06-03', '0', 4);

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
(3, 'Os Heróis da Fé De acordo com Hebreus 11', 'Domenico Barbera', '1507196539', NULL, 'SE assumimos a missão de escrever a respeito do décimo primeiro capítulo da carta aos Hebreus, não fizemos com o objetivo de fornecer ao leitor outro comentário, embora certas coisas vos escrevemos, além de não estar em comentários públicos, poderiam ser consideradas como tal, especialmente pelo conteúdo diferente que possui; mas apenas para enfatizar o valor da fé e sua eficácia, especialmente no exercício da vida cotidiana. Embora a respeito da fé, muitos livros foram escritos ao longo dos anos, acreditamos que é apropriado realizar uma pesquisa bastante completa sobre os homens e mulheres listados no capítulo 11 da Epístola aos Hebreus com o único propósito de descobrir os vários momentos e várias situações que caracterizaram a vida dessas pessoas. Sem dúvida, a maneira pela qual lidamos com este trabalho, embora nos envolveu muito, especialmente em termos do texto bíblico, acreditamos que vale a pena fazê-lo, pelo inevitável benefício que trará, a fim de compreender e avaliar os personagens tratados , especialmente no que diz respeito à sua fé.<br>', NULL, '', '', 0),
(4, 'Jesus', 'Charles Swindoll', '857325906X', NULL, 'Filho de Deus, o Salvador: o maior herói. Passados mais de 2.000 anos, a figura de Jesus continua em evidência. Se não bastassem os bilhões de seguidores enfileirados nos variados ramos do cristianismo que reconhecem sua santidade, pesquisadores nos diversos campos das ciências sociais continuam a discutir o verdadeiro papel de Jesus. Enquanto alguns exaltam sua liderança popular, há os que simplesmente o consideram uma farsa. Após desfilar alguns dos principais personagens da galeria de heróis bíblicos, Charles Swindoll encerra a série Heróis da fé com o ser mais importante da história. Distante de controvérsias, Swindoll ressalta a figura do Salvador da humanidade e sua história singular. Um carpinteiro, vindo das regiões mais desvalorizadas e esquecidas da Palestina, revela o amor de Deus e sua paixão pelos mais pobres, cidadãos de segunda classe alçados à condição de cidadãos do Reino de Deus. Acompanhe Charles Swindoll na inspiradora trajetória de Jesus de Nazaré e compreenda por que sua vida e seus ensinamentos são determinantes para quem deseja conhecer a Deus.', NULL, '', '', 0),
(5, 'One Piece - vol. 16', 'Eiichiro Oda', '6555121912', 'http://books.google.com/books/publisher/content?id=SmbjDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73cXT_lf7dG2iIRaU_pH5t99MxgZo8ES65IfvqtJsq5THhRl7pF8SHCtsYUzDSzQCrZ6Aln3HbnPnJtc9Kpbk0DvIYSM4xF7K53byZhx0gWDSbjv26PjOgMpYsRBcoTKwCIrx5h&source=gbs_api', 'No Reino de Drum, Luffy e Sanji enfrentam uma perigosa escalada ao Castelo de Drum para levar Nami a uma famosa médica e seu peculiar assistente. Mas Wapol, o antigo rei do local, pretende retomar o poder e passar por cima de quem estiver em seu caminho!', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 2),
(13, 'One Piece - vol. 8', 'Eiichiro Oda', '8542621301', 'http://books.google.com/books/publisher/content?id=sxCeDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE716ViXRVR9Qs5fmts_1VDrA-4qAhh3CGvSx5kpdIkzdNE_O3wwXD8g5CX7Izc2JgSMOwHi2GBJPBemmMoBLHLPuugyC2yaGypESMnLrcQ_hKFbfPhAlOC6s3RYOSIldEEA3Giac&source=gbs_api', 'O gás tóxico do MH5 tem como principal vítima Gin, único a sofrer todo o ataque sem uma máscara. Luffy parte para cima de Don Krieg com tudo, que volta a disparar dardos contra ele. Sem se importar, o garoto enfim se aproxima de Don Krieg, que usa um manto de espinhos para se proteger. Mesmo assim, Luffy não se importa e desfere um poderoso soco no oponente, atingindo os espinhos no processo. Zeff manda Sanji prestar atenção na luta de Luffy e perceber sua determinação.', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 2),
(15, 'One Piece - vol. 9', 'Eiichiro Oda', '854262131X', 'http://books.google.com/books/publisher/content?id=E_idDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71HECbk52anMmXB7aVWhUBOH1vceK0bhTHRDfefdFPMpQHWwbfJGVXB6RhKW5rZT_MlfL--5ubjm7uAiKHBeSkQhQ6sahgshhZGka1NoRaA3LMfKE1y_LGWsuUAkb2fcAQfNyBa&source=gbs_api', 'Luffy e sua tripulação devem enfrentar Arlong e seus piratas homens-peixe, especializados em usar táticas de intimidação para extorquir inocentes moradores da vila. E algo bombástico sobre o passado de Nami vem à tona!', 'Comics & Graphic Novels / Manga / General', '2019', 'Comics & Graphic Novels / Manga / General', 3),
(16, 'Dom Casmurro', 'Machado de Assis, Edições Câmara', '8540205416', 'http://books.google.com/books/publisher/content?id=I-fUDAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71rqzsY-wOOgyBlXGUkuRKUzKphOCdnu2oLUsjXYg5QvLYUXrgPH8BSdmWKT6zRwLn5kP12krhI7LUm-2eAF_3SCvDCAH8Yxp12cs9m6Zc5A4gE0Hc62yRsfQJS-ITbl98hO5s6&source=gbs_api', '<p>Romance publicado pela primeira vez em 1899, <i>Dom Casmurro</i>, novo título da série Prazer de Ler da Edições Câmara, apresenta um olhar crítico sobre a sociedade brasileira do século XIX e  integra a trilogia realista de Machado de Assis ao lado de <i>Memórias Póstumas de Brás Cubas</i> e <i>Quincas Borba</i>.</p><p></p>', 'Fiction / Romance / General', '2016', 'Fiction / Romance / General', 10),
(19, 'O Otelo brasileiro de Machado de Assis', 'Helen Caldwell', '8574800937', 'http://books.google.com/books/content?id=Q6kETzYptRMC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73coqBVKsPvi34o-B07drI77tYTxPNLR2egKVNUGTTm5MHvM2cwrh__dAWwrUJcy4khpK-XxCWm3T8FzAb8lrh-ALooAI-N09jkpAs7chNus4OiyZHWo8jSaRqia7-klhCsYOsG&source=gbs_api', 'Por muito tempo, prevaleceu nas leituras críticas de Dom Casmurro o tom malicioso sobre a personalidade de Capitu. Helena Caldwell analisa a obra-prima de Machado de Assis afastando-se dessas interpretações machistas e revelando o nexo que o escritor estabelece com Otelo, de Shakespeare. Publicado em 1960, este clássico dos estudos machadianos só foi traduzido para o português mais de quarenta anos depois, chegando agora ao leitor interessado num dos maiores artistas que o Brasil já teve.', 'Literary Criticism / Books & Reading', '2002', 'Literary Criticism / Books & Reading', 4),
(26, 'Dom Casmurro', 'Machado de Assis', '1452892369', 'sem_capa.png', 'Dom Casmurro é o romance mais famoso de Machado de Assis, o mestre da literatura brasileira no século XIX. Este livro é uma versão completa desse romance fantástico, que conta as desventuras de Bentinho e Capitu.//Dom Casmurro is the most well known novel by Machado de Assis, the master of Brazilian literature in the 19th century. This is the complete Portuguese text of the fantastic novel, telling the misadventures of Bentinho and Capitu.', 'Fiction / Classics', '2010', 'Fiction / Classics', 6);

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
(4, 'alefteste1', 'alefteste1@gmail.com', '72316609082', '$2y$10$oRFIkdbW5Nsjvb4RxW5Niu8d9tkPXtTvTngc7viEf.V8KSrb7sX/.', '2025-04-26 18:36:20', '2025-05-27 11:18:28', 1, 0),
(5, 'Alef Admin', 'alefsouzasobrinho51@gmail.com', '70319891089', '$2a$10$LbMCM.FD51ejQ79mBy8aV.RII9ZSxWiU25IeKL2ZWe6lGoFdWDCpq', '2025-05-26 07:43:41', '2025-05-27 10:19:44', 1, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `backup_log`
--
ALTER TABLE `backup_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
