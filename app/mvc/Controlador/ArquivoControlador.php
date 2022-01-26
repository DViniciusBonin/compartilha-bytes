<?php

namespace Controlador;

use Framework\DW3ImagemUpload;
use Framework\DW3Sessao;
use Modelo\Usuario;
use Modelo\Arquivo;

class ArquivoControlador extends Controlador
{

    private function calcularPaginacao()
    {
        $pagina = array_key_exists('p', $_GET) ? intval($_GET['p']) : 1;
        $limit = 2;
        $offset = ($pagina - 1) * $limit;
        $arquivos = Arquivo::buscarTodos($limit, $offset, $_GET);
        $ultimaPagina = ceil(Arquivo::contarTodos() / $limit);
        return compact('pagina', 'arquivos', 'ultimaPagina');
    }

    public function index()
    {
        $this->verificarLogado();

        $paginacao = $this->calcularPaginacao();
        

        $this->visao('arquivos/index.php', [
            'usuario' =>   $this->getUsuario(),
            'arquivos' => $paginacao['arquivos'],
            'pagina' => $paginacao['pagina'],
            'ultimaPagina' => $paginacao['ultimaPagina'],
            'mensagem' => DW3Sessao::getFlash('mensagem', null),
            'filtro' => array_key_exists('filtro', $_GET) ? $_GET['filtro'] : null 
        ]);
    }

    public function armazenar()
    {
        $this->verificarLogado();
        $usuario = $this->getUsuario();

        if (!array_key_exists('arquivo', $_FILES) || $_FILES['arquivo']['name'] === '' ) {
            $this->redirecionar(URL_RAIZ . 'arquivos?p=1');
        }

        $uploaddir =  PASTA_RAIZ . 'publico/uploads/';
        $nomeArquivo =   time() . $_FILES['arquivo']['name'];
        $uploadfile = $uploaddir . $nomeArquivo;

        $arquivo = new Arquivo($nomeArquivo, $_FILES['arquivo']['name'], $_POST['descricao'], null,  $usuario->getId());
        if ($arquivo->isValido() && move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)) {
            $arquivo->salvar();
            DW3Sessao::setFlash('mensagem', 'Upload de arquivo feito com sucesso!');
            $this->redirecionar(URL_RAIZ . 'arquivos');
        } else {
            $this->setErros($arquivo->getValidacaoErros());
            $errosRetornados = $arquivo->getValidacaoErros();
            DW3Sessao::setFlash('mensagem', $errosRetornados);
            $this->redirecionar(URL_RAIZ . 'arquivos?p=1');
        }
    }
}
