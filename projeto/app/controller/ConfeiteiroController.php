<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../model/Confeiteiro.php");
require_once(__DIR__ . "/../service/ConfeiteiroService.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");



class ConfeiteiroController extends Controller
{

    private ConfeiteiroDAO $confeiteiroDAO;
    private ConfeiteiroService $confeiteiroService;



    public function __construct()
    {
        if (! $this->usuarioLogado())
            exit;

        $this->confeiteiroDAO = new ConfeiteiroDAO();
        $this->confeiteiroService = new ConfeiteiroService();

        $this->handleAction();
    }


    protected function save()
    {
        //Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $nomeLoja = isset($_POST['nomeLoja']) ? trim($_POST['nomeLoja']) : NULL;
        $mei = isset($_POST['mei']) ? trim($_POST['mei']) : NULL;

        //Cria objeto Confeiteiro
        $confeiteiro = new Confeiteiro();
        $confeiteiro->setNomeLoja($nomeLoja);
        $confeiteiro->setMei($mei);

        $usu = new Usuario();
        $usu->setId($this->getIdUsuarioLogado());
        $confeiteiro->setUsuario($usu);


        //Validar os dados
        $erros = $this->confeiteiroService->validarDados($confeiteiro,);
        if (empty($erros)) {
            //Persiste o objeto
            try {

                if ($dados["id"] == 0)  //Inserindo
                    $this->confeiteiroDAO->insert($confeiteiro);
                else { //Alterando
                    $confeiteiro->setIdConfeiteiro($dados["id"]);
                    $this->confeiteiroDAO->update($confeiteiro);
                }
                //TODO - Enviar mensagem de sucesso
                $msg = "Confeiteiro salvo com sucesso.";
                exit;
            } catch (PDOException $e) {
                $erros = array("Erro ao salvar o confeiteiro na base de dados." . $e->getMessage());
            }
        }
        //Se há erros, volta para o formulário

        //Carregar os valores recebidos por POST de volta para o formulário
        $dados["confeiteiro"] = $confeiteiro;

        $msgsErro = implode("<br>", $erros);
        $this->loadView("confeiteiro/formConfeiteiro.php", $dados, $msgsErro);
    }


    //Método create
    protected function create()
    {
        //echo "Chamou o método create!";
        $dados["id"] = 0;

        $this->loadView("confeiteiro/formConfeiteiro.php", $dados);
    }

    //Método edit
    protected function edit()
    {
        $confeiteiro = $this->findConfeiteiroById();

        if ($confeiteiro != null) {
            //Setar os dados
            $dados["id"] = $confeiteiro->getIdConfeiteiro();
            $dados["confeiteiro"] = $confeiteiro;


            $this->loadView("confeiteiro/formConfeiteiro.php", $dados);
        } }


    //Método delete 
    protected function delete()
    {
        $confeiteiro = $this->findConfeiteiroById();

        if ($confeiteiro) {
            $this->confeiteiroDAO->deleteById($confeiteiro->getIdConfeiteiro());
    }
}

    //Método para buscar o usuário com base no ID recebido por parâmetro GET
    private function findConfeiteiroById()
    {
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $usuario = $this->confeiteiroDAO->findById($id);
        return $usuario;
    }
}
new ConfeiteiroController();
