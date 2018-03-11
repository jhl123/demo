<?php
/**
 * Created by PhpStorm.
 * User: jhl
 * Date: 2018/3/10
 * Time: 下午12:39
 */

class pdo_PdoModel
{
    //创建静态私有的变量保存该类对象
    static private $instance;
    //pdo对象
    private $pdo;
    //错误信息
    public $error;



    //防止直接创建对象
    private function __construct($params){
        try{
            //连接数据库
            $this->pdo = new PDO($params['dsn'],$params['username'],$params['password'],$params['options']);
        }catch (Exception $e){
            //连接异常
            $this->pdo = false;
            //$this->pdo = new PDO($params['dsn'],$params['username'],$params['password'],$params['options']);
            $this->error[] = $e->getMessage();
        }
    }
    //防止克隆对象
    private function __clone(){

    }

    /**
    * @param $params
    * @return PdoModel
    */
    static public function getInstance($params){
        //判断$instance是否是Uni的对象
        if (!self::$instance instanceof self) {
            //没有则创建
            self::$instance = new self($params);
        }
        return self::$instance;
    }


    /**
     * 查询方法，执行查询语句并解析查询结果
     * @param $sql
     * @return array|bool
     */
    public function query($sql){

        if(!$this->pdo || empty($sql))
        {
            return false;
        }


        $statement = $this->pdo->query($sql);
        if($statement === false)
        {
            $this->error[] = $this->pdo->errorInfo()[count($this->pdo->errorInfo())-1];
            return false;
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * 执行方法，执行添加，修改，删除语句
     * @param $sql
     * @return bool
     */
    public function execute($sql){

        if(!$this->pdo || empty($sql))
        {
            return false;
        }

        if($this->pdo->exec($sql) === false)
        {
            $this->error[] = $this->pdo->errorInfo()[count($this->pdo->errorInfo())-1];
            return false;
        }

        return true;
    }


}