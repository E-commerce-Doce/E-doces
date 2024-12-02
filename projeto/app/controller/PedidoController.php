<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

#Classe controller para Pedidos
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../dao/DoceDAO.php");
require_once(__DIR__ . "/../dao/EnderecoDAO.php");
require_once(__DIR__ . "/../dao/PedidoDAO.php");
require_once(__DIR__ . "/../model/Usuario.php");

class PedidoController extends Controller
{

    private PedidoDAO $pedidoDao;
    private DoceDAO $doceDao;
    private ConfeiteiroDAO $confeiteiroDao;
    private EnderecoDAO $enderecoDao;
    private Usuario $usuario;
    private UsuarioDAO $usuarioDao;


    public function __construct()
    {

        if (! $this->usuarioLogado())
            exit;

        $this->pedidoDao = new PedidoDAO();
        $this->doceDao = new DoceDAO();
        $this->confeiteiroDao = new ConfeiteiroDAO();
        $this->usuario = new Usuario();
        $this->enderecoDao = new EnderecoDAO();
        $this->usuarioDao = new UsuarioDAO();

        $this->handleAction();
    }

    protected function listProdutos(string $msgErro = "", string $msgSucesso = "")
    {
        $idConfeiteiro  = 0;
        if (isset($_GET["idConfeiteiro"]))
            $idConfeiteiro = $_GET["idConfeiteiro"];

        if (! $idConfeiteiro) {
            echo "Loja inválida!";
            exit;
        }

        $doces = $this->doceDao->listPorConfeiteiro($idConfeiteiro);
        $dados["lista"] = $doces;

        $this->loadView("pedido/produtos.php", $dados);
    }
    protected function descProduto(string $msgErro = "", string $msgSucesso = "")
    {
        $idDoce  = 0;
        if (isset($_GET["idDoces"]))
            $idDoce = $_GET["idDoces"];

        if (! $idDoce) {
            echo "Doce não encontrado!";
            exit;
        }

        $erro = 0;
        if(isset($_GET['erro']))
            $erro = $_GET['erro'];

        if($erro) 
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
        }}
}


new PedidoController();
