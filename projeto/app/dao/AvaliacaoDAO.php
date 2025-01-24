<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Avaliacao.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/Pedido.php");
include_once(__DIR__ . "/../model/Confeiteiro.php");

class AvaliacaoDAO
{
    private $conn;

    // Método para listar avaliações de um confeiteiro
    public function listPorConfeiteiro(int $idConfeiteiro)
    {
        try {
            $conn = Connection::getConn();

            $sql = "SELECT a.*, u.nomeCompleto AS nomeCompleto, c.nomeLoja AS nomeLoja, p.horario AS horario
                    FROM Avaliacao a
                    JOIN Usuario u ON (u.idUsuario = a.idUsuario)
                    JOIN Pedido p ON (p.idPedido = a.idPedido)
                    JOIN Confeiteiro c ON (c.idConfeiteiro = a.idConfeiteiro)
                    WHERE a.idConfeiteiro = :idConfeiteiro
                    ORDER BY a.idAvaliacao DESC";

            $stm = $conn->prepare($sql);
            $stm->bindValue(":idConfeiteiro", $idConfeiteiro);
            $stm->execute();

            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $this->mapAvaliacao($result); // Retorna as avaliações com dados completos
        } catch (PDOException $e) {
            // Tratar erro de listagem
            die("Erro ao listar avaliações: " . $e->getMessage());
        }
    }



    // Método para inserir uma avaliação
    public function insert(Avaliacao $avaliacao)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO Avaliacao (idPedido, nota, comentario, idConfeiteiro, idUsuario)
                 VALUES (:idPedido, :nota, :comentario, :idConfeiteiro, :idUsuario)";

        $stm = $conn->prepare($sql);
        $stm->bindValue('idPedido', $avaliacao->getPedido()->getIdPedido());
        $stm->bindValue('nota', $avaliacao->getNota());
        $stm->bindValue('comentario', $avaliacao->getComentario());
        $stm->bindValue('idConfeiteiro', $avaliacao->getConfeiteiro()->getIdConfeiteiro());
        $stm->bindValue('idUsuario', $avaliacao->getUsuario()->getId());

        $stm->execute();
    }

    // Método para buscar uma avaliação pelo pedido
    public function findByPedido(int $idPedido)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Avaliacao WHERE idPedido = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$idPedido]);
        $result = $stm->fetchAll();

        $avaliacoes = $this->mapAvaliacao($result);

        if (count($avaliacoes) == 1)
            return $avaliacoes[0];
        elseif (count($avaliacoes) == 0)
            return null;

        die("AvaliacaoDAO.findById()" .
            " - Erro: mais de uma Avalliação encontrada.");
    }



    // Método para converter um registro da base de dados em um objeto Avaliacao
    private function mapAvaliacao($result)
    {
        $avaliacoes = array();

        foreach ($result as $reg) {
            $avaliacao = new Avaliacao();
            $avaliacao->setIdAvaliacao($reg['idAvaliacao']);
            $avaliacao->setNota($reg['nota']);
            $avaliacao->setComentario($reg['comentario']);

            // Adiciona a avaliação à lista
            array_push($avaliacoes, $avaliacao);

            $confeiteiro = new Confeiteiro();
            $confeiteiro->setIdConfeiteiro($reg['idConfeiteiro']);
            if(isset($reg['nomeLoja'])) {
                $confeiteiro->setNomeLoja($reg['nomeLoja']);;
            }
            $avaliacao->setConfeiteiro($confeiteiro);

            $pedido = new Pedido();
            $pedido->setIdPedido($reg['idPedido']);

            $avaliacao->setPedido($pedido);

            $usuario = new Usuario();
            $usuario->setId($reg['idUsuario']);
            if(isset($reg['nomeCompleto'])) {
                $usuario->setNome($reg['nomeCompleto']);;
            }

            $avaliacao->setUsuario($usuario);
        }

        return $avaliacoes;
    }
}
