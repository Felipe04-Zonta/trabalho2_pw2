<?php
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}

// Se o usuário já possuir sessão válida guardada, pula o login automaticamente
if (isset($_SESSION['usuario_logado'])) {
    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'atleta') {
        header("Location: usuario/area_atleta.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
}

include_once __DIR__ . '/db.class.php';

$database = new Database(); 
$db = $database->getConnection();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login']; 
    // Conversão em criptografia MD5 para bater com as inserções nativas de teste do script SQL
    $senha = md5($_POST['senha']); 

    $query = "SELECT * FROM usuario WHERE login = :login AND senha = :senha LIMIT 1";
    $stmt = $db->prepare($query); 
    $stmt->execute(['login' => $login, 'senha' => $senha]);

    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_logado'] = $user['nome'];
        
        // Regra de Redirecionamento por Nível de Acesso (Requisito da Etapa 2)
        if (strpos($login, 'atleta') !== false) {
            $_SESSION['perfil'] = 'atleta';
            header("Location: usuario/area_atleta.php");
        } else {
            $_SESSION['perfil'] = 'admin';
            header("Location: dashboard.php");
        }
        exit;
    } else { 
        $erro = "Credenciais incorretas ou acesso inexistente."; 
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
        .login-card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            background: #ffffff;
            overflow: hidden;
        }
        .btn-premium {
            background-color: #ff4500;
            color: #ffffff;
            font-weight: 600;
            border: none;
            transition: all 0.25s ease;
        }
        .btn-premium:hover {
            background-color: #e03d00;
            color: #ffffff;
            transform: translateY(-1px);
        }
        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
            color: #64748b;
        }
        .form-control {
            border-left: none;
            background-color: #f8fafc;
        }
        .form-control:focus {
            background-color: #f8fafc;
            border-color: #dee2e6;
            box-shadow: none;
        }
    </style>
</head>
<body class="d-flex align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-5 col-lg-4 login-card p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="d-inline-flex p-3 bg-light rounded-circle text-warning mb-2">
                    <i class="fa-solid fa-circle-nodes fa-2x" style="color: #ff4500;"></i>
                </div>
                <h3 class="fw-bold text-dark m-0">Atleta<span style="color: #ff4500;">Pro</span></h3>
                <p class="text-muted small">Plataforma de Alta Performance</p>
            </div>

            <?php if($erro): ?>
                <div class="alert alert-danger text-center border-0 py-2 small rounded-3 mb-3">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nome de Usuário</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user-gear"></i></span>
                        <input type="text" name="login" class="form-control" required placeholder="admin ou atleta.nome">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold text-secondary">Senha de Acesso</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <input type="password" name="senha" class="form-control" required placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="btn btn-premium w-100 py-2.5 rounded-3 shadow-sm mb-2">
                    Entrar no Sistema <i class="fa-solid fa-right-to-bracket ms-1"></i>
                </button>
            </form>

            <div class="text-center mt-4 border-top pt-3">
                <a href="usuario/UsuarioForm.php" class="small text-decoration-none text-muted">
                    Novo Integrante? <span style="color: #ff4500;" class="fw-semibold">Criar Ficha Cadastral</span>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>