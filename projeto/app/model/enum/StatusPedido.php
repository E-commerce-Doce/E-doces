<?php
# Nome do arquivo: Status.php
# Objetivo: Classe Enum para representar as formas de pagamento no model de Pedido

class Status {

    public static string $SEPARADOR = "|";

    const RECEBIDO = "RECEBIDO";
    const PREPARANDO = "PREPARANDO";
    const ENVIADO = "ENVIADO";
    const ENTREGUE = "ENTREGUE";
    const CANCELADO = "CANCELADO";


    public static function getAllAsArray() {
        return [Status::RECEBIDO, Status::PREPARANDO,  Status::ENVIADO,  Status::ENTREGUE,  Status::CANCELADO];
    }

}
