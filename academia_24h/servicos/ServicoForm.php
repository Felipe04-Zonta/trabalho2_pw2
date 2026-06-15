<?php 
include_once __DIR__ . '/../db.class.php';
include_once __DIR__ . '/../header.php';

$database = new Database(); $db = $database->getConnection();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$nome_servico = ''; $categoria_esporte = ''; $professor_responsavel = '';

if(!empty($id)) {
    $query = "SELECT * FROM servicos WHERE id = :id";
    $stmt = $db->prepare($query); $stmt->execute(['id' => $id]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome_servico = $row['nome_servico']; $categoria_esporte = $row['categoria_esporte']; $professor_responsavel = $row['professor_responsavel'];
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_servico = $_POST['nome_servico']; $categoria_esporte = $_POST['categoria_esporte']; $professor_responsavel = $_POST['professor_responsavel'];
    if(!empty($id)) {
        $query = "UPDATE servicos SET nome_servico = :nome_servico, categoria_esporte = :categoria_esporte, professor_responsavel = :professor_responsavel WHERE id = :id";
        $stmt = $db->prepare($query); $stmt->execute(['nome_servico' => $nome_servico, 'categoria_esporte' => $categoria_esporte, 'professor_responsavel' => $professor_responsavel, 'id' => $id]);
    } else {
        $query = "INSERT INTO servicos (nome_servico, categoria_esporte, professor_responsavel) VALUES (:nome_servico, :categoria_esporte, :professor_responsavel)";
        $stmt = $db->prepare($query); $stmt->execute(['nome_servico' => $nome_servico, 'categoria_esporte' => $categoria_esporte, 'professor_responsavel' => $professor_responsavel]);
    }
    header("Location: ServicoList.php"); exit;
}
?>
<div class="card shadow-sm max-width-600 mx-auto p-4">
    <h4>Gerenciar Modalidade</h4>
    <form method="POST">
        <div class="mb-3"><label class="form-label">Nome da Modalidade *</label><input type="text" name="nome_servico" class="form-control" value="<?php echo htmlspecialchars($nome_servico); ?>" required></div>
        <div class="mb-3"><label class="form-label">Categoria *</label><input type="text" name="categoria_esporte" class="form-control" value="<?php echo htmlspecialchars($categoria_esporte); ?>" required></div>
        <div class="mb-3"><label class="form-label">Professor Responsável *</label><input type="text" name="professor_responsavel" class="form-control" value="<?php echo htmlspecialchars($professor_responsavel); ?>" required></div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="ServicoList.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
<?php include_once __DIR__ . '/../footer.php'; ?>