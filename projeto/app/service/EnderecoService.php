<?php

require_once(__DIR__ . "/../model/Endereco.php");
require_once(__DIR__ . "/../model/Usuario.php");

class EnderecoService
{

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Endereco $endereco)
    {
        $erros = array();

        //Validar campos vazios

        if (!$endereco->getCep())
            array_push($erros, "O campo CEP é obrigatório.");

        if (!$endereco->getNomeLogradouro())
            array_push($erros, "O campo Nome é obrigatório.");

        if (!$endereco->getNumero())
            array_push($erros, "O campo Numero é obrigatório.");


        if (!$endereco->getBairro())
            array_push($erros, "O campo bairro é obrigatório.");

        if (!$endereco->getEstado())
            array_push($erros, "O campo Estado é obrigatório.");


        if (!$endereco->getCidade())
            array_push($erros, "O campo cidade é obrigatório.");

        return $erros;
    }
}
