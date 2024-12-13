<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/DoceDAO.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../util/config.php");




session_start();

class CarrinhoController extends Controller
{
    private DoceDAO $doceDao;
    private ConfeiteiroDAO $confeiteiroDao;

    public function __construct()
    {
        if (!$this->usuarioLogado()) {
            exit("Usuário não está logado.");
        }

        $this->doceDao = new DoceDAO();
        $this->confeiteiroDao = new ConfeiteiroDAO();

        $this->handleAction();
    }

    protected function addCarrinho(string $msgErro = "", string $msgSucesso = "")
    {
        $idDoce = (int)$_POST['idDoce'];
        $nomeDoce = $_POST['nomeDoce'];
        $valorDoce = (float)$_POST['valorDoce'];
        $imgDoce = $_POST['imgDoce'];
        $idConfeiteiro = (int)$_POST['idConfeiteiro'];
        //$nomeLoja = $_POST['nomeLoja'];
        $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
            $_SESSION['carrinhoIdConfeiteiro'] = 0;
        }

        $doceExistente = false;
        foreach ($_SESSION['carrinho'] as $key => $doce) {
            if ($doce['id'] == $idDoce) {
                $_SESSION['carrinho'][$key]['quantidade'] += $quantidade;
                $doceExistente = true;
                break;
            }
        }

        if (!$doceExistente) {
            if ($_SESSION['carrinhoIdConfeiteiro'] > 0 && $_SESSION['carrinhoIdConfeiteiro'] != $idConfeiteiro) {
                header("location: " . BASEURL . "/controller/PedidoController.php?action=descProduto&idDoces=" . $idDoce . "&erro=1");
                exit;
            }

            $_SESSION['carrinhoIdConfeiteiro'] = $idConfeiteiro;

            $_SESSION['carrinho'][] = [
                'id' => $idDoce,
                'nome' => $nomeDoce,
                'preco' => $valorDoce,
                'quantidade' => $quantidade,
                'imagem' => $imgDoce,
                'idConfeiteiro' => $idConfeiteiro,
                //'nomeLoja' => $nomeLoja,
            ];
            //print_r($_SESSION['carrinho']);
            //exit;
        }

        //$msgSucesso = "Doce adicionado ao carrinho com sucesso!";
        //$dados["carrinho"] = $_SESSION['carrinho'];
        //$this->loadView("pedido/carrinho.php", [], $msgErro, $msgSucesso);

        header("location: " . BASEURL . "/controller/CarrinhoController.php?action=listCarrinho");
    }


    protected function listCarrinho()
    {
        // Verifica se o carrinho está vazio
        if (empty($_SESSION['carrinho'])) {
            $msgErro = "Carrinho vazio!";
            $this->loadView("pedido/carrinho.php", [], $msgErro);
            return;
        }

        // Obtém o primeiro doce do carrinho (exemplo simples)
        $primeiroItem = $_SESSION['carrinho'][0];
        $idDoce = $primeiroItem['id'];

        // Busca informações detalhadas do doce usando DoceDAO
        $doce = $this->doceDao->findById($idDoce);
        if (!$doce) {
            $msgErro = "Erro ao buscar informações do doce.";
            $this->loadView("pedido/carrinho.php", [], $msgErro);
            return;
        }

        // Adiciona o doce e o confeiteiro aos dados
        $dados['doce'] = $doce;
        $dados['confeiteiro'] = $this->confeiteiroDao->findById($_SESSION['carrinhoIdConfeiteiro']);

        // Carrega a view
        $this->loadView("pedido/carrinho.php", $dados);
    }


    // Método para limpar o carrinho
    protected function clearCarrinho()
    {
        unset($_SESSION['carrinho']);
        unset($_SESSION['carrinhoIdConfeiteiro']);
        //$msgSucesso = "Carrinho esvaziado com sucesso!";
        $this->listCarrinho(); // Corrigido para chamar sem parâmetros extras
    }

    protected function deleteDoce()
    {
        $idDoce = (int)$_GET['idDoce'];

        // Remove o doce do carrinho
        foreach ($_SESSION['carrinho'] as $key => $doce) {
            if ($doce['id'] == $idDoce) {
                unset($_SESSION['carrinho'][$key]);
                break;
            }
        }
        // Reindexa o carrinho
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);

        $this->listCarrinho();
    }

    protected function updateQuantidade()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['carrinho'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Carrinho está vazio.']);
            return;
        }

        if (isset($_POST['idDoce'], $_POST['quantidade'])) {
            $idDoce = $_POST['idDoce'];
            $quantidade = (int)$_POST['quantidade'];

            if ($quantidade < 1) {
                echo json_encode(['status' => 'error', 'msg' => 'Quantidade inválida.']);
                return;
            }

            foreach ($_SESSION['carrinho'] as &$doce) {
                if ($doce['id'] == $idDoce) {
                    $doce['quantidade'] = $quantidade;
                    echo json_encode(['status' => 'success', 'msg' => 'Quantidade atualizada com sucesso.']);
                    return;
                }
            }

            echo json_encode(['status' => 'error', 'msg' => 'Doce não encontrado no carrinho.']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Dados incompletos.']);
        }
    }
}


new CarrinhoController();
