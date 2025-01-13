<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Avaliacao.php");

class AvaliacaoDAO
{
    private $conn;

    // Método para inserir uma avaliação
    public function insert(Avaliacao $avaliacao)
    {
        $conn = Connection::getConn();
        $sql = "INSERT INTO avaliacoes (idPedido, nota, comentario, idConfeiteiro)
                VALUES (:idPedido, :nota, :comentario, :idConfeiteiro)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idPedido', $avaliacao->getIdPedido());
        $stmt->bindValue(':nota', $avaliacao->getNota());
        $stmt->bindValue(':comentario', $avaliacao->getComentario());
        $stmt->bindValue(':idConfeiteiro', $avaliacao->getIdConfeiteiro()); // Certifique-se de que esse campo existe no banco

        $stmt->execute();
    }

    // Método para buscar uma avaliação pelo ID
    public function findById($idAvaliacao)
    {
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
    }


    // Método para atualizar uma avaliação existente
    public function update(Avaliacao $avaliacao)
    {
        $conn = Connection::getConn();
        
        // SQL para atualizar uma avaliação existente
        $sql = "UPDATE avaliacoes
                SET nota = :nota, comentario = :comentario
                WHERE idAvaliacao = :idAvaliacao";

        $stmt = $conn->prepare($sql);

        // Bind dos valores para os parâmetros na consulta
        $stmt->bindValue(':nota', $avaliacao->getNota());
        $stmt->bindValue(':comentario', $avaliacao->getComentario());
        $stmt->bindValue(':idAvaliacao', $avaliacao->getIdAvaliacao()); // Passa o id da avaliação que será atualizada

        // Executa a consulta
        $stmt->execute();
    }

    // Método para excluir uma avaliação
    public function delete($idAvaliacao)
    {
        $conn = Connection::getConn();
        $sql = "DELETE FROM avaliacoes WHERE idAvaliacao = :idAvaliacao";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idAvaliacao', $idAvaliacao);

        // Executa a consulta
        $stmt->execute();
    }
}
