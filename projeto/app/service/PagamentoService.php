<?php

require_once(__DIR__ . "/../model/PedidoDoce.php");

class PagamentoService
{

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(PedidoDoce $pedidoDoce, $comprovanteImgAtual, $comprovanteImg)
    {
        $erros = array();

        //Validar campos vazios

        if (!$pedidoDoce->getNomeComprovante())
            array_push($erros, "O campo  [Nome do Comprovante] é obrigatório.");

        if (!$comprovanteImgAtual && $comprovanteImg['size'] <= 0)
            array_push($erros, "O campo [Comprovante] é obrigatório.");


        return $erros;
    }
}
