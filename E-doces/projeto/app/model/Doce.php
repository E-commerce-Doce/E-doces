<?php 
#Nome do arquivo: Doce.php
#Objetivo: classe Model para Doce
require_once(__DIR__ . "/TipoDoce.php");
require_once(__DIR__ . "/Confeiteiro.php");




    class Doce {
        private ?int $idDoces;
        private ?string $nomeDoce;
        private ?string $descricao;
        private ?string $caminhoImagem;
        private ?float $valor;
        private ?string $ingredientes;
        private ?TipoDoce $tipoDoce;
        private ?Confeiteiro $confeiteiro;

        public function __construct()
        {
            $this->caminhoImagem = null;
        }
    
        public function getIdDoces(): ?int
        {
            return $this->idDoces;
        }
    
        public function setIdDoces(?int $idDoces): self
        {
            $this->idDoces = $idDoces;
            return $this;
        }
    

        public function getNomeDoce(): ?string
        {
            return $this->nomeDoce;
        }
    
        public function setNomeDoce(?string $nomeDoce): self
        {
            $this->nomeDoce = $nomeDoce;
            return $this;
        }
    

        public function getDescricao(): ?string
        {
            return $this->descricao;
        }
    
        public function setDescricao(?string $descricao): self
        {
            $this->descricao = $descricao;
            return $this;
        }

        public function getCaminhoImagem(): ?string
        {
            return $this->caminhoImagem;
        }
    
        public function setCaminhoImagem(?string $caminhoImagem): self
        {
            $this->caminhoImagem = $caminhoImagem;
            return $this;
        }
    

        public function getValor(): ?float
        {
            return $this->valor;
        }

        public function getValorFormatado() {
            if($this->valor)
                return number_format($this->valor, 2, ",", ".");

            return "";
        }
    
        public function setValor(?float $valor): self
        {
            $this->valor = $valor;
            return $this;
        }
    

        public function getIngredientes(): ?string
        {
            return $this->ingredientes;
        }
    
        public function setIngredientes(?string $ingredientes): self
        {
            $this->ingredientes = $ingredientes;
            return $this;
        }
    

        public function getTipoDoce(): ?TipoDoce
        {
            return $this->tipoDoce;
        }
    
        public function setTipoDoce(?TipoDoce $tipoDoce): self
        {
            $this->tipoDoce = $tipoDoce;
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
    }
    

