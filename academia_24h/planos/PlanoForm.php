<?php 
include '../header.php'; 
include '../db.class.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$nome_plano = ''; $descricao = ''; $valor = '';

if(!empty($id)) {
    $query = "SELECT * FROM planos WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute(['id' => $id]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome_plano = $row['nome_plano'];
        $descricao = $row['descricao'];
        $valor = $row['valor'];
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_plano = $_POST['nome_plano'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];

    if(!empty($id)) {
        $query = "UPDATE planos SET nome_plano = :nome_plano, descricao = :descricao, valor = :valor WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome_plano' => $nome_plano, 'descricao' => $descricao, 'valor' => $valor, 'id' => $id]);
    } else {
        $query = "INSERT INTO planos (nome_plano, descricao, valor) VALUES (:nome_plano, :descricao, :valor)";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome_plano' => $nome_plano, 'descricao' => $descricao, 'valor' => $valor]);
    }
    echo "<script>window.location.href='PlanoList.php';</script>";
}
?>

<div class="card shadow-sm max-width-600 mx-auto">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0"><i class="fa-solid fa-id-card-alt"></i> Cadastrar/Editar Plano</h4>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome do Plano *</label>
                <input type="text" name="nome_plano" class="form-control" value="<?php echo htmlspecialchars($nome_plano); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição / Benefícios *</label>
                <textarea name="descricao" class="form-control" rows="3" required><?php echo htmlspecialchars($descricao); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Mensalidade (R$) *</label>
                <input type="number" step="0.01" name="valor" class="form-control" value="<?php echo htmlspecialchars($valor); ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="PlanoList.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Salvar Plano</button>
            </div>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>