<?php
#Nome do arquivo: DoceDAO.php
#Objetivo: classe DAO para o model de Doce

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/TipoDoce.php");

class TipoDoceDAO{

    public function list() {
        $sql = "SELECT idTipoDoce, descricao FROM TipoDoce";
        $conn = Connection::getConn();
        $stm = $conn->prepare($sql);
        $stm->execute();

        $registros = $stm->fetchAll(PDO::FETCH_ASSOC); 
        return $this->mapTipoDoce($registros);
    }

    private function mapTipoDoce($result)
     {
         $tipo = array();
         foreach ($result as $reg) {
            $tipoDoce = new TipoDoce();
            $tipoDoce->setIdTipoDoce($reg['idTipoDoce'])
                ->setDescricao($reg['descricao']) ;       
            array_push($tipo, $tipoDoce);
         }
 
         return $tipo;
     }
}