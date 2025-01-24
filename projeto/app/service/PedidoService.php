<?php
require_once(__DIR__ . "/../model/Pedido.php");



class PedidoService
{

    /* Método para validar os dados do confeiteiro que vem do formulário */
    public function validarDados(Pedido $pedido)
    {
        $erros = array();

        //Validar campos vazios
        if (!$pedido->getFormaPagamento())
            array_push($erros, "O campo Forma de Pagamento é obrigatório.");

        // Validar endereço
        if ($pedido->getTipoEntrega() == TipoEntrega::DELIVERY && empty($pedido->getEndereco())) {
            array_push($erros, "Você escolheu Entrega, por favor selecione o endereço.");
        }

        // Validar tipo de entrega (caso necessário)
        if (empty($pedido->getTipoEntrega())) {
            array_push($erros, "O campo Retirada ou Entrega? é obrigatório.");
        }

        return $erros;
    }
}