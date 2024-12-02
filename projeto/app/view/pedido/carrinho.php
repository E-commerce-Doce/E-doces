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

    <!-- <?php print_r($dados['confeiteiro']) ?> -->

    <div class="row">
        <!-- Área de Produtos -->
        <div class="col-md-7 mb-4">
            <div class="itens-carrinho p-3  ">
                <h2>Carrinho de Compras</h2>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['carrinho'] as $doce): ?>
                    <?php $subtotal = $doce['preco'] * $doce['quantidade']; ?>
                    <?php $total += $subtotal; ?>
                    <div class="item-carrinho d-flex mb-3 border-bottom pb-2">
                        <img src="<?= URL_ARQUIVOS . "/" . $doce['imagem'] ?? ''; ?>" alt="<?= htmlspecialchars($doce['nome']); ?>" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="m-3">
                            <h4><?= htmlspecialchars($doce['nome']); ?></h4>
                            <p>Preço: R$ <?= number_format($doce['preco'], 2, ',', '.'); ?></p>
                            <p>Quantidade: <?= (int) $doce['quantidade']; ?></p>
                            <p><strong>Subtotal: R$ <?= number_format($subtotal, 2, ',', '.'); ?></strong></p>
                            <a href="<?= BASEURL ?>/controller/CarrinhoController.php?action=deleteDoce&idDoce=<?= $doce['id'] ?>" class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <h4 class="mt-3 text-end">Total: R$ <?= number_format($total, 2, ',', '.'); ?></h4>

                <!-- Botão para limpar o carrinho -->
                <a href="<?= BASEURL ?>/controller/CarrinhoController.php?action=clearCarrinho" type="submit" class="btn btn-danger">Limpar Carrinho</a>

                <!-- Botão para voltar à loja -->
                <a class="btn btn-danger" href="<?= BASEURL ?>/controller/PedidoController.php?action=listProdutos&idConfeiteiro=<?= $_SESSION['carrinhoIdConfeiteiro'] ?>">
    Voltar
</a>


            </div>
        </div>

        <!-- Área de Resumo -->
        <div class="col-md-5 mb-4">
            <div class="resumo-pedido p-3">
                <h3>Resumo</h3>
                <?php foreach ($_SESSION['carrinho'] as $doce): ?>
                    <p><?= htmlspecialchars($doce['nome']); ?>: R$ <?= number_format($doce['preco'], 2, ',', '.'); ?></p>
                <?php endforeach; ?>
                <p><strong>Total: R$ <?= number_format($total, 2, ',', '.'); ?></strong></p>

                <h4>Retirada na loja?</h4>
                <select id="opcaoEntrega" onchange="mostrarEnderecos()">
                    <option value="">Selecione</option>
                    <option value="DELIVERY">Entrega</option>
                    <option value="RETIRADA">Retirada</option>
                </select>

                <div id="enderecosContainer" style="display: none;">
                    <!-- Os endereços serão exibidos aqui -->
                </div>

                <h4>Forma de pagamento</h4>
                <div>
                    <label><input type="radio" name="pagamento" value="dinheiro"> Dinheiro</label>
                    <label><input type="radio" name="pagamento" value="pix"> Pix</label>
                </div>

                <button class="btn btn-light w-100 mt-3">Finalizar Compra</button>
            </div>
        </div>
    </div>
</div>

</div>
<script>
    function mostrarEnderecos() {
        const opcao = document.getElementById('opcaoEntrega').value;
        const container = document.getElementById('enderecosContainer');
        const formEndereco = document.getElementById('formEndereco');
        const inputIdEndereco = document.getElementById('idEndereco');

        if (opcao === 'DELIVERY') {
            fetch('<?php echo BASEURL; ?>/controller/PedidoController.php?action=exibirEnderecos')
                .then(response => response.text())
                .then(data => {
                    if (data.includes('Nenhum endereço cadastrado')) {
                        container.innerHTML = `
                        <p>Nenhum endereço cadastrado. <a href='<?php echo BASEURL; ?>/controller/EnderecoController.php?action=create'>Cadastre um endereço</a></p>
                    `;

                        container.style.display = 'block';
                        formEndereco.style.display = 'none';
                    } else {
                        // Se tiver endereço cadastrado, mostra os dados

                        container.innerHTML = data;
                        container.style.display = 'block';
                        formEndereco.style.display = 'none';

                        // Adiciona evento de seleção para os rádios de endereço
                        document.querySelectorAll('input[name="endereco_selecionado"]').forEach((input) => {
                            input.addEventListener('change', function() {
                                inputIdEndereco.value = this.value;
                                formEndereco.style.display = 'block'; // Mostra o formulário após a seleção
                            });
                        });
                    }
                })
            // .catch(error => {
            //     console.error('Erro ao buscar os endereços:', error);
            //     alert('Erro ao carregar os endereços. Tente novamente mais tarde.');
            // });
        } else {
            // Se a opção de entrega não for 'DELIVERY', esconde tanto o container quanto o formulário de endereço
            container.style.display = 'none';
            formEndereco.style.display = 'none'; // Esconde o formulário se não for entrega
        }
    }
</script>