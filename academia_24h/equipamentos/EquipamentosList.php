<?php 
include '../header.php'; 
include '../db.class.php';

$database = new Database();
$db = $database->getConnection();

// Lógica de Busca funcional requerida pelo PDF
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
if(!empty($busca)) {
    $query = "SELECT * FROM equipamentos WHERE nome LIKE :busca ORDER BY nome ASC";
    $stmt = $db->prepare($query);
    $stmt->execute(['busca' => "%$busca%"]);
} else {
    $query = "SELECT * FROM equipamentos ORDER BY nome ASC";
    $stmt = $db->prepare($query);
    $stmt->execute();
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa-solid fa-list"></i> Listagem de Equipamentos Esportivos</h2>
    <a href="EquipamentosForm.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Novo Equipamento</a>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-9">
        <input type="text" name="busca" class="form-control" placeholder="Buscar equipamento pelo nome..." value="<?php echo htmlspecialchars($busca); ?>">
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
    </div>
</form>

<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table class="table table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nome do Equipamento</th>
                <th>Quantidade</th>
                <th>Estado de Conservação</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if($stmt->rowCount() > 0): ?>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><strong><?php echo $row['nome']; ?></strong></td>
                        <td><?php echo $row['quantidade']; ?> un.</td>
                        <td>
                            <span class="badge bg-info text-dark"><?php echo $row['estado_conservacao']; ?></span>
                        </td>
                        <td class="text-center">
                            <a href="EquipamentosForm.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="EquipamentosDelete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Nenhum registro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>