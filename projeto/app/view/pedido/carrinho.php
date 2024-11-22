<?php

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/carrinho.css">
<?php
    
//session_start();

// Verifica se o carrinho existe e não está vazio
if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0) {
    echo "<div class='container mt-5'><h2>Seu carrinho está vazio.</h2>";
    echo '<a href="/ProjetoIntegrador/E-doces/projeto/finalizarCompra.php" class="btn btn-primary mt-3">Voltar para home</a></div>';
    exit();
}
?>

<div class="container mt-5">
    <h2>Carrinho de Compras</h2>

    <?php
    $total = 0;

    // Itera sobre os produtos no carrinho
    foreach ($_SESSION['carrinho'] as $produto) {
        $subtotal = $produto['preco'] * $produto['quantidade'];
        $total += $subtotal;
    ?>
        <div class="cart-item">
            <!-- Verifica se a imagem existe antes de exibi-la -->
            <img src="<?= URL_ARQUIVOS . "/" . $produto['imagem'] ?? ''; ?>" alt="<?= htmlspecialchars($produto['nome']); ?>">
            <div class="product-details">
                <p><strong><?= htmlspecialchars($produto['nome']); ?></strong></p>
                <p>Preço: R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></p>
                <p>Quantidade: <?= (int) $produto['quantidade']; ?></p>
                <p><strong>Subtotal: R$ <?= number_format($subtotal, 2, ',', '.'); ?></strong></p>
            </div>
        </div>
    <?php } ?>

    <!-- Total do Carrinho -->
    <div class="total">
        <p>Total: R$ <?= number_format($total, 2, ',', '.'); ?></p>
    </div>

    <!-- Botão para finalizar compra 
    <form action="/ProjetoIntegrador/E-doces/projeto/app/controller/FinalizarCompraController.php" method="POST">
        <button type="submit" class="btn-finalizar">Finalizar Compra</button>
    </form>-->

    <!-- Botão para voltar à loja -->
    <a href="<?= BASEURL ?>/controller/PedidoController.php?action=listProdutos&idConfeiteiro=1" class="btn btn-secondary mt-3">
        Continuar comprando
    </a>
</div>

