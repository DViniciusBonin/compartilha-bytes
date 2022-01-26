<?php
namespace Teste\Unitario;

use \Teste\Teste;
use \Modelo\Usuario;
use \Modelo\Arquivo;
use \Modelo\Comentario;
use \Framework\DW3BancoDeDados;


class TesteComentario extends Teste
{
	public function testeInserir()
	{
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $usuario->getId());
        $arquivo->salvar();
        $comentario = new Comentario(null, 'comentario teste', $usuario->getId(), $arquivo->getId());
        $comentario->salvar();
        $query = DW3BancoDeDados::query("SELECT * FROM comentarios where user_id = " . $usuario->getId() . ' and arquivo_id = ' . $arquivo->getId());
        $bdComentario = $query->fetch();
        $this->verificar($bdComentario !== false);
	}

    public function testeAtualizar()
    {
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $usuario->getId());
        $arquivo->salvar();
        $comentario = new Comentario(null, 'comentario teste', $usuario->getId(), $arquivo->getId());
        $comentario->salvar();
        $comentario->setTexto('comentario atualizado');
        $comentario->salvar();
        $query = DW3BancoDeDados::query("SELECT * FROM comentarios where user_id = " . $usuario->getId() . ' and arquivo_id = ' . $arquivo->getId());
        $bdComentario = $query->fetch();
        $this->verificar($bdComentario !== false);
        $this->verificar($bdComentario['texto'] == 'comentario atualizado');
    }

    public function testeBuscarId() 
    {
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $usuario->getId());
        $arquivo->salvar();
        $comentario = new Comentario(null, 'comentario teste', $usuario->getId(), $arquivo->getId());
        $comentario->salvar();

        $bdComentario = Comentario::buscarId($comentario->getId());
        $this->verificar($bdComentario !== false);
    }

    public function testeBuscarArquivoId() 
    {
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $usuario->getId());
        $arquivo->salvar();
        $comentario = new Comentario(null, 'comentario teste', $usuario->getId(), $arquivo->getId());
        $comentario->salvar();

        $bdComentario = Comentario::buscarArquivoId($arquivo->getId());
        $this->verificar($bdComentario !== false);
    }

    public function testeDestruir()
    {
        
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $usuario->getId());
        $arquivo->salvar();
        $comentario = new Comentario(null, 'comentario teste', $usuario->getId(), $arquivo->getId());
        $comentario->salvar();
        
        $comentario->destruir();

        $query = DW3BancoDeDados::query("SELECT * FROM comentarios");
        $bdComentario = $query->fetch();
        $this->verificar($bdComentario == false);
    }

   
}
