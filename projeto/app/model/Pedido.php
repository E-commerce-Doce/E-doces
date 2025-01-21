<?php
#Nome do arquivo: Pedido.php
#Objetivo: classe Model para Pedido

require_once(__DIR__ . "/enum/FormaPagamento.php");
require_once(__DIR__ . "/enum/TipoEntrega.php");
require_once(__DIR__ . "/enum/StatusPedido.php");

class Pedido
{

    private  ?int $idPedido;
    private  ?string $formaPagamento;
    private  ?string $status;
    private  ?string $horario;
    private  ?string $tipoEntrega;
    private ?string $comprovante = null;
    private ?string $nomeComprovante = null;
    private  ?Endereco $endereco;
    private  ?Usuario $usuario;
    private  ?Confeiteiro $confeiteiro;
    private  array $pedidoDoces= [];

    private ?Avaliacao $avaliacaoObj;



    public function __construct(int $idPedido = 0)
    {
        $this->idPedido = $idPedido;
        $this->endereco = null;
        $this->confeiteiro = null;
        $this->usuario = null;
        $this->pedidoDoces = []; // Inicializando com array vazio
        $this->avaliacaoObj = null;

    }

    public function getIdPedido(): ?int
    {
        return $this->idPedido;
    }

    public function setIdPedido(?int $idPedido): self
    {
        $this->idPedido = $idPedido;
        return $this;
    }


    public function getFormaPagamento(): ?string
    {
        return $this->formaPagamento;
    }

    public function setFormaPagamento(?string $formaPagamento): self
    {
        $this->formaPagamento = $formaPagamento;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }


    public function getHorario(): ?string
    {
        return $this->horario;
    }

    public function setHorario(?string $horario): self
    {
        $this->horario = $horario;
        return $this;
    }


    public function getTipoEntrega(): ?string
    {
        return $this->tipoEntrega;
    }

    public function setTipoEntrega(?string $tipoEntrega): self
    {
        $this->tipoEntrega = $tipoEntrega;
        return $this;
    }

    public function getComprovante()
    {
        return $this->comprovante;
    }
    public function setComprovante($comprovante)
    {
        $this->comprovante = $comprovante;
    }

    public function getNomeComprovante()
    {
        return $this->nomeComprovante;
    }
    public function setNomeComprovante($nomeComprovante)
    {
        $this->nomeComprovante = $nomeComprovante;
    }


    public function getEndereco(): ?Endereco
    {
        return $this->endereco;
    }

    public function setEndereco(?Endereco $endereco): self
    {
        $this->endereco = $endereco;
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


    public function getConfeiteiro(): ?Confeiteiro
    {
        return $this->confeiteiro;
    }

    public function setConfeiteiro(?Confeiteiro $confeiteiro): self
    {
        $this->confeiteiro = $confeiteiro;
        return $this;
    }

    public function addPedidoDoce(PedidoDoce $pedidoDoce): void
    {
        $this->pedidoDoces[] = $pedidoDoce; // Adiciona o PedidoDoce ao array
    }

    // Método para obter os doces do pedido
    public function getPedidosDoces(): array
    {
        return $this->pedidoDoces;
    }


    /**
     * Get the value of avaliacaoObj
     */ 
    public function getAvaliacaoObj()
    {
        return $this->avaliacaoObj;
    }

    /**
     * Set the value of avaliacaoObj
     *
     * @return  self
     */ 
    public function setAvaliacaoObj($avaliacaoObj)
    {
        $this->avaliacaoObj = $avaliacaoObj;

        return $this;
    }
}
