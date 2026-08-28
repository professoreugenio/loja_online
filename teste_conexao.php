<?php

declare(strict_types=1);

// Carrega o arquivo da classe Config
require_once __DIR__ . '/database/conexao.php';

try {
    $pdo = Config::connect();

    echo "<h3>Conexão bem-sucedida!</h3>";

    // 1. Exibe qual banco de dados está sendo usado no momento
    $stmtDb = $pdo->query("SELECT DATABASE()");
    $bancoAtual = $stmtDb->fetchColumn();
    echo "<strong>Banco de Dados Conectado:</strong> " . ($bancoAtual ?: 'Nenhum banco selecionado') . "<br><br>";

    // 2. Conta a quantidade de registros na tabela 'clientes'
    // (Ajuste o nome 'clientes' caso sua tabela no banco tenha outro nome)
    $stmtCount = $pdo->query("SELECT COUNT(*) FROM clientes");
    $totalClientes = $stmtCount->fetchColumn();
    echo "<strong>Total de Clientes na Tabela:</strong> " . $totalClientes;

} catch (Throwable $e) {
    echo "<h3 style='color:red;'>Erro na Conexão:</h3>";
    echo $e->getMessage();
}