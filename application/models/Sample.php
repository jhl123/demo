<?php
/**
 * @name SampleModel
 * @desc sample数据获取类, 可以访问数据库，文件，其它系统等
 * @author jhl
 */
class SampleModel {
    //数据库操作对象
    public $dc;

    public function __construct() {
        $this->dc = dc_DcModel::getDc();
    }   
    
    public function selectSample() {

        $sql = "SELECT * FROM cs_user ";

        return $this->dc->query($sql);

    }

    public function insertSample($arrInfo) {
        return true;
    }
}
