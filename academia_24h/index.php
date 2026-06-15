<?php 
// include_once com __DIR__ garante que o PHP encontra o ficheiro a partir da localização física exata no disco
include_once __DIR__ . '/header.php'; 
?>

<div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
    <div class="container-fluid py-4">
        <h1 class="display-5 fw-bold text-dark">Centro de Formação AtletaPro</h1>
        <p class="col-md-10 fs-5 text-muted">Gestão integrada e lapidação de novos talentos do esporte nacional. Controle infraestruturas, planos de incentivos e modalidades desportivas de alto rendimento.</p>
    </div>
</div>

<div class="row text-center">
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <i class="fa-solid fa-screwdriver-wrench fa-3x text-warning mb-3"></i>
                <h5>Equipamentos</h5>
                <a href="equipamentos/EquipamentosList.php" class="btn btn-primary btn-sm">Acessar Módulo</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <i class="fa-solid fa-id-card-alt fa-3x text-success mb-3"></i>
                <h5>Planos & Bolsas</h5>
                <a href="planos/PlanoList.php" class="btn btn-primary btn-sm">Acessar Módulo</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <i class="fa-solid fa-person-running fa-3x text-danger mb-3"></i>
                <h5>Modalidades</h5>
                <a href="servicos/ServicoList.php" class="btn btn-primary btn-sm">Acessar Módulo</a>
            </div>
        </div>
    </div>
</div>

<?php 
// Inclui o rodapé unificado fechando a estrutura HTML da página
include_once __DIR__ . '/footer.php'; 
?>