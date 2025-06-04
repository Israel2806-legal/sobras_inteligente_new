<?php
$host = 'localhost';
$dbname = 'sobras_inteligente_new';
$user = 'root';
$pass = '';

try {
    $connCadastro = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $connCadastro->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>

