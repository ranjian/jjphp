<?php
function __autoload($class){
    if(strpos($class,'jjphp') === 0){
        $class = substr_replace ($class,'jjphp\\lib',0,5);
    }
    $file = strtr($class, '\\', DIRECTORY_SEPARATOR).'.php';
    if (file_exists($file)) {
        if (is_file($file)) {
            include $file;
        }
    }
}

function route(){
	$para = $_SERVER["PHP_SELF"];
    $para = explode('/',$para);
    if($para[1] == 'index.php'){
        array_splice($para,1,1);
    }

    $m = 'home';
    $c = 'c\\index';
    $a = 'index';

    $n = count($para);
    if($n>0){
        $a = $para[$n-1];
        unset($para[$n-1]);
    }
    if($n>1){
        $c = 'c\\'.$para[$n-2];
        unset($para[$n-2]);
    }
    if($n>2){
        $m = implode('\\',$para);
    }

    $obj = "$m\\$c";
    $obj = new $obj();
    $obj->$a();
}

/**
 * 实例化一个没有模型文件的Model
 * @param string $name Model名称 支持指定基础模型 例如 MongoModel:User
 * @param string $tablePrefix 表前缀
 * @param mixed $connection 数据库连接信息
 * @return jjphp\m
 */
function m($name='', $tablePrefix='',$connection='') {
    static $_model  = [];
    if(strpos($name,':')) {
        list($class,$name)    =  explode(':',$name);
    }else{
        $class      =   'jjphp\\m';
    }
    $guid           =   (is_array($connection)?implode('',$connection):$connection).$tablePrefix . $name . '_' . $class;
    if (!isset($_model[$guid])){
        $_model[$guid] = new $class($name,$tablePrefix,$connection);
    }
    return $_model[$guid];
}

function c($name=null, $value=null,$default=null) {
    static $_config = array();
    // 无参数时获取所有
    if (empty($name)) {
        return $_config;
    }
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtoupper($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : $default;
            $_config[$name] = $value;
            return null;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtoupper($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
        $_config[$name[0]][$name[1]] = $value;
        return null;
    }
    // 批量设置
    if (is_array($name)){
        $_config = array_merge($_config, array_change_key_case($name,CASE_UPPER));
        return null;
    }
    return null; // 避免非法参数
}

function parse_name($name, $type=0) {
    if ($type) {
        return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function($match){return strtoupper($match[1]);}, $name));
    } else {
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}

?>