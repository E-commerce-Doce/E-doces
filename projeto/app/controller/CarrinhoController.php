<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/DoceDAO.php");
require_once(__DIR__ . "/../util/config.php");


session_start();

class CarrinhoController extends Controller
{
    private DoceDAO $doceDao;

    public function __construct()
    {
        if (!$this->usuarioLogado()) {
            exit("Usuário não está logado.");
        }

        $this->doceDao = new DoceDAO();
        $this->handleAction();
    }

    protected function addCarrinho(string $msgErro = "", string $msgSucesso = "")
    {
        // Valida se os dados necessários estão presentes no POST
        if (!isset($_POST['idProduto'], $_POST['nomeProduto'], $_POST['valorProduto'], $_POST['imgProduto'])) {
            $msgErro = "Dados do produto estão incompletos!";
            
            //Dados do confeiteiro do carrinho
            
            
            $this->loadView("pedido/carrinho.php", [], $msgErro);
            return;
        }

        // Captura os dados do produto enviados pelo formulário
        $idProduto = (int)$_POST['idProduto'];
        $nomeProduto = $_POST['nomeProduto'];
        $valorProduto = (float)$_POST['valorProduto'];
        $imgProduto = $_POST['imgProduto']; // Captura a imagem do produto
        $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

        // Inicializa o carrinho se não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Verifica se o produto já existe no carrinho
        $produtoExistente = false;
        foreach ($_SESSION['carrinho'] as $key => $produto) {
            if ($produto['id'] == $idProduto) {
                // Se já existir, atualiza a quantidade
                $_SESSION['carrinho'][$key]['quantidade'] += $quantidade;
                $produtoExistente = true;
                break;
            }
        }

        // Adiciona o produto ao carrinho se ele ainda não existir
        if (!$produtoExistente) {
            $_SESSION['carrinho'][] = [
                'id' => $idProduto,
                'nome' => $nomeProduto,
                'preco' => $valorProduto,
                'quantidade' => $quantidade,
                'imagem' => $imgProduto, // Adiciona o caminho da imagem
            ];
        }

        // Define mensagem de sucesso
        $msgSucesso = "Produto adicionado ao carrinho com sucesso!";

        // Carrega a view do carrinho
        $dados["carrinho"] = $_SESSION['carrinho'];
        $this->loadView("pedido/carrinho.php", $dados, $msgErro, $msgSucesso);
    }
}

new CarrinhoController();
