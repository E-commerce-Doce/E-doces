<?php
#Nome do arquivo: ConfeiteiroDAO.php
#Objetivo: classe DAO para o model de confeiteiro

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Confeiteiro.php");
include_once(__DIR__ . "/../model/Usuario.php");



class ConfeiteiroDAO
{

    public function list()
    {
        $sql = "SELECT * FROM Confeiteiro c ORDER BY c.nomeLoja";
        $conn = Connection::getConn();
        $stm = $conn->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Confeiteiro c" .
            " WHERE c.idConfeiteiro = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $confeiteiros = $this->mapConfeiteiro($result);

        if (count($confeiteiros) == 1)
            return $confeiteiros[0];
        elseif (count($confeiteiros) == 0)
            return null;

        die("ConfeiteiroDAO.findById()" .
            " - Erro: mais de um confeiteiro encontrado.");
    }

    public function findConfeiteiroByIdUsuario(int $idUsuario)
{
    $conn = Connection::getConn();

    $sql = "SELECT * FROM Confeiteiro c WHERE c.idUsuario = ?";
    $stm = $conn->prepare($sql);
    $stm->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $stm->execute([$idUsuario]);
    $result = $stm->fetchAll();

    // Mapeia os resultados
    $confeiteiros = $this->mapConfeiteiro($result);

    // Retorna o primeiro confeiteiro encontrado ou null
    if (count($confeiteiros) == 1) {
        return $confeiteiros[0];
    } else {
        return null;
    }
}
    

    public function insert(Confeiteiro $confeiteiro)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO Confeiteiro (nomeLoja, mei, qrCode, logo, idUsuario)" .
            " VALUES (:nomeLoja, :mei, :qrCode, :logo ,:idUsuario)";


        $stm = $conn->prepare($sql);
        $stm->bindValue('nomeLoja', $confeiteiro->getNomeLoja());
        $stm->bindValue('mei', $confeiteiro->getMei());
        $stm->bindValue('qrCode', $confeiteiro->getQrCode());
        $stm->bindValue('logo', $confeiteiro->getLogo());
        $stm->bindValue('idUsuario', $confeiteiro->getUsuario()->getId());

        $stm->execute();
    }

    public function update(Confeiteiro $confeiteiro)
    {
        $conn = Connection::getConn();
    
        // Verifica se o idConfeiteiro está presente
        $idConfeiteiro = $confeiteiro->getIdConfeiteiro();
        if (!$idConfeiteiro) {
            throw new Exception("ID do confeiteiro não encontrado.");
        }
    
        // Atualizar dados do confeiteiro
        $sql = "UPDATE Confeiteiro SET nomeLoja = :nomeLoja, mei = :mei, qrCode = :qrCode, logo = :logo
                WHERE idConfeiteiro = :idConfeiteiro";
    
        try {
            $stm = $conn->prepare($sql);
    
            // Vincular os valores aos parâmetros
            $stm->bindValue(':nomeLoja', $confeiteiro->getNomeLoja());
            $stm->bindValue(':mei', $confeiteiro->getMei());
            $stm->bindValue(':qrCode', $confeiteiro->getQrCode());
            $stm->bindValue(':logo', $confeiteiro->getLogo());
            $stm->bindValue(':idConfeiteiro', $idConfeiteiro);  // Passando o idConfeiteiro para a query
    
            // Executar a query
            $stm->execute();
        } catch (PDOException $e) {
            $erros = array("Erro ao atualizar o confeiteiro na base de dados." . $e->getMessage());
            throw new Exception($erros[0]);
        }
    }
    

    //Método para excluir um Confeiteiro pelo seu ID
    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM Confeiteiro WHERE idConfeiteiro = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }


    private function mapConfeiteiro($result)
    {
        $confeiteiros = array();
        foreach ($result as $reg) {
            $confeiteiro = new Confeiteiro();
            $confeiteiro->setIdConfeiteiro($reg['idConfeiteiro'])
                ->setNomeLoja($reg['nomeLoja'])
                ->setMei($reg['mei'])
                ->setQrCode($reg['qrCode'])
                ->setLogo($reg['logo']);
            //->setUsuario($reg['idUsuario']);
            array_push($confeiteiros, $confeiteiro);

            $usuario = new Usuario();
            $usuario->setId($reg['idUsuario']);

            $confeiteiro->setUsuario($usuario);
        }
        return $confeiteiros;
    }
}
