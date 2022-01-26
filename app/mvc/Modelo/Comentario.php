<?php

namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;

class Comentario extends Modelo
{
    const BUSCAR_ID = 'SELECT * FROM comentarios WHERE id = ?';
    const BUSCAR_ARQUIVO_ID = 'SELECT c.id as comentario_id, c.user_id, c.arquivo_id, c.texto, u.id, u.nome FROM comentarios c JOIN usuarios u ON (c.user_id = u.id) where arquivo_id = ?';
    const INSERIR = 'INSERT INTO comentarios(texto, user_id, arquivo_id) VALUES (?, ?, ?)';
    const ATUALIZAR = 'UPDATE comentarios SET texto = ? WHERE id = ? and user_id = ?';
    const DELETAR = 'DELETE FROM comentarios WHERE id = ? and user_id = ?';

    private $id;
    private $texto;
    private $userId;
    private $arquivoId;
    private $usuario;

    public function __construct(
        $id = null,
        $texto = null,
        $userId = null,
        $arquivoId = null,
        $usuario = null
    ) {
        $this->id = $id;
        $this->texto = $texto;
        $this->userId = $userId;
        $this->arquivoId = $arquivoId;
        $this->usuario = $usuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTexto() 
    {
        return $this->texto;
    }

    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

    public function getArquivoId()
    {
        return $this->arquivoId;
    }


    public function setArquivoId($arquivoId)
    {
        $this->arquivoId = $arquivoId;
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
        if ($this->id == null) {
            $this->inserir();
        } else {
            $this->atualizar();
        }
    }

    public function atualizar()
    {
        $comando = DW3BancoDeDados::prepare(self::ATUALIZAR);
        $comando->bindValue(1, $this->texto, PDO::PARAM_STR);
        $comando->bindValue(2, $this->id, PDO::PARAM_INT);
        $comando->bindValue(3, $this->userId, PDO::PARAM_INT);
        $comando->execute();
    } 

    public function inserir()
    {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->texto, PDO::PARAM_STR);
        $comando->bindValue(2, $this->userId, PDO::PARAM_STR);
        $comando->bindValue(3, $this->arquivoId, PDO::PARAM_STR);

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
        
        return new Comentario(
            $registro['id'],
            $registro['texto'],
            $registro['user_id'],
            $registro['arquivo_id'],
        );
    }

    public static function buscarArquivoId($id)
    {   
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ARQUIVO_ID);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $registros = $comando->fetchAll();
      
        $objetos = [];
            
            
        foreach($registros as $registro) {
            
            $objetos[] = new Comentario(
                $registro['comentario_id'],
                $registro['texto'],
                $registro['user_id'],
                $registro['arquivo_id'],
                new Usuario($registro['nome'], null, null, $registro['user_id'])
            );
        }
        
        return $objetos;        
      
    }

    public function destruir()
    {   

        $comando = DW3BancoDeDados::prepare(self::DELETAR);
        $comando->bindValue(1, $this->id, PDO::PARAM_INT);
        $comando->bindValue(2, $this->userId, PDO::PARAM_INT);
        $comando->execute();
    }


    protected function verificarErros()
    {
        if (strlen($this->texto) < 3) {
            $this->setErroMensagem('Comentário', 'Deve ter no mínimo 3 caracteres.');
        }
    }
}
