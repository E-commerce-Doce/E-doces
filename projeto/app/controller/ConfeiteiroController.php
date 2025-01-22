<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../dao/PedidoDAO.php");
require_once(__DIR__ . "/../model/Confeiteiro.php");
require_once(__DIR__ . "/../service/ConfeiteiroService.php");
require_once(__DIR__ . "/../service/ArquivoService.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");

class ConfeiteiroController extends Controller
{

    private ConfeiteiroDAO $confeiteiroDao;
    private PedidoDAO $pedidoDao;
    private ConfeiteiroService $confeiteiroService;
    private ArquivoService $arquivoService;
    private UsuarioDAO $usuarioDao;
    private Usuario $usuario;



    public function __construct()
    {
        if (! $this->usuarioLogado())
            exit;

        $this->confeiteiroDao = new ConfeiteiroDAO();
        $this->pedidoDao = new PedidoDAO();
        $this->confeiteiroService = new ConfeiteiroService();
        $this->arquivoService = new ArquivoService();
        $this->usuarioDao = new UsuarioDAO();
        $this->usuario = new Usuario();


        $this->handleAction();
    }

    // Exibe a lista de pedidos com detalhes (na mesma página)
    public function listPedidos(string $msgErro = "", string $msgSucesso = "")
    {
        if(! $this->getIdConfeiteiroLogado()) {
            echo "O usuário não é confeiteiro.";
            exit;
        }

        // Chama o DAO para pegar todos os pedidos
        $pedidos = $this->pedidoDao->listPedidoPorConfeiteiro($this->getIdConfeiteiroLogado());
        $dados["listaPedidos"] = $pedidos;

        // Exibe os pedidos e também detalhes de um pedido, se necessário
        include_once(__DIR__ . "/../view/pedido/listPedidos.php");
    }

   


    protected function listLojas(string $msgErro = "", string $msgSucesso = ""){
        $lojas = $this->confeiteiroDao->list();

        $dados["lista"] = $lojas;
         $this->loadView("confeiteiro/lojas.php", $dados, $msgErro, $msgSucesso);
    }


    protected function save() {
        // Captura os dados do formulário
        $dados["idUsuario"] = isset($_POST['idUsuario']) ? (int)$_POST['idUsuario'] : 0;
        // $idConfeiteiro = isset($_POST['idConfeiteiro']) ? (int)($_POST['idConfeiteiro']) : 0;
        $nomeLoja = isset($_POST['nomeLoja']) ? trim($_POST['nomeLoja']) : NULL;
        $mei = isset($_POST['mei']) ? trim($_POST['mei']) : NULL;

            
        $qrCodeImg = $_FILES["qrCodeImagem"] ?? [];
        $logoImg = $_FILES["logoImagem"] ?? [];

        // Caminhos atuais das imagens (se existirem)
        $qrCodeImgAtual = $_POST['qrCodeImagemAtual'] ?? null;
        $logoImgAtual = $_POST['logoImagemAtual'] ?? null;


        $confeiteiro = new Confeiteiro;
        $confeiteiro->setNomeLoja ($nomeLoja);
        $confeiteiro->setMei  ($mei);
        $confeiteiro->setQrCode($qrCodeImgAtual);
        $confeiteiro->setLogo($logoImgAtual);
        
        $usu = new Usuario();
        $usu->setId($dados["idUsuario"]);
        $usu->setPapel($dados["idUsuario"]);
        $confeiteiro->setUsuario($usu);
    
        
        // Valida os dados
        $erros = $this->confeiteiroService->validarDados($confeiteiro, $qrCodeImgAtual, $qrCodeImg);
    
        // Processa QR Code
        if (empty($erros) && $qrCodeImg['size'] > 0) {
            $caminhoQrCode = $this->arquivoService->salvarArquivo($qrCodeImg);
            if ($caminhoQrCode) {
                $confeiteiro->setQrCode($caminhoQrCode);
                if ($qrCodeImgAtual) {
                    $this->arquivoService->removerArquivo($qrCodeImgAtual);
                }
            } else {
                $erros[] = "Erro ao salvar o QR Code.";
            }
        }
    
        // Processa logo
        if (empty($erros)) {
            if ($logoImg['size'] > 0) {
                $caminhoLogo = $this->arquivoService->salvarArquivo($logoImg);
                if ($caminhoLogo) {
                    $confeiteiro->setLogo($caminhoLogo);
                    if ($logoImgAtual) {
                        $this->arquivoService->removerArquivo($logoImgAtual);
                    }
                } else {
                    $erros[] = "Erro ao salvar a logo.";
                }
            } elseif (!$logoImgAtual) {
                // Permite que o campo logo seja nulo se não houver imagem enviada
                $confeiteiro->setLogo(null);
            }
        }
    
        // Persiste no banco de dados
        if (empty($erros)) {
            try {
                if ($dados["idUsuario"]== 0){
                    $this->confeiteiroDao->insert($confeiteiro);
                } else{
                    //Setar o ID do confeiteiro
                    $confeiteiroAux = $this->confeiteiroDao->findConfeiteiroByIdUsuario($dados["idUsuario"]);
                    $confeiteiro->setIdConfeiteiro($confeiteiroAux->getIdConfeiteiro());

                    $this->confeiteiroDao->update($confeiteiro);
                }
                $this->usuarioDao->updatePapel($dados["idUsuario"], UsuarioPapel::CONFEITEIRO);
                header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
                exit;
            } catch (PDOException $e) {
                $erros[] = "Erro ao salvar no banco de dados: " . $e->getMessage();
            }
        }
        // Caso haja erros, exibe o formulário novamente
        $dados["confeiteiro"] = $confeiteiro;
        $msgsErro = implode("<br>", $erros);
        $this->loadView("confeiteiro/formConfeiteiro.php", $dados, $msgsErro);
    }

    //Método create
    protected function create()
    {
        //echo "Chamou o método create!";
        $idUsuario = 0;
        if(isset($_GET["idUsuario"]))
            $idUsuario = $_GET["idUsuario"];

        if(! $idUsuario) {
            echo "Usuário inválido!";
            exit;
        }

        $dados["idUsuario"] = $idUsuario;
        $this->loadView("confeiteiro/formConfeiteiro.php", $dados);
    }

    // Método edit
    protected function edit()
    {
        $idUsuario = isset($_GET["idUsuario"]) ? (int)$_GET["idUsuario"] : 0;

        if ($idUsuario <= 0) {
            echo "Usuário inválido!";
            exit;
        }
        
        // Busca o confeiteiro pelo idUsuario
        $confeiteiro = $this->confeiteiroDao->findConfeiteiroByIdUsuario($idUsuario);
        
        if ($confeiteiro) {
            // Preenche os dados no formulário para edição
            $dados["confeiteiro"] = $confeiteiro;
            $this->loadView("confeiteiro/formConfeiteiro.php", $dados);
        } else {
            echo "Confeiteiro não encontrado!";
            exit;
        }
    }        
    
}
new ConfeiteiroController();
