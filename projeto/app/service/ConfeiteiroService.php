<?php
require_once(__DIR__ . "/../model/Confeiteiro.php");



class ConfeiteiroService
{

    /* Método para validar os dados do confeiteiro que vem do formulário */
    public function validarDados(Confeiteiro $confeiteiro, $qrCodeImgAtual, $qrCodeImg)
    {
        $erros = array();

        //Validar campos vazios
        if (!$confeiteiro->getNomeLoja())
            array_push($erros, "O campo [Nome Loja] é obrigatório.");

        if (!$confeiteiro->getMei())
            array_push($erros, "O campo [MEI] é obrigatório.");

        if (!$qrCodeImgAtual && $qrCodeImg['size'] <= 0)
            array_push($erros, "O campo [QrCode] é obrigatório.");

        return $erros;
    }
}
