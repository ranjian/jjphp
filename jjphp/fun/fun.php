<?php
function __autoload($class){
    var_dump($class);
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
?>