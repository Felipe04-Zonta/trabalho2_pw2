<?php
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}

include_once __DIR__ . '/../db.class.php';

$database = new Database(); 
$db = $database->getConnection();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login']; 
    $senha = md5($_POST['senha']);

    $query = "SELECT * FROM usuario WHERE login = :login AND senha = :senha LIMIT 1";
    $stmt = $db->prepare($query); 
    $stmt->execute(['login' => $login, 'senha' => $senha]);

    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_logado'] = $user['nome'];
        
        if (strpos($login, 'atleta') !== false) {
            $_SESSION['perfil'] = 'atleta';
            header("Location: area_atleta.php");
        } else {
            $_SESSION['perfil'] = 'admin';
            header("Location: ../index.php");
        }
        exit;
    } else { 
        $erro = "Credenciais inválidas ou utilizador inexistente!"; 
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AtletaPro - Autenticação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .card-login {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            background-color: #ffffff;
        }
        .btn-orange {
            background-color: #ff4500;
            color: #fff;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-orange:hover {
            background-color: #e03d00;
            color: #fff;
        }
    </style>
</head>
<body class="d-flex align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 card-login p-4 m-3">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark mb-1"><i class="fa-solid fa-circle-nodes text-warning me-2"></i>Atleta<span style="color: #ff4500;">Pro</span></h2>
                <small class="text-muted">Introduza as suas credenciais de acesso</small>
            </div>
            
            <?php if($erro): ?>
                <div class="alert alert-danger text-center py-2 small"><i class="fa-solid fa-triangle-exclamation me-1"></i> <?php echo $erro; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nome de Utilizador</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="login" class="form-control" required placeholder="admin ou atleta.nome">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold text-secondary">Senha de Segurança</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="senha" class="form-control" required placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="btn btn-orange w-100 py-2 shadow-sm rounded-3">Entrar no Painel</button>
            </form>
            <div class="text-center mt-4 border-top pt-3">
                <a href="UsuarioForm.php" class="small text-decoration-none text-secondary">Não tem conta? <span style="color: #ff4500;" class="fw-semibold">Criar Ficha de Atleta</span></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>