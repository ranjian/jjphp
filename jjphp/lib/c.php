<?php
namespace jjphp;
class c {
    public function __construct() {
        if(method_exists($this,'_init'))
            $this->_init();
    }
}
?>