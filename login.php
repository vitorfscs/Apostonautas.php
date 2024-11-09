<?php
session_start();
require_once 'db.php';  // Conecta ao banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se o usuário existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "Usuário não encontrado!";
        exit;
    }

    // Verifica a senha
    if (!password_verify($password, $user['password_hash'])) {
        echo "Senha incorreta!";
        exit;
    }

    // Sessão do usuário
    $_SESSION['user'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['credits'] = $user['credits']; // Salva os créditos do usuário na sessão

    // Redireciona para a página principal (index.php)
    header("Location: index.php");
    exit;
}
?>
