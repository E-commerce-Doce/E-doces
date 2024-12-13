<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/TipoDoceDAO.php");
require_once(__DIR__ . "/../model/TipoDoce.php");

class TipoDoceController extends Controller{

    private TipoDoceDAO $tipoDoceDAO;


    public function __construct()
    {
        if (! $this->usuarioLogado())
            exit;

        $this->tipoDoceDAO = new TipoDoceDAO();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        $tipoDoce = $this->tipoDoceDAO->list();
        $dados["lista"] = $tipoDoce;

        $this->loadView("doce/listDoce.php", $dados,  $msgErro, $msgSucesso);
    }
}