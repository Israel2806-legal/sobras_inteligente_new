<?php

session_start();
header('Content-Type: application/json');

require_once 'conexao_cadastro.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["erro" => "Usuário não autenticado"]);
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];

$acao = $_POST['acao'] ?? '';

switch ($acao) {
    case 'listar':
        $sql = "SELECT eu.id_estoque, i.nome_ingrediente, eu.quantidade, i.unidade_medida_ingrediente, eu.data_validade
                FROM estoque_usuario eu
                JOIN ingrediente i ON eu.id_ingrediente = i.id_ingrediente
                WHERE eu.id_usuario = :id_usuario";
        $stmt = $connCadastro->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["sucesso" => true, "itens" => $itens]);
        break;

    case 'adicionar':
        $nome = trim($_POST['nome']);
        $quantidade = (float) $_POST['quantidade'];
        $unidade = trim($_POST['unidade']);
        $validade = DateTime::createFromFormat('Y-m-d', $_POST['validade']);
        $data_formatada = $validade ? $validade->format('Y-m-d') : null;

        if (!$data_formatada) {
            echo json_encode(["erro" => "Data de validade inválida."]);
            exit();
        }

        // Verifica se o ingrediente já existe
        $stmt = $connCadastro->prepare("SELECT id_ingrediente FROM ingrediente WHERE nome_ingrediente = :nome LIMIT 1");
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $id_ingrediente = $row['id_ingrediente'];
        } else {
            $stmt = $connCadastro->prepare("INSERT INTO ingrediente (nome_ingrediente, unidade_medida_ingrediente) VALUES (:nome, :unidade)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':unidade', $unidade);
            $stmt->execute();
            $id_ingrediente = $connCadastro->lastInsertId();
        }

        $stmt = $connCadastro->prepare("INSERT INTO estoque_usuario (id_usuario, id_ingrediente, quantidade, data_validade) 
                                        VALUES (:id_usuario, :id_ingrediente, :quantidade, :validade)");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_ingrediente', $id_ingrediente);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':validade', $data_formatada);
        $stmt->execute();

        echo json_encode(["sucesso" => true]);
        break;

    case 'excluir':
        $id_estoque = (int) $_POST['id_estoque'];

        $stmt = $connCadastro->prepare("DELETE FROM estoque_usuario WHERE id_estoque = :id_estoque AND id_usuario = :id_usuario");
        $stmt->bindParam(':id_estoque', $id_estoque);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        echo json_encode(["sucesso" => true]);
        break;

    case 'editar':
        $id_estoque = (int) $_POST['id_estoque'];
        $quantidade = (float) $_POST['quantidade'];
        $validade = DateTime::createFromFormat('Y-m-d', $_POST['validade']);
        $data_formatada = $validade ? $validade->format('Y-m-d') : null;

        if (!$data_formatada) {
            echo json_encode(["erro" => "Data de validade inválida."]);
            exit();
        }

        $stmt = $connCadastro->prepare("UPDATE estoque_usuario 
                                        SET quantidade = :quantidade, data_validade = :validade 
                                        WHERE id_estoque = :id_estoque AND id_usuario = :id_usuario");
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':validade', $data_formatada);
        $stmt->bindParam(':id_estoque', $id_estoque);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        echo json_encode(["sucesso" => true]);
        break;

    default:
        echo json_encode(["erro" => "Ação inválida."]);
        break;
}
?>