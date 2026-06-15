<?php 
include_once __DIR__ . '/../db.class.php';
include_once __DIR__ . '/../header.php';

$database = new Database();
$db = $database->getConnection();

// LÓGICA INTELIGENTE DOIS-EM-UM (Cadastro e Edição unificados):
// Verifica se foi passado um ID na barra de endereço (?id=X). Se sim, é uma Edição.
$id = isset($_GET['id']) ? $_GET['id'] : '';
$nome = ''; $quantidade = ''; $estado_conservacao = '';

if(!empty($id)) {
    // Se for uma edição, busca os dados atuais do equipamento para preencher os campos do formulário automaticamente
    $query = "SELECT * FROM equipamentos WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute(['id' => $id]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome = $row['nome']; 
        $quantidade = $row['quantidade']; 
        $estado_conservacao = $row['estado_conservacao'];
    }
}

// Executa este bloco apenas quando o botão "Salvar" for clicado (Envio via POST)
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome']; 
    $quantidade = $_POST['quantidade']; 
    $estado_conservacao = $_POST['estado_conservacao'];

    if(!empty($id)) {
        // Se o ID existia, faz uma operação de UPDATE (Atualização de dados)
        $query = "UPDATE equipamentos SET nome = :nome, quantidade = :quantidade, estado_conservacao = :estado_conservacao WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute(['nome' => $nome, 'quantidade' => $quantidade, 'estado_conservacao' => $estado_conservacao, 'id' => $id]);
    } else {
        // Se o ID estava vazio, faz uma operação de INSERT (Cadastro de novo item)
        $query = "INSERT INTO equipamentos (nome, quantidade, estado_conservacao) VALUES (:nome, :quantidade, :estado_conservacao)";
        $stmt = $db->prepare($query);
        // O uso do prepare() + execute() blinda o código contra ataques de Injeção de SQL (SQL Injection)
        $stmt->execute(['nome' => $nome, 'quantidade' => $quantidade, 'estado_conservacao' => $estado_conservacao]);
    }
    // Redireciona o utilizador de volta para a tabela de listagem atualizada
    header("Location: EquipamentosList.php");
    exit;
}
?>

<div class="card shadow-sm max-width-600 mx-auto p-4 bg-white">
    <h4><i class="fa-solid fa-pen-to-square"></i> Gerenciar Equipamento</h4>
    <hr>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nome do Equipamento *</label>
            <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantidade em Estoque *</label>
            <input type="number" name="quantidade" class="form-control" value="<?php echo htmlspecialchars($quantidade); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado de Conservação *</label>
            <select name="estado_conservacao" class="form-select" required>
                <option value="Novo" <?php echo ($estado_conservacao=='Novo')?'selected':''; ?>>Novo</option>
                <option value="Bom" <?php echo ($estado_conservacao=='Bom')?'selected':''; ?>>Bom</option>
                <option value="Manutenção" <?php echo ($estado_conservacao=='Manutenção')?'selected':''; ?>>Necessita Manutenção</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Salvar Dados</button>
        <a href="EquipamentosList.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>