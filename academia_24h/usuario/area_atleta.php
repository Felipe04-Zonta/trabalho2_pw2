<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['usuario_logado']) || $_SESSION['perfil'] !== 'atleta') { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><title>Portal do Atleta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card p-5 shadow">
        <h2>Painel do Atleta - AtletaPro</h2>
        <p>Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['usuario_logado']); ?></strong>!</p>
        <div class="alert alert-info">Foco de hoje: Treino de Pliometria e Velocidade Base.</div>
        <a href="logout.php" class="btn btn-danger btn-sm">Sair do Painel</a>
    </div>
</div>
</body>
</html>