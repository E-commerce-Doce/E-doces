<?php
# Nome do arquivo: TipoEntrega.php
# Objetivo: Classe Enum para representar as formas de pagamento no model de Pedido

class TipoEntrega {

    public static string $SEPARADOR = "|";

    const RETIRADA = "RETIRADA";
    const DELIVERY = "DELIVERY";
    


    public static function getAllAsArray() {
        return [TipoEntrega::RETIRADA, TipoEntrega::DELIVERY];
    }

}
