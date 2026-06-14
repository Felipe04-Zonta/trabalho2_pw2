<?php 
include '../header.php'; 
include '../db.class.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$nome = ''; $quantidade = ''; $estado_conservacao = '';

// Se for edição, busca os dados atuais do banco
if(!empty($id)) {
    $query = "SELECT * FROM equipamentos WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute(['id' => $id]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome = $row['nome'];
        $quantidade = $row['quantidade'];
        $estado_conservacao = $row['estado_conservacao'];
    }
}

// Processamento do formulário (Salvar)
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $estado_conservacao = $_POST['estado_conservacao'];

    if(!empty($id)) {
        // UPDATE
        $query = "UPDATE equipamentos SET nome = :nome, quantidade = :quantidade, estado_conservacao = :estado_conservacao WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome' => $nome, 'quantidade' => $quantidade, 'estado_conservacao' => $estado_conservacao, 'id' => $id]);
    } else {
        // INSERT
        $query = "INSERT INTO equipamentos (nome, quantidade, estado_conservacao) VALUES (:nome, :quantidade, :estado_conservacao)";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome' => $nome, 'quantidade' => $quantidade, 'estado_conservacao' => $estado_conservacao]);
    }
    echo "<script>window.location.href='EquipamentosList.php';</script>";
}
?>

<div class="card shadow-sm max-width-600 mx-auto">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="fa-solid fa-pen-to-square"></i> Formular que Gerencia Equipamento</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Nome do Equipamento *</label>
                <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantidade *</label>
                <input type="number" name="quantidade" class="form-control" value="<?php echo htmlspecialchars($quantidade); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Estado de Conservação *</label>
                <select name="estado_conservacao" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="Novo" <?php echo ($estado_conservacao == 'Novo') ? 'selected' : ''; ?>>Novo</option>
                    <option value="Bom" <?php echo ($estado_conservacao == 'Bom') ? 'selected' : ''; ?>>Bom</option>
                    <option value="Necessita Manutenção" <?php echo ($estado_conservacao == 'Necessita Manutenção') ? 'selected' : ''; ?>>Necessita Manutenção</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <a href="EquipamentosList.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            </div>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>