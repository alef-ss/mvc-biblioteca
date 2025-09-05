#!/usr/bin/env php
<?php
/**
 * db_sync.php
 *
 * Sincroniza um dump .sql com um banco local do MySQL (XAMPP),
 * SEM deletar nada: só cria tabelas/colunas novas e insere linhas novas (quando houver PK).
 *
 * Uso:
 *   php db_sync.php --sql="dump.sql" --db="mvc_biblioteca" --host="127.0.0.1" --user="root" --pass=""
 *
 * Requisitos:
 *   - Rodar via PHP CLI do XAMPP (C:\xampp\php\php.exe)
 *   - O .sql deve ser um export padrão (phpMyAdmin funciona).
 */

ini_set('display_errors', 'stderr');
error_reporting(E_ALL);

function arg(string $name, $default = null)
{
  foreach ($GLOBALS['argv'] as $a) {
    if (strpos($a, "--$name=") === 0) {
      return substr($a, strlen($name) + 3);
    }
  }
  return $default;
}

$cfg = [
  'sql'  => arg('sql'),
  'db'   => arg('db'),
  'host' => arg('host', '127.0.0.1'),
  'user' => arg('user', 'root'),
  'pass' => arg('pass', ''),
  'port' => (int)arg('port', 3306),
];

function fail($msg, $code = 1)
{
  fwrite(STDERR, "[ERRO] $msg\n");
  exit($code);
}
function info($msg)
{
  fwrite(STDOUT, "[INFO] $msg\n");
}
function ok($msg)
{
  fwrite(STDOUT, "[OK] $msg\n");
}
function warn($msg)
{
  fwrite(STDOUT, "[AVISO] $msg\n");
}

if (!$cfg['sql'] || !$cfg['db']) {
  fail("Parâmetros obrigatórios: --sql=arquivo.sql --db=nome_do_banco [--host --user --pass --port]");
}
if (!is_file($cfg['sql'])) {
  fail("Arquivo SQL não encontrado: {$cfg['sql']}");
}

$mysqli = @new mysqli($cfg['host'], $cfg['user'], $cfg['pass'], null, $cfg['port']);
if ($mysqli->connect_error) {
  fail("Não conectou ao MySQL: {$mysqli->connect_error}");
}
$mysqli->set_charset("utf8mb4");

/** UTILIDADES **/

function dbExists(mysqli $m, string $db): bool
{
  $stmt = $m->prepare("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME=?");
  $stmt->bind_param("s", $db);
  $stmt->execute();
  $stmt->bind_result($name);
  $exists = $stmt->fetch();
  $stmt->close();
  return (bool)$exists;
}

function execAll(mysqli $m, string $sql): bool
{
  if (!$m->multi_query($sql)) {
    throw new RuntimeException("Falha no multi_query: " . $m->error);
  }
  do {
    if ($res = $m->store_result()) {
      $res->free();
    }
  } while ($m->more_results() && $m->next_result());
  if ($m->errno) {
    throw new RuntimeException("Erro após multi_query: " . $m->error);
  }
  return true;
}

function runSqlFile(mysqli $m, string $path): void
{
  $sql = file_get_contents($path);
  if ($sql === false) throw new RuntimeException("Não consegui ler o arquivo SQL.");
  execAll($m, $sql);
}

function listTables(mysqli $m, string $db): array
{
  $stmt = $m->prepare("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA=?");
  $stmt->bind_param("s", $db);
  $stmt->execute();
  $res = $stmt->get_result();
  $out = [];
  while ($row = $res->fetch_assoc()) $out[] = $row['TABLE_NAME'];
  $stmt->close();
  return $out;
}

function showCreateTable(mysqli $m, string $db, string $table): string
{
  $res = $m->query("SHOW CREATE TABLE `" . $m->real_escape_string($db) . "`.`" . $m->real_escape_string($table) . "`");
  if (!$res) throw new RuntimeException("SHOW CREATE TABLE falhou: " . $m->error);
  $row = $res->fetch_array(MYSQLI_NUM);
  $res->free();
  return $row[1] ?? '';
}

function listColumns(mysqli $m, string $db, string $table): array
{
  $stmt = $m->prepare("
        SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT, EXTRA, COLUMN_KEY
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA=? AND TABLE_NAME=?
        ORDER BY ORDINAL_POSITION
    ");
  $stmt->bind_param("ss", $db, $table);
  $stmt->execute();
  $res = $stmt->get_result();
  $cols = [];
  while ($r = $res->fetch_assoc()) $cols[$r['COLUMN_NAME']] = $r;
  $stmt->close();
  return $cols;
}

function primaryKeyColumns(mysqli $m, string $db, string $table): array
{
  $stmt = $m->prepare("
        SELECT k.COLUMN_NAME
        FROM information_schema.TABLE_CONSTRAINTS t
        JOIN information_schema.KEY_COLUMN_USAGE k
          ON k.CONSTRAINT_NAME = t.CONSTRAINT_NAME
         AND k.TABLE_SCHEMA = t.TABLE_SCHEMA
         AND k.TABLE_NAME = t.TABLE_NAME
        WHERE t.TABLE_SCHEMA=? AND t.TABLE_NAME=? AND t.CONSTRAINT_TYPE='PRIMARY KEY'
        ORDER BY k.ORDINAL_POSITION
    ");
  $stmt->bind_param("ss", $db, $table);
  $stmt->execute();
  $res = $stmt->get_result();
  $out = [];
  while ($r = $res->fetch_assoc()) $out[] = $r['COLUMN_NAME'];
  $stmt->close();
  return $out;
}

function buildAddColumnSQL(array $col): string
{
  // Constrói definição aproximada da coluna baseada no information_schema
  $name = "`{$col['COLUMN_NAME']}`";
  $type = $col['COLUMN_TYPE'];
  $null = ($col['IS_NULLABLE'] === 'YES') ? "NULL" : "NOT NULL";
  $default = "";
  if (!is_null($col['COLUMN_DEFAULT'])) {
    // Trata CURRENT_TIMESTAMP e valores literais
    $def = $col['COLUMN_DEFAULT'];
    $default = " DEFAULT " . (preg_match('/CURRENT_TIMESTAMP/i', $def) ? $def : "'" . $def . "'");
  }
  $extra = $col['EXTRA'] ? " " . $col['EXTRA'] : "";
  return "ADD COLUMN $name $type $null$default$extra";
}

/** INÍCIO **/

info("Conectado a {$cfg['host']}:{$cfg['port']} como {$cfg['user']}.");

if (!dbExists($mysqli, $cfg['db'])) {
  info("Banco '{$cfg['db']}' não existe. Criando...");
  if (!$mysqli->query("CREATE DATABASE `{$cfg['db']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
    fail("Não foi possível criar o banco: " . $mysqli->error);
  }
  ok("Banco criado.");
  info("Importando dump para '{$cfg['db']}'...");
  if (!$mysqli->select_db($cfg['db'])) {
    fail("Falhou ao selecionar o banco após criar: " . $mysqli->error);
  }
  try {
    runSqlFile($mysqli, $cfg['sql']);
    ok("Importação concluída.");
    exit(0);
  } catch (Throwable $e) {
    fail("Erro importando o arquivo SQL: " . $e->getMessage(), 2);
  }
}

// Banco existe → sincronização incremental
ok("Banco '{$cfg['db']}' existe. Iniciando comparação com dump.");
$tmpDb = $cfg['db'] . "_tmp_sync_" . date('Ymd_His');

try {
  // Cria DB temporário e importa o dump
  info("Criando banco temporário '{$tmpDb}'...");
  execAll($mysqli, "CREATE DATABASE `{$tmpDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
  ok("Temporário criado.");

  info("Importando dump para '{$tmpDb}'...");
  $mysqli->select_db($tmpDb);
  runSqlFile($mysqli, $cfg['sql']);
  ok("Dump importado no temporário.");

  // Comparar
  $mysqli->select_db($cfg['db']);
  $tablesReal = listTables($mysqli, $cfg['db']);
  $tablesTmp  = listTables($mysqli, $tmpDb);

  $setReal = array_flip($tablesReal);
  $setTmp  = array_flip($tablesTmp);

  // 1) Tabelas novas
  foreach ($tablesTmp as $t) {
    if (!isset($setReal[$t])) {
      info("Tabela nova encontrada: {$t}. Criando no banco real e copiando dados...");
      $create = showCreateTable($mysqli, $tmpDb, $t);
      // Reescreve o CREATE para apontar para o banco real
      $createReal = preg_replace('/CREATE TABLE `' . preg_quote($t, '/') . '`/i', 'CREATE TABLE `' . $cfg['db'] . '`.`' . $t . '`', $create, 1);
      execAll($mysqli, $createReal);
      // Copia dados
      execAll($mysqli, "INSERT INTO `{$cfg['db']}`.`{$t}` SELECT * FROM `{$tmpDb}`.`{$t}`;");
      ok("Tabela '{$t}' criada e dados copiados.");
    }
  }

  // 2) Colunas novas e 3) Dados novos
  foreach ($tablesTmp as $t) {
    if (!isset($setReal[$t])) continue; // já tratamos tabelas novas

    info("Verificando tabela existente: {$t}");
    $colsReal = listColumns($mysqli, $cfg['db'], $t);
    $colsTmp  = listColumns($mysqli, $tmpDb,  $t);

    // 2) Colunas novas
    $adds = [];
    foreach ($colsTmp as $cname => $cdef) {
      if (!isset($colsReal[$cname])) {
        $adds[] = buildAddColumnSQL($cdef);
      }
    }
    if ($adds) {
      $sqlAlter = "ALTER TABLE `{$cfg['db']}`.`{$t}` " . implode(", ", $adds) . ";";
      info("Adicionando " . count($adds) . " coluna(s) nova(s) em {$t}...");
      execAll($mysqli, $sqlAlter);
      ok("Colunas adicionadas em {$t}.");
    } else {
      info("Sem novas colunas em {$t}.");
    }

    // 3) Dados novos — só se houver PK para evitar duplicatas
    $pk = primaryKeyColumns($mysqli, $cfg['db'], $t);
    if (!$pk) {
      warn("Tabela '{$t}' não tem chave primária; pulando merge de dados para evitar duplicações.");
      continue;
    }

    // Campos em comum (garante compatibilidade)
    $commonCols = array_values(array_intersect(array_keys($colsTmp), array_keys($colsReal)));
    if (!$commonCols) {
      warn("Sem colunas em comum em '{$t}'; pulando merge de dados.");
      continue;
    }
    // Lista para INSERT (sem alias)
    $colsListInsert = "`" . implode("`,`", $commonCols) . "`";

    // Lista para SELECT (com alias t)
    $colsListSelect = implode(", ", array_map(fn($c) => "t.`$c`", $commonCols));

    // Filtro NOT EXISTS por PK
    $pkConds = [];
    foreach ($pk as $k) {
      $kq = "`{$k}`";
      $pkConds[] = "t.$kq = r.$kq";
    }
    $where = implode(' AND ', $pkConds);

    $sqlInsert = "
    INSERT INTO `{$cfg['db']}`.`{$t}` ($colsListInsert)
    SELECT $colsListSelect
    FROM `{$tmpDb}`.`{$t}` t
    LEFT JOIN `{$cfg['db']}`.`{$t}` r
      ON $where
    WHERE r.`{$pk[0]}` IS NULL
";
    info("Inserindo linhas novas em '{$t}' (com base na PK)...");
    $affBefore = $mysqli->affected_rows;
    execAll($mysqli, $sqlInsert);
    $affAfter = $mysqli->affected_rows;
    ok("Merge de dados em '{$t}' concluído.");
  }

  // Limpeza
  info("Removendo banco temporário '{$tmpDb}'...");
  execAll($mysqli, "DROP DATABASE `{$tmpDb}`;");
  ok("Temporário removido.");

  ok("Sincronização finalizada com sucesso.");
  exit(0);
} catch (Throwable $e) {
  // Tenta limpar o temporário se algo deu errado
  try {
    execAll($mysqli, "DROP DATABASE IF EXISTS `{$tmpDb}`;");
  } catch (Throwable $e2) {
  }
  fail($e->getMessage(), 3);
}
