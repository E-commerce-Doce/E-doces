<?php 
#Nome do arquivo: Endereco.php
#Objetivo: classe Model para Endereço


class Endereco{
    private ?int $idEndereco;
    private ?string $cep;
    private ?string $nomeLogradouro;
    private ?int $numero;
    private ?string $bairro;
    private ?string $cidade;
    private ?string $estado;
    private ?string $complemento;
    private ?Usuario $usuario;
    

    public function __construct($idEndereco = 0)
    {
        $this->idEndereco= $idEndereco;
    }

    public function getEnderecoCompleto() {
        return  $this->nomeLogradouro . ", " . $this->numero . " - " . $this->bairro . " | " . $this->complemento . 
        " <br> " . $this->cidade . " - ". $this->estado;
    }

    public function getIdEndereco(): ?int
    {
        return $this->idEndereco;
    }

    public function setIdEndereco(?int $idEndereco): self
    {
        $this->idEndereco = $idEndereco;
        return $this;
    }

    public function getCep(): ?string
    {
        return $this->cep;
    }

    public function setCep(?string $cep): self
    {
        $this->cep = $cep;
        return $this;
    }

    public function getNomeLogradouro(): ?string
    {
        return $this->nomeLogradouro;
    }

    public function setNomeLogradouro(?string $nomeLogradouro): self
    {
        $this->nomeLogradouro = $nomeLogradouro;
        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;
        return $this;
    }

    public function getBairro(): ?string
    {
        return $this->bairro;
    }

    public function setBairro(?string $bairro): self
    {
        $this->bairro = $bairro;
        return $this;
    }

    public function getCidade(): ?string
    {
        return $this->cidade;
    }

    public function setCidade(?string $cidade): self
    {
        $this->cidade = $cidade;
        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): self
    {
        $this->estado = $estado;
        return $this;
    }

    public function getComplemento(): ?string
    {
        return $this->complemento;
    }

    public function setComplemento(?string $complemento): self
    {
        $this->complemento = $complemento;
        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

}