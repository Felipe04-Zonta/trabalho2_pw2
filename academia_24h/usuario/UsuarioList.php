<?php 
include '../header.php'; 
include '../db.class.php';

$database = new Database();
$db = $database->getConnection();

// Lógica de Busca funcional para o CRUD de usuários
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
if(!empty($busca)) {
    $query = "SELECT id, nome, telefone, email, login FROM usuario WHERE nome LIKE :busca OR email LIKE :busca ORDER BY nome ASC";
    $stmt = $db->prepare($query);
    $stmt->execute(['busca' => "%$busca%"]);
} else {
    $query = "SELECT id, nome, telefone, email, login ORDER BY nome ASC";
    $stmt = $db->prepare($query);
    $stmt->execute();
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa-solid fa-users-cog"></i> Administradores do Sistema</h2>
    <a href="UsuarioForm.php" class="btn btn-success"><i class="fa-solid fa-user-plus"></i> Novo Usuário</a>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-9">
        <input type="text" name="busca" class="form-control" placeholder="Buscar usuário por nome ou e-mail..." value="<?php echo htmlspecialchars($busca); ?>">
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
    </div>
</form>

<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table class="table table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Login (Usuário)</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if($stmt->rowCount() > 0): ?>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><strong><?php echo $row['nome']; ?></strong></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><span class="badge bg-secondary"><?php echo $row['login']; ?></span></td>
                        <td class="text-center">
                            <a href="UsuarioForm.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-user-pen"></i></a>
                            <a href="UsuarioDelete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover este administrador?')"><i class="fa-solid fa-user-slash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Nenhum usuário encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>