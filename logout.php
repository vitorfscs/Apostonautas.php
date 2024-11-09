<?php
// Inicia a sessão para poder manipular as variáveis de sessão
session_start();

// Destrói todas as variáveis de sessão
session_unset();

// Destrói a sessão
session_destroy();

// Redireciona o usuário para a página inicial (ou página de login)
header("Location: index.php");
exit();
?>
