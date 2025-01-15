<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../dao/DoceDAO.php");
require_once(__DIR__ . "/../dao/EnderecoDAO.php");
require_once(__DIR__ . "/../dao/PedidoDAO.php");
require_once(__DIR__ . "/../dao/PedidoDoceDAO.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/StatusPedido.php");
require_once(__DIR__ . "/../model/enum/TipoEntrega.php");
require_once(__DIR__ . "/../service/PedidoService.php");
require_once(__DIR__ . "/../service/PagamentoService.php");
require_once(__DIR__ . "/../service/ArquivoService.php");


class PedidoController extends Controller
{
    private PedidoDAO $pedidoDao;
    private PedidoDoceDAO $pedidoDoceDao;
    private DoceDAO $doceDao;
    private ConfeiteiroDAO $confeiteiroDao;
    private EnderecoDAO $enderecoDao;
    private Usuario $usuario;
    private UsuarioDAO $usuarioDao;
    private PedidoService $pedidoService;
    private PagamentoService $pagamentoService;
    private ArquivoService $arquivoService;

    public function __construct()
    {
        if (! $this->usuarioLogado())
            exit;

        $this->pedidoDao = new PedidoDAO();
        $this->pedidoDoceDao = new PedidoDoceDAO();
        $this->doceDao = new DoceDAO();
        $this->confeiteiroDao = new ConfeiteiroDAO();
        $this->usuario = new Usuario();
        $this->enderecoDao = new EnderecoDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->pedidoService = new PedidoService();
        $this->pagamentoService = new PagamentoService();
        $this->arquivoService = new ArquivoService();

        $this->handleAction();
    }

    protected function listProdutos(string $msgErro = "", string $msgSucesso = "")
    {
        $idConfeiteiro = 0;
        if (isset($_GET["idConfeiteiro"]))
            $idConfeiteiro = $_GET["idConfeiteiro"];

        if (!$idConfeiteiro) {
            echo "Loja inválida!";
            exit;
        }

        $doces = $this->doceDao->listPorConfeiteiro($idConfeiteiro);
        $dados["lista"] = $doces;

        $this->loadView("pedido/produtos.php", $dados);
    }

    protected function descProduto(string $msgErro = "", string $msgSucesso = "")
    {
        $idDoce = 0;
        if (isset($_GET["idDoces"]))
            $idDoce = $_GET["idDoces"];

        if (!$idDoce) {
            echo "Doce não encontrado!";
            exit;
        }

        $erro = 0;
        if (isset($_GET['erro']))
            $erro = $_GET['erro'];

        if ($erro)
            $msgErro = "Você não pode adicionar doces de diferentes confeiteiros ao carrinho!";

        $doce = $this->doceDao->findByIdCompleto($idDoce);
        $dados["doce"] = $doce;

        $this->loadView("pedido/descProdutos.php", $dados, $msgErro);
    }

    protected function exibirEnderecos()
    {
        $idUsuario = $this->getIdUsuarioLogado();
        $enderecos = $this->enderecoDao->list($idUsuario);

        if (empty($enderecos)) {
            echo "<p>Nenhum endereço cadastrado. <a href='" . BASEURL . "/view/endereco/formEndereço.php'>Cadastre um endereço</a></p>";
        } else {
            foreach ($enderecos as $endereco) {
                echo "<label><input type='radio' name='endereco_selecionado' value='" . $endereco->getIdEndereco() . "'> " . htmlspecialchars($endereco->getNomeLogradouro() . ", " . $endereco->getNumero()) . "</label><br>";
            }
        }
    }

    public function finalizarPedido()
    {
        // Verificar se o carrinho não está vazio
        if (empty($_SESSION['carrinho'])) {
            header("Location: " . BASEURL . "/controller/ConfeiteiroController.php?action=listLojas");
            exit();
        }

        // Obter os dados do pedido
        $pedido = $this->createPedido();

        // Validar os dados
        $erros = $this->pedidoService->validarDados($pedido);

        if (empty($erros)) {
            // Persistir o pedido no banco
            try {
                $idPedido = $this->pedidoDao->insert($pedido);

                if ($idPedido) {
                    // Inserir os itens do pedido
                    $this->insertItensDoPedido($idPedido);
                    // Finalizar o carrinho
                    unset($_SESSION['carrinho']);
                    unset($_SESSION['carrinhoIdConfeiteiro']);

                    // Redirecionar para acompanhar o status do pedido
                    header("Location: " . BASEURL . "/controller/PedidoController.php?action=acompanharStatus&idPedido=" . $idPedido);
                    exit();
                }
            } catch (PDOException $e) {
                // Caso ocorra um erro ao inserir o pedido
                $erros = array("Erro ao salvar o pedido na base de dados: " . $e->getMessage());
            }
        }
        // Se houver erros, exibir na página
        $msgsErro = implode('<br>', $erros);
        $this->loadView("pedido/carrinho.php", [], $msgsErro);
        exit();
    }

    // método para criar o objeto Pedido
    protected function createPedido()
    {
        $pedido = new Pedido();
        $pedido->setFormaPagamento($_POST['pagamento'] ?? null);
        $pedido->setStatus(Status::RECEBIDO);
        $pedido->setTipoEntrega($_POST['tipoEntrega'] ?? TipoEntrega::RETIRADA);
        $pedido->setConfeiteiro(new Confeiteiro($_SESSION['carrinhoIdConfeiteiro']));
        $pedido->setHorario(date('Y-m-d H:i:s'));
        $pedido->setUsuario(new Usuario($_SESSION['usuarioLogadoId']));

        if ($_POST['tipoEntrega'] == TipoEntrega::DELIVERY && isset($_POST['endereco_selecionado'])) {
            $pedido->setEndereco(new Endereco($_POST['endereco_selecionado']));
        }

        return $pedido;
    }

    // método para inserir os itens do pedido
    protected function insertItensDoPedido($idPedido)
    {
        $itens = $_SESSION['carrinho'];
        foreach ($itens as $doce) {
            $pedidoDoce = new PedidoDoce();
            $pedidoDoce->setPedido(new Pedido($idPedido));
            $pedidoDoce->setDoce(new Doce($doce['id']));
            $pedidoDoce->setQuantidade($doce['quantidade']);
            $pedidoDoce->setValorUnitario($doce['preco']);
            $pedidoDoce->setValorTotal($doce['preco'] * $doce['quantidade']);
            $this->pedidoDoceDao->insert($pedidoDoce);
        }
    }

    // Exibe a lista de pedidos com detalhes (na mesma página)
    protected function listPedidos(string $msgErro = "", string $msgSucesso = "")
    {
        // Chama o DAO para pegar todos os pedidos
        $pedidos = $this->pedidoDao->listPedidosCliente($this->getIdUsuarioLogado());
        $dados["lista"] = $pedidos;

        // Exibe os pedidos e também detalhes de um pedido
        include_once(__DIR__ . "/../view/pedido/historicoPedidos.php");
    }

    protected function realizarPagamento()
    {
        // Captura o ID do pedido
        $dados['idPedido'] = isset($_POST['idPedido']) ? (int)$_POST['idPedido'] : 0;
    
        // Captura os dados do formulário
        $nomeComprovante = trim($_POST['nomeComprovante'] ?? '');
        $comprovanteImg = $_FILES['comprovanteImagem'] ?? [];
        $comprovanteImgAtual = $_POST['comprovanteImagemAtual'] ?? null;
    
        // Cria o objeto PedidoDoce com os dados fornecidos
        $pedidoPagamento = new PedidoDoce();
        $pedidoPagamento->setNomeComprovante($nomeComprovante);
        $pedidoPagamento->setComprovante($comprovanteImgAtual);
    
        // Cria o objeto Pedido com o ID do pedido
        $pedido = new Pedido();
        $pedido->setIdPedido($dados['idPedido']);
        $pedidoPagamento->setPedido($pedido);
    
        // Valida os dados
        $erros = $this->pagamentoService->validarDados($pedidoPagamento, $comprovanteImgAtual, $comprovanteImg);
    
        // Verifica se não há erros e se o arquivo foi enviado
        if (empty($erros) && $comprovanteImg['size'] > 0) {
            // Salva o comprovante
            $caminhoComprovante = $this->arquivoService->salvarArquivo($comprovanteImg);
    
            if ($caminhoComprovante) {
                $pedidoPagamento->setComprovante($caminhoComprovante);
    
                // Remove o comprovante anterior, se houver
                if ($comprovanteImgAtual) {
                    $this->arquivoService->removerArquivo($comprovanteImgAtual);
                }
            } else {
                $erros[] = "Erro ao salvar o comprovante.";
            }
        }
    
        // Persistência no banco de dados
        if (empty($erros)) {
            try {
                // Atualiza o banco de dados com as informações do pagamento
                $this->pedidoDoceDao->makePagamento($pedidoPagamento);
    
                // Redireciona para acompanhar o status do pedido
                header("Location: " . BASEURL . "/controller/PedidoController.php?action=acompanharStatus&idPedido=" .  $dados['idPedido']);
                exit;
            } catch (PDOException $e) {
                // Captura erros de banco de dados
                $erros[] = "Erro ao salvar o pedido no banco de dados: " . $e->getMessage();
            }
        }
    
        // Exibe os erros se houver
        if (!empty($erros)) {
            $msgsErro = implode("<br>", $erros);
            $this->loadView("pedido/pagamento.php", $dados, $msgsErro);
        }
    }

     //Método create
     protected function createPagamento()
     {
         //echo "Chamou o método create!";
         $idPedido = 0;
         if(isset($_GET["idPedido"]))
             $idPedido = $_GET["idPedido"];
 
         if(! $idPedido) {
             echo "Pedido inválido";
             exit;
         }
 
         $dados["idPedido"] = $idPedido;
         $this->loadView("pedido/pagamento.php", $dados);
     }
    


    protected function alterarStatus(string $msgErro = "", string $msgSucesso = "")
    {
        session_start();

        // Obtém os valores do pedido e novo status
        $idPedido = $_POST['idPedido'] ?? null;
        $novoStatus = $_POST['novoStatus'] ?? null;

        // Verifica se os valores obrigatórios foram fornecidos
        if (!$idPedido || !$novoStatus) {
            $_SESSION['msgErro'] = "Erro: ID do pedido ou novo status não foram informados.";
            header("Location: " . BASEURL . "/controller/ConfeiteiroController.php?action=listPedidos");
            exit();
        }

        // Busca o pedido pelo ID para obter detalhes do cliente
        $pedido = $this->pedidoDao->findByIdCompleto($idPedido);


        // Obtém o nome do cliente a partir do pedido
        $nomeCliente = $pedido->getUsuario()->getNome();
        $numero = $pedido->getIdPedido();
        // Atualiza o status do pedido no banco de dados
        $this->pedidoDao->updateStatus($idPedido, $novoStatus);

        // Define a mensagem de sucesso na sessão
        $_SESSION['msgSucesso'] = "Status do pedido  #$numero de $nomeCliente foi atualizado para |$novoStatus| com sucesso.";

        // Redireciona para a página de listagem de pedidos
        header("Location: " . BASEURL . "/controller/ConfeiteiroController.php?action=listPedidos");
        exit();
    }

    // PedidoController.php
    protected function acompanharStatus()
    {
        // Verifica se o idPedido foi passado via GET
        if (isset($_GET['idPedido'])) { 
            $pedidoId = $_GET['idPedido'];

            // Supondo que o DAO tenha um método findById que retorna todos os dados do pedido
            $pedido = $this->pedidoDao->findByIdCompleto($pedidoId); // Obtém o pedido com todos os dados

            // Verifica se o pedido foi encontrado
            if ($pedido) {
                $status = $pedido->getStatus(); // Obtém o status do pedido
                $formaPagamento = $pedido->getFormaPagamento(); // Obtém a forma de pagamento do pedido            


                // Passa o status, a forma de pagamento e a mensagem de sucesso para a view
                require_once(__DIR__ . '/../view/pedido/status.php');
            } else {
                echo "Pedido não encontrado.";
            }
        } else {
            echo "ID do pedido não fornecido.";
        }
    }
}

new PedidoController();
