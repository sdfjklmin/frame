<?php

# 数据库类
class Db
{
    # 数据库配置
    protected $config ;

    # 连接对象
    protected $linkDb ;

    # 数据表名称
    protected $tab ;

    # 数据表前缀
    protected $tabFix ;


    public function __construct($name='',$tabFix='m_',$connect='')
    {
        # 连接配置
        $this->config = [
            'TYPE'  =>  'mysql' ,
            'HOST'  =>  'localhost',
            'DB'    =>  'min_test',
            'ROOT'  =>  'root',
            'PWD'   =>  '123456',
        ] ;
        # 表前缀
        $this->tabFix = $tabFix ;
        # 数据表名
        if(!empty($name)) {
            $this->tab = ltrim($this->tabFix.$name) ;
        }
        $this->connect() ;
    }

    # 数据库连接
    public function connect($config = []) {
        if(empty($config)) {
            $config = $this->config ;
        }
        try{
            $dbh = new PDO($config['TYPE'].':host='.$config['HOST'].';dbname='.$config['DB'], $config['ROOT'],$config['PWD']);
            $this->linkDb = $dbh ;
        }catch(PDOException $e){
            throw new PDOException($e->getMessage())  ;
        }
        return $dbh ;
    }

    # 查询数据
    public function select()
    {
        $sql = ' SELECT * FROM '.$this->tab ;
        $m =  $this->linkDb ->query($sql) ;
        $r = [] ;
        if(!empty($m)) {
            while($row = $m->fetch(PDO::FETCH_ASSOC)){
                $r[] = $row ;
            }
        }
        return $r ;
    }
}