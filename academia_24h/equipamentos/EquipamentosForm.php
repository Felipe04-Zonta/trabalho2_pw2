<?php 
include_once __DIR__ . '/../db.class.php';
include_once __DIR__ . '/../header.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$nome = ''; $quantidade = ''; $estado_conservacao = '';

if(!empty($id)) {
    $query = "SELECT * FROM equipamentos WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute(['id' => $id]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome = $row['nome']; $quantidade = $row['quantidade']; $estado_conservacao = $row['estado_conservacao'];
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome']; $quantidade = $_POST['quantidade']; $estado_conservacao = $_POST['estado_conservacao'];

    if(!empty($id)) {
        $query = "UPDATE equipamentos SET nome = :nome, quantidade = :quantidade, estado_conservacao = :estado_conservacao WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome' => $nome, 'quantidade' => $quantidade, 'estado_conservacao' => $estado_conservacao, 'id' => $id]);
    } else {
        $query = "INSERT INTO equipamentos (nome, quantidade, estado_conservacao) VALUES (:nome, :quantidade, :estado_conservacao)";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome' => $nome, 'quantidade' => $quantidade, 'estado_conservacao' => $estado_conservacao]);
    }
    header("Location: EquipamentosList.php");
    exit;
}
?>

<div class="card shadow-sm max-width-600 mx-auto p-4">
    <h4>Formulário de Equipamento</h4>
    <form method="POST">
        <div class="mb-3"><label class="form-label">Nome *</label><input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required></div>
        <div class="mb-3"><label class="form-label">Quantidade *</label><input type="number" name="quantidade" class="form-control" value="<?php echo htmlspecialchars($quantidade); ?>" required></div>
        <div class="mb-3"><label class="form-label">Estado *</label>
            <select name="estado_conservacao" class="form-select" required>
                <option value="Novo" <?php echo ($estado_conservacao=='Novo')?'selected':''; ?>>Novo</option>
                <option value="Bom" <?php echo ($estado_conservacao=='Bom')?'selected':''; ?>>Bom</option>
                <option value="Manutenção" <?php echo ($estado_conservacao=='Manutenção')?'selected':''; ?>>Manutenção</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="EquipamentosList.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>