<?php

namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;

class Arquivo extends Modelo
{
    const BUSCAR_ID = 'SELECT * FROM arquivos WHERE id = ?';
    const BUSCAR_TODOS = 'SELECT a.id as arquivo_id, a.nome_original as nomeOriginal, a.nome as nome, a.descricao as descricao, u.id as usuario, u.nome as nomeUsuario FROM arquivos a JOIN usuarios u ON (a.user_id = u.id) WHERE TRUE';
    const INSERIR = 'INSERT INTO arquivos(nome, nome_original, descricao, user_id) VALUES (?, ?, ?, ?)';
    const CONTAR_TODOS = 'SELECT count(id) FROM arquivos';
    
    private $nome;
    private $nomeOriginal;
    private $descricao;
    private $criadoEm;
    private $userId;
    private $id;
    private $comentarios;

    public function __construct(
        $nome = null,
        $nomeOriginal = null,
        $descricao = null,
        $criadoEm = null,
        $userId = null,
        $id = null,
        $comentarios = null
    ) {
        $this->nome = $nome;
        $this->nomeOriginal = $nomeOriginal;
        $this->descricao = $descricao;
        $this->criadoEm = $criadoEm;
        $this->userId = $userId;
        $this->id = $id;
        $this->comentarios = $comentarios;
    }

    public function getComentarios() {
        return $this->comentarios;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }


    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getNomeOriginal()
    {
        return $this->nomeOriginal;
    }


    public function setNomeOriginal($nome)
    {
        $this->nomeOriginal = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }


    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getUserId()
    {
        return $this->userId;
    }


    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function salvar()
    {
        $this->inserir();
    }

    public function inserir()
    {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->nome, PDO::PARAM_STR);
        $comando->bindValue(2, $this->nomeOriginal, PDO::PARAM_STR);
        $comando->bindValue(3, $this->descricao, PDO::PARAM_STR);
        $comando->bindValue(4, $this->userId, PDO::PARAM_STR);

        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }

    public static function buscarId($id)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $registro = $comando->fetch();


        return new Arquivo(
            $registro['nome'],
            $registro['nome_original'],
            $registro['descricao'],
            null,
            $registro['user_id'],
            $registro['id']
        );
    }

    public static function buscarTodos($limit = 4, $offset = 0, $filtro = [])
    {   
        $sqlWhere = '';
        $parametros = [];
        if (array_key_exists('filtro', $filtro) && $filtro['filtro'] != '') {
            $descricao = $filtro['filtro'];
            $sqlWhere .= " AND a.descricao  LIKE '$descricao%' ";
        }
        if (array_key_exists('ordenacao', $filtro) && $filtro['ordenacao'] != '') {
            if($filtro['ordenacao'] == 'criado_em') {
                $sqlWhere .= ' ORDER BY a.criado_em DESC LIMIT ? OFFSET ?';
            }else if($filtro['ordenacao'] == 'nome') {
                $sqlWhere .= ' ORDER BY nome_original LIMIT ? OFFSET ?';
            }
           
        }else {
            $sqlWhere .= ' ORDER BY a.id DESC  LIMIT ? OFFSET ?';
        }

        $sql = self::BUSCAR_TODOS . $sqlWhere;
        $comando = DW3BancoDeDados::prepare($sql);
        $comando->bindValue((count($parametros) + 1), $limit, PDO::PARAM_INT);
        $comando->bindValue((count($parametros) + 2), $offset, PDO::PARAM_INT);
        $comando->execute();
        $registros = $comando->fetchAll();
        $objetos = [];
        foreach ($registros as $registro) {
            $usuario = new Usuario(
                $registro['nomeUsuario'],
                null,
                null,
                $registro['usuario']
            );

            
            $comentarios = Comentario::buscarArquivoId($registro['arquivo_id']);
            $objetos[] = new Arquivo(
                $registro['nome'],
                $registro['nomeOriginal'],
                $registro['descricao'],
                null,
                $registro['usuario'],
                $registro['arquivo_id'],
                $comentarios
            );
        }
        return $objetos;
    }

    public static function contarTodos()
    {
        $registros = DW3BancoDeDados::query(self::CONTAR_TODOS);
        $total = $registros->fetch();
        return intval($total[0]);
    }

    protected function verificarErros()
    {
        if (!$this->userId) {
            $this->setErroMensagem('Usuário', 'É obrigatório ter um usuário.');
        }

        if (strlen($this->descricao) < 3) {
            $this->setErroMensagem('Descrição', 'Deve ter no mínimo 3 caracteres.');
        }
    }
}
