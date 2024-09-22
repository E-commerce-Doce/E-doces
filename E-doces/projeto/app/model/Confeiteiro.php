<?php 
#Nome do arquivo: Confeiteiro.php
#Objetivo: classe Model para Confeiteiro
require_once(__DIR__ . "/Usuario.php");


    class Confeiteiro {
        private ?int $idConfeiteiro;
        private ?string $nomeLoja;
        private ?string $mei;
        private Usuario $usuario;

        
        
            
            public function getIdConfeiteiro(): ?int
            {
                return $this->idConfeiteiro;
            }
        
            public function setIdConfeiteiro(?int $idConfeiteiro): self
            {
                $this->idConfeiteiro = $idConfeiteiro;
                return $this;
            }
        
            public function getNomeLoja(): ?string
            {
                return $this->nomeLoja;
            }
        
            public function setNomeLoja(?string $nomeLoja): self
            {
                $this->nomeLoja = $nomeLoja;
                return $this;
            }
        
            public function getMei(): ?string
            {
                return $this->mei;
            }
        
            public function setMei(?string $mei): self
            {
                $this->mei = $mei;
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
        

