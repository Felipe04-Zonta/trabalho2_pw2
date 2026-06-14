<?php include 'header.php'; ?>

<div class="p-5 mb-4 bg-light rounded-3 shadow-sm border">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold text-dark">Centro de Formação AtletaPro</h1>
        <p class="col-md-8 fs-4">Sistema de Gestão voltado para lapidação e desenvolvimento de novos talentos do esporte nacional. Gerencie infraestrutura, planos de bolsas e modalidades esportivas.</p>
    </div>
</div>

<div class="row text-center">
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <i class="fa-solid fa-screwdriver-wrench fa-3x text-warning mb-3"></i>
                <h5 class="card-title">Equipamentos</h5>
                <p class="card-text">Gerencie os materiais e aparelhos disponíveis para os atletas de alto rendimento.</p>
                <a href="equipamentos/EquipamentosList.php" class="btn btn-primary">Acessar CRUD</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <i class="fa-solid fa-id-card-alt fa-3x text-success mb-3"></i>
                <h5 class="card-title">Planos & Bolsas</h5>
                <p class="card-text">Administre os planos de treinamento e incentivos de patrocínio dos atletas.</p>
                <a href="planos/PlanoList.php" class="btn btn-primary">Acessar CRUD</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <i class="fa-solid fa-medal fa-3x text-danger mb-3"></i>
                <h5 class="card-title">Serviços e Esportes</h5>
                <p class="card-text">Configure as modalidades esportivas ativas e os professores orientadores.</p>
                <a href="servicos/ServicoList.php" class="btn btn-primary">Acessar CRUD</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>