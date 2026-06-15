<?php 
include_once __DIR__ . '/header.php'; 
?>

<div class="p-4 p-md-5 mb-4 rounded-4 bg-white shadow-sm border border-light">
    <div class="row align-items-center">
        <div class="col-md-9">
            <h1 class="fw-bold text-dark">Painel Executivo AtletaPro</h1>
            <p class="text-muted fs-5 mb-0">Central integrada de monitoramento operacional. Controle recursos materiais, infraestrutura desportiva de alto nível e as concessões de bolsas de treinamento de forma segura.</p>
        </div>
        <div class="col-md-3 text-end d-none d-md-block">
            <i class="fa-solid fa-cubes-stacked fa-5x text-body-tertiary"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card card-modern p-3 text-center h-100 border border-light">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-3 d-inline-block p-3 bg-warning bg-opacity-10 rounded-4 text-warning">
                        <i class="fa-solid fa-screwdriver-wrench fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Equipamentos</h5>
                    <p class="text-muted small">Controle de inventário físico, contagem total de maquinários e vistorias de manutenção.</p>
                </div>
                <a href="equipamentos/EquipamentosList.php" class="btn btn-sm btn-outline-primary rounded-pill px-4 align-self-center mt-3">Acessar Listagem</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card card-modern p-3 text-center h-100 border border-light">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-3 d-inline-block p-3 bg-success bg-opacity-10 rounded-4 text-success">
                        <i class="fa-solid fa-address-card fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Planos & Mensalidades</h5>
                    <p class="text-muted small">Configuração de bolsas públicas, taxas de filiação e planos corporativos de rendimento.</p>
                </div>
                <a href="planos/PlanoList.php" class="btn btn-sm btn-outline-primary rounded-pill px-4 align-self-center mt-3">Acessar Listagem</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card card-modern p-3 text-center h-100 border border-light">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-3 d-inline-block p-3 bg-danger bg-opacity-10 rounded-4 text-danger">
                        <i class="fa-solid fa-person-running fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Modalidades Ofertadas</h5>
                    <p class="text-muted small">Vínculo de professores de educação física especialistas e controle de treinos e categorias.</p>
                </div>
                <a href="servicos/ServicoList.php" class="btn btn-sm btn-outline-primary rounded-pill px-4 align-self-center mt-3">Acessar Listagem</a>
            </div>
        </div>
    </div>
</div>

<?php 
include_once __DIR__ . '/footer.php'; 
?>