<?php
class Avaliacao
{
    private ?int $idAvaliacao;
    private ?Pedido $pedido;
    private ?int $nota;
    private ?string $comentario;
    private ?Confeiteiro $confeiteiro;
    private ?Usuario $usuario;

    public function __construct(int $idAvaliacao = 0)
    {
        $this->idAvaliacao = $idAvaliacao;
        $this->pedido = null;
        $this->confeiteiro = null;
    }

    public function getIdAvaliacao(): ?int
    {
        return $this->idAvaliacao;
    }

    public function setIdAvaliacao(?int $idAvaliacao): self
    {
        $this->idAvaliacao = $idAvaliacao;
        return $this;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;
        return $this;
    }

    public function getNota(): ?int
    {
        return $this->nota;
    }

    public function setNota(?int $nota): self
    {
        $this->nota = $nota;
        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;
        return $this;
    }

    public function getConfeiteiro(): ?Confeiteiro
    {
        return $this->confeiteiro;
    }

    public function setConfeiteiro(?Confeiteiro $confeiteiro): self
    {
        $this->confeiteiro = $confeiteiro;
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
