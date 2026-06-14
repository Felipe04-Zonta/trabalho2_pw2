<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Regra do PDF: Se não estiver logado, redireciona (Descomente após criar a tela de login)
/*
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: /academia_24h/usuario/UsuarioForm.php");
    exit;
}
*/
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
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; color: #ff4500 !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/academia_24h/index.php"><i class="fa-solid fa-dumbbell"></i> AtletaPro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/academia_24h/index.php">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="/academia_24h/equipamentos/EquipamentosList.php">Equipamentos</a></li>
                <li class="nav-item"><a class="nav-link" href="/academia_24h/planos/PlanoList.php">Planos Esportivos</a></li>
                <li class="nav-item"><a class="nav-link" href="/academia_24h/servicos/ServicoList.php">Modalidades/Serviços</a></li>
            </ul>
            <span class="navbar-text text-white me-3">
                Olá, <strong>Admin</strong>
            </span>
            <a href="#" class="btn btn-outline-danger btn-sm">Sair</a>
        </div>
    </div>
</nav>
<div class="container">