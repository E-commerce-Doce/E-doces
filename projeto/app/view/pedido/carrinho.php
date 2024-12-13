<?php require_once(__DIR__ . "/../include/header.php"); ?>
<?php require_once(__DIR__ . "/../include/menu.php"); ?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/carrinho.css">

<div class="container mt-5">
    <?php if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0): ?>
        <div class="alert alert-warning" role="alert">
            Seu carrinho está vazio. <a href="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=listLojas" class="btn btn-primary btn-sm">Escolha uma loja</a>
        </div>
        <?php exit(); ?>
    <?php endif; ?>

    <div class="row">
        <!-- Área de Produtos -->
        <div class="col-md-7 mb-4">
            <div class="itens-carrinho p-3">
                <h2>Carrinho de Compras</h2>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['carrinho'] as $doce): ?>
                    <?php $subtotal = $doce['preco'] * $doce['quantidade']; ?>
                    <?php $total += $subtotal; ?>
                    <div class="item-carrinho d-flex mb-3 border rounded p-2 align-items-center">
                        <img src="<?= URL_ARQUIVOS . "/" . $doce['imagem'] ?? ''; ?>" alt="<?= htmlspecialchars($doce['nome']); ?>" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h5><?= htmlspecialchars($doce['nome']); ?></h5>
                            <p>Preço: R$ <?= number_format($doce['preco'], 2, ',', '.'); ?></p>
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-outline-danger btn-sm me-2" onclick="alterarQuantidade('menos', <?= $doce['id'] ?>)">-</button>
                                <span id="quantidade-<?= $doce['id'] ?>" class="px-3 border bg-light rounded"><?= (int)$doce['quantidade']; ?></span>
                                <button type="button" class="btn btn-outline-success btn-sm ms-2" onclick="alterarQuantidade('mais', <?= $doce['id'] ?>)">+</button>
                            </div>
                            <p id="subtotal-<?= $doce['id'] ?>" data-preco="<?= $doce['preco'] ?>" class="mt-2">
                                <strong>Subtotal: R$ <?= number_format($subtotal, 2, ',', '.'); ?></strong>
                            </p>
                        </div>
                        <a href="<?= BASEURL ?>/controller/CarrinhoController.php?action=deleteDoce&idDoce=<?= $doce['id'] ?>" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
                <h4 id="total-carrinho" class="mt-3 text-end">Total: R$ <?= number_format($total, 2, ',', '.'); ?></h4>
                <div class="d-flex justify-content-between mt-3">
                    <a href="<?= BASEURL ?>/controller/CarrinhoController.php?action=clearCarrinho" class="btn btn-danger">Limpar Carrinho</a>
                    <a href="<?= BASEURL ?>/controller/PedidoController.php?action=listProdutos&idConfeiteiro=<?= $_SESSION['carrinhoIdConfeiteiro'] ?>" class="btn btn-secondary">Voltar à Loja</a>
                </div>
            </div>
        </div>

        <!-- Área de Resumo -->
        <div class="col-md-5 mb-4">
            <div class="resumo-pedido p-3 bg-light rounded shadow-sm">
                <h3>Resumo</h3>
                <ul class="list-group mb-3">
                    <?php foreach ($_SESSION['carrinho'] as $doce): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($doce['nome']); ?>
                            <span>R$ <?= number_format($doce['preco'], 2, ',', '.'); ?></span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Total</strong>
                        <strong>R$ <?= number_format($total, 2, ',', '.'); ?></strong>
                    </li>
                </ul>

                <div class="mb-3">
                    <label for="opcaoEntrega" class="form-label">Retirada na loja?</label>
                    <select id="opcaoEntrega" class="form-select" onchange="mostrarEnderecos()">
                        <option value="">Selecione</option>
                        <option value="DELIVERY">Entrega</option>
                        <option value="RETIRADA">Retirada</option>
                    </select>
                </div>

                <div id="enderecosContainer" style="display: none;">
                    <!-- Endereços renderizados via JavaScript -->
                </div>

                <div class="mb-3">
                    <h4>Forma de pagamento</h4>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="pagamento" id="pagamentoDinheiro" value="dinheiro">
                        <label for="pagamentoDinheiro" class="form-check-label">Dinheiro</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="pagamento" id="pagamentoPix" value="pix">
                        <label for="pagamentoPix" class="form-check-label">Pix</label>
                    </div>
                </div>

                <button class="btn btn-primary w-100">Finalizar Compra</button>
            </div>
        </div>
    </div>
</div>

<script>
    function alterarQuantidade(acao, idDoce) {
        const quantidadeSpan = document.getElementById(`quantidade-${idDoce}`);
        const subtotalElement = document.getElementById(`subtotal-${idDoce}`);
        const preco = parseFloat(subtotalElement.getAttribute('data-preco'));
        const totalElement = document.getElementById('total-carrinho');

        let quantidade = parseInt(quantidadeSpan.textContent);

        // Atualiza quantidade localmente
        if (acao === 'mais') {
            quantidade++;
        } else if (acao === 'menos' && quantidade > 1) {
            quantidade--;
        } else {
            return; // Não permite quantidade menor que 1
        }

        // Enviar requisição AJAX para o servidor
        if (!idDoce || quantidade < 1) {
            console.error('Dados inválidos para atualizar a quantidade.');
            return;
        }

        fetch(`<?= BASEURL ?>/controller/CarrinhoController.php?action=updateQuantidade`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    idDoce,
                    quantidade
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Quantidade atualizada com sucesso.');
                } else {
                    console.error('Erro ao atualizar:', data.msg);
                }
            })
            .catch(error => console.error('Erro:', error));

        function mostrarEnderecos() {
            const opcao = document.getElementById('opcaoEntrega').value;
            const container = document.getElementById('enderecosContainer');

            if (opcao === 'DELIVERY') {
                fetch('<?php echo BASEURL; ?>/controller/PedidoController.php?action=exibirEnderecos')
                    .then(response => response.text())
                    .then(data => {
                        container.innerHTML = data.includes('Nenhum endereço cadastrado') ?
                            `<p>Nenhum endereço cadastrado. <a href='<?php echo BASEURL; ?>/controller/EnderecoController.php?action=create'>Cadastre um endereço</a></p>` :
                            data;
                        container.style.display = 'block';
                    });
            } else {
                container.style.display = 'none';
            }

        }
    }
</script>