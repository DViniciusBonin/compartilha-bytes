<?php
namespace Teste\Funcional;

use \Teste\Teste;
use \Modelo\Arquivo;
use \Modelo\Comentario;
use \Framework\DW3Sessao;

class TesteRelatorio extends Teste
{
    public function testeAcessarCriarComentario()
    {   
        $this->logar();
        
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuario->getId());
        $arquivo->salvar();
        $comentario = new Comentario(null, 'comentario teste', $this->usuario->getId(), $arquivo->getId());
        $comentario->salvar();

        $resposta = $this->get(URL_RAIZ . 'relatorios');
        $this->verificarContem($resposta, 'nomeoriginal');
    }    
}
