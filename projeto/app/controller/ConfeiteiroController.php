<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../model/Confeiteiro.php");
require_once(__DIR__ . "/../service/ConfeiteiroService.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");



class ConfeiteiroController extends Controller
{

    private ConfeiteiroDAO $confeiteiroDao;
    private ConfeiteiroService $confeiteiroService;
    private UsuarioDAO $usuarioDao;
    private Usuario $usuario;



    public function __construct()
    {
        if (! $this->usuarioLogado())
            exit;

        $this->confeiteiroDao = new ConfeiteiroDAO();
        $this->confeiteiroService = new ConfeiteiroService();
        $this->usuarioDao = new UsuarioDAO();
        $this->usuario = new Usuario();


        $this->handleAction();
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
    
        // Cria objeto Confeiteiro
        $confeiteiro = new Confeiteiro();
        // $confeiteiro->setIdConfeiteiro($idConfeiteiro);
        $confeiteiro->setNomeLoja($nomeLoja);
        $confeiteiro->setMei($mei);
        
        $usu = new Usuario();
        $usu->setId($dados["idUsuario"]);
        $usu->setPapel($dados["idUsuario"]);
        $confeiteiro->setUsuario($usu);
    
    
        // Validar os dados
        $erros = $this->confeiteiroService->validarDados($confeiteiro);
        if (empty($erros)) {
            // Persiste o objeto
            try {
                $this->confeiteiroDao->insert($confeiteiro);
                $this->usuarioDao->updatePapel($dados["idUsuario"], UsuarioPapel::CONFEITEIRO);
                header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
                exit; // É uma boa prática chamar exit após redirecionar
            } catch (PDOException $e) {
                $erros = array("Erro ao salvar o confeiteiro na base de dados." . $e->getMessage());
            }
        }
    
        // Se há erros, volta para o formulário
        // Carregar os valores recebidos por POST de volta para o formulário
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

    // //Método edit
    // protected function edit()
    // {
    //     $confeiteiro = $this->findConfeiteiroById();

    //     if ($confeiteiro != null) {
    //         //Setar os dados
    //         $dados["id"] = $confeiteiro->getIdConfeiteiro();
    //         $dados["confeiteiro"] = $confeiteiro;


    //         $this->loadView("confeiteiro/formConfeiteiro.php", $dados);
    //     }
    // }


    // //Método delete 
    // protected function delete()
    // {
    //     $confeiteiro = $this->findConfeiteiroById();

    //     if ($confeiteiro) {
    //         $this->confeiteiroDAO->deleteById($confeiteiro->getIdConfeiteiro());
    //     }
    // }

    //Método para buscar o usuário com base no ID recebido por parâmetro GET
    private function findConfeiteiroById()
    {
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $confeiteiro = $this->confeiteiroDao->findById($id);
        return $confeiteiro;
    }
}
new ConfeiteiroController();

