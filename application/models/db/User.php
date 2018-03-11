<?php
/**
 * Created by PhpStorm.
 * User: jhl
 * Date: 2018/3/10
 * Time: 下午5:34
 */

class db_UserModel
{

    static private $tableName = 'cs_user';

    static public function getUserInfoByWhere($dc,array $whereAnd = [],array $whereOr = [])
    {
        $sql = buildSelectSql(self::$tableName,array("*"),$whereAnd,$whereOr);

        return $dc->query($sql);
    }

    static public function addUser($dc,$params)
    {
        $sql = buildInsertSql(self::$tableName,$params);

        return $dc->execute($sql);

    }

    static public function modifyUserByWhere($dc,$params,$where)
    {
        $sql = buildUpdateSql(self::$tableName,$params,$where);

        return $dc->execute($sql);
    }

}