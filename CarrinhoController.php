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
            if($_SESSION['carrinhoIdConfeiteiro'] > 0 && $_SESSION['carrinhoIdConfeiteiro'] != $idConfeiteiro) {
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

        // Adiciona informações dos confeiteiros aos itens do carrinho
        $confeiteiros = [];
        /*
        foreach ($_SESSION['carrinho'] as $item) {
            //echo "<pre>" . print_r($item, true) . "</pre>";
            //continue;


            if (!isset($confeiteiros[$item['idConfeiteiro']])) {
                $confeiteiro = $this->confeiteiroDao->findById($item['idConfeiteiro']);
                $confeiteiros[$item['idConfeiteiro']] = $confeiteiro;
            }
            $item['confeiteiro'] = $confeiteiros[$item['idConfeiteiro']];
        }
        */
        $dados['confeiteiro'] = $this->confeiteiroDao->findById($_SESSION['carrinhoIdConfeiteiro']);

        //$dados["carrinho"] = $_SESSION['carrinho'];
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
        if (isset($_POST['idDoce'], $_POST['quantidade'])) {
            $idDoce = $_POST['idDoce'];
            $quantidade = (int)$_POST['quantidade'];

            // Verifica se a quantidade é válida (não menor que 1)
            if ($quantidade < 1) {
                echo 'Erro: Quantidade inválida.';
                return;
            }

            // Verifica se o carrinho já existe na sessão
            if (isset($_SESSION['carrinho'])) {
                foreach ($_SESSION['carrinho'] as &$doce) {
                    if ($doce['id'] == $idDoce) {
                        // Atualiza a quantidade do doce no carrinho
                        $doce['quantidade'] = $quantidade;
                        break;
                    }
                }
            }

            // Responde com sucesso (status 200) para a requisição AJAX
            echo json_encode(['status' => 'success', 'msg' => 'Carrinho atualizado com sucesso.']);
        } else {
            echo 'Erro: dados incompletos.';
        }
    }
}

new CarrinhoController();
