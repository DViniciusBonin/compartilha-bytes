<?php

namespace Controlador;

use \Modelo\Usuario;
use \Framework\DW3Sessao;

class UsuarioControlador extends Controlador
{
    public function index()
    {
        $this->visao('usuarios/criar.php', [
            'mensagem' => DW3Sessao::getFlash('mensagem', null)
        ]);
    }


    public function armazenar()
    {

        $usuario = new Usuario($_POST['nome'], $_POST['senha'], $_POST['email']);
        if ($usuario->isValido()) {
            $usuario->salvar();
            DW3Sessao::setFlash('mensagem', 'Usuário cadastrado com sucesso!');
            $this->redirecionar(URL_RAIZ . 'usuarios/criar');
        } else {
            $this->setErros($usuario->getValidacaoErros());
            $errosRetornados = $usuario->getValidacaoErros();
        }

        DW3Sessao::setFlash('mensagem', $errosRetornados);
        $this->redirecionar(URL_RAIZ . 'usuarios/criar');
    }
}
