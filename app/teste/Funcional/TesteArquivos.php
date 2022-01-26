<?php

namespace Teste\Funcional;

use \Teste\Teste;
use \Modelo\Arquivo;
use \Framework\DW3BancoDeDados;

class TesteArquivos extends Teste
{
    public function testeListagemDeslogado()
    {
        $resposta = $this->get(URL_RAIZ . 'arquivos');
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

    public function testeListagem()
    {
        $this->logar();
        (new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuario->getId()))->salvar();
        $resposta = $this->get(URL_RAIZ . 'arquivos');
        $this->verificarContem($resposta, 'Download');
    }

    
    public function testeArmazenarDeslogado()
    {
        $resposta = $this->post(URL_RAIZ . 'arquivos', [
            'descricao' => 'Olá deslogado'
        ]);
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

}
