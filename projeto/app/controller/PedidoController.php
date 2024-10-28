<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

#Classe controller para Pedidos
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../dao/DoceDAO.php");
require_once(__DIR__ . "/../model/Usuario.php");

class PedidoController extends Controller
{

    private PedidoDAO $pedidoDao;
    private DoceDAO $doceDao;
    private ConfeiteiroDAO $confeiteiroDao;
    private UsuarioDAO $usuarioDao;
    private Usuario $usuario;


    public function __construct()
    {

        if (! $this->usuarioLogado())
            exit;

        $this->pedidoDao = new PedidoDAO();
        $this->doceDao = new DoceDAO();
        $this->confeiteiroDao = new ConfeiteiroDAO();
        $this->usuarioDao = new UsuarioDAO();


        $this->handleAction();
    }

    protected function listProdutos(int $idConfeiteiro, string $msgErro = "", string $msgSucesso = "")
    {
        $pedidos = $this->doceDao->listPorConfeiteiro($idConfeiteiro);
        $dados["lista"] = $pedidos;


        var_dump($dados); // Verifique o conteúdo aqui para debug
        $this->loadView("pedido/produtos.php", $dados);
        exit; // Interrompe para ver o resultado
    }
}
