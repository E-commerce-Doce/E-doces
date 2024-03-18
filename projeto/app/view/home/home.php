<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?=BASEURL?>/view/home/home.css">

<div class="row mt-3 justify-content-center">
    <div class="col-3 text-center">
        <span class="fonte-grande">Usuários ativos:</span>
        <span class="badge badge-info  fonte-grande"><?= $dados["totalUsuarios"]?></span>
        
        <ul>
    <?php 
    foreach ($dados["listaUsuarios"] as $u) {
        echo "<li>". $u->getNome(). "</li>";
    }
    ?>
        </ul>
    <a href="#" onclick = "usuarios()" class="btn btn-info"> Chamada AJAX</a>
    </div>
</div>


<script src="<?=BASEURL?>/view/home/home.js"></script>
<?php  
require_once(__DIR__ . "/../include/footer.php");
?>