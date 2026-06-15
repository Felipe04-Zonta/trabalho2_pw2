<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
// PROTEÇÃO CRÍTICA DO PORTAL: Se tentar entrar sem login ou não for um Atleta (for admin), é expulso para a tela de login
if (!isset($_SESSION['usuario_logado']) || $_SESSION['perfil'] !== 'atleta') { 
    header("Location: login.php"); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><title>Portal de Desenvolvimento do Atleta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card p-5 shadow border-0 rounded-4 bg-white">
        <h2><i class="fa-solid fa-circle-user text-primary"></i> Portal do Atleta - AtletaPro</h2>
        <hr>
        <p class="fs-5">Bem-vindo à sua área de monitoramento, <strong><?php echo htmlspecialchars($_SESSION['usuario_logado']); ?></strong>!</p>
        <div class="alert alert-info border-start border-5 border-info">
            <strong>Foco Técnico de Hoje:</strong> Treinamento específico de Pliometria, saltos em caixa e corrida intervalada de alta intensidade.
        </div>
        <a href="logout.php" class="btn btn-danger btn-sm mt-3">Sair do Painel de Controle</a>
    </div>
</div>
</body>
</html>