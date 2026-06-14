<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db.class.php';

$database = new Database();
$db = $database->getConnection();
$erro = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $senha = md5($_POST['senha']); // Mesma criptografia usada no INSERT padrão do banco

    $query = "SELECT * FROM usuario WHERE login = :login AND senha = :senha LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute(['login' => $login, 'senha' => $senha]);

    if($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['usuario_logado'] = $user['nome'];
        header("Location: ../index.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>AtletaPro - Acesso Restrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 text-primary fw-bold">AtletaPro LOGIN</h3>
                    
                    <?php if(!empty($erro)): ?>
                        <div class="alert alert-danger"><?php echo $erro; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Usuário (Login)</label>
                            <input type="text" name="login" class="form-control" required placeholder="admin">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required placeholder="123">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Entrar no Sistema</button>
                    </form>
                    
                    <div class="text-center mt-4">
                        [cite_start]<small class="text-muted">Acesso de testes:<br><strong>admin / 123</strong></small> [cite: 40]
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>