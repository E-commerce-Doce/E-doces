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
                    <!-- Imagem da loja -->
                    <img  src="../../../projeto/arquivos/Logo_chapeu.png" class="card-img-top" alt="Imagem da loja">
                    
                    <div class="card-body">
                        <!-- Nome da loja como link para a listagem de produtos -->
                        <h5 class="text-center font-weight-bold" style="font-size:30px; font-family: 'Caveat', cursive;">
                            <a href="<?= BASEURL ?>/controller/PedidoController.php?action=listProdutos&idConfeiteiro=<?= $loja['idConfeiteiro'] ?>" class="text-decoration-none">
                                <?= $loja['nomeLoja'] ?>
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php
require_once(__DIR__ . "/../include/footer2.php");
?>
