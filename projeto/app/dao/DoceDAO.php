<?php
#Nome do arquivo: DoceDAO.php
#Objetivo: classe DAO para o model de Doce

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Doce.php");
include_once(__DIR__ . "/../model/TipoDoce.php");
include_once(__DIR__ . "/../model/Confeiteiro.php");



class DoceDAO
{

    public function listPorConfeiteiro(int $idConfeiteiro)
    {
        $conn = Connection::getConn();

        $sql = "SELECT d.*, t.descricao AS tipo_descricao, c.nomeLoja as nomeLoja,c.logo as logo FROM Doce d 
                JOIN TipoDoce t ON (t.idTipoDoce = d.idTipoDoce)
                JOIN Confeiteiro c ON (c.idConfeiteiro = d.idConfeiteiro)
                WHERE d.idConfeiteiro = :idConfeiteiro
                ORDER BY d.nomeDoce";
        $stm = $conn->prepare($sql);
        $stm->bindValue("idConfeiteiro",$idConfeiteiro);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapDoce($result);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Doce d" .
            " WHERE d.idDoces = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $doces = $this->mapDoce($result);

        if (count($doces) == 1)
            return $doces[0];
        elseif (count($doces) == 0)
            return null;

        die("DoceDAO.findById()" .
            " - Erro: mais de um usuário encontrado.");
    }

    public function findByIdCompleto(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT d.*, t.descricao AS tipo_descricao, c.nomeLoja as nomeLoja, c.logo as logo FROM Doce d 
                JOIN TipoDoce t ON (t.idTipoDoce = d.idTipoDoce)
                JOIN Confeiteiro c ON (c.idConfeiteiro = d.idConfeiteiro)
                WHERE d.idDoces = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $doces = $this->mapDoce($result);

        if (count($doces) == 1)
            return $doces[0];
        elseif (count($doces) == 0)
            return null;

        die("DoceDAO.findByIdCompleto()" .
            " - Erro: mais de um usuário encontrado.");
    }


    public function insert(Doce $doce, int $idUsuarioLogado)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO Doce (nomeDoce, descricao, caminhoImagem, valor, ingredientes, idConfeiteiro, idTipoDoce)" .
            " VALUES (:nomeDoce, :descricao, :caminhoImagem,:valor,:ingredientes," . 
            " (SELECT sub.idConfeiteiro FROM confeiteiro sub WHERE sub.idUsuario = :idUsuario), " .
            " :idTipoDoce)";


        $stm = $conn->prepare($sql);
        $stm->bindValue('nomeDoce', $doce->getNomeDoce());
        $stm->bindValue('descricao', $doce->getDescricao());
        $stm->bindValue('caminhoImagem', $doce->getCaminhoImagem());
        $stm->bindValue('valor', $doce->getValor());
        $stm->bindValue('ingredientes', $doce->getIngredientes());
        $stm->bindValue('idUsuario', $idUsuarioLogado);
        $stm->bindValue('idTipoDoce', $doce->getTipoDoce()->getIdTipoDoce());
        $stm->execute();
    }

    public function update(Doce $doce)
    {
        $conn = Connection::getConn();

        // Atualizar 
        $sql = "UPDATE Doce SET nomeDoce = :nomeDoce, descricao = :descricao, caminhoImagem = :caminhoImagem,
                valor = :valor, ingredientes = :ingredientes, idTipoDoce = :idTipoDoce
                WHERE idDoces = :id";

        try {
            $stm = $conn->prepare($sql);

            // Vincular os valores aos parâmetros
            $stm->bindValue(':nomeDoce', $doce->getNomeDoce());
            $stm->bindValue(':descricao', $doce->getDescricao());
            $stm->bindValue(':caminhoImagem', $doce->getCaminhoImagem());
            $stm->bindValue(':valor', $doce->getValor());
            $stm->bindValue(':ingredientes', $doce->getIngredientes());
            $stm->bindValue(':idTipoDoce', $doce->getTipoDoce()->getIdTipoDoce());
            $stm->bindValue(':id', $doce->getIdDoces());

            // Executar a query
            $stm->execute();
        } catch (PDOException $e) {
            $erros = array("Erro ao atualizar o doce na base de dados." . $e->getMessage());
        }
    }


    //Método para excluir um Doce pelo seu ID
    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM Doce WHERE idDoces = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    //Método para converter um registro da base de dados em um objeto Doce
    private function mapDoce($result)
    {
        $doces = array();
        foreach ($result as $reg) {
            $doce = new Doce();
            $doce->setIdDoces($reg['idDoces']);
            $doce->setNomeDoce($reg['nomeDoce']);
            $doce->setDescricao($reg['descricao']);
            $doce->setCaminhoImagem($reg['caminhoImagem']);
            $doce->setValor($reg['valor']);
            $doce->setIngredientes($reg['ingredientes']);

            array_push($doces, $doce);

            // Verificar se 'nomeLoja' está definido antes de usá-lo, para evitar aviso de Undefined array key
            $confeiteiro = new Confeiteiro();
            $confeiteiro->setIdConfeiteiro($reg['idConfeiteiro']);
            if (isset($reg['nomeLoja'])) {
                $confeiteiro->setNomeLoja($reg['nomeLoja']);
                $confeiteiro->setLogo($reg['logo']);
            }
            $doce->setConfeiteiro($confeiteiro);

            $tipoDoce = new TipoDoce();
            $tipoDoce->setIdTipoDoce($reg['idTipoDoce']);
            if (isset($reg['tipo_descricao'])) {
                $tipoDoce->setDescricao($reg['tipo_descricao']);
            }
            $doce->setTipoDoce($tipoDoce);
        }

        return $doces;
    }
}
