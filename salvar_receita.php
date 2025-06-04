<?php
session_start();
require_once 'conexao_cadastro.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario']['id'])) {
    echo json_encode(['erro' => 'Usuário não autenticado']);
    exit;
}

$id_usuario = $_SESSION['usuario']['id'];

$dadosRecebidos = json_decode(file_get_contents('php://input'), true);

$nome = $dadosRecebidos['nome'] ?? '';
$descricao = $dadosRecebidos['descricao'] ?? '';
$tempo = $dadosRecebidos['tempo'] ?? '';
$dificuldade = $dadosRecebidos['dificuldade'] ?? '';
$modo_preparo = $dadosRecebidos['modo_preparo'] ?? '';

if (!$nome || !$descricao || !$modo_preparo) {
    echo json_encode(['erro' => 'Dados incompletos para salvar a receita.']);
    exit;
}

try {
    // 1. Inserir na tabela `receita`
    $stmt = $connCadastro->prepare("
        INSERT INTO receita (nome_receita, descricao_receita, tempo_prep_receita, dificuldade_receita, modo_preparo)
        VALUES (:nome, :descricao, :tempo, :dificuldade, :modo_preparo)
    ");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':tempo', $tempo);
    $stmt->bindParam(':dificuldade', $dificuldade);
    $stmt->bindParam(':modo_preparo', $modo_preparo);
    $stmt->execute();

    $id_receita = $connCadastro->lastInsertId();

    // 2. Relacionar com o usuário
    $stmtRelacao = $connCadastro->prepare("
        INSERT INTO usuario_receita_favorito (id_usuario, id_receita)
        VALUES (:id_usuario, :id_receita)
    ");
    $stmtRelacao->bindParam(':id_usuario', $id_usuario);
    $stmtRelacao->bindParam(':id_receita', $id_receita);
    $stmtRelacao->execute();

    echo json_encode(['sucesso' => true]);
} catch (Exception $e) {
    echo json_encode(['erro' => 'Erro ao salvar a receita.', 'detalhe' => $e->getMessage()]);
}

?>