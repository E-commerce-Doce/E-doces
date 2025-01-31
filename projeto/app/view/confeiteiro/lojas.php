<?php
#Nome do arquivo: doce/listDoce.php
#Objetivo: interface para listagem dos doces do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container my-5">
    <div class="container my-4">
        <div class="row">
            <?php foreach ($dados['lista'] as $loja): ?>
                <div class="col-md-4 col-sm-6 store-card">
                    <div class="card" style="border: none; background-color: transparent;">
                        <a href="<?= BASEURL ?>/controller/PedidoController.php?action=listProdutos&idConfeiteiro=<?= $loja['idConfeiteiro'] ?>" class="text-decoration-none">
                            <!-- Imagem da loja, se não houver, exibe a logo do chapéu -->
                            <img
                                src="<?= !empty($loja['logo']) ? URL_ARQUIVOS . '//' . $loja['logo'] : BASEURL . '/view/img/Logo_chapeu.png' ?>"
                                alt="Imagem da loja"
                                class="card-img-top"
                                style="<?= !empty($loja['logo']) ? 'border-radius: 50%; height: 350px; width: 350px; object-fit: cover;' : 
                                'border-radius: 40%; height: 350px; width: 350px; object-fit: contain;' ?>">
                            <div class="card-body">
                                <!-- Nome da loja como link para a listagem de produtos -->
                                <h5 class="text-center font-weight-bold" style="font-size:30px; font-family: 'Caveat', cursive;">
                                    <?= $loja['nomeLoja'] ?>
                                </h5>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</div>


<?php
require_once(__DIR__ . "/../include/footer2.php");
?>