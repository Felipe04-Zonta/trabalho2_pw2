<?php 
include '../header.php'; 
include '../db.class.php';

$database = new Database();
$db = $database->getConnection();

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
if(!empty($busca)) {
    $query = "SELECT * FROM planos WHERE nome_plano LIKE :busca ORDER BY nome_plano ASC";
    $stmt = $db->prepare($query);
    $stmt->execute(['busca' => "%$busca%"]);
} else {
    $query = "SELECT * FROM planos ORDER BY nome_plano ASC";
    $stmt = $db->prepare($query);
    $stmt->execute();
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa-solid fa-id-card-alt"></i> Planos de Treinamento e Incentivo</h2>
    <a href="PlanoForm.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Novo Plano</a>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-9">
        <input type="text" name="busca" class="form-control" placeholder="Buscar plano pelo nome..." value="<?php echo htmlspecialchars($busca); ?>">
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
    </div>
</form>

<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table class="table table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nome do Plano</th>
                <th>Descrição / Benefícios</th>
                <th>Investimento</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><strong><?php echo $row['nome_plano']; ?></strong></td>
                    <td><?php echo $row['descricao']; ?></td>
                    <td>R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                    <td class="text-center">
                        <a href="PlanoForm.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="PlanoDelete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir plano?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>