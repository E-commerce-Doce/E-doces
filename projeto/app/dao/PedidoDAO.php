<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Pedido.php");
include_once(__DIR__ . "/../model/Endereco.php");
include_once(__DIR__ . "/../model/Confeiteiro.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/PedidoDoce.php");
include_once(__DIR__ . "/../model/Doce.php");

class PedidoDAO
{
    // Método privado para obter a consulta SQL base
    private function getBaseQuery()
    {
        return "SELECT p.*, c.nomeLoja, c.qrCode, u.nomeCompleto, u.login, u.telefone, e.nomeLogradouro, e.numero, e.bairro, 
                       e.cep, e.cidade, e.estado, e.complemento,
                       pd.idPedidoDoce, pd.idDoce, pd.quantidade, pd.valorUnitario, pd.valorTotal, 
                       d.nomeDoce
                FROM Pedido p
                LEFT JOIN Confeiteiro c ON c.idConfeiteiro = p.idConfeiteiro
                LEFT JOIN Usuario u ON u.idUsuario = p.idUsuario
                LEFT JOIN Endereco e ON e.idEndereco = p.idEndereco
                LEFT JOIN PedidoDoce pd ON pd.idPedido = p.idPedido
                LEFT JOIN Doce d ON pd.idDoce = d.idDoces";
    }

    // Método para buscar pedidos por confeiteiro
    public function listPedidoPorConfeiteiro($idConfeiteiro)
    {
        $conn = Connection::getConn();
        $sql = $this->getBaseQuery() . " WHERE c.idConfeiteiro = :idConfeiteiro ORDER BY p.horario";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idConfeiteiro', $idConfeiteiro, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapPedido($result);
    }

    // Método para listar todos os pedidos
    public function listPedidosCliente($idUsuario)
    {
        $conn = Connection::getConn();
        $sql = $this->getBaseQuery() . " WHERE u.idUsuario = :idUsuario ORDER BY p.horario";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapPedido($result);
    }

    public function insert(Pedido $pedido)
    {
        $conn = Connection::getConn();

        // Definindo o fuso horário para Brasília (GMT-3)
        date_default_timezone_set('America/Sao_Paulo');

        // Obter o horário atual no fuso horário de Brasília
        $horario = date('Y-m-d H:i:s');

        $sql = "INSERT INTO Pedido (idConfeiteiro, formaPagamento, status, horario, tipo, nomeComprovante, comprovante, idEndereco, idUsuario) 
        VALUES (:idConfeiteiro, :formaPagamento, :status, :horario, :tipo,  :nomeComprovante, :comprovante, :idEndereco, :idUsuario)";

        $stm = $conn->prepare($sql);
        $stm->bindValue(':idConfeiteiro', $pedido->getConfeiteiro()->getIdConfeiteiro());
        $stm->bindValue(':formaPagamento', $pedido->getFormaPagamento());
        $stm->bindValue(':status', $pedido->getStatus());
        $stm->bindValue(':horario', $horario);
        $stm->bindValue(':tipo', $pedido->getTipoEntrega());
        $stm->bindValue(':nomeComprovante', $pedido->getNomeComprovante());
        $stm->bindValue(':comprovante', $pedido->getComprovante());


        if ($pedido->getEndereco())
            $stm->bindValue(':idEndereco', $pedido->getEndereco()->getIdEndereco());
        else
            $stm->bindValue(':idEndereco', null);

        $stm->bindValue(':idUsuario', $pedido->getUsuario()->getId());

        $stm->execute();
        return $conn->lastInsertId();
    }


    public function makePagamento(Pedido $pedido)
    {
        $conn = Connection::getConn();


        $sql = "UPDATE Pedido
                SET comprovante = :comprovante, nomeComprovante = :nomeComprovante 
                WHERE idPedido = :idPedido";

        $stm = $conn->prepare($sql);
        $stm->bindValue(':idPedido', $pedido->getIdPedido());
        $stm->bindValue(':comprovante', $pedido->getComprovante());
        $stm->bindValue(':nomeComprovante', $pedido->getNomeComprovante());

        $stm->execute();
    }

    public function updateStatus($idPedido, $novoStatus)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE Pedido SET status = :status WHERE idPedido = :id";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':status', $novoStatus);
        $stm->bindParam(':id', $idPedido);
        return $stm->execute();
    }

    public function getTelefoneConfeiteiroByPedido($idPedido) {

        $conn = Connection::getConn();

        $sql = "SELECT u.telefone 
                FROM Pedido p
                JOIN Confeiteiro c ON p.idConfeiteiro = c.idConfeiteiro
                JOIN Usuario u ON c.idUsuario = u.idUsuario
                WHERE p.idPedido = :idPedido";
    
        $stm = $conn->prepare($sql);
        $stm->bindValue(':idPedido', $idPedido, PDO::PARAM_INT);
        $stm->execute();
    
        return $stm->fetchColumn(); // Retorna o telefone diretamente
    }
    

    // Método para buscar um pedido completo por ID
    public function findByIdCompleto(int $id)
    {
        $conn = Connection::getConn();
        $sql = $this->getBaseQuery() . " WHERE p.idPedido = ?";

        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $pedidos = $this->mapPedido($result);

        if (count($pedidos) == 1)
            return $pedidos[0];
        elseif (count($pedidos) == 0)
            return null;

        die("PedidoDAO.findByIdCompleto()" .
            " - Erro: mais de um pedido encontrado.");
    }

    //Método para buscar um pedido por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Pedido p" .
            " WHERE p.idPedido = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $pedidos = $this->mapPedido($result);

        if (count($pedidos) == 1)
            return $pedidos[0];
        elseif (count($pedidos) == 0)
            return null;

        die("PedidoDAO.findById()" .
            " - Erro: mais de um usuário encontrado.");
    }



    // Método para mapear os resultados da consulta em objetos Pedido, incluindo os doces
    private function mapPedido($result)
    {
        $pedidos = [];
        $pedidoAtual = null;

        foreach ($result as $reg) {
            // Se for um novo pedido, cria um novo objeto Pedido
            if (!$pedidoAtual || $pedidoAtual->getIdPedido() != $reg['idPedido']) {
                $pedidoAtual = new Pedido();
                $pedidoAtual->setIdPedido($reg['idPedido']);
                $pedidoAtual->setFormaPagamento($reg['formaPagamento']);
                $pedidoAtual->setStatus($reg['status']);
                $pedidoAtual->setHorario($reg['horario']);
                $pedidoAtual->setTipoEntrega($reg['tipo']);
                $pedidoAtual->setComprovante($reg['comprovante']);
                $pedidoAtual->setNomeComprovante($reg['nomeComprovante']);

                // Mapeando dados do confeiteiro
                $confeiteiro = new Confeiteiro();
                $confeiteiro->setIdConfeiteiro($reg['idConfeiteiro']);
                if (isset($reg['nomeLoja'])) {
                    $confeiteiro->setNomeLoja($reg['nomeLoja']);
                    $confeiteiro->setQrCode($reg['qrCode']);
                }
                $pedidoAtual->setConfeiteiro($confeiteiro);

                // Mapeando dados do usuário
                $usuario = new Usuario();
                $usuario->setId($reg['idUsuario']);
                if (isset($reg['nomeCompleto']))
                    $usuario->setNome($reg['nomeCompleto']);
                $usuario->setLogin($reg['login']);
                $usuario->setTelefone($reg['telefone']);
                $pedidoAtual->setUsuario($usuario);

                // Mapeando dados do endereço
                $endereco = new Endereco();
                if ($reg['idEndereco']) {
                    $endereco->setIdEndereco($reg['idEndereco']);
                    if (isset($reg['nomeLogradouro'])) {
                        $endereco->setNomeLogradouro($reg['nomeLogradouro']);
                        $endereco->setBairro($reg['bairro']);
                        $endereco->setNumero($reg['numero']);
                        $endereco->setCep($reg['cep']);
                        $endereco->setComplemento($reg['complemento']);
                        $endereco->setCidade($reg['cidade']);
                        $endereco->setEstado($reg['estado']);
                    }
                    $pedidoAtual->setEndereco($endereco);
                }

                // Adicionando o pedido à lista
                array_push($pedidos, $pedidoAtual);
            }

            // Mapeando dados do PedidoDoce
            if (isset($reg['idPedidoDoce'])) {
                $pedidoDoce = new PedidoDoce();
                $pedidoDoce->setIdPedidoDoce($reg['idPedidoDoce']);

                // Criando o objeto Doce e atribuindo valores
                $doce = new Doce();
                $doce->setIdDoces($reg['idDoce']);
                $doce->setNomeDoce($reg['nomeDoce']);
                $pedidoDoce->setDoce($doce);  // Atribuindo o Doce ao PedidoDoce

                $pedidoDoce->setQuantidade($reg['quantidade']);
                $pedidoDoce->setValorTotal($reg['valorTotal']);
                $pedidoDoce->setValorUnitario($reg['valorUnitario']);


                // Adicionando o PedidoDoce ao pedido
                $pedidoAtual->addPedidoDoce($pedidoDoce); // Usa addPedidoDoce para múltiplos doces
            }
        }

        return $pedidos;
    }
}
