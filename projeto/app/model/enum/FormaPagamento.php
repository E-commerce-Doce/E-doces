<?php
# Nome do arquivo: FormaPagamento.php
# Objetivo: Classe Enum para representar as formas de pagamento no model de Pedido

class FormaPagamento {

    public static string $SEPARADOR = "|";

    const DINHEIRO = "DINHEIRO";
    const PIX = "PIX";

    public static function getAllAsArray() {
        return [FormaPagamento::DINHEIRO, FormaPagamento::PIX];
    }

}
