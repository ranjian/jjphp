<?php
namespace home\c;
use jjphp\c;

class home extends c{
	function index(){
	    $rs = m('sys_boot')->getDbFields();
	    var_dump($rs);
		echo 123;exit;
	}
}
?>