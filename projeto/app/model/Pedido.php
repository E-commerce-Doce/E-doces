<?php 
#Nome do arquivo: Pedido.php
#Objetivo: classe Model para Pedido

require_once(__DIR__ . "/enum/FormaPagemento.php");
require_once(__DIR__ . "/enum/TipoEntrega.php");
require_once(__DIR__ . "/enum/StatusPedido.php");

class Pedido{

    private  ?int $idPedido;
    private  ?string $formaPagamento;
    private  ?string $avaliacao;
    private  ?string $status;
    private  ?string $horario;
    private  ?string $tipoEntrega;
    private  ?Endereco $endereco;
    private  ?Usuario $usuario;
    private  ?Confeiteiro $confeiteiro;

    
     public function getIdPedido(): ?int{
         return $this->idPedido;
     }
 
     public function setIdPedido(?int $idPedido): self{
         $this->idPedido = $idPedido;
         return $this;
     }
 

     public function getFormaPagamento(): ?string{
         return $this->formaPagamento;
     }
 
     public function setFormaPagamento(?string $formaPagamento): self{
         $this->formaPagamento = $formaPagamento;
         return $this;
     }

 
     public function getAvaliacao(): ?string{
         return $this->avaliacao;
     }
 
     public function setAvaliacao(?string $avaliacao): self{
         $this->avaliacao = $avaliacao;
         return $this;
     }
 

     public function getStatus(): ?string{
         return $this->status;
     }
 
     public function setStatus(?string $status): self{
         $this->status = $status;
         return $this;
     }

 
     public function getHorario(): ?string{
         return $this->horario;
     }
 
     public function setHorario(?string $horario): self{
         $this->horario = $horario;
         return $this;
     }

 
     public function getTipoEntrega(): ?string{
         return $this->tipoEntrega;
     }
 
     public function setTipoEntrega(?string $tipoEntrega): self{
         $this->tipoEntrega = $tipoEntrega;
         return $this;
     }

 
     public function getEndereco(): ?Endereco{
         return $this->endereco;
     }
 
     public function setEndereco(?Endereco $endereco): self {
         $this->endereco = $endereco;
         return $this;
     }

 
     public function getUsuario(): ?Usuario{
         return $this->usuario;
     }
 
     public function setUsuario(?Usuario $usuario): self{
         $this->usuario = $usuario;
         return $this;
     }
 
     
     public function getConfeiteiro(): ?Confeiteiro{
         return $this->confeiteiro;
     }
 
     public function setConfeiteiro(?Confeiteiro $confeiteiro): self{
         $this->confeiteiro = $confeiteiro;
         return $this;
     }
 }
