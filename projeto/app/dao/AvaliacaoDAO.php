<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Avaliacao.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/Pedido.php");
include_once(__DIR__ . "/../model/Confeiteiro.php");

class AvaliacaoDAO
{
    private $conn;

    // Método para inserir uma avaliação
    public function insert(Avaliacao $avaliacao)
    {
        try {
            $conn = Connection::getConn();

            // SQL para inserir a avaliação associando o idUsuario a partir do idPedido
            $sql = "INSERT INTO avaliacoes (idPedido, nota, comentario, idConfeiteiro, idUsuario)
                    SELECT :idPedido, :nota, :comentario, :idConfeiteiro, p.idUsuario
                    FROM Pedido p
                    WHERE p.idPedido = :idPedido";

            // Preparando a consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idPedido', $avaliacao->getIdPedido());
            $stmt->bindValue(':nota', $avaliacao->getNota());
            $stmt->bindValue(':comentario', $avaliacao->getComentario());
            $stmt->bindValue(':idConfeiteiro', $avaliacao->getIdConfeiteiro());

            // Executando o insert
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratar erro de inserção
            die("Erro ao inserir avaliação: " . $e->getMessage());
        }
    }

    // Método para listar avaliações de um confeiteiro
    public function listPorConfeiteiro(int $idConfeiteiro)
    {
        try {
            $conn = Connection::getConn();

            // SQL para listar avaliações, incluindo informações do usuário e do pedido
            $sql = "SELECT a.*, u.nomeCompleto AS nomeUsuario, p.dataPedido AS dataPedido
                    FROM Avaliacao a
                    JOIN Usuario u ON (u.idUsuario = a.idUsuario)
                    JOIN Pedido p ON (p.idPedido = a.idPedido)
                    WHERE a.idConfeiteiro = :idConfeiteiro
                    ORDER BY a.idAvaliacao DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idConfeiteiro", $idConfeiteiro);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->mapAvaliacao($result); // Retorna as avaliações com dados completos
        } catch (PDOException $e) {
            // Tratar erro de listagem
            die("Erro ao listar avaliações: " . $e->getMessage());
        }
    }

    // Método para buscar uma avaliação pelo ID
    public function findById(int $idAvaliacao)
    {
        try {
            $conn = Connection::getConn();

            $sql = "SELECT * FROM avaliacoes WHERE idAvaliacao = :idAvaliacao";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idAvaliacao', $idAvaliacao);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $avaliacao = new Avaliacao();
                $avaliacao->setIdAvaliacao($row['idAvaliacao']);
                $avaliacao->setIdPedido($row['idPedido']);
                $avaliacao->setNota($row['nota']);
                $avaliacao->setComentario($row['comentario']);
                $avaliacao->setIdConfeiteiro($row['idConfeiteiro']); // Preenche o idConfeiteiro

                return $avaliacao;
            }

            return null;
        } catch (PDOException $e) {
            // Tratar erro de busca
            die("Erro ao buscar avaliação: " . $e->getMessage());
        }
    }

    // Método para atualizar uma avaliação existente
    public function update(Avaliacao $avaliacao)
    {
        try {
            $conn = Connection::getConn();

            // SQL para atualizar a avaliação
            $sql = "UPDATE avaliacoes
                    SET nota = :nota, comentario = :comentario
                    WHERE idAvaliacao = :idAvaliacao";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':nota', $avaliacao->getNota());
            $stmt->bindValue(':comentario', $avaliacao->getComentario());
            $stmt->bindValue(':idAvaliacao', $avaliacao->getIdAvaliacao()); // Passa o id da avaliação a ser atualizada

            // Executando a atualização
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratar erro de atualização
            die("Erro ao atualizar avaliação: " . $e->getMessage());
        }
    }

    // Método para excluir uma avaliação pelo ID
    public function deleteById(int $idAvaliacao)
    {
        try {
            $conn = Connection::getConn();

            // SQL para excluir a avaliação
            $sql = "DELETE FROM avaliacoes WHERE idAvaliacao = :idAvaliacao";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idAvaliacao', $idAvaliacao);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratar erro de exclusão
            die("Erro ao excluir avaliação: " . $e->getMessage());
        }
    }

    // Método para converter um registro da base de dados em um objeto Avaliacao
    private function mapAvaliacao($result)
    {
        $avaliacoes = array();
    
        foreach ($result as $reg) {
            $avaliacao = new Avaliacao();
            $avaliacao->setIdAvaliacao($reg['idAvaliacao']);
            $avaliacao->setIdPedido($reg['idPedido']);
            $avaliacao->setNota($reg['nota']);
            $avaliacao->setComentario($reg['comentario']);
            $avaliacao->setIdConfeiteiro($reg['idConfeiteiro']);
    
            // Associa o usuário que fez a avaliação
            $usuario = new Usuario();
            if (isset($reg['idUsuario'])) {
                $usuario->setId($reg['idUsuario']);
            }
            if (isset($reg['nomeUsuario'])) {
                $usuario->setNome($reg['nomeUsuario']);
            }
            $avaliacao->setIdAvaliacao($usuario);
    
            // Associa o confeiteiro relacionado à avaliação
            $confeiteiro = new Confeiteiro();
            if (isset($reg['idConfeiteiro'])) {
                $confeiteiro->setIdConfeiteiro($reg['idConfeiteiro']);
            }
            if (isset($reg['nomeLoja'])) {
                $confeiteiro->setNomeLoja($reg['nomeLoja']);
            }
            $avaliacao->setIdConfeiteiro($confeiteiro);
    
            // Adiciona a avaliação à lista
            array_push($avaliacoes, $avaliacao);
        }
    
        return $avaliacoes;
    }
    
}
?>
