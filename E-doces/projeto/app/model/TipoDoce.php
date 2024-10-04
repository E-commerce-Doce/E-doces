<?php 
#Nome do arquivo: TipoDoce.php
#Objetivo: classe Model para TipoDoce

    class TipoDoce {
        private ?int $idTipoDoce;
        private ?string $descricao;

        
            public function getIdTipoDoce(): ?int
            {
                return $this->idTipoDoce;
            }
        
            public function setIdTipoDoce(?int $idTipoDoce): self
            {
                $this->idTipoDoce = $idTipoDoce;
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
        }
        




