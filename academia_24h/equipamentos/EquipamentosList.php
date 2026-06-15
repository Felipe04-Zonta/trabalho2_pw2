<?php 
// Carrega a classe de ligação e o cabeçalho usando caminhos absolutos (__DIR__)
include_once __DIR__ . '/../db.class.php';
include_once __DIR__ . '/../header.php';

// Inicializa a ligação com o banco de dados
$database = new Database();
$db = $database->getConnection();

// OBRIGATORIEDADE DA BARRA DE PESQUISA (Roteiro do PDF):
// Captura o termo de busca enviado via método GET. Se não houver nada digitado, assume vazio.
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';

if(!empty($busca)) {
    // Caso tenha digitado algo, roda um SQL com o operador LIKE para buscar termos parciais e ordena por nome (ASC)
    $query = "SELECT * FROM equipamentos WHERE nome LIKE :busca ORDER BY nome ASC";
    $stmt = $db->prepare($query);
    // Os símbolos de porcentagem (%) significam que a palavra pode estar em qualquer lugar da string
    $stmt->execute(['busca' => "%$busca%"]);
} else {
    // Se a pesquisa estiver vazia, lista todos os equipamentos cadastrados no sistema em ordem alfabética
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
    <div class="col-md-10">
        <input type="text" name="busca" class="form-control" placeholder="Buscar equipamento por nome..." value="<?php echo htmlspecialchars($busca); ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
    </div>
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
                        <a href="EquipamentosDelete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover este equipamento?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>