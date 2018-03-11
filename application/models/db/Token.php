<?php
/**
 * Created by PhpStorm.
 * User: jhl
 * Date: 2018/3/10
 * Time: 下午8:27
 */

class db_TokenModel
{
    static private $tableName = 'cs_token';

    static public function getTokenInfoByWhere($dc,array $whereAnd = [],array $whereOr = [])
    {
        $sql = buildSelectSql(self::$tableName,array("*"),$whereAnd,$whereOr);

        return $dc->query($sql);
    }

    static public function addToken($dc,$params)
    {
        $sql = buildInsertSql(self::$tableName,$params);

        return $dc->execute($sql);

    }

    static public function modifyTokenByWhere($dc,$params,$where)
    {
        $sql = buildUpdateSql(self::$tableName,$params,$where);
        return $dc->execute($sql);
    }

}