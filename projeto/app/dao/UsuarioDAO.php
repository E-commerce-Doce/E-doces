<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Usuario.php");

class UsuarioDAO
{

    //Método para listar os usuaários a partir da base de dados
    public function list()
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u ORDER BY u.nomeCompleto";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapUsuarios($result);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u" .
            " WHERE u.idUsuario = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findById()" .
            " - Erro: mais de um usuário encontrado.");
    }


    //Método para buscar um usuário por seu login e senha
    public function findByLoginSenha(string $login, string $senha)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u" .
            " WHERE BINARY u.login = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$login]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1) {
            //Tratamento para senha criptografada
            if (password_verify($senha, $usuarios[0]->getSenha()))
                return $usuarios[0];
            else
                return null;
        } elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findByLoginSenha()" .
            " - Erro: mais de um usuário encontrado.");
    }

    //Método para inserir um Usuario
    public function insert(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO Usuario (cpf, nomeCompleto, telefone, login, senha, dataNascimento, papel)" .
            " VALUES (:cpf, :nome, :telefone, :login, :senha, :dataNascimento, :papel)";


        $stm = $conn->prepare($sql);
        $stm->bindValue('cpf', $usuario->getCpf());
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("telefone", $usuario->getTelefone());
        $stm->bindValue("login", $usuario->getLogin());
        $senhaCript = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);
        $stm->bindValue("senha", $senhaCript);
        $stm->bindValue("dataNascimento", $usuario->getDataNascimento());
        $stm->bindValue("papel", $usuario->getPapel());
        $stm->execute();
    }

    //Método para atualizar um Usuario
    public function update(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE Usuario SET cpf = :cpf, nomeCompleto = :nome, login = :login, " .
            " telefone = :telefone, dataNascimento = :dataNascimento, " .
            " senha = :senha, papel = :papel" .
            " WHERE idUsuario = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue('cpf', $usuario->getCpf());
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("telefone", $usuario->getTelefone());
        $stm->bindValue("login", $usuario->getLogin());
        $senhaCript = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);
        $stm->bindValue("senha", $senhaCript);
        $stm->bindValue("dataNascimento", $usuario->getDataNascimento());
        $stm->bindValue("papel", $usuario->getPapel());
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }

    //Método para excluir um Usuario pelo seu ID
    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM Usuario WHERE idUsuario = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function count()
    {
        $conn = Connection::getConn();

        $sql = "SELECT COUNT(*) total FROM Usuario";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $result[0]["total"];
    }

    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapUsuarios($result)
    {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Usuario();
            $usuario->setId($reg['idUsuario']);
            $usuario->setCpf($reg['cpf']);
            $usuario->setNome($reg['nomeCompleto']);
            $usuario->setTelefone($reg['telefone']);
            $usuario->setLogin($reg['login']);
            $usuario->setSenha($reg['senha']);
            $usuario->setDataNascimento($reg['dataNascimento']);
            $usuario->setPapel($reg['papel']);
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }
}