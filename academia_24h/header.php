<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Proteção da Área Administrativa contra acessos anónimos
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: /TRABALHO2_PW2/academia_24h/usuario/login.php");
    exit;
} elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'atleta') {
    header("Location: /TRABALHO2_PW2/academia_24h/usuario/area_atleta.php");
    exit;
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/TRABALHO2_PW2/academia_24h/');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AtletaPro - Academia de Talentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: 800; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">
            <i class="fa-solid fa-medal text-warning me-2"></i>Atleta<span style="color: #ff4500;">Pro</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php"><i class="fa-solid fa-house"></i> Início</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>equipamentos/EquipamentosList.php">Equipamentos</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>planos/PlanoList.php">Planos</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>servicos/ServicoList.php">Modalidades</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>usuario/UsuarioList.php">Administradores</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <span class="navbar-text text-white">
                    Olá, <strong><?php echo htmlspecialchars($_SESSION['usuario_logado']); ?></strong>
                </span>
                <a href="<?php echo BASE_URL; ?>usuario/logout.php" class="btn btn-sm btn-outline-danger" onclick="return confirm('Terminar sessão?')">Sair</a>
            </div>
        </div>
    </div>
</nav>
<div class="container pb-5">