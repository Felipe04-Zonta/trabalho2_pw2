<?php 
include '../header.php'; 
include '../db.class.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$nome_servico = ''; $categoria_esporte = ''; $professor_responsavel = '';

if(!empty($id)) {
    $query = "SELECT * FROM servicos WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute(['id' => $id]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome_servico = $row['nome_servico'];
        $categoria_esporte = $row['categoria_esporte'];
        $professor_responsavel = $row['professor_responsavel'];
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_servico = $_POST['nome_servico'];
    $categoria_esporte = $_POST['categoria_esporte'];
    $professor_responsavel = $_POST['professor_responsavel'];

    if(!empty($id)) {
        $query = "UPDATE servicos SET nome_servico = :nome_servico, categoria_esporte = :categoria_esporte, professor_responsavel = :professor_responsavel WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome_servico' => $nome_servico, 'categoria_esporte' => $categoria_esporte, 'professor_responsavel' => $professor_responsavel, 'id' => $id]);
    } else {
        $query = "INSERT INTO servicos (nome_servico, categoria_esporte, professor_responsavel) VALUES (:nome_servico, :categoria_esporte, :professor_responsavel)";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome_servico' => $nome_servico, 'categoria_esporte' => $categoria_esporte, 'professor_responsavel' => $professor_responsavel]);
    }
    echo "<script>window.location.href='ServicoList.php';</script>";
}
?>

<div class="card shadow-sm max-width-600 mx-auto">
    <div class="card-header bg-danger text-white">
        <h4 class="mb-0"><i class="fa-solid fa-medal"></i> Configurar Modalidade Esportiva</h4>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome da Modalidade *</label>
                <input type="text" name="nome_servico" class="form-control" value="<?php echo htmlspecialchars($nome_servico); ?>" required placeholder="Ex: Treinamento Funcional de Sprint">
            </div>
            <div class="mb-3">
                <label class="form-label">Categoria do Esporte *</label>
                <input type="text" name="categoria_esporte" class="form-control" value="<?php echo htmlspecialchars($categoria_esporte); ?>" required placeholder="Ex: Atletismo / Futebol / Natação">
            </div>
            <div class="mb-3">
                <label class="form-label">Técnico / Professor Responsável *</label>
                <input type="text" name="professor_responsavel" class="form-control" value="<?php echo htmlspecialchars($professor_responsavel); ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="ServicoList.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            </div>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>