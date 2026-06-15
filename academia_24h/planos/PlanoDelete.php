<?php
include_once __DIR__ . '/../db.class.php';
$database = new Database(); $db = $database->getConnection();
$id = isset($_GET['id']) ? $_GET['id'] : '';
if(!empty($id)) {
    $query = "DELETE FROM planos WHERE id = :id";
    $stmt = $db->prepare($query); $stmt->execute(['id' => $id]);
}
header("Location: PlanoList.php"); exit;
?>