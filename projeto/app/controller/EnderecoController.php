<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

#Classe controller para endereco
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/EnderecoDAO.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../model/Endereco.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../service/EnderecoService.php");



class EnderecoController extends Controller
{

    private EnderecoDAO $enderecoDao;
    private UsuarioDAO $usuarioDao;
    private EnderecoService $enderecoService;
    private Endereco $endereco;

    public function __construct()
    {
        if (! $this->usuarioLogado())
            exit;

        $this->enderecoDao = new EnderecoDAO;
        $this->usuarioDao = new UsuarioDAO;
        $this->enderecoService = new EnderecoService;
        $this->endereco = new Endereco;

       
        
        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "")
    {

        $endereco = $this->enderecoDao->list($this->getIdUsuarioLogado());

        $dados["lista"] = $endereco;


        $this->loadView("endereco/listEndereco.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function save()
    {
        // Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $cep = isset($_POST['cep']) ? trim($_POST['cep']) : NULL;
        $nomeLogradouro = isset($_POST['nomeLogradouro']) ? trim($_POST['nomeLogradouro']) : NULL;
        $numero = isset($_POST['numero']) ? (int)$_POST['numero'] : 0;
        $bairro = isset($_POST['bairro']) ? trim($_POST['bairro']) : NULL;
        $cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : NULL;
        $estado = isset($_POST['estado']) ? trim($_POST['estado']) : NULL;
        $complemento = isset($_POST['complemento']) ? trim($_POST['complemento']) : NULL;



        // Cria objeto endereco
        $endereco = new Endereco();
        $endereco->setCep($cep);
        $endereco->setNomeLogradouro($nomeLogradouro);
        $endereco->setNumero($numero);
        $endereco->setBairro($bairro);
        $endereco->setCidade($cidade);
        $endereco->setEstado($estado);
        $endereco->setComplemento($complemento);

        $usuario = new Usuario;
        $usuario->setId($this->getIdUsuarioLogado());
        $endereco->setUsuario($usuario);



        // Validar os dados
        $erros = $this->enderecoService->validarDados($endereco);
     
        if (empty($erros)) {
            //Persiste o objeto
            try {
                if ($dados["id"] == 0)  //Inserindo
                    $this->enderecoDao->insert($endereco);

                else { //Atualizando
                    $endereco->setIdEndereco($dados["id"]);
                    $this->enderecoDao->update($endereco);
                }

                //TODO - Enviar mensagem de sucesso
                $msg = "Endereço salvo com sucesso.";
                $this->list("", $msg);
                exit;
                
            } catch (PDOException $e) {
                $erros = array("Erro ao salvar o doce na base de dados." . $e->getMessage());
            }
        }


        // Se há erros, volta para o formulário
        $dados["endereco"] = $endereco;


        $msgsErro = implode("<br>", $erros);
        $this->loadView("endereco/formEndereco.php", $dados, $msgsErro);
    }

    // Método create
    protected function create()
    {

        $dados["id"] = 0;
        $this->loadView("endereco/formEndereco.php", $dados);
    }

    //Método edit
    protected function edit()
    {
        $endereco = $this->findEnderecoById();

        if ($endereco != null) {
            //Setar os dados
            $dados["id"] = $endereco->getIdEndereco();
            $dados["endereco"] = $endereco;

            $this->loadView("endereco/formEndereco.php", $dados);
        } else
            $this->list("Endereço não encontrado");
    }

    //Método delete 
    protected function delete()
    {

        $endereco = $this->findEnderecoById();

        if ($endereco) {
            $this->enderecoDao->deleteById($endereco->getIdEndereco());

            $this->list("", "Endereço excluído com sucesso!");
        } else
            $this->list("Endereço não encontrado");
    }


    //Método para buscar o endereco com base no ID recebido por parâmetro GET
    private function findEnderecoById()
    {
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $endereco = $this->enderecoDao->findById($id);
        return $endereco;
    }
}

new EnderecoController();
