<?php
#Nome do arquivo: Avaliacao.php
#Objetivo: classe Model para Avaliacao

require_once(__DIR__ . "/../model/Pedido.php");

class Avaliacao
{
    private $idAvaliacao;
    private $idPedido;
    private $nota;
    private $comentario;
    private $idConfeiteiro; // Certifique-se de ter a propriedade $idConfeiteiro

    // Getter para idConfeiteiro
    public function getIdConfeiteiro()
    {
        return $this->idConfeiteiro;
    }

    // Setter para idConfeiteiro
    public function setIdConfeiteiro($idConfeiteiro)
    {
        $this->idConfeiteiro = $idConfeiteiro;
    }

    // Outros getters e setters para idAvaliacao, idPedido, nota e comentario
    public function getIdAvaliacao()
    {
        return $this->idAvaliacao;
    }

    public function setIdAvaliacao($idAvaliacao)
    {
        $this->idAvaliacao = $idAvaliacao;
    }

    public function getNota()
    {
        return $this->nota;
    }

    public function setNota($nota)
    {
        $this->nota = $nota;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

    public function getIdPedido()
    {
        return $this->idPedido;
    }

    public function setIdPedido($idPedido)
    {
        $this->idPedido = $idPedido;
    }
}
