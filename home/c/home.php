<?php
namespace home\c;
use jjphp\c;
use jjphp\db\m;

class home extends c{
	function index(){
	    $m = new m();
	    $m->find();
		echo 'home/index';exit;
	}
}
?>