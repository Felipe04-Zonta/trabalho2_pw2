<?php 
include '../header.php'; 
include '../db.class.php';

$database = new Database();
$db = $database->getConnection();

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
if(!empty($busca)) {
    $query = "SELECT * FROM servicos WHERE nome_servico LIKE :busca ORDER BY nome_servico ASC";
    $stmt = $db->prepare($query);
    $stmt->execute(['busca' => "%$busca%"]);
} else {
    $query = "SELECT * FROM servicos ORDER BY nome_servico ASC";
    $stmt = $db->prepare($query);
    $stmt->execute();
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa-solid fa-medal"></i> Modalidades Esportivas Ofertadas</h2>
    <a href="ServicoForm.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Nova Modalidade</a>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-9">
        <input type="text" name="busca" class="form-control" placeholder="Buscar por modalidade..." value="<?php echo htmlspecialchars($busca); ?>">
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
                <th>Nome do Serviço/Modalidade</th>
                <th>Categoria do Esporte</th>
                <th>Professor Orientador</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><strong><?php echo $row['nome_servico']; ?></strong></td>
                    <td><?php echo $row['categoria_esporte']; ?></td>
                    <td><i class="fa-solid fa-user-tie text-muted"></i> <?php echo $row['professor_responsavel']; ?></td>
                    <td class="text-center">
                        <a href="ServicoForm.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="ServicoDelete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir serviço?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>