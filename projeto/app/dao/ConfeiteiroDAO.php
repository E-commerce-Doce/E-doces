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

    public function insert(Confeiteiro $confeiteiro)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO Confeiteiro (nomeLoja, mei, idUsuario)" .
            " VALUES (:nomeLoja, :mei, :idUsuario)";


        $stm = $conn->prepare($sql);
        $stm->bindValue('nomeLoja', $confeiteiro->getNomeLoja());
        $stm->bindValue('mei', $confeiteiro->getMei());
        $stm->bindValue('idUsuario', $confeiteiro->getUsuario()->getId());

        $stm->execute();
    }

    public function update(Confeiteiro $confeiteiro)
    {
        $conn = Connection::getConn();

        // Atualizar 
        $sql = "UPDATE Confeiteiro SET nomeLoja = :nomeLoja, mei = :mei,
                WHERE idConfeiteiro = :id";

        try {
            $stm = $conn->prepare($sql);

            // Vincular os valores aos parâmetros
            $stm->bindValue(':nomeLoja', $confeiteiro->getNomeLoja());
            $stm->bindValue(':mei', $confeiteiro->getMei());
            // Executar a query
            $stm->execute();
        } catch (PDOException $e) {
            $erros = array("Erro ao atualizar o confeiteiro na base de dados." . $e->getMessage());
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
                ->setUsuario($reg['idUsuario']);
            array_push($confeiteiros, $confeiteiro);
        }
        return $confeiteiros;
    }
}
