<?php

namespace Controlador;

use Framework\DW3Sessao;
use Modelo\Arquivo;
use Modelo\Comentario;

class ComentarioControlador extends Controlador
{
    public function criar($id)
    {
        $this->verificarLogado();
        $arquivo = Arquivo::buscarId($id);

        $this->visao('comentarios/criar.php', [
            'arquivo' => $arquivo,
            'usuario' => $this->getUsuario(),
            'mensagem' => DW3Sessao::getFlash('mensagem', null)
        ]);
    }

    public function armazenar()
    {
        $this->verificarLogado();
        $usuario = $this->getUsuario();

        $comentario = new Comentario(null, $_POST['comentario'], $usuario->getId(), $_POST['arquivo_id']);
        if($comentario->isValido()) {
           $comentario->salvar();
           $this->redirecionar(URL_RAIZ . 'arquivos');
       }else{
        $this->setErros($comentario->getValidacaoErros());
        $errosRetornados = $comentario->getValidacaoErros();
        DW3Sessao::setFlash('mensagem', $errosRetornados);
            $this->redirecionar(URL_RAIZ . 'comentarios/' . $_POST['arquivo_id'] . '/editar');
       }
    }

    public function editar($arquivoId, $comentarioId) 
    {
        $this->verificarLogado();
        $arquivo = Arquivo::buscarId($arquivoId);
        $comentario = Comentario::buscarId($comentarioId);
    
        $this->visao('comentarios/editar.php', [
            'arquivo' => $arquivo,
            'comentario' => $comentario,
            'usuario' => $this->getUsuario(),
            'mensagem' => DW3Sessao::getFlash('mensagem', null)
        ]);
    }

    public function atualizar($id)
    {
        $this->verificarLogado();
      
        $comentario = Comentario::buscarId($id);
        $comentario->setTexto($_POST['comentario']);
        if($comentario->isValido() && $this->getUsuario()->getId() == $comentario->getUserId()) {
            $comentario->salvar();
            $this->redirecionar(URL_RAIZ . 'arquivos');
        }else{
         $this->setErros($comentario->getValidacaoErros());
         $errosRetornados = $comentario->getValidacaoErros();
         DW3Sessao::setFlash('mensagem', $errosRetornados);
             $this->redirecionar(URL_RAIZ . 'comentarios/' . $_POST['arquivo_id'] . '/editar');
        }
    }

    public function destruir($id)
    {
        $this->verificarLogado();
        $comentario = Comentario::buscarId($id);
        if ($comentario->getUserId() == $this->getUsuario()->getId()) {
            echo "entrei aqui";
            $comentario->destruir();
            DW3Sessao::setFlash('mensagemFlash', 'Comentário destruido.');
        } else {
            DW3Sessao::setFlash('mensagemFlash', [
                'Você não pode deletar as comentários dos outros.'
            ]);
        }
        $this->redirecionar(URL_RAIZ . 'arquivos');
    }
           
}
