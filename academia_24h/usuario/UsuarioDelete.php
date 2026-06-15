<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
include_once __DIR__ . '/../db.class.php';

if (!isset($_SESSION['usuario_logado']) || $_SESSION['perfil'] !== 'admin') { header("Location: login.php"); exit; }

$database = new Database(); $db = $database->getConnection();
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id)) {
    if ($id == $_SESSION['usuario_id']) {
        echo "<script>alert('Erro: Não se pode eliminar a si próprio!'); window.location.href='UsuarioList.php';</script>";
        exit;
    }
    $query = "DELETE FROM usuario WHERE id = :id";
    $stmt = $db->prepare($query); $stmt->execute(['id' => $id]);
}
header("Location: UsuarioList.php"); exit;
?>