<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'mvc_biblioteca';
$sqlFile = 'C:\Users\AlefDeSouzaSobrinho\Desktop\coisas\xampp\htdocs\mvc-biblioteca\mvc_biblioteca.sql';

echo "======================================\n";
echo "Atualização do banco de dados\n";
echo "======================================\n";

try {
    // Conexão inicial sem banco
    $mysqli = new mysqli($host, $user, $pass);

    // Verifica se o banco existe
    $result = $mysqli->query("SHOW DATABASES LIKE '$dbName'");
    if ($result->num_rows > 0) {
        echo "Banco '$dbName' existe. Excluindo para recriar...\n";
        $mysqli->query("DROP DATABASE `$dbName`");
        echo "Banco excluído.\n";
    }

    // Cria banco e importa SQL
    echo "Criando banco '$dbName'...\n";
    $mysqli->query("CREATE DATABASE `$dbName`");
    echo "Banco criado com sucesso.\n";
    $mysqli->select_db($dbName);

    echo "Importando SQL completo...\n";
    importSQL($dbName, $sqlFile, $mysqli);
    echo "Importação concluída.\n";

    $mysqli->close();
    echo "======================================\n";
    echo "Processo finalizado.\n";
    echo "======================================\n";
} catch (mysqli_sql_exception $e) {
    echo "Erro MySQL em [" . $e->getFile() . ":" . $e->getLine() . "]: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Erro geral em [" . $e->getFile() . ":" . $e->getLine() . "]: " . $e->getMessage() . "\n";
}

// Função para importar SQL completo
function importSQL($dbName, $sqlFile, $mysqli)
{
    if (!file_exists($sqlFile)) {
        throw new Exception("Arquivo SQL não encontrado: $sqlFile");
    }

    $sql = file_get_contents($sqlFile);
    $mysqli->select_db($dbName);

    try {
        if ($mysqli->multi_query($sql)) {
            do {
                // Limpa resultados pendentes
                if ($result = $mysqli->store_result()) {
                    $result->free();
                }
            } while ($mysqli->more_results() && $mysqli->next_result());
        }
    } catch (mysqli_sql_exception $e) {
        echo "Erro ao importar SQL:\n";
        echo "Mensagem: " . $e->getMessage() . "\n";
    }
}
