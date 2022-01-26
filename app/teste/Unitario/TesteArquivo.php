<?php
namespace Teste\Unitario;

use \Teste\Teste;
use \Modelo\Usuario;
use \Modelo\Arquivo;
use \Framework\DW3BancoDeDados;

class TesteArquivo extends Teste
{
    private $usuarioId;

    public function antes()
    {
        $usuario = new Usuario('joao', '123', 'joao@gmail.com');
        $usuario->salvar();
        $this->usuarioId = $usuario->getId();
    }

    public function testeInserir()
    {
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuarioId);
        $arquivo->salvar();
        $query = DW3BancoDeDados::query("SELECT * FROM arquivos WHERE id = " . $arquivo->getId());
        $bdArquivo = $query->fetch();
        $this->verificar($bdArquivo['nome'] === $arquivo->getNome());
    }

    public function testeBuscarTodos()
    {
        (new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuarioId))->salvar();
        (new Arquivo('nomearquivo2', 'nomeoriginal2', 'descricao2', null,  $this->usuarioId))->salvar();
        $arquivos = Arquivo::buscarTodos();
        $this->verificar(count($arquivos) == 2);
    }

    public function testeContarTodos()
    {
        (new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuarioId))->salvar();
        (new Arquivo('nomearquivo2', 'nomeoriginal2', 'descricao2', null,  $this->usuarioId))->salvar();
        $total = Arquivo::contarTodos();
        $this->verificar($total == 2);
    }

    public function testeDestruir()
    {   
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuarioId);
        $arquivo->salvar();
        $query = DW3BancoDeDados::query("SELECT * FROM arquivos WHERE id = " . $arquivo->getId());
        $bdArquivo = $query->fetch();
        $this->verificar($bdArquivo['id'] === $arquivo->getId());
    }
}
