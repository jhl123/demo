<?php
/**
 * Created by PhpStorm.
 * User: jhl
 * Date: 2018/3/10
 * Time: 下午6:32
 */

function buildId($length = 12,$prefix = '')
{
    list($usec, $sec) = explode(" ", microtime());

    $str = strval(((float)$usec + (float)$sec)*10000);

    if(strlen($str) < $length)
    {
        $temp = $str;
        for ($i=0;$i<=$length-strlen($str);$i++)
        {
            $temp .= rand(0,9);
        }

        $str = $temp;
    }

    return $prefix.$str;
}



function buildSelectSql($tableName,array $fildes = ["*"],array $whereAnd = [],array $whereOr = [],array $limit = [], $orderBy = "")
{
    $fildes_str = "*";
    if(is_array($fildes) && !empty($fildes))
    {
        $fildes_str = implode(",",$fildes);
    }

    $sql = "SELECT {$fildes_str} FROM {$tableName}";

    $where_and = array();
    if(is_array($whereAnd) && !empty($whereAnd))
    {

        foreach ($whereAnd as $key => $value)
        {
            $where_and[] = "{$key} = '{$value}'";
        }

    }

    if(is_array($whereOr) && !empty($whereOr))
    {
        $where_or = array();
        foreach ($whereOr as $key => $value)
        {
            $where_or[] = "{$key} = '{$value}'";
        }
        $where_or_str = "(" . implode(" OR ",$where_or) . ")";
        $where_and[] = $where_or_str;
    }

    if(!empty($where_and))
    {
        $where_and_str = implode(" AND ",$where_and);

        $sql .= " WHERE {$where_and_str}";
    }


    return $sql;

}


function buildUpdateSql($tableName,$params,$where)
{

    $sql = "UPDATE {$tableName}";

    if(is_array($params) && !empty($params))
    {
        $update = array();

        foreach ($params as $key => $value)
        {
            $update[] = "{$key} = '{$value}'";
        }

        $sql .= " SET " . implode(",",$update);
    }

    if(is_array($where) && !empty($where))
    {
        $where_arr = array();

        foreach ($where as $key => $value)
        {
            $where_arr[] = "{$key} = '{$value}'";
        }

        $sql .= " WHERE " . implode(" AND ",$where_arr);
    }

    return $sql;
}


function buildInsertSql($tableName,$params)
{

    $sql = "INSERT INTO {$tableName}";

    if(is_array($params) && !empty($params))
    {

        $key_arr = array();
        $value_arr = array();
        foreach ($params as $key => $value)
        {

            $key_arr[] = $key;
            $value_arr[] = "'{$value}'";
        }

        $sql .= " (" . implode(",",$key_arr) . ") VALUES (" . implode(",",$value_arr) . ")";
    }

    return $sql;
}