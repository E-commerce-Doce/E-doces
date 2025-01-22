<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once(__DIR__ . "/Controller.php");
include_once(__DIR__ . "/../model/Avaliacao.php");
include_once(__DIR__ . "/../dao/AvaliacaoDAO.php");
include_once(__DIR__ . "/../dao/PedidoDAO.php");
include_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");



class AvaliacaoController extends Controller
{

    private AvaliacaoDAO $avaliacaoDao;
    private Avaliacao $avaliacao;
    private PedidoDAO $pedidoDao;
    private ConfeiteiroDAO $confeiteiroDao;

    public function __construct()
    {
        if (! $this->usuarioLogado())
            exit;

        $this->avaliacaoDao = new AvaliacaoDAO();
        $this->avaliacao = new Avaliacao();
        $this->pedidoDao = new PedidoDAO();
        $this->confeiteiroDao = new ConfeiteiroDAO();

        $this->handleAction();
    }


    protected function listAvaliacoes(string $msgErro = "", string $msgSucesso = "")
    {
        $idConfeiteiro = 0;
        if (isset($_GET["idConfeiteiro"]))
            $idConfeiteiro = $_GET["idConfeiteiro"];

        if (!$idConfeiteiro) {
            echo "Avaliação inválida!";
            exit;
        }

        $avaliacao = $this->avaliacaoDao->listPorConfeiteiro($idConfeiteiro);
        $dados["lista"] = $avaliacao;

        $this->loadView("pedido/avaliacao.php", $dados);
    }


    protected function save()
    {
        // Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $idPedido = isset($_POST['idPedido']) ? (int)$_POST['idPedido'] : 0;
        $nota = isset($_POST['avaliacao']) ? (int)$_POST['avaliacao'] : 0;
        $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : null;


        $avaliacao = new Avaliacao();
        $avaliacao->setNota((int)$nota);
        $avaliacao->setComentario(trim($comentario));
        $pedido = $this->pedidoDao->findById((int)$idPedido);

        if ($pedido) {
            $avaliacao->setPedido($pedido);
            $avaliacao->setConfeiteiro($pedido->getConfeiteiro());
            $avaliacao->setUsuario((new Usuario())->setId($this->getIdUsuarioLogado()));

            try {
                $this->avaliacaoDao->insert($avaliacao);
                header("location: " . BASEURL . "/controller/PedidoController.php?action=listPedidos");
                exit;
            } catch (PDOException $e) {
                $erros = array("Erro ao salvar a avaliação: " . $e->getMessage());
            }

            // Se há erros, volta para o formulário
            $msgsErro = implode("<br>", $erros);
            header("location: " . BASEURL . "/controller/PedidoController.php?action=listPedidos");
            
        }
    }


}

new AvaliacaoController();
