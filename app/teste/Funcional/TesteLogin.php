<?php

namespace Teste\Funcional;

use \Teste\Teste;
use \Modelo\Usuario;
use \Framework\DW3Sessao;

class TesteLogin extends Teste
{
    public function testeAcessar()
    {
        $resposta = $this->get(URL_RAIZ . 'login');
        $this->verificarContem($resposta, 'Login');
    }


    public function testeLogar()
    {
        (new Usuario('Joao', '123', 'joao@gmail.com'))->salvar();
        $resposta = $this->post(URL_RAIZ . 'login', [
            'email' => 'joao@gmail.com',
            'senha' => '123'
        ]);
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'arquivos');
        $this->verificar(DW3Sessao::get('usuario') != null);
    }

    public function testeLogarInvalido()
    {
        (new Usuario('Joao', '123', 'joao@gmail.com'))->salvar();
        $resposta = $this->post(URL_RAIZ . 'login', [
            'email' => 'joao@gmail.com',
            'senha' => '1234'
        ]);
        
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
        $resposta2 = $this->get(URL_RAIZ . 'login');
        $this->verificar(DW3Sessao::getFlash('mensagem', null) == 'Email ou senha incorretos!');
    }   


    public function testeDeslogar()
    {
        (new Usuario('Joao', '123', 'joao@gmail.com'))->salvar();
        $resposta = $this->post(URL_RAIZ . 'login', [
            'email' => 'joao@gmail.com',
            'senha' => '123'
        ]);
        $resposta = $this->delete(URL_RAIZ . 'login');
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
        $this->verificar(DW3Sessao::get('usuario') == null);
    }
}
