<?php
namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;
use \DateTime;

class Relatorio
{
    const BUSCAR_TODOS = 'SELECT a.id, a.nome_original, a.descricao, a.criado_em FROM arquivos a join usuarios on a.user_id = usuarios.id   WHERE TRUE';

    public static function buscarRegistros($userId, $filtro = [])
    {
        $sqlWhere = '';
        $parametros = [];
        if (array_key_exists('dataInicial', $filtro) && $filtro['dataInicial'] != '') {
            $parametros[] = $filtro['dataInicial'];
            $sqlWhere .= " AND DATE_FORMAT(a.criado_em,'%Y-%m-%d') >= ?";
        }
        if (array_key_exists('dataFinal', $filtro) && $filtro['dataFinal'] != '') {
            $parametros[] = $filtro['dataFinal'];
            $sqlWhere .= " AND DATE_FORMAT(a.criado_em,'%Y-%m-%d') <= ?";
        }
        
        $sql = self::BUSCAR_TODOS . $sqlWhere . ' AND a.user_id = ? ORDER BY nome_original';
        $comando = DW3BancoDeDados::prepare($sql);
        foreach ($parametros as $i => $parametro) {
            $comando->bindValue($i+1, $parametro, PDO::PARAM_STR);
        }

        $comando->bindValue((count($parametros) + 1), $userId, PDO::PARAM_STR);
        $comando->execute();
        $registros = $comando->fetchAll();
        $registrosFormatados = [];

        foreach($registros as $registro) {

            $timestamp = strtotime($registro['criado_em']);
            $date = date('Y-m-d', $timestamp);
          
            $registrosFormatados[] = [
                'id' => $registro['id'],
                'nome_original' => $registro['nome_original'],
                'descricao' => $registro['descricao'],
                'criado_em' => implode('/',array_reverse(explode('-',$date)))
            ];
        }
        return $registrosFormatados;
    }
}
