<?php 
require_once(__DIR__ . "/../model/Avaliacao.php");

class AvaliacaoService
{
    /* Método para validar os dados da avaliação do pedido */
    public function validarDados(Avaliacao $avaliacao)
    {
        $erros = array();

        // Validar nota da avaliação (de 1 a 5)
        if (!$avaliacao->getNota() || $avaliacao->getNota() < 1 || $avaliacao->getNota() > 5) {
            array_push($erros, "A nota deve ser entre 1 e 5.");
        }

        // Validar comentário (caso obrigatório)
        if ($avaliacao->getComentario() && strlen($avaliacao->getComentario()) < 10) {
            array_push($erros, "O comentário deve ter pelo menos 10 caracteres.");
        }

        return $erros;
    }
}
