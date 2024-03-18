<?php 
#Nome do arquivo: Usuario.php
#Objetivo: classe Model para Usuario

require_once(__DIR__ . "/enum/UsuarioPapel.php");

class Usuario implements JsonSerializable{

    private ?int $id;
    private ?string $nome;
    private ?string $login;
    private ?string $senha;
    private ?string $papel;

    public function JsonSerialize():array{
        return array(""=> $this->id,
                    "nome"=>$this->nome,
                    "login"=>$this->login,
                    "papel"=>$this->papel);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(?string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getPapel(): ?string
    {
        return $this->papel;
    }

    public function setPapel(?string $papel): self
    {
        $this->papel = $papel;

        return $this;
    }
}