<?php
include '../db.class.php';
$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : '';
if(!empty($id)) {
    $query = "DELETE FROM equipamentos WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute(['id' => $id]);
}
header("Location: EquipamentosList.php");
?>