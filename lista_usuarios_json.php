<?php
session_start();
require_once 'conexao_cadastro.php';

header('Content-Type: application/json');

try {
    $stmt = $connCadastro->query("SELECT id, nome, email, foto FROM usuarios ORDER BY id DESC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($usuarios);
} catch (Exception $e) {
    // Retorna erro JSON em caso de falha
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao consultar usuários: ' . $e->getMessage()]);
}
exit;
?>
