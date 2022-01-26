<?php
namespace Teste\Unitario;

use \Teste\Teste;
use \Modelo\Usuario;
use \Modelo\Arquivo;
use \Modelo\Relatorio;

class TesteRelatorio extends Teste
{
   
    public function testeBuscarRegistros()
    {
        $this->logar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuario->getId());
        $arquivo->salvar();

        $registros = Relatorio::buscarRegistros($this->usuario->getId());

        $this->verificar(count($registros) > 0);
    }
   
}
