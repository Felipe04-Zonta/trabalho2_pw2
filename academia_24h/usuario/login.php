<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
include_once __DIR__ . '/../db.class.php';

$database = new Database(); $db = $database->getConnection();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login']; $senha = md5($_POST['senha']);

    $query = "SELECT * FROM usuario WHERE login = :login AND senha = :senha LIMIT 1";
    $stmt = $db->prepare($query); $stmt->execute(['login' => $login, 'senha' => $senha]);

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
    } else { $erro = "Credenciais inválidas!"; }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><title>AtletaPro - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center" style="height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 card p-4 shadow-lg">
            <h3 class="text-center mb-3">AtletaPro Login</h3>
            <?php if($erro): ?><div class="alert alert-danger"><?php echo $erro; ?></div><?php endif; ?>
            <form method="POST">
                <div class="mb-3"><label>Usuário</label><input type="text" name="login" class="form-control" required></div>
                <div class="mb-3"><label>Senha</label><input type="password" name="senha" class="form-control" required></div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
            <div class="text-center mt-3"><a href="UsuarioForm.php" class="small">Cadastrar Novo Atleta</a></div>
        </div>
    </div>
</div>
</body>
</html>