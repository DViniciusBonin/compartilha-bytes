<?php

namespace Controlador;

use \Modelo\Usuario;
use \Modelo\Relatorio;
use \Framework\DW3Sessao;

class RelatorioControlador extends Controlador
{
    public function index()
    {   
        $this->verificarLogado();

        $registros = Relatorio::buscarRegistros($this->getUsuario()->getId(), $_GET);

        $this->visao('relatorios/index.php', [
            'usuario' => $this->getUsuario() ,
            'registros' => $registros
        ]);
    }

}
