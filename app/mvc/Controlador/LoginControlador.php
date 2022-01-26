<?php

namespace Controlador;

use \Modelo\Usuario;
use \Framework\DW3Sessao;

class LoginControlador extends Controlador
{
    public function criar()
    {
        $this->visao('login/index.php', [
            'mensagem' => DW3Sessao::getFlash('mensagem', null)
        ]);
    }

    public function armazenar()
    {
        $usuario = Usuario::buscarEmail($_POST['email']);
        if ($usuario && $usuario->verificarSenha($_POST['senha'])) {
            DW3Sessao::set('usuario', $usuario->getId());
            $this->redirecionar(URL_RAIZ . 'arquivos');
        }else {
            DW3Sessao::setFlash('mensagem', 'Email ou senha incorretos!');
            $this->redirecionar(URL_RAIZ . 'login');
        }
    }

    public function destruir()
    {
        DW3Sessao::deletar('usuario');
        $this->redirecionar(URL_RAIZ . 'login');
    }
}
