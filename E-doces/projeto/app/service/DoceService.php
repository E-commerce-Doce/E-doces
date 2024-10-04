<?php

require_once(__DIR__ . "/../model/Doce.php");
require_once(__DIR__ . "/../model/TipoDoce.php");


class DoceService
{

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Doce $doce, $arquivoImg, $caminhoImagemAtual)
    {
        $erros = array();

        //Validar campos vazios
        if (!$doce->getNomeDoce())
            array_push($erros, "O campo [Nome] é obrigatório.");

        if (!$doce->getDescricao())
            array_push($erros, "O campo [Descrição] é obrigatório.");

        if (!$caminhoImagemAtual && $arquivoImg['size'] <= 0)
            array_push($erros, "O campo [Imagem] é obrigatório.");

        if (!$doce->getValor())
            array_push($erros, "O campo [Valor] é obrigatório.");

        if (!$doce->getIngredientes())
            array_push($erros, "O campo [Ingredientes] é obrigatório.");

        return $erros;
    }
}
