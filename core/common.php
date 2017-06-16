<?php

# 调试打印
function pr()
{
    if(func_get_args()) {
        echo '<pre>' ;
        foreach(func_get_args() as $v) {
            echo '[type]'.gettype($v),'<br>' ;
            echo '[data]' ;
            print_r($v) ;
            echo '<br><br>' ;
        }
    }
    exit ;
}

# 错误信息
function pr_e($s,$t=1)
{
    if(empty($e) && !isset($s)) {
        exit('Error : not find this arg');
    }
    $tip = "<span style='color: red'>".[1=>'Fatal error : ',2=>'Warning : ',3=>'Notice : '][$t]."</span>".$s ;
    exit($tip);
}

# module实例化
function module($m='')
{
    # 无参数
    if(empty($m) && !isset($m)) {
        pr_e('not find this arg') ;
    }else{
        # 指定实例
        $local  =  APP_PATH.'module/'.$m.'Module.class.php' ;
        $module = $m.'Module' ;
        if(file_exists($local)) {
            require_once $local ;
            return new $module ;
        }else{
            pr_e('not find '.$m.' module');
        }

    }
}

# 文件引入优化
function require_cache($filename)
{
    static $_requireFile = [] ;
    # 检查是否已经调用
    if(!isset($_requireFile[$filename])) {
        # 判断文件是否存在
        if(file_exists($filename)) {
            require $filename ;
            # 引入成功后添加标示
            $_requireFile[$filename] = true ;
        }else{
            $_requireFile[$filename] = false ;
        }
    }
    return $_requireFile[$filename] ;
}

# 数据库实例化
function D($mod='')
{
    # 数据类
    require_cache(CORE_PATH.'Db.class.php');
    # 默认判断
    if(empty($mod)) {
        return new Db;
    }
    # 转换字符串格式
    $mod = strFormat($mod) ;
    return new Db($mod);
}

# 字符串转换 BUserTest b_user_test
function strFormat($name){
    $temp_array = array();
    for($i=0;$i<strlen($name);$i++){
        $ascii_code = ord($name[$i]);
        if($ascii_code >= 65 && $ascii_code <= 90){
            if($i == 0){
                $temp_array[] = chr($ascii_code + 32);
            }else{
                $temp_array[] = '_'.chr($ascii_code + 32);
            }
        }else{
            $temp_array[] = $name[$i];
        }
    }
    return implode('',$temp_array);
}

