<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");


class HomeController extends Controller {

    private UsuarioDAO $usuarioDAO;

    public function __construct() {
        //Testar se o usuário está logado
        if(! $this->usuarioLogado()) {
            exit;
        }

        $this->usuarioDAO = new UsuarioDAO();

        $this->handleAction();       
    }

    protected function home() {
        $totalUsuario = $this->usuarioDAO->count();
        $listaUsuario = $this->usuarioDAO->list();

        $dados ["totalUsuarios"] = $totalUsuario;
        $dados ["listaUsuarios"] = $listaUsuario;
        $this->loadView("home/home.php", $dados);

    }

}

//Criar o objeto da classe HomeController
new HomeController();