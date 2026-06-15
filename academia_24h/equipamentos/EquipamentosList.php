<?php 
include_once __DIR__ . '/../db.class.php';
include_once __DIR__ . '/../header.php';

$database = new Database();
$db = $database->getConnection();

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
    <h2><i class="fa-solid fa-list"></i> Equipamentos Esportivos</h2>
    <a href="EquipamentosForm.php" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Novo Equipamento</a>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-10"><input type="text" name="busca" class="form-control" placeholder="Buscar..." value="<?php echo htmlspecialchars($busca); ?>"></div>
    <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Pesquisar</button></div>
</form>

<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr><th>#</th><th>Nome</th><th>Quantidade</th><th>Estado</th><th class="text-center">Ações</th></tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><strong><?php echo $row['nome']; ?></strong></td>
                    <td><?php echo $row['quantidade']; ?> un.</td>
                    <td><span class="badge bg-info text-dark"><?php echo $row['estado_conservacao']; ?></span></td>
                    <td class="text-center">
                        <a href="EquipamentosForm.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></a>
                        <a href="EquipamentosDelete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remover?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>