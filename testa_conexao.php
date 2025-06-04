<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=cadastro;charset=utf8", "root", "R@fasoad20");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
?>
