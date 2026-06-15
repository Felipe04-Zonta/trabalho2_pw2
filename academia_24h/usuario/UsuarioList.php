<?php 
include_once __DIR__ . '/../db.class.php';
include_once __DIR__ . '/../header.php';

$database = new Database(); $db = $database->getConnection();
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';

if(!empty($busca)) {
    $query = "SELECT id, nome, telefone, email, login FROM usuario WHERE nome LIKE :busca ORDER BY nome ASC";
    $stmt = $db->prepare($query); $stmt->execute(['busca' => "%$busca%"]);
} else {
    $query = "SELECT id, nome, telefone, email, login FROM usuario ORDER BY nome ASC";
    $stmt = $db->prepare($query); $stmt->execute();
}
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa-solid fa-users"></i> Administradores do Sistema</h2>
    <a href="UsuarioForm.php" class="btn btn-success btn-sm">Novo Administrador</a>
</div>
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-10"><input type="text" name="busca" class="form-control" placeholder="Buscar administrador por nome..." value="<?php echo htmlspecialchars($busca); ?>"></div>
    <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Pesquisar</button></div>
</form>
<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table class="table table-hover">
        <thead class="table-dark"><tr><th>#</th><th>Nome</th><th>Telefone</th><th>Email</th><th>Login</th><th class="text-center">Ações</th></tr></thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><strong><?php echo $row['nome']; ?></strong></td>
                    <td><?php echo $row['telefone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><span class="badge bg-secondary"><?php echo $row['login']; ?></span></td>
                    <td class="text-center">
                        <a href="UsuarioForm.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></a>
                        <a href="UsuarioDelete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja revogar as credenciais deste administrador?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include_once __DIR__ . '/../footer.php'; ?>