<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
include_once __DIR__ . '/../db.class.php';

// SISTEMA HÍBRIDO (Público/Privado):
// Verifica se quem está acedendo a esta página é um administrador logado. 
$isAdmin = (isset($_SESSION['usuario_logado']) && $_SESSION['perfil'] === 'admin');

// Se for administrador, renderiza o menu superior unificado, caso contrário é uma inscrição pública e oculta o menu.
if($isAdmin) { 
    include_once __DIR__ . '/../header.php'; 
}

$database = new Database(); $db = $database->getConnection();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$nome = ''; $telefone = ''; $email = ''; $login = '';

// Ação de carregar dados para edição restrita a administradores logados
if(!empty($id) && $isAdmin) {
    $query = "SELECT * FROM usuario WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($query); $stmt->execute(['id' => $id]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome = $row['nome']; $telefone = $row['telefone']; $email = $row['email']; $login = $row['login'];
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome']; $telefone = $_POST['telefone']; $email = $_POST['email']; $login = $_POST['login'];
    // Se digitou uma nova senha, gera a hash MD5, senão mantém vazia
    $senha = !empty($_POST['senha']) ? md5($_POST['senha']) : null;

    if(!empty($id) && $isAdmin) {
        // Lógica de Atualização (Admin editando conta existente)
        if($senha) {
            $query = "UPDATE usuario SET nome=:nome, telefone=:telefone, email=:email, login=:login, senha=:senha WHERE id=:id";
            $stmt = $db->prepare($query); $stmt->execute(['nome' => $nome, 'telefone' => $telefone, 'email' => $email, 'login' => $login, 'senha' => $senha, 'id' => $id]);
        } else {
            $query = "UPDATE usuario SET nome=:nome, telefone=:telefone, email=:email, login=:login WHERE id=:id";
            $stmt = $db->prepare($query); $stmt->execute(['nome' => $nome, 'telefone' => $telefone, 'email' => $email, 'login' => $login, 'id' => $id]);
        }
        header("Location: UsuarioList.php"); exit;
    } else {
        $query = "INSERT INTO usuario (nome, telefone, email, login, senha) VALUES (:nome, :telefone, :email, :login, :senha)";
        $stmt = $db->prepare($query); $stmt->execute(['nome' => $nome, 'telefone' => $telefone, 'email' => $email, 'login' => $login, 'senha' => md5($_POST['senha'])]);
        header("Location: login.php"); exit;
    }
}
?>
<?php if(!$isAdmin): ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light py-5">
<?php endif; ?>

<div class="card shadow-sm max-width-600 mx-auto p-4 bg-white">
    <h4>Ficha de Registo de Integrante</h4>
    <hr>
    <form method="POST">
        <div class="mb-3"><label class="form-label">Nome Completo *</label><input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required></div>
        <div class="mb-3"><label class="form-label">Telefone de Contato *</label><input type="text" name="telefone" class="form-control" value="<?php echo htmlspecialchars($telefone); ?>" required></div>
        <div class="mb-3"><label class="form-label">E-mail Válido *</label><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required></div>
        <div class="mb-3">
            <label class="form-label">Defina seu Nome de Usuário (Login) *</label>
            <input type="text" name="login" class="form-control" value="<?php echo htmlspecialchars($login); ?>" required placeholder="Atletas: iniciem obrigatoriamente com 'atleta.'">
        </div>
        <div class="mb-3"><label class="form-label">Senha *</label><input type="password" name="senha" class="form-control" <?php echo !empty($id)?'':'required';?>></div>
        <button type="submit" class="btn btn-primary fw-bold">Gravar Ficha</button>
        <a href="<?php echo $isAdmin ? 'UsuarioList.php' : 'login.php'; ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php if($isAdmin) { include_once __DIR__ . '/../footer.php'; } else { echo '</body></html>'; } ?>