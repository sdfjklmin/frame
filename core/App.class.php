<?php
namespace core ;

class App
{

	# 执行方法
	public static function run()
	{
		self::setCharset();		# 字符
		self::setConst() ;		# 常量
		self::buildLib() ;		# 引入文件
		self::setError();		# 错误
		self::iniUrl();			# url
		self::disController();	# 控制器

	}

	# 字符设置
	private static function setCharset()
	{
		header('content-type:text/html;charset=utf-8');
		# 跨域设置
		header('Access-Control-Allow-Origin: * ');

	}

	# 常量设置
	private static function setConst()
	{
		# 系统目录定义 统一以 / 结尾
		# 系统常量可以在项目中单独定义

		# 对应项目的入口目录
		defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
		# 核心路径
		defined('CORE_PATH') or define('CORE_PATH',dirname(__FILE__).'/') ;
	}

	# 设置错误信息
	private static function setError()
	{
	}

	# 解析url
	private static function iniUrl()
	{
		# 参数模式
		$plat = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : 'Admin';
		$module = isset($_REQUEST['c']) ? ucfirst(strtolower($_REQUEST['c'])) : 'Index';
		$action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';

		# 定义常量
		define('PLAT', $plat); //Admin或者Home 这里没有设置前后台项目
		define('CONTROLLER', $module);//指定控制器或者Index
		define('ACTION', $action);//指定方法或者index
	}

	# 分发控制器
	private static function disController()
	{
		//拿到对应的平台，控制器和方法
		$module = CONTROLLER . 'Controller';
		$action = ACTION;
		//实例化对应的控制器，然后调用方法
		require_once '/controller/' . CONTROLLER . 'Controller.class.php';
		//当前是Core空间，需要转到对应的控制器空间，空间命名规则：平台+对应属性。
		//new \Home\Controller\IndexController();
		//$module =  '\\controllers\\' . $module;//构建一个完全限定名称访问的路径
		$module = new $module;
		$module->$action();
	}

	# 引入项目所需要的文件
	private static function buildLib()
	{
		# 公共方法
		require_once(CORE_PATH.'/common.php');
		# 系统类
		$list = [
			CORE_PATH.'/Action.class.php' ,
			CORE_PATH.'/Model.class.php' ,
			CORE_PATH.'/Db.class.php' ,
			CORE_PATH.'/Error.class.php' ,
			CORE_PATH.'/Log.class.php' ,
			CORE_PATH.'/View.class.php' ,
		] ;
		foreach($list as $key=>$value) {
			if(is_file($value)) {
				require_once($value);
			}
		}
		# 连接配置
		$db_conf = require_once(APP_PATH.'config.php');
		if(!empty($db_conf)) {
			define('DB_CONF',json_encode($db_conf,true)) ;
		}

	}
}

# 运行入口
App::run() ;