<?php
session_start();
require_once 'db.php'; // Conecta ao banco de dados

// Verifica se o usuário está logado
if (isset($_SESSION['user_id'])) {
    // Obtém as informações do usuário logado
    $userId = $_SESSION['user_id'];
    $username = $_SESSION['user'];
    
    // Obtém os dados do usuário, incluindo os créditos
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user) {
        // Obtém o histórico de jogos do usuário
        $stmt = $pdo->prepare("SELECT * FROM historico_jogos WHERE user_id = ?");
        $stmt->execute([$user['id']]);
        $historico = $stmt->fetchAll();
    }
} else {
    $username = null;
    $user = null;
    $historico = null;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apostonauta, sua casa de apostas!</title>
    <link rel="stylesheet" href="css/index.css"> <!-- Referência para o CSS externo -->
</head>
<body>
    <div class="container">
        <header class="topo">
            <div class="logo">
                <h2>Apostonauta.bet</h2>
                <p>A casa do vencedor!</p>
            </div>
            <nav class="auth-links">
                <ul>
                    <?php if ($user): ?>
                        <!-- Mostrar dados do usuário quando estiver logado -->
                        <li><a href="logout.php">Sair</a></li>
                        <li><a href="#">Jogos do Momento</a></li>
                    <?php else: ?>
                        <!-- Exibir botão "Entrar" se o usuário não estiver logado -->
                        <li><a href="javascript:void(0);" id="loginBtn">Entrar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <!-- Exibe o nome do usuário, créditos e histórico logo abaixo do cabeçalho -->
            <?php if ($user): ?>
            <div class="user-welcome">
                <span class="user-name">Bem-vindo, <?php echo htmlspecialchars($username); ?>!</span>
                <div class="user-details">
                    <small>Créditos: <?php echo $user['credits']; ?></small>
                    <small>Histórico de Jogos: <?php echo count($historico); ?> jogos</small>
                </div>
            </div>
            <?php endif; ?>
        </header>

        <div class="hero-section">
            <h1>Jogue com confiança e vença!</h1>
            <p>As melhores odds e segurança total para suas apostas</p>
            <a href="Games/Animal/index.html" class="cta-button">Comece agora</a>
        </div>

        <!-- Carrossel de Imagens -->
        <div class="carousel-container">
            <div class="carousel">
                <img src="image/banner-do-jogo-do-tigrinho.webp" alt="Banner 1">
                <img src="image/imagem-destaque-logo-aviator.webp" alt="Banner 2">
                <img src="image/istockphoto-1354694626-1024x1024.jpg" alt="Banner 3">
            </div>
            <div class="carousel-controls">
                <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                <button class="next" onclick="moveSlide(1)">&#10095;</button>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2024 Apostonauta.bet - Todos os direitos reservados</p>
        </footer>
    </div>

    <!-- Popup de Login -->
    <div id="loginPopup" class="popup">
        <div class="popup-content">
            <span class="close-btn" id="closeLoginPopup">&times;</span>
            <h2>Entrar</h2>
            <form method="POST" action="login.php">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Entrar</button>
            </form>
            <p>Ainda não tem conta? <a href="javascript:void(0);" id="goToSignup">Cadastre-se</a></p>
        </div>
    </div>

    <!-- Popup de Cadastro -->
    <div id="signupPopup" class="popup">
        <div class="popup-content">
            <span class="close-btn" id="closeSignupPopup">&times;</span>
            <h2>Cadastrar</h2>
            <form method="POST" action="register.php">
                <label for="newUsername">Nome de Usuário:</label>
                <input type="text" id="newUsername" name="username" required>
                <label for="newPassword">Senha:</label>
                <input type="password" id="newPassword" name="password" required>
                <label for="confirmPassword">Confirmar Senha:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <button type="submit">Cadastrar</button>
            </form>
            <p>Já tem uma conta? <a href="javascript:void(0);" id="goToLogin">Entrar</a></p>
        </div>
    </div>

    <script src="js/function.js"></script>
</body>
</html>
