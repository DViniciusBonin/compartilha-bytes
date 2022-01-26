<?php
namespace Teste\Unitario;

use \Teste\Teste;
use \Modelo\Usuario;
use \Framework\DW3BancoDeDados;

class TesteUsuario extends Teste
{
	public function testeInserir()
	{
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $query = DW3BancoDeDados::query("SELECT * FROM usuarios WHERE email = 'usuario@teste.com'");
        $bdUsuairo = $query->fetch();
        $this->verificar($bdUsuairo !== false);
	}

    public function testeBuscarEmail()
    {
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $usuario = Usuario::buscarEmail('usuario@teste.com');
        $this->verificar($usuario !== false);
    }

    public function testeBuscarId() 
    {
        $usuario = new Usuario('usuario-teste', '123', 'usuario@teste.com');
        $usuario->salvar();
        $id = $usuario->getId();
        $usuario = Usuario::buscarId($id);
        $this->verificar($id === $usuario->getId());
    }
}
