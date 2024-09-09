<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

#Classe controller para Doce
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/DoceDAO.php");
require_once(__DIR__ . "/../dao/TipoDoceDAO.php");
require_once(__DIR__ . "/../dao/ConfeiteiroDAO.php");
require_once(__DIR__ . "/../service/DoceService.php");
require_once(__DIR__ . "/../service/ArquivoService.php");
require_once(__DIR__ . "/../model/Doce.php");

class DoceController extends Controller
{

    private DoceDAO $doceDao;
    private TipoDoceDAO $tipoDoceDao;
    private DoceService $doceService;
    private ArquivoService $arquivoService;


    public function __construct()
    {
        if (! $this->usuarioLogado())
            exit;

        $this->doceDao = new DoceDAO();
        $this->tipoDoceDao = new TipoDoceDAO();
        $this->doceService = new DoceService();
        $this->arquivoService = new ArquivoService();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "")
    {
        $doce = $this->doceDao->list();
        $dados["lista"] = $doce;
       

        $this->loadView("doce/listDoce.php", $dados,  $msgErro, $msgSucesso);
    }



    protected function save()
    {
        //Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $nomeDoce = isset($_POST['nomeDoce']) ? trim($_POST['nomeDoce']) : NULL;
        $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : NULL;
        $valor = isset($_POST['valor']) ? (float) $_POST['valor'] : NULL;
        $ingredientes = isset($_POST['ingredientes']) ? trim($_POST['ingredientes']) : NULL;
        //$idConfeiteiro = isset($_POST['idConfeiteiro']) ? (int)$_POST['idConfeiteiro'] : NULL;
        $idTipoDoce = isset($_POST['idTipoDoce']) ? (int)$_POST['idTipoDoce'] : NULL;

        $arquivoImg = isset($_FILES["caminhoImagem"]) ?  $_FILES["caminhoImagem"] : array(); // 'caminhoImagem' é o 'name' do input

        //Armazenar o caminho de imagem já existente
        $caminhoImagemAtual = isset($_POST['caminhoImagemAtual']) ? $_POST['caminhoImagemAtual'] : NULL;
        
        $doce = new Doce;
        $doce->setNomeDoce($nomeDoce);
        $doce->setDescricao($descricao);
        $doce->setValor($valor);
        $doce->setIngredientes($ingredientes);
        $doce->setCaminhoImagem($caminhoImagemAtual);

        $conf = new Confeiteiro();
        $conf->setIdConfeiteiro($this->getIdUsuarioLogado());
        $doce->setConfeiteiro($conf);

        $tipo = new TipoDoce;
        $tipo->setIdTipoDoce($idTipoDoce);
        $tipo->setDescricao($descricao);
        $doce->setTipoDoce($tipo);


        //Validar os dados- conferir depois
        $erros = $this->doceService->validarDados($doce, $arquivoImg, $caminhoImagemAtual);

        if (empty($erros)) {
            // Salva a imagem
            if($arquivoImg['size'] > 0) {
                $caminhoImagem = $this->arquivoService->salvarArquivo($arquivoImg);
                if ($caminhoImagem) {
                    $doce->setCaminhoImagem($caminhoImagem);

                    $this->arquivoService->removerArquivo($caminhoImagemAtual);
                } else {
                    $erros[] = "Erro ao salvar a imagem.";
                }
            }
        }

        if (empty($erros)) {
            //Persiste o objeto
            try {
                if ($dados["id"] == 0)  //Inserindo
                    $this->doceDao->insert($doce);
                else { //Atualizando
                    $doce->setIdDoces($dados["id"]);
                    $this->doceDao->update($doce);
                }

                //TODO - Enviar mensagem de sucesso
                $msg = "Doce salvo com sucesso.";
                $this->list("", $msg);
                exit;
            } catch (PDOException $e) {
                $erros = array("Erro ao salvar o doce na base de dados." . $e->getMessage());
            }
        }


        //Carregar os valores recebidos por POST de volta para o formulário
        $dados["doce"] = $doce;
        $tiposDoces = $this->tipoDoceDao->list();
        $dados["tiposDoces"] = $tiposDoces;

        $msgsErro = implode("<br>", $erros);
        $this->loadView("doce/formDoce.php", $dados, $msgsErro);
    }


    //Método create
    protected function create()
    {
        $dados["id"] = 0;

        $tiposDoces = $this->tipoDoceDao->list();
        $dados["tiposDoces"] = $tiposDoces;

        $this->loadView("doce/formDoce.php", $dados);
    }

    //Método edit
    protected function edit()
    {
        $doce = $this->findDoceById();

        if ($doce != null) {
            //Setar os dados
            $dados["id"] = $doce->getIdDoces();
            $dados["doce"] = $doce;
            $tiposDoces = $this->tipoDoceDao->list();
            $dados["tiposDoces"] = $tiposDoces;


            $this->loadView("doce/formDoce.php", $dados);
        } else
            $this->list("Doce não encontrado");
    }

    //Método delete 
    protected function delete()
    {
        $doce = $this->findDoceById();

        if ($doce) {
            $this->doceDao->deleteById($doce->getIdDoces());
            $this->arquivoService->removerArquivo($doce->getCaminhoImagem());
            
            $this->list("", "Doce excluído com sucesso!");
        } else
            $this->list("Doce não encontrado");
    }


    //Método para buscar o usuário com base no ID recebido por parâmetro GET
    private function findDoceById(){
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $doce = $this->doceDao->findById($id);
        return $doce;
    }
}

new DoceController();
