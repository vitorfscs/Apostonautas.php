<?php
session_start();
require_once 'db.php';  // Conecta ao banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Verifica se as senhas coincidem
    if ($password !== $confirmPassword) {
        echo "As senhas não coincidem!";
        exit;
    }

    // Verifica se o nome de usuário já existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        echo "Nome de usuário já existe!";
        exit;
    }

    // Cria o hash da senha
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 1. Insere o novo usuário na tabela `users` com a senha criptografada
    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    $stmt->execute([$username, $passwordHash]);

    // 2. Obtém o ID do usuário recém-criado
    $user_id = $pdo->lastInsertId();

    // 3. Insere um registro de créditos na tabela `creditos` para esse usuário
    // Suponha que você quer iniciar com 100 créditos para o novo usuário
    $stmt = $pdo->prepare("INSERT INTO creditos (user_id, valor_credito) VALUES (?, ?)");
    $stmt->execute([$user_id, 100]);  // 100 créditos iniciais

    // 4. Obtém o ID do crédito inserido
    $credit_id = $pdo->lastInsertId();

    // 5. Atualiza a tabela `users` com o ID do crédito (coluna `credits`)
    $stmt = $pdo->prepare("UPDATE users SET credits = ? WHERE id = ?");
    $stmt->execute([$credit_id, $user_id]);

    // 6. Redireciona para a página principal (index.php)
    header("Location: index.php");
    exit;
}
?>
