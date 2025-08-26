-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: mvc_biblioteca
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_settings`
--

DROP TABLE IF EXISTS `admin_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secret_code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_settings`
--

LOCK TABLES `admin_settings` WRITE;
/*!40000 ALTER TABLE `admin_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alunos`
--

DROP TABLE IF EXISTS `alunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alunos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `professor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  KEY `professor_id` (`professor_id`),
  CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alunos`
--

LOCK TABLES `alunos` WRITE;
/*!40000 ALTER TABLE `alunos` DISABLE KEYS */;
INSERT INTO `alunos` VALUES (1,'Ana Silva','3A','ana.silva@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(2,'marcos','3a','marcosaluno@gmail.com','33a55ce3bd6606437c71a69a15cee2c6',NULL),(3,'Carla Ferreira','1C','carla.ferreira@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(4,'Daniel Lima','3A','daniel.lima@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(5,'Eduarda Costa','2B','eduarda.costa@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(6,'Felipe Martins','1C','felipe.martins@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(7,'Gabriela Rocha','3A','gabriela.rocha@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(8,'Hugo Almeida','2B','hugo.almeida@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(9,'Isabela Ramos','1C','isabela.ramos@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(10,'João Mendes','3A','joao.mendes@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',NULL),(11,'João','6°A','alice@gmail.com','$2y$10$QJOZgpfBujBUvbt9Yt4OqOgOH7xUM6GvTVXKI75oS3Q4Z7BnCv.BK',NULL),(12,'João','2A','alefteste100@gmail.com','$2y$10$ICYHzsnt7JuRxIONbbZ58eMFjqd4RcPp69Ov/RDYJxs8VmMrZGj2.',NULL),(13,'João','2D','joao@gmail.com','$2y$10$Q9XOpB2o4V.n3MFKl/UWo.W/JtCDwl3bXJlqRF2H0g76RC5rB7Vp2',NULL),(14,'João','3D','teste@gmail.com','$2y$10$XgNu09Cv1Bi8IZA75BML0efR4/flnHG2UO6cmCfO0qszyK25gEoYW',NULL),(15,'alef','2A','fff@gmail.com','',NULL);
/*!40000 ALTER TABLE `alunos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_log`
--

DROP TABLE IF EXISTS `backup_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arquivo` varchar(255) NOT NULL,
  `data_backup` datetime NOT NULL,
  `tamanho` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `automatico` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `backup_log_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `professores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_log`
--

LOCK TABLES `backup_log` WRITE;
/*!40000 ALTER TABLE `backup_log` DISABLE KEYS */;
INSERT INTO `backup_log` VALUES (1,'backup_completo_2025-08-21_16-35-31.zip','2025-08-21 11:35:36',4403083,5,0),(2,'backup_2025-08-21_16-39-49.sql','2025-08-21 11:39:50',24589,5,0),(3,'backup_2025-08-21_16-40-38.sql','2025-08-21 11:40:38',24658,5,0),(4,'backup_2025-08-21_16-44-16.sql','2025-08-21 11:44:17',24727,5,0),(5,'backup_2025-08-21_16-44-30.sql','2025-08-21 11:44:31',24796,5,0),(6,'backup_2025-08-21_16-45-01.sql','2025-08-21 11:45:01',24865,5,0),(7,'backup_2025-08-21_16-46-02.sql','2025-08-21 11:46:02',24934,5,0);
/*!40000 ALTER TABLE `backup_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracoes`
--

DROP TABLE IF EXISTS `configuracoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dias_emprestimo` int(11) NOT NULL DEFAULT 7,
  `max_livros_aluno` int(11) NOT NULL DEFAULT 3,
  `max_renovacoes` int(11) NOT NULL DEFAULT 2,
  `multa_dia_atraso` decimal(10,2) NOT NULL DEFAULT 0.50,
  `backup_automatico` tinyint(1) NOT NULL DEFAULT 1,
  `email_notificacao` varchar(255) NOT NULL,
  `tema_padrao` enum('light','dark') NOT NULL DEFAULT 'light',
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracoes`
--

LOCK TABLES `configuracoes` WRITE;
/*!40000 ALTER TABLE `configuracoes` DISABLE KEYS */;
INSERT INTO `configuracoes` VALUES (1,7,10,5,0.00,1,'alefsouzasobrinho51@gmail.com','light','2025-05-27 13:55:13');
/*!40000 ALTER TABLE `configuracoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emprestimos`
--

DROP TABLE IF EXISTS `emprestimos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emprestimos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_id` int(11) DEFAULT NULL,
  `livro_id` int(11) DEFAULT NULL,
  `data_emprestimo` date NOT NULL,
  `data_devolucao` date DEFAULT NULL,
  `devolvido` varchar(50) NOT NULL,
  `professor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aluno_id` (`aluno_id`),
  KEY `livro_id` (`livro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emprestimos`
--

LOCK TABLES `emprestimos` WRITE;
/*!40000 ALTER TABLE `emprestimos` DISABLE KEYS */;
INSERT INTO `emprestimos` VALUES (15,3,16,'0000-00-00','2025-05-27','Sim',4),(16,1,16,'0000-00-00','2025-05-27','Nao',4),(17,8,15,'0000-00-00','2025-05-27','Sim',4),(18,9,15,'0000-00-00','2025-08-21','Sim',4),(19,9,13,'0000-00-00','2025-08-21','Sim',4),(20,4,13,'0000-00-00','2025-08-21','Sim',4),(21,7,5,'0000-00-00','2025-08-21','Sim',4),(22,6,19,'0000-00-00','2025-05-27','0',4),(23,4,19,'0000-00-00','2025-06-03','0',4),(24,7,19,'0000-00-00','2025-06-03','0',4),(25,8,28,'2025-06-25','2025-07-02','0',4),(26,1,26,'2025-06-25','2025-07-02','0',4),(27,1,26,'2025-06-25','2025-07-02','0',4),(28,7,5,'2025-06-25','2025-08-21','Sim',4),(29,9,31,'2025-08-21','2025-08-21','Sim',4),(30,1,27,'2025-08-21','2025-08-21','Sim',4);
/*!40000 ALTER TABLE `emprestimos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livros`
--

DROP TABLE IF EXISTS `livros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `capa_url` varchar(700) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `ano_publicacao` varchar(4) NOT NULL,
  `genero` varchar(100) NOT NULL,
  `quantidade` int(100) NOT NULL,
  `preview_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livros`
--

LOCK TABLES `livros` WRITE;
/*!40000 ALTER TABLE `livros` DISABLE KEYS */;
INSERT INTO `livros` VALUES (3,'Os Heróis da Fé De acordo com Hebreus 11','Domenico Barbera','1507196539',NULL,'SE assumimos a missão de escrever a respeito do décimo primeiro capítulo da carta aos Hebreus, não fizemos com o objetivo de fornecer ao leitor outro comentário, embora certas coisas vos escrevemos, além de não estar em comentários públicos, poderiam ser consideradas como tal, especialmente pelo conteúdo diferente que possui; mas apenas para enfatizar o valor da fé e sua eficácia, especialmente no exercício da vida cotidiana. Embora a respeito da fé, muitos livros foram escritos ao longo dos anos, acreditamos que é apropriado realizar uma pesquisa bastante completa sobre os homens e mulheres listados no capítulo 11 da Epístola aos Hebreus com o único propósito de descobrir os vários momentos e várias situações que caracterizaram a vida dessas pessoas. Sem dúvida, a maneira pela qual lidamos com este trabalho, embora nos envolveu muito, especialmente em termos do texto bíblico, acreditamos que vale a pena fazê-lo, pelo inevitável benefício que trará, a fim de compreender e avaliar os personagens tratados , especialmente no que diz respeito à sua fé.<br>',NULL,'','',0,NULL),(4,'Jesus','Charles Swindoll','857325906X',NULL,'Filho de Deus, o Salvador: o maior herói. Passados mais de 2.000 anos, a figura de Jesus continua em evidência. Se não bastassem os bilhões de seguidores enfileirados nos variados ramos do cristianismo que reconhecem sua santidade, pesquisadores nos diversos campos das ciências sociais continuam a discutir o verdadeiro papel de Jesus. Enquanto alguns exaltam sua liderança popular, há os que simplesmente o consideram uma farsa. Após desfilar alguns dos principais personagens da galeria de heróis bíblicos, Charles Swindoll encerra a série Heróis da fé com o ser mais importante da história. Distante de controvérsias, Swindoll ressalta a figura do Salvador da humanidade e sua história singular. Um carpinteiro, vindo das regiões mais desvalorizadas e esquecidas da Palestina, revela o amor de Deus e sua paixão pelos mais pobres, cidadãos de segunda classe alçados à condição de cidadãos do Reino de Deus. Acompanhe Charles Swindoll na inspiradora trajetória de Jesus de Nazaré e compreenda por que sua vida e seus ensinamentos são determinantes para quem deseja conhecer a Deus.',NULL,'','',0,NULL),(5,'One Piece - vol. 16','Eiichiro Oda','6555121912','http://books.google.com/books/publisher/content?id=SmbjDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73cXT_lf7dG2iIRaU_pH5t99MxgZo8ES65IfvqtJsq5THhRl7pF8SHCtsYUzDSzQCrZ6Aln3HbnPnJtc9Kpbk0DvIYSM4xF7K53byZhx0gWDSbjv26PjOgMpYsRBcoTKwCIrx5h&source=gbs_api','No Reino de Drum, Luffy e Sanji enfrentam uma perigosa escalada ao Castelo de Drum para levar Nami a uma famosa médica e seu peculiar assistente. Mas Wapol, o antigo rei do local, pretende retomar o poder e passar por cima de quem estiver em seu caminho!','Comics & Graphic Novels / Manga / General','2019','Comics & Graphic Novels / Manga / General',3,NULL),(13,'One Piece - vol. 8','Eiichiro Oda','8542621301','http://books.google.com/books/publisher/content?id=sxCeDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE716ViXRVR9Qs5fmts_1VDrA-4qAhh3CGvSx5kpdIkzdNE_O3wwXD8g5CX7Izc2JgSMOwHi2GBJPBemmMoBLHLPuugyC2yaGypESMnLrcQ_hKFbfPhAlOC6s3RYOSIldEEA3Giac&source=gbs_api','O gás tóxico do MH5 tem como principal vítima Gin, único a sofrer todo o ataque sem uma máscara. Luffy parte para cima de Don Krieg com tudo, que volta a disparar dardos contra ele. Sem se importar, o garoto enfim se aproxima de Don Krieg, que usa um manto de espinhos para se proteger. Mesmo assim, Luffy não se importa e desfere um poderoso soco no oponente, atingindo os espinhos no processo. Zeff manda Sanji prestar atenção na luta de Luffy e perceber sua determinação.','Comics & Graphic Novels / Manga / General','2019','Comics & Graphic Novels / Manga / General',4,NULL),(15,'One Piece - vol. 9','Eiichiro Oda','854262131X','http://books.google.com/books/publisher/content?id=E_idDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71HECbk52anMmXB7aVWhUBOH1vceK0bhTHRDfefdFPMpQHWwbfJGVXB6RhKW5rZT_MlfL--5ubjm7uAiKHBeSkQhQ6sahgshhZGka1NoRaA3LMfKE1y_LGWsuUAkb2fcAQfNyBa&source=gbs_api','Luffy e sua tripulação devem enfrentar Arlong e seus piratas homens-peixe, especializados em usar táticas de intimidação para extorquir inocentes moradores da vila. E algo bombástico sobre o passado de Nami vem à tona!','Comics & Graphic Novels / Manga / General','2019','Comics & Graphic Novels / Manga / General',4,NULL),(16,'Dom Casmurro','Machado de Assis, Edições Câmara','8540205416','http://books.google.com/books/publisher/content?id=I-fUDAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71rqzsY-wOOgyBlXGUkuRKUzKphOCdnu2oLUsjXYg5QvLYUXrgPH8BSdmWKT6zRwLn5kP12krhI7LUm-2eAF_3SCvDCAH8Yxp12cs9m6Zc5A4gE0Hc62yRsfQJS-ITbl98hO5s6&source=gbs_api','<p>Romance publicado pela primeira vez em 1899, <i>Dom Casmurro</i>, novo título da série Prazer de Ler da Edições Câmara, apresenta um olhar crítico sobre a sociedade brasileira do século XIX e  integra a trilogia realista de Machado de Assis ao lado de <i>Memórias Póstumas de Brás Cubas</i> e <i>Quincas Borba</i>.</p><p></p>','Fiction / Romance / General','2016','Fiction / Romance / General',10,NULL),(19,'O Otelo brasileiro de Machado de Assis','Helen Caldwell','8574800937','http://books.google.com/books/content?id=Q6kETzYptRMC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73coqBVKsPvi34o-B07drI77tYTxPNLR2egKVNUGTTm5MHvM2cwrh__dAWwrUJcy4khpK-XxCWm3T8FzAb8lrh-ALooAI-N09jkpAs7chNus4OiyZHWo8jSaRqia7-klhCsYOsG&source=gbs_api','Por muito tempo, prevaleceu nas leituras críticas de Dom Casmurro o tom malicioso sobre a personalidade de Capitu. Helena Caldwell analisa a obra-prima de Machado de Assis afastando-se dessas interpretações machistas e revelando o nexo que o escritor estabelece com Otelo, de Shakespeare. Publicado em 1960, este clássico dos estudos machadianos só foi traduzido para o português mais de quarenta anos depois, chegando agora ao leitor interessado num dos maiores artistas que o Brasil já teve.','Literary Criticism / Books & Reading','2002','Literary Criticism / Books & Reading',4,NULL),(27,'Diário de um Banana 3','Jeff Kinney','8576835207','http://books.google.com/books/publisher/content?id=L7kqAgAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71EiR3LrMjRZfOu9Fg13FGkmVSQZ9lpcBlbujhcy75UCC9ld_XZ-XAb_R6YY9KcFT-x0lYl4lMo65L3zbNfZjCOO6eNa2lCPbxTYn2f2sldaswt39hJOWry-tiQZgylvlpyocei&source=gbs_api','Greg não toma jeito mesmo. E a cada dia se envolve em mais confusão. O difícil é fazer seu pai engolir esse talento de Greg para se meter em situações embaraçosas. Ele já está por aqui com o garoto. E para botar algum juízo na cabeça dele, Frank Heffley tenta de tudo um pouco. É claro que Greg sempre encontra uma maneira de estragar tudo. Até que seu pai faz uma grande ameaça e as coisas mudam de figura. Qual será a gota d\'água que vai fazer a paciência de Frank transbordar de vez? Destaque: Não é fácil ser criança. E ninguém sabe disso melhor do que Greg Heffley, que se vê mergulhado no mundo do ensino fundamental, onde fracotes são obrigados a dividir os corredores com garotos mais altos, mais malvados e que já se barbeiam. Com uma linguagem universal e própria dos pré-adolescentes, essa coleção já vendeu mais de 40 milhões de exemplares em todo o mundo. É uma das séries infantis de maior sucesso de todos os tempos.','Juvenile Fiction / Family / General','2013','Juvenile Fiction / Family / General',1,'http://books.google.com.br/books?id=L7kqAgAAQBAJ&hl=&source=gbs_api'),(28,'O Diário de um Banana 1','Jeff Kinney','9896237336','http://books.google.com/books/publisher/content?id=t_6VEAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE710QCmk_6uQfMnzlacT4i6SXbkGgUpTvXHJpzlfQN5feiDb5uiWW0AJW9MMJ8t49R57Xn9POKPNILBkyODf86227wTu0M3xNFtN6Smg3sQgRMW_dU89rCbPtarsz2g2thAABDYz&source=gbs_api','<p>Como o Greg diz no seu diário: Não esperem que eu me ponha para aqui com \"Querido Diário\" isto e \"Querido Diário\" aquilo. Felizmente para nós, o que o Greg diz e o que realmente faz são duas coisas muito diferentes.</p> <p>«Não é fácil ser criança. E ninguém sabe isso melhor do que o Greg Heffley, que se vê aprisionado na escola preparatória, onde fracotes minorcas pidem os corredores com miúdos mais altos e malvados que já fazem a barba. Em <b> <i>O Diário de um Banana</i> </b>, o autor e ilustrador Jeff Kinney apresenta-nos um herói improvável.</p> <p>Como o Greg diz no seu diário: Não esperem que eu me ponha para aqui com \"Querido Diário\" isto e \"Querido Diário\" aquilo. Felizmente para nós, o que o Greg diz e o que realmente faz são duas coisas muito diferentes.»</p> <p>«O mundo está louco pela coleção O Diário de um Banana e pelo Jeff Kinney!» <b>The Sun</b> </p> <p>«Jeff Kinney está no topo, juntamente com J. K. Rowling, dos autores infantojuvenis mais bem-sucedidos do mundo.» <b>The Independent</b> </p>','Juvenile Fiction / Comics & Graphic Novels / Humorous','2022','Juvenile Fiction / Comics & Graphic Novels / Humorous',0,'http://books.google.com.br/books?id=t_6VEAAAQBAJ&hl=&source=gbs_api'),(30,'Vidas Secas - Edição especial','Graciliano Ramos','6585279042','http://books.google.com/books/publisher/content?id=_j79EAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73JMRfMVhXcDBt4NvWKlNkc3lWEhjZtltQWgsLeCH6YGK547LiTUcrN_jrZB9cN3asVFOMIUcppkRsDSvaF0UdDewog-eEhjSPmxQLkI-zvtTioX1voJ-BEMqc4gGkECQ9hG0Ds&source=gbs_api','<p> <b>Descubra \"Vidas Secas\" em uma Edição Especial pela Editora Tabuleta V</b> </p> <p>Descubra \"Vidas Secas\", de Graciliano Ramos, numa edição revitalizada pela editora Tabuleta V, e mergulhe na saga emocionante de uma família de retirantes em sua luta incansável pela sobrevivência no sertão nordestino. Esta edição não só reacende a chama de uma das obras mais significativas da literatura brasileira, mas também a enriquece com conteúdos exclusivos que prometem intensificar sua experiência de leitura.</p> <p>Inicie sua jornada com uma carta íntima ao leitor, preparando o cenário para a profunda narrativa que se segue. Antes mesmo de virar a primeira página, familiarize-se com Fabiano, Sinhá Vitória, seus filhos e a inesquecível cadela Baleia através de perfis detalhados, construindo uma conexão íntima que perdurará por toda a história.</p> <p>Navegue pela essência de \"Vidas Secas\" com uma análise meticulosa que revela o rico contexto histórico e social do Nordeste brasileiro das décadas de 1920 e 1930, trazendo à tona a realidade árida e desafiadora do sertão, assim como as lutas sociais e políticas de uma época. Esta seção destila a magia da prosa de Ramos, destacando sua habilidade em retratar a dignidade humana frente às adversidades, oferecendo uma visão aprofundada que transcende o ato de leitura.</p> <p>Aprofunde-se na vida e legado de Graciliano Ramos com uma seção dedicada a um dos pilares do modernismo literário brasileiro, capturando a essência de sua obra e o impacto duradouro em nossa cultura.</p> <p>Para estudantes e aficionados por literatura, a edição traz uma análise aprofundada de temas, símbolos e estrutura de \"Vidas Secas\", complementada por questões de vestibular que enriquecem o entendimento e a apreciação do texto.</p> <p>Além disso, a Tabuleta V se orgulha em apresentar esta obra-prima na fonte Open Dyslexic Alt, tornando-a acessível a leitores com dislexia e reafirmando o compromisso com a democratização da cultura e educação.</p> <p> <i> <b>\"Vidas Secas\" não é apenas uma leitura obrigatória, mas uma experiência imersiva que ressoa com questões de humanidade, resistência e esperança. Garanta sua cópia hoje e seja parte da jornada inesquecível de uma família pelo coração do Brasil.</b> </i> </p>','Fiction / Literary','2024','Fiction / Literary',1,'http://books.google.com.br/books?id=_j79EAAAQBAJ&hl=&source=gbs_api'),(31,'One Piece, Vol. 107','Eiichiro Oda','1974749797','http://books.google.com/books/content?id=JYSO0AEACAAJ&printsec=frontcover&img=1&zoom=1&imgtk=AFLRE71PJTsA1XZ1OrqOl4N7NRrUULz8JpmejXgyrTXc20RwLKsC1dFvHeTC9hAtlBoMw4-6IKvaVxyjkbomPXkPMpcA88dxPYINWf7RupeOA0614kQw4Uayr7tW83nz2CHFQWBRg9-x&source=gbs_api','<b>Join Monkey D. Luffy and his swashbuckling crew in their search for the ultimate treasure, One Piece!</b><br><br>As a child, Monkey D. Luffy dreamed of becoming King of the Pirates. But his life changed when he accidentally gained the power to stretch like rubber...at the cost of never being able to swim again! Years later, Luffy sets off in search of the One Piece, said to be the greatest treasure in the world...<br><br>Having learned too much of the world’s history, Dr. Vegapunk is now the target of the CP0 assassins. Vegapunk’s only hope may be to ask for help from Luffy and the Straw Hat crew, but where are they? Chaos erupts on Egghead Island as the world government sends some powerful reinforcements.','Comics & Graphic Novels / Manga / General','2024','Comics & Graphic Novels / Manga / General',1,'http://books.google.com.br/books?id=JYSO0AEACAAJ&hl=&source=gbs_api');
/*!40000 ALTER TABLE `livros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professores`
--

DROP TABLE IF EXISTS `professores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `professores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `ultimo_login` datetime DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professores`
--

LOCK TABLES `professores` WRITE;
/*!40000 ALTER TABLE `professores` DISABLE KEYS */;
INSERT INTO `professores` VALUES (4,'alefteste1','alefteste1@gmail.com','72316609082','$2y$10$YuNDRe6vCVqyjfo/6soKHOyNUI2f2U2RYtJAj6kcAkdvF4H5zHxCG','2025-04-26 18:36:20','2025-08-21 11:15:08',1,0),(5,'Alef Admin','alefsouzasobrinho51@gmail.com','70319891089','$2a$10$LbMCM.FD51ejQ79mBy8aV.RII9ZSxWiU25IeKL2ZWe6lGoFdWDCpq','2025-05-26 07:43:41','2025-08-21 11:35:25',1,1),(6,'Fernando Franciolli','ffranciolliprofessor@gmail.com','63070137024','25d55ad283aa400af464c76d713c07ad','2025-06-27 08:10:44',NULL,1,0),(7,'Fernando2','fernando@gmail.com','06042303031','25d55ad283aa400af464c76d713c07ad','2025-06-27 08:25:00',NULL,1,0),(8,'Alice','alice@gmail.com','12345678901','$2y$10$FAvpmuOZr1VYPyFR7tIiP.rU1ka2.v9V3renliB5kjxX/xqagt5Lu','2025-06-27 08:47:41',NULL,1,0);
/*!40000 ALTER TABLE `professores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-21 11:49:27
