<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
include_once __DIR__ . '/../db.class.php';

// PROTEÇÃO DE ROTA EXTRA: Impede que qualquer utilizador comum ou invasor execute este arquivo via URL
if (!isset($_SESSION['usuario_logado']) || $_SESSION['perfil'] !== 'admin') { 
    header("Location: login.php"); 
    exit; 
}

$database = new Database(); $db = $database->getConnection();
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id)) {
    // REGRA DE SEGURANÇA E NEGÓCIO EXIGIDA EM SISTEMAS WEB:
    // Impede que um administrador consiga deletar a própria conta de dentro do sistema estando logado nela.
    if ($id == $_SESSION['usuario_id']) {
        echo "<script>alert('Erro de Segurança: Não é permitido excluir o utilizador da sessão ativa!'); window.location.href='UsuarioList.php';</script>";
        exit;
    }
    $query = "DELETE FROM usuario WHERE id = :id";
    $stmt = $db->prepare($query); $stmt->execute(['id' => $id]);
}
header("Location: UsuarioList.php"); 
exit;
?>