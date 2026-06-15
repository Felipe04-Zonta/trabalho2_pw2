<?php
// Ficheiro invisível de processamento de eliminação
include_once __DIR__ . '/../db.class.php';

$database = new Database(); 
$db = $database->getConnection();

// Captura o ID do item que deve ser eliminado
$id = isset($_GET['id']) ? $_GET['id'] : '';

if(!empty($id)) {
    // Executa a instrução DELETE com parâmetros seguros de substituição (:id)
    $query = "DELETE FROM equipamentos WHERE id = :id";
    $stmt = $db->prepare($query); 
    $stmt->execute(['id' => $id]);
}

// Redireciona imediatamente de volta para a listagem
header("Location: EquipamentosList.php");
exit;
?>