<?php
$host = 'localhost';  // ou o endereço do seu banco de dados
$dbname = 'apostonauta';  // Nome do banco de dados
$username = 'root';  // Nome de usuário do banco de dados
$password = '';  // Senha do banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
    exit();
}
?>
