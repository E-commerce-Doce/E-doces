<?php
#Nome do arquivo: EnderecoDAO.php
#Objetivo: classe DAO para o model de Doce

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Endereco.php");
include_once(__DIR__ . "/../model/Usuario.php");


class EnderecoDAO{


      //Método para listar os usuaários a partir da base de dados
      public function list(int $idUsuario)
      {
          $conn = Connection::getConn();
      
          $sql = "SELECT e.*, u.idUsuario FROM Endereco e 
            JOIN Usuario u ON (u.idUsuario = e.idUsuario)
            WHERE e.idUsuario = :idUsuario 
            ORDER BY e.nomeLogradouro";
          
          $stm = $conn->prepare($sql);
          $stm->bindValue("idUsuario", $idUsuario);
          $stm->execute();
          $result = $stm->fetchAll();
      
          return $this->mapEnderecos($result);
      }
      

     //Método para buscar um usuário por seu ID
     public function findById(int $id)
     {
         $conn = Connection::getConn();
 
         $sql = "SELECT * FROM Endereco e" .
             " WHERE e.idEndereco = ?";
         $stm = $conn->prepare($sql);
         $stm->execute([$id]);
         $result = $stm->fetchAll();
 
         $enderecos = $this->mapEnderecos($result);
 
         if (count($enderecos) == 1)
             return $enderecos[0];
         elseif (count($enderecos) == 0)
             return null;
 
         die("EnderecoDAO.findById()" .
             " - Erro: mais de um Endereco encontrado.");
     }
 
     public function insert(Endereco $endereco)
     {
         $conn = Connection::getConn();
 
         $sql = "INSERT INTO Endereco (cep, nomeLogradouro, numero, bairro, estado, cidade, complemento,  idUsuario)" .
             " VALUES (:cep, :nomeLogradouro, :numero, :bairro, :estado,  :cidade , :complemento, :idUsuario)";
 
 
         $stm = $conn->prepare($sql);
         $stm->bindValue('cep', $endereco->getCep());
         $stm->bindValue('nomeLogradouro', $endereco->getNomeLogradouro());
         $stm->bindValue('numero', $endereco->getNumero());
         $stm->bindValue('bairro', $endereco->getBairro());
         $stm->bindValue('estado', $endereco->getEstado());
         $stm->bindValue('cidade', $endereco->getCidade());
         $stm->bindValue('complemento', $endereco->getComplemento());
         $stm->bindValue('idUsuario', $endereco->getUsuario()->getId());

         $stm->execute();
     }
 
     public function update(Endereco $endereco)
     {
         $conn = Connection::getConn();
 
         // Atualizar 
         $sql = "UPDATE Endereco SET cep = :cep,  nomeLogradouro = :nomeLogradouro, numero = :numero, bairro = :bairro, estado = :estado,
         cidade = :cidade, complemento = :complemento WHERE idEndereco = :id";
 
         try {
             $stm = $conn->prepare($sql);
 
             // Vincular os valores aos parâmetros
             $stm->bindValue('cep', $endereco->getCep());
             $stm->bindValue('nomeLogradouro', $endereco->getNomeLogradouro());
             $stm->bindValue('numero', $endereco->getNumero());
             $stm->bindValue('bairro', $endereco->getBairro());
             $stm->bindValue('estado', $endereco->getEstado());
             $stm->bindValue('cidade', $endereco->getCidade());
             $stm->bindValue('complemento', $endereco->getComplemento());
             $stm->bindValue(':id', $endereco->getIdEndereco());

             // Executar a query
             $stm->execute();
         } catch (PDOException $e) {
             $erros = array("Erro ao atualizar o Endereco na base de dados." . $e->getMessage());
         }
     }
 
     //Método para excluir um Endereco pelo seu ID
     public function deleteById(int $id)
     {
         $conn = Connection::getConn();
 
         $sql = "DELETE FROM Endereco WHERE idEndereco = :id";
 
         $stm = $conn->prepare($sql);
         $stm->bindValue("id", $id);
         $stm->execute();
     }
 
 
     private function mapEnderecos($result)
     {
         $enderecos = array();
         foreach ($result as $reg) {
             $endereco = new Endereco();
             $endereco->setIdEndereco($reg['idEndereco'])
                ->setCep($reg['cep'])
                 ->setNomeLogradouro($reg['nomeLogradouro'])
                 ->setNumero($reg['numero'])
                 ->setBairro($reg['bairro'])
                 ->setCidade($reg['cidade'])
                 ->setEstado($reg['estado'])
                 ->setComplemento($reg['complemento']);
                 
             array_push($enderecos, $endereco);
 
             $usuario = new Usuario();
             $usuario->setId($reg['idUsuario']);
            
             $endereco->setUsuario($usuario);
         }
         return $enderecos;
     }
 }
 
