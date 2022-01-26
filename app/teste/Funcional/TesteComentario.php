<?php
namespace Teste\Funcional;

use \Teste\Teste;
use \Modelo\Usuario;
use \Modelo\Arquivo;
use \Modelo\Comentario;
use \Framework\DW3Sessao;
use \Framework\DW3BancoDeDados;

class TesteComentario extends Teste
{
    public function testeAcessarCriarComentario()
    {   
        $this->logar();
        
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $usuario->getId());
        $arquivo->salvar();
        $comentario = new Comentario(null, 'comentario teste', $usuario->getId(), $arquivo->getId());
        $comentario->salvar();

        $resposta = $this->get(URL_RAIZ . 'comentarios/' . $arquivo->getId() . '/criar');
        $this->verificarContem($resposta, 'Digite seu comentário....');
    }

    public function testeAcessarEditarComentario()
    {   
        $this->logar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuario->getId());
        $arquivo->salvar();
        $comentario = new Comentario(null, 'comentario teste', $this->usuario->getId(), $arquivo->getId());
        $comentario->salvar();

        $resposta = $this->get(URL_RAIZ . 'comentarios/' . $arquivo->getId() . "/editar/" . $comentario->getId());

        $this->verificarContem($resposta, $comentario->getTexto());
    }

    public function testeCriarComentario() {
        $this->logar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuario->getId());
        $arquivo->salvar();

        $resposta = $this->post(URL_RAIZ . 'comentarios', [ 
            'comentario' => 'testando criar comentario',
            'arquivo_id' => $arquivo->getId()
        ]);

        $this->verificarRedirecionar($resposta, URL_RAIZ . 'arquivos');

        $query = DW3BancoDeDados::query("SELECT * FROM comentarios");
        $bdArquivo = $query->fetch();
        $this->verificar($bdArquivo !== false);
    }
    
    public function testeAtualizarComentario() {
        $this->logar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuario->getId());
        $arquivo->salvar();

        $resposta1 = $this->post(URL_RAIZ . 'comentarios', [ 
            'comentario' => 'testando criar comentario',
            'arquivo_id' => $arquivo->getId()
        ]);

        $query = DW3BancoDeDados::query("SELECT * FROM comentarios");
        $bdComentario = $query->fetch();
        
        $resposta2 = $this->patch(URL_RAIZ . 'comentarios/' . $bdComentario['id'], [
            'comentario' => 'testando atualizar comentario'
        ]);

        $query = DW3BancoDeDados::query("SELECT * FROM comentarios");
        $bdComentario = $query->fetch();
        
        $this->verificar($bdComentario['texto'] === 'testando atualizar comentario');
    }
    
    public function testeDeletarComentario() {
        $this->logar();
        $arquivo = new Arquivo('nomearquivo', 'nomeoriginal', 'descricao', null,  $this->usuario->getId());
        $arquivo->salvar();

        $resposta1 = $this->post(URL_RAIZ . 'comentarios', [ 
            'comentario' => 'testando criar comentario',
            'arquivo_id' => $arquivo->getId()
        ]);

        $query = DW3BancoDeDados::query("SELECT * FROM comentarios");
        $bdComentario = $query->fetch();
        
        $resposta2 = $this->delete(URL_RAIZ . 'comentarios/' . $bdComentario['id']);

        $query = DW3BancoDeDados::query("SELECT * FROM comentarios");
        $bdComentario = $query->fetch();
        
        $this->verificar($bdComentario === false);
    }

    
}
