<?php
//Classe service para aluno

require_once(__DIR__ . "/../util/config.php");

class ArquivoService
{
    public function salvarArquivo($arquivo)
    {
        if ($arquivo['size'] <= 0) {
            return null;
        }

        //Captura o nome e a extensão do arquivo
        $arquivoNome = explode('.', $arquivo['name']);
        $arquivoExtensao = $arquivoNome[1];

        //A partir da extensão, o ideal é gerar um nome único para o arquivo
        //Exemplo: pode-se concatenar um identificador único do tipo UUID
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        $nomeArquivoSalvar = "arquivo_" . $uuid . "." . $arquivoExtensao;

        //Salva a foto no diretorio de arquivos
        if (move_uploaded_file($arquivo["tmp_name"], DIR_ARQUIVOS . "/" . $nomeArquivoSalvar)) {
            return $nomeArquivoSalvar;

        } else {
            //echo "Erro, o arquivo não pode ser enviado.";
            return null;
        }
    }

    public function removerArquivo($nomeArquivo)
    {
        $caminhoArquivo = DIR_ARQUIVOS . "/" . $nomeArquivo;

        if (file_exists($caminhoArquivo))
            unlink($caminhoArquivo);
    }
}
