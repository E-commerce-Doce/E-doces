<?php

require_once(__DIR__ . "/../model/Usuario.php");

class UsuarioService
{

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Usuario $usuario, ?string $confSenha)
    {
        $erros = array();

        //Validar campos vazios
        if (!$usuario->getNome())
            array_push($erros, "O campo Nome é obrigatório.");

        if (!$usuario->getCpf())
            array_push($erros, "O campo CPF é obrigatório.");

        if (!$usuario->getTelefone())
            array_push($erros, "O campo Telefone é obrigatório.");

        if (!$usuario->getLogin())
            array_push($erros, "O campo Login é obrigatório.");

        if (!$usuario->getSenha())
            array_push($erros, "O campo Senha é obrigatório.");

        if (!$confSenha)
            array_push($erros, "O campo Confirmação da senha é obrigatório.");

        if (!$usuario->getDataNascimento()){
            array_push($erros, "O campo Data de Nascimento é obrigatório.");

        }else {
                // Validação da idade
                $nascimento = new DateTime($usuario->getDataNascimento());
                $hoje = new DateTime();
                $idade = $hoje->diff($nascimento)->y;
        
                // Verificar se a idade é menor que 18 anos
                if ($idade < 16) {
                    array_push($erros, "Para se cadastrar sua idade deve ser superior a 16!");
        }
    }

       

        //Validar se a senha é igual a contra senha
        if ($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha)
            array_push($erros, "O campo Senha deve ser igual ao Confirmação da senha.");

        return $erros;
    }

}