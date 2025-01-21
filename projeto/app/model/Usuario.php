<?php 
#Nome do arquivo: Usuario.php
#Objetivo: classe Model para Usuario

require_once(__DIR__ . "/enum/UsuarioPapel.php");
// require_once(__DIR__ . "/model/Confeiteiro.php");


class Usuario implements JsonSerializable{

    private ?int $id;
    private ?string $cpf;
    private ?string $papel;
    private ?string $nome;
    private ?string $telefone;
    private ?string $login;
    private ?string $senha;
    private ?string $dataNascimento;

    private ?Confeiteiro $confeiteiro;

    public function __construct($idUsuario = null)
    {
        $this->id= $idUsuario;
        $this->confeiteiro = null;
    }

    public function JsonSerialize():array{
        return array(""=> $this->id,
                    "cpf"=> $this->cpf,
                    "papel"=>$this->papel,
                    "nome"=>$this->nome,
                    "telefone"=>$this->telefone,
                    "login"=>$this->login,
                    "senha"=>$this->senha,
                    "dataNascimento"=>$this->dataNascimento
                   );
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

    public function getCpf(): ?string {
        return $this->cpf;
    }

    public function setCpf(?string $cpf): self {
        $this->cpf = $cpf;
        return $this;
    }

    public function getPapel(): ?string {
        return $this->papel;
    }

    public function setPapel(?string $papel): self {
        $this->papel = $papel;
        return $this;
    }

    public function getNome(): ?string {
        return $this->nome;
    }

    public function setNome(?string $nome): self {
        $this->nome = $nome;
        return $this;
    }

    public function getTelefone(): ?string {
        return $this->telefone;
    }

    public function setTelefone(?string $telefone): self {
        $this->telefone = $telefone;
        return $this;
    }

    public function getLogin(): ?string {
        return $this->login;
    }

    public function setLogin(?string $login): self {
        $this->login = $login;
        return $this;
    }

    public function getSenha(): ?string {
        return $this->senha;
    }

    public function setSenha(?string $senha): self {
        $this->senha = $senha;
        return $this;
    }

    public function getDataNascimento(): ?string {
        return $this->dataNascimento;
    }

    public function setDataNascimento(?string $dataNascimento): self {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }

    public function getDataNascimentoFormatada(): ?string {
        if($this->dataNascimento) {
            $data = DateTime::createFromFormat('Y-m-d', $this->dataNascimento);
            return $data->format('d/m/Y');
        }
        
        return "";
    }

   
    public function getConfeiteiro()
    {
        return $this->confeiteiro;
    }

   
    public function setConfeiteiro($confeiteiro)
    {
        $this->confeiteiro = $confeiteiro;

        return $this;
    }
}