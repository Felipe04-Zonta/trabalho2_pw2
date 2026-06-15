<?php
// Liga as sessões locais para guardar dados do utilizador logado temporariamente
if (session_status() == PHP_SESSION_NONE) { session_start(); }
include_once __DIR__ . '/../db.class.php';

$database = new Database(); 
$db = $database->getConnection();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login']; 
    // Codifica a senha recebida em MD5 para poder comparar de forma correta com a hash salva no banco
    $senha = md5($_POST['senha']);

    // Consulta SQL restrita buscando a combinação exata de login e senha criados
    $query = "SELECT * FROM usuario WHERE login = :login AND senha = :senha LIMIT 1";
    $stmt = $db->prepare($query); 
    $stmt->execute(['login' => $login, 'senha' => $senha]);

    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Guarda o ID e o Nome do utilizador na memória de sessão do servidor PHP
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_logado'] = $user['nome'];
        
        // REDIRECIONAMENTO INTELIGENTE POR NÍVEL DE ACESSO (Etapa 2 do PDF):
        // Se o termo 'atleta' estiver presente dentro do login digitado, define nível Atleta e isola o acesso
        if (strpos($login, 'atleta') !== false) {
            $_SESSION['perfil'] = 'atleta';
            header("Location: area_atleta.php");
        } else {
            // Caso contrário, assume que é um Administrador do sistema e liberta o menu completo
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
    <meta charset="UTF-8"><title>AtletaPro - Autenticação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center" style="height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 card p-4 shadow-lg">
            <h3 class="text-center mb-3">AtletaPro Login</h3>
            <?php if($erro): ?><div class="alert alert-danger text-center"><?php echo $erro; ?></div><?php endif; ?>
            <form method="POST">
                <div class="mb-3"><label class="form-label fw-bold">Nome de Usuário</label><input type="text" name="login" class="form-control" required placeholder="admin ou atleta.nome"></div>
                <div class="mb-3"><label class="form-label fw-bold">Senha de Acesso</label><input type="password" name="senha" class="form-control" required></div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Aceder ao Sistema</button>
            </form>
            <div class="text-center mt-3"><a href="UsuarioForm.php" class="small text-decoration-none">Novo atleta? Registe-se aqui</a></div>
        </div>
    </div>
</div>
</body>
</html>