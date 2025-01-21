<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");

class HomeController extends Controller {

    private UsuarioDAO $usuarioDAO;
    private ?Usuario $usuario;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();

        if (!$this->usuarioLogado()) {
            exit;
        }

        $usuarioId = $_SESSION[SESSAO_USUARIO_ID] ?? null;
        $this->usuario = $usuarioId ? $this->usuarioDAO->findById($usuarioId) : null;

        if (!$this->usuario) {
            echo "Usuário não encontrado!";
            exit;
        }

        $this->handleAction();       
    }

    protected function home() {
        $totalUsuario = $this->usuarioDAO->count();
        $listaUsuario = $this->usuarioDAO->list();

        $dados["totalUsuarios"] = $totalUsuario;
        $dados["listaUsuarios"] = $listaUsuario;

        $papel = $this->usuario->getPapel();

        switch ($papel) {
            case UsuarioPapel::ADMINISTRADOR:
                $this->loadView("home/homeAdm.php", $dados);
                break;
            case UsuarioPapel::CONFEITEIRO:
                $this->loadView("home/homeConfeiteiro.php", $dados);
                break;
            case UsuarioPapel::CLIENTE:
                $this->loadView("home/homeCliente.php", $dados);
                break;
            default:
                echo "Papel de usuário não reconhecido!";
                exit;
        }
    }
}

new HomeController();