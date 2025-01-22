<?php require_once(__DIR__ . '/../include/header.php'); ?>
<?php require_once(__DIR__ . '/../include/menu.php'); ?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/carrinho.css">

<div class="col-6 m-3">
    <?php require_once(__DIR__ . "/../include/msg.php"); ?>
</div>

<div class="container mt-5">
    <?php if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0): ?>
        <div class="alert" role="alert">
            <a href="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=listLojas" class="btn btn-primary btn-sm">Escolha uma loja</a>
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
                        <img src="<?= URL_ARQUIVOS . '/' . $doce['imagem'] ?? ''; ?>" alt="<?= htmlspecialchars($doce['nome']); ?>" class="img-thumbnail me-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h5><?= htmlspecialchars($doce['nome']); ?></h5>
                            <p>Preço: R$ <?= number_format($doce['preco'], 2, ',', '.'); ?></p>
                            <div class="d-flex align-items-center quant">
                                <button type="button" class="btn btn-sm me-2" onclick="alterarQuantidade('menos', <?= $doce['id'] ?>)">-</button>
                                <span id="quantidade-<?= $doce['id'] ?>" class="px-3 rounded"><?= (int)$doce['quantidade']; ?></span>
                                <button type="button" class="btn btn-sm ms-2" onclick="alterarQuantidade('mais', <?= $doce['id'] ?>)">+</button>
                            </div>
                            <p id="subtotal-<?= $doce['id'] ?>" data-preco="<?= $doce['preco'] ?>" class="mt-2">
                                <strong>Subtotal: R$ <?= number_format($subtotal, 2, ',', '.'); ?></strong>
                            </p>
                        </div>
                        <a href="<?= BASEURL ?>/controller/CarrinhoController.php?action=deleteDoce&idDoce=<?= $doce['id'] ?>" class="btn btn-sm limpar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
                <h4 id="total-carrinho" class="mt-3 text-end">Total: R$ <?= number_format($total, 2, ',', '.'); ?></h4>
                <div class="d-flex justify-content-between mt-3 botao">
                    <a href="<?= BASEURL ?>/controller/CarrinhoController.php?action=clearCarrinho" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                        </svg>
                    </a>
                    <a href="<?= BASEURL ?>/controller/PedidoController.php?action=listProdutos&idConfeiteiro=<?= $_SESSION['carrinhoIdConfeiteiro'] ?>" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Área de Resumo -->
        <div class="col-md-5 mb-4">
            <div class="resumo-pedido p-3">
                <h3>Resumo</h3>
                <ul class="list-group mb-3">
                    <?php foreach ($_SESSION['carrinho'] as $doce): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($doce['nome']); ?>
                            <span><?= (int)$doce['quantidade']; ?> x R$ <?= number_format($doce['preco'], 2, ',', '.'); ?></span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Total</strong>
                        <strong>R$ <?= number_format($total, 2, ',', '.'); ?></strong>
                    </li>
                </ul>

                <form method="POST" action="<?= BASEURL ?>/controller/PedidoController.php?action=finalizarPedido">

                    <h4>Retirada ou Entrega?</h4>
                    <select class="mb-3" name="tipoEntrega" id="opcaoEntrega" onchange="mostrarEnderecos()">
                        <option value="">Selecione:</option>
                        <option value="RETIRADA">Retirada na loja</option>
                        <option value="DELIVERY">Entrega</option>
                    </select>

                    <div class="ml-3 mb-3" id="enderecosContainer" style="display: none;">
                        <h4>Escolha seu endereço</h4>
                        <div id="enderecosList"></div>
                    </div>

                    <h4>Forma de pagamento</h4>
                    <div class="ml-3 escolha">
                        <label><input type="radio" name="pagamento" value="DINHEIRO" <?= (isset($_POST['pagamento']) && $_POST['pagamento'] === 'DINHEIRO') ? 'checked' : '' ?>> Dinheiro</label><br>
                        <label><input type="radio" name="pagamento" value="PIX" <?= (isset($_POST['pagamento']) && $_POST['pagamento'] === 'PIX') ? 'checked' : '' ?>> Pix</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-3 finalizar">Finalizar Compra</button>
                </form>
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

        // Atualiza a interface localmente
        quantidadeSpan.textContent = quantidade;

        // Calcula o novo subtotal
        const novoSubtotal = preco * quantidade;
        subtotalElement.innerHTML = `<strong>Subtotal: R$ ${novoSubtotal.toFixed(2).replace('.', ',')}</strong>`;

        // Recalcula o total
        let novoTotal = 0;
        document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
            const precoSubtotal = parseFloat(el.textContent.replace('Subtotal: R$ ', '').replace(',', '.'));
            novoTotal += precoSubtotal;
        });
        totalElement.textContent = `Total: R$ ${novoTotal.toFixed(2).replace('.', ',')}`;

        // Atualiza o resumo
        atualizarResumo();

        // Enviar requisição AJAX para atualizar no servidor
        fetch('<?= BASEURL ?>/controller/CarrinhoController.php?action=updateQuantidade', {
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
    }

    function atualizarResumo() {
        const resumoContainer = document.querySelector('.resumo-pedido ul');
        resumoContainer.innerHTML = ''; // Limpa o resumo atual

        let novoTotal = 0;

        // Atualiza o resumo com os itens atuais do carrinho
        document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
            const idDoce = el.id.split('-')[1];
            const quantidade = document.getElementById(`quantidade-${idDoce}`).textContent;
            const preco = parseFloat(el.getAttribute('data-preco'));
            const nome = document.querySelector(`#quantidade-${idDoce}`).closest('.item-carrinho').querySelector('h5').textContent;

            novoTotal += preco * quantidade;

            const listItem = document.createElement('li');
            listItem.className = 'list-group-item d-flex justify-content-between align-items-center resumocolor';
            listItem.innerHTML = `${nome} x${quantidade} <span>R$ ${preco.toFixed(2).replace('.', ',')}</span>`;
            resumoContainer.appendChild(listItem);
        });

        // Adiciona o total atualizado
        const totalItem = document.createElement('li');
        totalItem.className = 'list-group-item d-flex justify-content-between align-items-center resumocolor';
        totalItem.innerHTML = `<strong>Total</strong> <strong>R$ ${novoTotal.toFixed(2).replace('.', ',')}</strong>`;
        resumoContainer.appendChild(totalItem);
    }

    function mostrarEnderecos() {
        const opcao = document.getElementById('opcaoEntrega').value;
        const container = document.getElementById('enderecosContainer');

        if (opcao === 'DELIVERY') {
            fetch('<?= BASEURL ?>/controller/PedidoController.php?action=exibirEnderecos')
                .then(response => response.text())
                .then(data => {
                    if (data.includes('Nenhum endereço cadastrado')) {
                        container.innerHTML = `<p>Nenhum endereço cadastrado. <a href='<?= BASEURL ?>/controller/EnderecoController.php?action=create'>Cadastre um endereço</a></p>`;
                    } else {
                        container.innerHTML = data;
                    }
                    container.style.display = 'block';
                });
        } else {
            container.style.display = 'none';
        }
    }
</script>

<?php require_once(__DIR__ . '/../include/footer2.php'); ?>