<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/PedidoDoce.php");

class PedidoDoceDAO
{
    // Método para inserir um item no pedido
    public function insert(PedidoDoce $pedidoDoce)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO PedidoDoce (idPedido, idDoce, quantidade, valorUnitario, valorTotal, comprovante, nomeComprovante) 
                VALUES (:idPedido, :idDoce, :quantidade, :valorUnitario, :valorTotal, :comprovante, :nomeComprovante)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue('idPedido', $pedidoDoce->getPedido()->getIdPedido());
        $stm->bindValue('idDoce', $pedidoDoce->getDoce()->getIdDoces());
        $stm->bindValue('quantidade', $pedidoDoce->getQuantidade());
        $stm->bindValue('valorUnitario', $pedidoDoce->getValorUnitario());
        $stm->bindValue('valorTotal', $pedidoDoce->getValorTotal());
        $stm->bindValue('comprovante', $pedidoDoce->getComprovante());
        $stm->bindValue('nomeComprovante', $pedidoDoce->getNomeComprovante());

        $stm->execute();
    }

    public function makePagamento(PedidoDoce $pedidoDoce)
    {
        $conn = Connection::getConn();

        var_dump($pedidoDoce->getPedido()->getIdPedido());

    
        $sql = "UPDATE PedidoDoce 
                SET comprovante = :comprovante, nomeComprovante = :nomeComprovante 
                WHERE idPedido = :idPedido"; // Atualizando com base no idPedido
    
        $stm = $conn->prepare($sql);
        $stm->bindValue(':idPedido', $pedidoDoce->getPedido()->getIdPedido()); // Associar idPedido
        $stm->bindValue(':comprovante', $pedidoDoce->getComprovante());
        $stm->bindValue(':nomeComprovante', $pedidoDoce->getNomeComprovante());
    
        $stm->execute();
    }
    
    
    

    //Método para buscar um pedido por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM PedidoDoce pd" .
            " WHERE pd.idPedidoDoce = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $pedidosDoces = $this->mapPedidoDoce($result);

        if (count($pedidosDoces) == 1)
            return $pedidosDoces[0];
        elseif (count($pedidosDoces) == 0)
            return null;

        die("PedidoDoceDAO.findById()" .
            " - Erro: mais de um usuário encontrado.");
    }

    // Método para mapear os itens de pedido para objetos PedidoDoce
private function mapPedidoDoce($data)
{
    $pedidoDoces = array();
    foreach ($data as $reg) {
        $pedidoDoce = new PedidoDoce();
        $pedidoDoce->setIdPedidoDoce($reg['idPedidoDoce']);
        $pedidoDoce->setQuantidade($reg['quantidade']);
        $pedidoDoce->setValorUnitario($reg['valorUnitario']);
        $pedidoDoce->setValorTotal($reg['valorTotal']);
        $pedidoDoce->setComprovante($reg['comprovante']);
        $pedidoDoce->setNomeComprovante($reg['nomeComprovante']);
        
        // Atribuindo os dados do pedido e doce ao pedidoDoce
        $pedido = new Pedido();
        $pedido->setIdPedido($reg['idPedido']);
        $pedidoDoce->setPedido($pedido);

        $doce = new Doce();
        $doce->setIdDoces($reg['idDoce']);
        $doce->setNomeDoce($reg['nomeDoce']);

        $pedidoDoce->setDoce($doce);

        // Adiciona o objeto PedidoDoce ao array
        array_push($pedidoDoces, $pedidoDoce);
    }
    
    // Retorna todos os pedidos doces
    return $pedidoDoces;
}

}

