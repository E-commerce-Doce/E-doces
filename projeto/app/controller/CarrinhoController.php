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

    // Método para adicionar doces ao carrinho
    protected function addCarrinho(string $msgErro = "", string $msgSucesso = "")
    {
        $idDoce = (int)$_POST['idDoce'];
        $nomeDoce = $_POST['nomeDoce'];
        $valorDoce = (float)$_POST['valorDoce'];
        $imgDoce = $_POST['imgDoce'];
        $idConfeiteiro = (int)$_POST['idConfeiteiro'];
        $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

        // Se não houver carrinho, cria um novo
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
            $_SESSION['carrinhoIdConfeiteiro'] = 0;
        }

        $doceExistente = false;
        // Verifica se o doce já existe no carrinho e soma a quantidade
        foreach ($_SESSION['carrinho'] as $key => $doce) {
            if ($doce['id'] == $idDoce) {
                $_SESSION['carrinho'][$key]['quantidade'] += $quantidade;
                $doceExistente = true;
                break;
            }
        }

        if (!$doceExistente) {
            // Verifica se o carrinho já contém doces de outro confeiteiro
            if ($_SESSION['carrinhoIdConfeiteiro'] > 0 && $_SESSION['carrinhoIdConfeiteiro'] != $idConfeiteiro) {
                header("location: " . BASEURL . "/controller/PedidoController.php?action=descProduto&idDoces=" . $idDoce . "&erro=1");
                exit;
            }

            $_SESSION['carrinhoIdConfeiteiro'] = $idConfeiteiro;

            // Adiciona o doce ao carrinho
            $_SESSION['carrinho'][] = [
                'id' => $idDoce,
                'nome' => $nomeDoce,
                'preco' => $valorDoce,
                'quantidade' => $quantidade,
                'imagem' => $imgDoce,
                'idConfeiteiro' => $idConfeiteiro,
            ];
        }

        header("location: " . BASEURL . "/controller/CarrinhoController.php?action=listCarrinho");
    }

    // Método para listar os itens do carrinho
    protected function listCarrinho()
    {
        // Verifica se o carrinho está vazio
        if (empty($_SESSION['carrinho'])) {
            $msgErro = "Seu carrinho está vazio!";
            $this->loadView("pedido/carrinho.php", [], $msgErro);
            return;
        }

        // Carrega as informações do confeiteiro
        $dados['confeiteiro'] = $this->confeiteiroDao->findById($_SESSION['carrinhoIdConfeiteiro']);
        $dados['carrinho'] = $_SESSION['carrinho']; // Passa o carrinho para a view

        $this->loadView("pedido/carrinho.php", $dados);
    }

    // Método para limpar o carrinho
    protected function clearCarrinho()
    {
        unset($_SESSION['carrinho']);
        unset($_SESSION['carrinhoIdConfeiteiro']);
        $this->listCarrinho(); // Redireciona para a lista do carrinho
    }

    // Método para excluir um item do carrinho
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

    // Método para atualizar a quantidade de um item no carrinho
    protected function updateQuantidade()
{
    header('Content-Type: application/json');

    if (!isset($_SESSION['carrinho'])) {
        echo json_encode(['status' => 'error', 'msg' => 'Carrinho está vazio.']);
        return;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['idDoce'], $data['quantidade'])) {
        $idDoce = $data['idDoce'];
        $quantidade = (int)$data['quantidade'];

        if ($quantidade < 1) {
            echo json_encode(['status' => 'error', 'msg' => 'Quantidade inválida.']);
            return;
        }

        // Atualiza a quantidade no carrinho
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
