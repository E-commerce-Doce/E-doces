<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");


// UsuarioController.php
class UsuarioController extends Controller {
    private UsuarioDAO $usuarioDao;
    private ConfeiteiroDAO $confeiteiroDao;
    private UsuarioService $usuarioService;
    private Usuario $usuario;

    public function __construct() {
        if (!$this->usuarioLogado()) {
            exit;
        }

        $this->usuarioDao = new UsuarioDAO();
        $this->confeiteiroDao = new ConfeiteiroDAO();
        $this->usuarioService = new UsuarioService();

      
        $usuarioId = $_SESSION[SESSAO_USUARIO_ID]; 
        $this->usuario = $this->usuarioDao->findById($usuarioId); 

        if (!$this->usuario) {
            echo 'Usuário não encontrado!';
            exit;
        }

        $this->handleAction();
    }
    

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        if ($this->usuario->getPapel() !== UsuarioPapel::ADMINISTRADOR) {
            echo 'Acesso negado!';
            return;
        }

        $usuarios = $this->usuarioDao->list();
        
        $dados["lista"] = $usuarios;
        $this->loadView("usuario/list.php", $dados, $msgErro, $msgSucesso);
    }

    protected function save() {
        //Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : NULL;
        $nome = isset($_POST['nome']) ? trim($_POST['nome']) : NULL;
        $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : NULL;
        $login = isset($_POST['login']) ? trim($_POST['login']) : NULL;
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : NULL;
        $confSenha = isset($_POST['conf_senha']) ? trim($_POST['conf_senha']) : NULL;
        $dataNascimento = isset($_POST['dataNascimento']) ? trim($_POST['dataNascimento']) : NULL;
        $papel = isset($_POST['papel']) ? trim($_POST['papel']) : NULL;

        //Cria objeto Usuario
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setCpf($cpf);
        $usuario->setTelefone($telefone);
        $usuario->setLogin($login);
        $usuario->setSenha($senha);
        $usuario->setDataNascimento($dataNascimento);
        $usuario->setPapel($papel);

        //Validar os dados
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);
        if(empty($erros)) {
            //Persiste o objeto
            try {
                
                if($dados["id"] == 0)  //Inserindo
                    $this->usuarioDao->insert($usuario);                    
                else { //Alterando
                    $usuario->setId($dados["id"]);
                    $this->usuarioDao->update($usuario);
                }

                //TODO - Enviar mensagem de sucesso
                $msg = "Usuário salvo com sucesso.";
                $this->editProfile("", $msg);
                exit;
            } catch (PDOException $e) {
                $erros = array("Erro ao salvar o usuário na base de dados." . $e->getMessage());                
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário
        $dados["usuario"] = $usuario;
        $dados["confSenha"] = $confSenha;
        $dados["papeis"] = UsuarioPapel::getAllAsArray();

        $msgsErro = implode("<br>", $erros);
        $this->loadView("usuario/form.php", $dados, $msgsErro);
    }

    //Método create
    protected function create() {
        //echo "Chamou o método create!";

        $dados["id"] = 0;
        $dados["papeis"] = UsuarioPapel::getAllAsArray(); 
        $this->loadView("usuario/form.php", $dados);
    }

    //Método edit
    protected function edit() {
        $usuario = $this->findUsuarioById();

        if ($usuario != null) {
            $usuario->setSenha("");

            //Setar os dados
            $dados["id"] = $usuario->getId();
            $dados["usuario"] = $usuario;
            $dados["papeis"] = UsuarioPapel::getAllAsArray();

            $this->loadView("usuario/form.php", $dados);
        } else
            $this->list("Usuario não encontrado");
     }

     
     public function editProfile(string $msgErro = "", string $msgSucesso = "") {
        $usuarioId = $_SESSION[SESSAO_USUARIO_ID]; // ID do usuário logado
        $usuario = $this->usuarioDao->findById($usuarioId);
    
        if (!$usuario) {
            $msgErro = "Usuário não encontrado.";
            $this->loadView("usuario/form.php", [], $msgErro);
            return;
        }
    
        $dados["usuario"] = $usuario;
        $this->loadView("usuario/edit.php", $dados, $msgErro, $msgSucesso);
    }
    

       //Método delete 
    protected function delete() {
        $usuario = $this->findUsuarioById();

        if ($usuario) {
            $this->usuarioDao->deleteById($usuario->getId());

            $this->create("", "Usuario excluído com sucesso!");

        } else 
            $this->create("Usuario não encontrado");
    }

    protected function listJson(){
        $listaUsuarios = $this->usuarioDao->list();
        $json = json_encode($listaUsuarios);
        echo $json;

    }
    
    //Método para buscar o usuário com base no ID recebido por parâmetro GET
    private function findUsuarioById() {
        $id = 0;
        if(isset($_GET['id']))
            $id = $_GET['id'];

        $usuario = $this->usuarioDao->findById($id);
        return $usuario;
    }

}


#Criar objeto da classe para assim executar o construtor
new UsuarioController();
