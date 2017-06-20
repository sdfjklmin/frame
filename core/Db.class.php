<?php

# 数据库类
class Db
{
    # 数据库配置
    protected $config ;

    # 连接对象
    protected $linkDb = null ;

    # 数据表名称
    protected $tab ;

    # 数据表前缀
    protected $tabFix ;

    # 数据库查询语句
    public $queryStr = '' ;

    # 查询字段
    protected $field = '*' ;

    # 查询条件
    protected $where = '' ;

    # 查询条件 WHERE GROUP ORDER
    protected $comWhere = '' ;

    public function __construct($name='',$connect='')
    {

        # 连接配置
        $this->config = json_decode(DB_CONF,true);
        if(empty($this->config)) {
            pr_e('数据库配置引入错误');
        }
        # 表前缀
        $this->tabFix = ( $this->config['DB_FIX'] ? $this->config['DB_FIX'] : '' ) ;
        unset($this->config['DB_FIX']);
        # 数据表名
        if(!empty($name)) {
            $this->tab = ltrim($this->tabFix.$name) ;
        }
        $this->connect($this->config) ;

    }

    # 数据库连接
    public function connect($config = []) {

        static $linkDb = [] ;
        # 参数判断
        if(empty($config)) {
            # 关闭数据库连接
            $this->linkDb = null ;
            unset($linkDb[0]);
            return ;
        }

        # 连接优化
        if(!empty($linkDb)) {
            $this->linkDb = $linkDb[0] ;
            return ;
        }

        # 字段检查
        $check = ['DB_TYPE','DB_HOST','DB_NAME','DB_ROOT','DB_PWD'];
        foreach($config as $key=>$value)
        {
            if(!in_array($key,$check)) {
                pr_e('数据库参数错误');
            }
        }


        try{
            # 连接参数
            $dbh = new PDO($config['DB_TYPE'].':host='.$config['DB_HOST'].';dbname='.$config['DB_NAME'], $config['DB_ROOT'],$config['DB_PWD']);
            # 编码设置
            $dbh->exec('set names utf8');
            $linkDb[0] = $dbh ;
            $this->linkDb =  $linkDb[0] ;
        }catch(PDOException $e){
            throw new PDOException($e->getMessage())  ;
        }
        return ;
    }

    # 查询数据
    public function select()
    {
        $sql = ' SELECT '.$this->field.' FROM '.$this->tab.$this->where ;
        $m =  $this->linkDb ->query($sql) ;
        if(false === $m) {
            pr_e($sql);
        }
        $this->queryStr = $sql ;
        $r = [] ;
        if(!empty($m)) {
            while($row = $m->fetch(PDO::FETCH_ASSOC)){
                $r[] = $row ;
            }
        }
        return $r ;
    }

    protected function _before()
    {
        if(!empty($this->where)){
            $this->comWhere = " WHERE ".$this->where ;
        }
    }


    # 查询字段
    public function field($field)
    {
        $this->field = $field ;
    }


    # 查询条件
    public function where($where)
    {
        $this->where = " WHERE ".$where ;
    }


}