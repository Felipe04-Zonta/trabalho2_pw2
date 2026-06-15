<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/trabalho2_pw2/academia_24h/');
}

// Proteção absoluta de rotas administrativas
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: " . BASE_URL . "index.php");
    exit; 
} elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'atleta') {
    header("Location: " . BASE_URL . "usuario/area_atleta.php");
    exit;
}

// Mapeamento dinâmico de navegação ativa
$diretorio_atual = dirname($_SERVER['PHP_SELF']);
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AtletaPro - Área Administrativa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-slate: #1e293b;
            --accent-orange: #ff4500;
        }
        body { 
            background-color: #f8fafc; 
            font-family: 'Segoe UI', system-ui, sans-serif; 
        }
        .navbar-premium {
            background-color: var(--bg-slate) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            padding: 0.7rem 0;
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #94a3b8;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin: 0 0.15rem;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }
        /* Elemento Indicador de Página Ativa */
        .navbar-dark .navbar-nav .nav-link.active-item {
            color: #ffffff !important;
            background-color: var(--accent-orange);
            box-shadow: 0 4px 12px rgba(255, 69, 0, 0.25);
        }
        .card-modern {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            background: #ffffff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-premium mb-4 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="<?php echo BASE_URL; ?>dashboard.php">
            <i class="fa-solid fa-circle-nodes text-warning me-2"></i>Atleta<span style="color: var(--accent-orange);">Pro</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($pagina_atual == 'dashboard.php') ? 'active-item' : ''; ?>" href="<?php echo BASE_URL; ?>dashboard.php">
                        <i class="fa-solid fa-chart-pie me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($diretorio_atual, 'equipamentos') !== false) ? 'active-item' : ''; ?>" href="<?php echo BASE_URL; ?>equipamentos/EquipamentosList.php">
                        <i class="fa-solid fa-dumbbell me-1"></i> Equipamentos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($diretorio_atual, 'planos') !== false) ? 'active-item' : ''; ?>" href="<?php echo BASE_URL; ?>planos/PlanoList.php">
                        <i class="fa-solid fa-id-card me-1"></i> Planos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($diretorio_atual, 'servicos') !== false) ? 'active-item' : ''; ?>" href="<?php echo BASE_URL; ?>servicos/ServicoList.php">
                        <i class="fa-solid fa-person-running me-1"></i> Modalidades
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($diretorio_atual, 'usuario') !== false && $pagina_atual != 'area_atleta.php') ? 'active-item' : ''; ?>" href="<?php echo BASE_URL; ?>usuario/UsuarioList.php">
                        <i class="fa-solid fa-users-gear me-1"></i> Integrantes
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <small class="text-muted d-block" style="font-size: 0.72rem;">Operador Ativo</small>
                    <span class="text-white fw-semibold small"><?php echo htmlspecialchars($_SESSION['usuario_logado']); ?></span>
                </div>
                <a href="<?php echo BASE_URL; ?>usuario/logout.php" class="btn btn-sm btn-outline-danger rounded-3 border-0 bg-opacity-10 bg-danger text-danger fw-medium" onclick="return confirm('Deseja encerrar a sessão atual?')">
                    <i class="fa-solid fa-power-off"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="container">