<?php
class PedidoDoce
{
    private ?int $idPedidoDoce;
    private  ?Pedido $pedido;
    private  ?Doce $doce;
    private ?string $quantidade;
    private ?string $valorUnitario;
    private ?string $valorTotal;
    private ?string $comprovante = null;
    private ?string $nomeComprovante = null;


    public function __construct(int $idPedidoDoce = 0)
    {
        $this->idPedidoDoce = $idPedidoDoce;
        $this->pedido = null;
        
    }

    public function getIdPedidoDoce()
    {
        return $this->idPedidoDoce;
    }
    public function setIdPedidoDoce($idPedidoDoce)
    {
        $this->idPedidoDoce = $idPedidoDoce;
    }

    public function getPedido(): ?Pedido{
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self{
        $this->pedido = $pedido;
        return $this;
    }
    public function getDoce(): ?Doce{
        return $this->doce;
    }

    public function setDoce(?Doce $doce): self{
        $this->doce = $doce;
        return $this;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;
    }

    public function getValorTotal()
    {
        return $this->valorTotal;
    }
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
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
}
